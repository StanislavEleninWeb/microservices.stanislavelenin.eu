<?php

namespace App\Listeners;

use App\Events\PageCreatedEvent as Event;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Notifications\PageCreatedNotification;

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
        $users = User::find($event->users->pluck('id'));

        Notification::send($users, new PageCreatedNotification($event->data));
    }
}
