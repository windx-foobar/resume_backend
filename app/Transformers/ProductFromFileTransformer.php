<?php

namespace App\Transformers;

use Illuminate\Support\Str;
use League\Fractal\TransformerAbstract;

class ProductFromFileTransformer extends TransformerAbstract {
   private $data;

   public function transform($data) {
      $this->data = $data;

      return [
         'id' => isset($this->data['id']) ? (int) $this->data['id'] : null,
         'title' => $this->data['title'],
         'eId' => $this->getEId(),
         'price' => $this->data['price'],
         'categories' => $this->getCategories(),
         'categoriesEId' => $this->getCategoriesEId()
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

   private function getCategoriesEId() {
      return collect($this->data)
         ->filter(
            function ($_, $key) {
               $key = strtolower($key);

               return $this->checkCategoriesEId($key);
            }
         )->last();
   }

   private function getCategories() {
      return collect($this->data)
         ->filter(
            function ($_, $key) {
               $key = strtolower($key);

               return $this->checkCategoriesId($key);
            }
         )->last();
   }

   private function checkCategories($key) {
      return Str::startsWith($key, 'categor');
   }

   private function checkCategoriesId($key) {
      return $this->checkCategories($key) && !Str::endsWith($key, 'eid');
   }

   private function checkCategoriesEId($key) {
      return $this->checkCategories($key) && Str::endsWith($key, 'eid');
   }
}
