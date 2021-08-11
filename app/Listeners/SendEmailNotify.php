<?php

namespace App\Listeners;

use App\Events\CreateEntity;
use App\Models\Category;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;

class SendEmailNotify {
   /**
    * Create the event listener.
    *
    * @return void
    */
   public function __construct() {
      //
   }

   /**
    * Handle the event.
    *
    * @param CreateEntity $event
    *
    * @return void
    */
   public function handle(CreateEntity $event) {
      $model = $event->model;
      $update = $event->update;

      $title = $update ? 'обновлен' : 'создан новый';
      $title .= ' товар';

      if ($event->model instanceof Category) {
         $title = $update ? 'обновлена' : 'создана новая';
         $title .= ' категория';
      }

      \Mail::send(
         'mail.create-notify',
         compact('title', 'model'),
         function (Message $message) use ($title) {
            $message
               ->from('resume-backend@debug.ru')
               ->to(config('mail.to'))
               ->subject(Str::ucfirst($title));
         }
      );
   }
}
