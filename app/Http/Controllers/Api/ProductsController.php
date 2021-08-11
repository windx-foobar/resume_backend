<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Services\ProductsService;
use App\Transformers\ProductTransformer;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\{Request};
use Illuminate\Routing\Controller;

class ProductsController extends Controller {
   private $productsService;

   public function __construct(ProductsService $productsService) {
      $this->productsService = $productsService;
   }

   /**
    * Показать список всех товаров.
    *
    * @return mixed
    */
   public function index() {
      return \Responder::success(Product::all(), new ProductTransformer);
   }

   /**
    * Создать новый товар.
    *
    * @param Request $request
    *
    * @return void|mixed
    */
   public function store(Request $request) {
      try {
         $newProduct = $this->productsService->create($request->except('q'));

         return \Responder::success($newProduct)->respond(\HttpStatus::HTTP_CREATED);
      } catch (Exception $e) {
         switch (true) {
            case $e instanceof ValidationException:
               return \Responder::error(null, 'Переданы неверные данные')
                  ->data(['list' => $e->errors()])
                  ->respond(\HttpStatus::HTTP_BAD_REQUEST);
            case $e instanceof Exception:
               return \Responder::error(null, $e->getMessage())->respond(\HttpStatus::HTTP_INTERNAL_SERVER_ERROR);
         }
      }
   }

   /**
    * Показать определенный товар.
    *
    * @param Product $product
    *
    * @return mixed
    */
   public function show(Product $product) {
      return \Responder::success($product, new ProductTransformer);
   }

   /**
    * Обновить товар.
    *
    * @param Request $request
    * @param Product $product
    *
    * @return void|mixed
    */
   public function update(Request $request, Product $product) {
      try {
         $updatedProduct = $this->productsService->update($product, $request->except('q'));

         return \Responder::success($updatedProduct, new ProductTransformer);
      } catch (Exception $e) {
         switch (true) {
            case $e instanceof ValidationException:
               return \Responder::error(null, 'Переданы неверные данные')
                  ->data(['list' => $e->errors()])
                  ->respond(\HttpStatus::HTTP_BAD_REQUEST);
            case $e instanceof Exception:
               return \Responder::error(null, $e->getMessage())->respond(\HttpStatus::HTTP_INTERNAL_SERVER_ERROR);
         }
      }
   }

   /**
    * Удалить товар.
    *
    * @param Product $product
    *
    * @return mixed
    */
   public function destroy(Product $product) {
      try {
         $product->delete();
         return \Responder::success();
      } catch (Exception $e) {
         return \Responder::error(null, "Продукт {$product->id} не может быть удален")
            ->respond(\HttpStatus::HTTP_INTERNAL_SERVER_ERROR);
      }
   }
}
