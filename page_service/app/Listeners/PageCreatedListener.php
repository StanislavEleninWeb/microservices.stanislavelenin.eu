<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\PageCreatedEvent as Event;

class PageCreatedListener implements ShouldQueue
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
    public $exchange_routing_key = 'notifycation';

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        // Config RabbitMQ Exchange Direct routing key
        config([
            'queue.connections.rabbitmq_direct.options.queue.exchange_routing_key' => $this->exchange_routing_key
        ]);
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ExampleEvent  $event
     * @return void
     */
    public function handle(Event $event)
    {
        echo "PageCreatedListener";        
    }

}
