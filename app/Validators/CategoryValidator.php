<?php

declare(strict_types=1);

namespace App\Validators;

use Illuminate\Support\Arr;
use Illuminate\Validation\Validator;

/**
 * Class BaseValidator
 * @package App\Validators
 */
class CategoryValidator extends BaseValidator {
   private $isUpdate = false;

   public function getMessages(): array {
      return [
         'required' => 'Поле обязательно для заполнения',
         'string' => 'Поле должно быть строкой',
         'numeric' => 'Поле должно быть числом',
         'title.min' => 'Минимальная длина заголовка 3 символа',
         'title.max' => 'Максимальная длина заголовка 12 символов',
         'products.array' => 'Товары должны быть массивом id',
      ];
   }

   public function getRules(): array {
      $required = $this->isUpdate ? '' : 'required|';

      return [
         'title' => $required . 'string|min:3|max:12',
         'products' => 'array',
         'products.*' => 'numeric',
         'eId' => 'numeric'
      ];
   }

   public static function validate(array $data, array $options = []): Validator {
      $instance = new static();

      $instance->isUpdate = Arr::get($options, 'update', false);

      return parent::make($data, $instance);
   }
}