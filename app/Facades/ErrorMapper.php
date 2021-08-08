<?php

namespace App\Facades;

use App\Services\ErrorMapperService;
use Illuminate\Support\Facades\Facade;

/**
 * Class ErrorMapper
 * @package App\Facades
 */
class ErrorMapper extends Facade {
   protected static function getFacadeAccessor() {
      return ErrorMapperService::class;
   }
}