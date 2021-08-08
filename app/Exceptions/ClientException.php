<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

/**
 * Class ClientException
 * @package App\Exceptions
 */
class ClientException extends Exception {
   public function __construct($message = "") {
      parent::__construct($message, 400);
   }
}