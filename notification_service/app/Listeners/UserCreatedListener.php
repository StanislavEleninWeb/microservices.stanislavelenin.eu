<?php

namespace App\Listeners;

use App\Events\UserCreatedEvent as Event;
use App\Notifications\UserCreatedNotification
use App\Models\User;

class UserCreatedListener
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\ExampleEvent  $event
     * @return void
     */
    public function handle(Event $event)
    {
        $user = new User;
        
        $user->id = $event->data['id'];
        $user->name = $event->data['name'];
        $user->email = $event->data['email'];

        $user->save();

        $user->notify(new UserCreatedNotification);
    }
}
