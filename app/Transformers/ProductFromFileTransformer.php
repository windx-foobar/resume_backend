<?php

namespace App\Transformers;

use Illuminate\Support\Str;
use League\Fractal\TransformerAbstract;

class ProductFromFileTransformer extends TransformerAbstract {
   private $data;

   public function transform($data) {
      $this->data = $data;

      return [
         'title' => $this->data['title'],
         'eId' => $this->getEId(),
         'price' => $this->data['price'],
         'categories' => $this->getCategories()
      ];
   }

   private function getEId() {
      return collect($this->data)
         ->filter(
            function ($_, $key) {
               return strtolower($key) === 'eid';
            }
         )->last();
   }

   private function getCategories() {
      return collect($this->data)
         ->filter(
            function ($_, $key) {
               $key = strtolower($key);

               return Str::startsWith($key, 'categor');
            }
         )->last();
   }
}
