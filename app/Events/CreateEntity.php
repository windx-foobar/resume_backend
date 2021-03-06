<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreateEntity {
   public $model;
   public $update = false;

   use Dispatchable, InteractsWithSockets, SerializesModels;

   /**
    * Create a new event instance.
    *
    * @return void
    */
   public function __construct(Model $model, $update = false) {
      $this->model = $model;
      $this->update = $update;
   }

   /**
    * Get the channels the event should broadcast on.
    *
    * @return \Illuminate\Broadcasting\Channel|array
    */
   public function broadcastOn() {
      return new PrivateChannel('channel-name');
   }
}
