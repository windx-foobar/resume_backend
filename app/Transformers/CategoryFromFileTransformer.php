<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class CategoryFromFileTransformer extends TransformerAbstract {
   private $data;

   public function transform($data) {
      $this->data = $data;

      return [
         'title' => $this->data['title'],
         'eId' => $this->getEId()
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
}
