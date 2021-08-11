<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class CategoryFromFileTransformer extends TransformerAbstract {
   private $data;

   public function transform($data) {
      $this->data = $data;

      return [
         'id' => isset($this->data['id']) ? (int) $this->data['id'] : null,
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
