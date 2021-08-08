<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Product;
use App\Services\ErrorMapperService;
use App\Services\ProductsService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;

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
            return new ProductsService(new Product(), new Category());
         }
      );

      $this->app->bind(ErrorMapperService::class,
         function () {
            return new ErrorMapperService();
         }
      );
   }
}
