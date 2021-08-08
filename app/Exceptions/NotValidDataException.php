<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

/**
 * Class NotSaveException
 * @package App\Exceptions
 */
class NotValidDataException extends Exception {
   /**
    * @var array
    */
   private $errors;

   public function __construct($errors) {
      parent::__construct('Переданы неверные данные', 400);
      $this->errors = $errors;
   }

   public function errors() {
      return $this->errors;
   }
}