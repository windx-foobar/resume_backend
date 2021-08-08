<?php

namespace App\Services;

use App\Exceptions\{ClientException,
   NotSaveException,
   NotFoundException,
   NotUpdateException,
   NotValidDataException,
   NotDeleteException,
   ServerException
};
use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Validation\ValidationException;
use Validator;

/**
 * Class ProductsService
 */
class ErrorMapperService {
   /**
    * @param Exception $e
    *
    * @return array
    */
   public function mapErrors(Exception $e): array {
      $err = ['data' => [], 'code' => $e->getCode()];

      switch (true) {
         case $e instanceof NotValidDataException:
            $err['data'] = [
               'message' => $e->getMessage(),
               'errors' => $e->errors()
            ];
            break;
         case $e instanceof ServerException:
         case $e instanceof ClientException:
            $err['data'] = ['message' => $e->getMessage()];
            break;
      }

      return $err;
   }
}