<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

/**
 * Class NotSaveException
 * @package App\Exceptions
 */
class NotFoundException extends ClientException {
   public function __construct($name, $id) {
      parent::__construct("$name $id не найден");
   }
}