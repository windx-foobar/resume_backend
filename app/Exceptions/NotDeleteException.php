<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

/**
 * Class NotSaveException
 * @package App\Exceptions
 */
class NotDeleteException extends ServerException {
   public function __construct($message = "", $code = 0, Throwable $previous = null) {
      parent::__construct($message, $code, $previous);
   }
}