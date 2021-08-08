<?php

namespace App\Services;

use App\Exceptions\{ClientException,
   NotSaveException,
   NotFoundException,
   NotUpdateException,
   NotValidDataException,
   NotDeleteException,
   ServerException
};
use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Validation\ValidationException;
use Validator;

/**
 * Class ProductsService
 */
class ProductsService {
   /**
    * @var Product
    */
   private $product;

   /**
    * @var Category
    */
   private $category;

   public function __construct(Product $product, Category $category) {
      $this->product = $product;
      $this->category = $category;
   }

   /**
    * @param string $title
    * @param mixed $price
    * @param array $categories
    *
    * @return Product
    *
    * @throws NotSaveException|NotValidDataException
    */
   public function create(string $title, $price, array $categories = []): Product {
      try {
         $this->validationData(compact('title', 'price'));

         $this->product->title = $title;
         $this->product->price = $price;

         $categories = $this->category->find($categories);

         $this->product->categories()->attach($categories);

         if ($this->product->save()) {
            return $this->product;
         } else {
            throw new NotSaveException('Продукт не был сохранен');
         }
      } catch (NotValidDataException $e) {
         throw $e;
      }
   }

   /**
    * @param int $id
    * @param array|null $data
    *
    * @return Product
    *
    * @throws NotValidDataException|NotUpdateException|NotFoundException
    */
   public function update(int $id, array $data = null): Product {
      if (!$product = $this->product->find($id)) {
         throw new NotFoundException('Продукт', $id);
      }

      try {
         $this->validationData($data, true);

         if ($product->update($data)) {
            return $product;
         } else {
            throw new NotUpdateException('Продукт не был обновлен');
         }
      } catch (NotValidDataException $exception) {
         throw $exception;
      }
   }

   /**
    * @param int $id
    *
    * @return bool
    *
    * @throws NotDeleteException|NotFoundException
    */
   public function delete(int $id): bool {
      if (!$product = $this->product->find($id)) {
         throw new NotFoundException('Продукт', $id);
      }

      try {
         return $product->delete();
      } catch (Exception $e) {
         throw new NotDeleteException($e->getMessage());
      }
   }

   /**
    * @param array $data
    * @param bool $updated
    *
    * @return void
    *
    * @throws NotValidDataException
    */
   private function validationData(array $data, bool $updated = false): void {
      $required = $updated ? '' : 'required|';

      try {
         Validator::make(
            $data,
            [
               'title' => $required . 'min:3|max:12',
               'price' => $required . 'numeric|min:0|max:200'
            ],
            [
               'required' => 'Поле обязательно для заполнения',
               'title.min' => 'Поле должно быть минимум 3 символа',
               'title.max' => 'Поле не должно быть более 12 символов',
               'numeric' => 'Поле должно быть числовым типом',
               'price.min' => 'Поле не должно быть меньше 0',
               'price.max' => 'Поле не должно быть больше 200'
            ]
         )->validate();
      } catch (ValidationException $e) {
         throw new NotValidDataException($e->errors());
      }
   }
}