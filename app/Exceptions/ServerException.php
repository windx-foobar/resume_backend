<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

/**
 * Class NotSaveException
 * @package App\Exceptions
 */
class ServerException extends Exception {
   public function __construct($message = "") {
      parent::__construct($message, 500);
   }
}