<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;

use App\Events\PageCreatedEvent as Event;

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
        dd('Rating Service');
    }

}
