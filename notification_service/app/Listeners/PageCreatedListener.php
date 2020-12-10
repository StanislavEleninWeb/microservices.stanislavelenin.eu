<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\PageCreatedEvent as Event;

use Illuminate\Support\Facades\Notification;
use App\Notifications\PageCreatedNotification;

use App\Models\User;

class PageCreatedListener implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\ExampleEvent  $event
     * @return void
     */
    public function handle(Event $event)
    {
        // $users = User::find(collect($event->users)->pluck('id'));
        $users = User::all();
        
        Notification::send($users, new PageCreatedNotification($event));
    }
}
