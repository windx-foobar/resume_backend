<?php

namespace App\Http\Controllers\Api;

use ErrorMapper;
use App\Exceptions\{NotDeleteException, NotFoundException, NotValidDataException, NotSaveException, NotUpdateException};
use App\Models\Product;
use Exception;
use Illuminate\Http\{Request, JsonResponse};
use Illuminate\Routing\Controller;
use Products;

class ProductsController extends Controller {
   /**
    * Display a listing of the resource.
    *
    * @return JsonResponse
    */
   public function index(): JsonResponse {
      return response()->json(
         [
            'message' => 'Список всех продуктов',
            'products' => Product::all()
         ]
      );
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param Request $request
    *
    * @return JsonResponse
    */
   public function store(Request $request): JsonResponse {
      try {
         return response()->json(
            [
               'message' => 'Продукт успешно создан',
               'data' => Products::create($request->title, $request->price, $request->categories)
            ]
         );
      } catch (Exception $e) {
         switch (true) {
            case $e instanceof NotSaveException:
               return response()->json(
                  [
                     'message' => $e->getMessage(),
                  ],
                  500
               );
            case $e instanceof NotValidDataException:
               return response()->json(
                  [
                     'message' => $e->getMessage(),
                     'errors' => $e->errors()
                  ],
                  400
               );
         }
      }
   }

   /**
    * Display the specified resource.
    *
    * @param Product $product
    *
    * @return JsonResponse
    */
   public function show(Product $product): JsonResponse {
      return response()->json($product);
   }

   /**
    * Update the specified resource in storage.
    *
    * @param Request $request
    * @param int $id
    *
    * @return JsonResponse
    */
   public function update(Request $request, int $id): JsonResponse {
      try {
         return response()->json(
            [
               'message' => 'Продукт успешно обновлен',
               'data' => Products::update($id, $request->toArray())
            ]
         );
      } catch (Exception $e) {
         $error = ErrorMapper::mapErrors($e);
         return response()->json($error['data'], $error['code']);
      }
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param int $id
    *
    * @return JsonResponse
    */
   public function destroy(int $id): JsonResponse {
      try {
         Products::delete($id);

         return response()->json(
            ['message' => 'Продукт успешно удален'],
         );
      } catch (Exception $e) {
         $error = ErrorMapper::mapErrors($e);
         return response()->json($error['data'], $error['code']);
      }
   }
}
