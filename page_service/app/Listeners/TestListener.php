<?php

namespace App\Listeners;

use App\Events\TestEvent as Event;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TestListener implements ShouldQueue
{

    /**
     * The name of the connection the job should be sent to.
     *
     * @var string|null
     */
    public $connection = 'rabbitmq';

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'page.service';

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ExampleEvent  $event
     * @return void
     */
    public function handle(Event $event)
    {
        echo 'TEstListener';
    }
}
