<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;

use App\Events\PageCreatedEvent as Event;

class PageCreatedListener implements ShouldQueue
{
    /**
     * The name of the connection the job should be sent to.
     *
     * @var string|null
     */
    public $connection = 'rabbitmq_fanout';

    /**
     * Handle the event.
     *
     * @param  \App\Events\ExampleEvent  $event
     * @return void
     */
    public function handle(Event $event)
    {
        //        
    }

}
