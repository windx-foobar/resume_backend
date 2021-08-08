<?php

namespace App\Facades;

use App\Services\ProductsService;
use Illuminate\Support\Facades\Facade;

/**
 * Class Products
 * @package App\Facades
 */
class Products extends Facade {
   protected static function getFacadeAccessor() {
      return ProductsService::class;
   }
}