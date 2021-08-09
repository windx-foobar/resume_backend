<?php

namespace App\Transformers;

use App\Models\Category;
use Flugg\Responder\Transformers\Transformer;

class CategoryTransformer extends Transformer {
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
   protected $load = [];

   /**
    * Transform the model.
    *
    * @param Category $category
    *
    * @return array
    */
   public function transform(Category $category) {
      return $category->toArray();
   }
}
