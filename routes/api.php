<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/products', 'Api\ProductsController@index');
Route::post('/products', 'Api\ProductsController@store');
Route::get('/products/{product}', 'Api\ProductsController@show');
Route::put('/products/{id}', 'Api\ProductsController@update');
Route::delete('/products/{id}', 'Api\ProductsController@destroy');
