<?php

declare(strict_types=1);

namespace App\Validators;

use Illuminate\Validation\Validator;

/**
 * Class BaseValidator
 * @package App\Validators
 */
abstract class BaseValidator {
   abstract function getMessages(): array;

   abstract function getRules(): array;

   protected static function make(array $data, self $validator): Validator {
      return \Validator::make($data, $validator->getRules(), $validator->getMessages());
   }
}