<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $title
 * @property float $price
 * @property int|null $eId
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $categories
 * @property-read int|null $categories_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereEId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTitle($value)
 * @mixin \Eloquent
 */
class Product extends Model {
   protected $table = 'products';

   protected $fillable = [
      'title',
      'price',
      'eId'
   ];

   protected $casts = [
      'price' => 'float',
      'eId' => 'integer'
   ];

   /**
    * @return BelongsToMany
    */
   public function categories() {
      return $this->belongsToMany(Category::class, 'products_categories');
   }
}
