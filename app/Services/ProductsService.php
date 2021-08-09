<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Validators\ProductValidator;
use Exception;

/**
 * Class ProductsService
 */
class ProductsService {
   /**
    * @throws Exception
    */
   public function create(array $data): Product {
      try {
         ProductValidator::validate($data)->validate();

         $product = new Product();

         $product->title = $data['title'];
         $product->price = $data['price'];
         $product->eId = $data['eId'] ?? null;

         $categories = Category::find($data['categories']);

         if ($product->save()) {
            $product->categories()->attach($categories);
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

         $categories = Category::find($data['categories']);
         $product->categories()->attach($categories);

         if ($product->update($data)) {
            return $product;
         }

         throw new Exception('Продукт не может быть обновлен.');
      } catch (Exception $e) {
         throw $e;
      }
   }
}