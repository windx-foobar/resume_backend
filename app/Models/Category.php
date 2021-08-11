<?php

namespace App\Models;

use Illuminate\Contracts\Support\Arrayable;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $title
 * @property int|null $eId
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereEId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereTitle($value)
 * @mixin \Eloquent
 */
class Category extends Model {
   protected $table = 'categories';

   protected $fillable = [
      'title',
      'eId'
   ];

   protected $casts = [
      'eId' => 'integer'
   ];
}
