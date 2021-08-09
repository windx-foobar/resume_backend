<?php

namespace App\Transformers;

use App\Models\Product;
use Flugg\Responder\Transformers\Transformer;

class ProductTransformer extends Transformer {
   /**
    * List of available relations.
    *
    * @var string[]
    */
   protected $relations = [];

   /**
    * List of autoloaded default relations.
    *
    * @var array
    */
   protected $load = [
      'categories' => CategoryTransformer::class
   ];

   /**
    * Transform the model.
    *
    * @param Product $product
    *
    * @return array
    */
   public function transform(Product $product) {
      return $product->toArray();
   }

   public function includeCategories(Product $product) {
      return $product->categories;
   }
}
