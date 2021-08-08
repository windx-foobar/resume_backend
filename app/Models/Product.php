<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model {
   protected $table = 'products';

   public $timestamps = false;

   protected $fillable = [
      'title',
      'price'
   ];

   /**
    * @return BelongsToMany
    */
   public function categories() {
      return $this->belongsToMany(Category::class);
   }
}
