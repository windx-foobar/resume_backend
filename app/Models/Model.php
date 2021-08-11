<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model as BaseModel;

abstract class Model extends BaseModel {
   public $timestamps = false;

   protected $hidden = ['pivot'];

   public static function findByEId($eId, $columns = ['*']) {
      $builder = self::query()->whereIn('eId', $eId);

      if (is_array($eId) || $eId instanceof Arrayable) {
         return $builder->get($columns);
      }

      return $builder->first($columns);
   }
}