<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Services\ProductsService;
use App\Transformers\ProductTransformer;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\{Request, JsonResponse};
use Illuminate\Routing\Controller;

class ProductsController extends Controller {
   private $productsService;

   public function __construct(ProductsService $productsService) {
      $this->productsService = $productsService;
   }

   /**
    * Display a listing of the resource.
    *
    * @return mixed
    */
   public function index() {
      return \Responder::success(Product::all(), new ProductTransformer);
   }

   /**
    * Создать новый продукт
    *
    * @param Request $request
    *
    * @return mixed
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
               return \Responder::error(null, $e->getMessage())
                  ->respond(\HttpStatus::HTTP_INTERNAL_SERVER_ERROR);
         }
      }
   }

   /**
    * Display the specified resource.
    *
    * @param Product $product
    *
    * @return mixed
    */
   public function show(Product $product) {
      return \Responder::success($product);
   }

   /**
    * Update the specified resource in storage.
    *
    * @param Request $request
    * @param Product $product
    *
    * @return mixed
    */
   public function update(Request $request, Product $product) {
      try {
         $updatedProduct = $this->productsService->update($product, $request->except('q'));

         return \Responder::success($updatedProduct);
      } catch (Exception $e) {
         switch (true) {
            case $e instanceof ValidationException:
               return \Responder::error(null, 'Переданы неверные данные')
                  ->data(['list' => $e->errors()])
                  ->respond(\HttpStatus::HTTP_BAD_REQUEST);
            case $e instanceof Exception:
               return \Responder::error(null, $e->getMessage())
                  ->respond(\HttpStatus::HTTP_INTERNAL_SERVER_ERROR);
         }
      }
   }

   /**
    * Remove the specified resource from storage.
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
