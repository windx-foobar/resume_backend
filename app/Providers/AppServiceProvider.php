<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Product;
use App\Services\ProductsService;
use App\Validators\ProductValidator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
   /**
    * Bootstrap any application services.
    *
    * @return void
    */
   public function boot() {
      //
   }

   /**
    * Register any application services.
    *
    * @return void
    */
   public function register() {
      $this->app->bind(ProductsService::class,
         function () {
            return new ProductsService();
         }
      );
   }
}
