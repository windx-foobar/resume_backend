<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\CreateEntity;
use App\Models\Category;
use App\Models\Product;
use App\Validators\ProductValidator;
use Exception;

/**
 * Class ProductsService
 */
class ProductsService {
   /**
    * @var \Illuminate\Support\Collection
    */
   private $data;

   /**
    * @var \Illuminate\Database\Eloquent\Collection | Category[] | null
    */
   private $categories = null;

   /**
    * @throws Exception
    */
   public function create(array $data): Product {
      $this->data = collect($data);

      try {
         ProductValidator::validate($data)->validate();

         $product = new Product();

         $product->title = $this->data->get('title');
         $product->price = $this->data->get('price');
         $product->eId = $this->data->get('eId');

         $categories = $this->setCategories()->categories;

         if ($product->save()) {
            $product->categories()->attach($categories);

            \Event::dispatch(new CreateEntity($product));

            return $product;
         }

         throw new Exception('Продукт не может быть создан.');
      } catch (Exception $e) {
         throw $e;
      }
   }

   /**
    * @throws Exception
    */
   public function update(Product $product, array $data): Product {
      try {
         ProductValidator::validate($data, ['update' => true])->validate();

         $categories = $this->setCategories()->categories;
         $product->categories()->attach($categories);

         if ($product->update($data)) {
            \Event::dispatch(new CreateEntity($product, true));

            return $product;
         }

         throw new Exception('Продукт не может быть обновлен.');
      } catch (Exception $e) {
         throw $e;
      }
   }

   private function setCategories(): self {
      $categoriesIds = $this->data->get('categories');
      $categoriesEIds = $this->data->get('categoriesEId');

      if ($categoriesIds) {
         $this->categories = Category::find($categoriesIds);
      }

      if ($categoriesEIds) {
         $categories = Category::findByEId($categoriesEIds);

         if ($this->categories) {
            $this->categories->merge($categories);
            return $this;
         }

         $this->categories = $categories;
      }

      return $this;
   }
}