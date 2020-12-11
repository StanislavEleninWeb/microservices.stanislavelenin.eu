<?php

namespace App\Listeners;

use App\Events\NotifyAdmins as Event;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyAdminsListener implements ShouldQueue
{
    /**
     * The name of the connection the job should be sent to.
     *
     * @var string|null
     */
    public $connection = 'rabbitmq_direct';

    /**
     * The name of the connection the job should be sent to.
     *
     * @var string|null
     */
    public $exchange_routing_key = 'notification';

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
