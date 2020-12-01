<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \App\Events\UserCreatedEvent::class => [
            \App\Listeners\UserCreatedListener::class,
        ],
        \App\Events\PageCreatedEvent::class => [
            \App\Listeners\PageCreatedListener::class,
        ],
        \App\Events\TestEvent::class => [
            \App\Listeners\TestListener::class,
        ],
    ];
}
