<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

/**
 * Class NotSaveException
 * @package App\Exceptions
 */
class NotSaveException extends ServerException {
   public function __construct($message = "") {
      parent::__construct($message);
   }
}