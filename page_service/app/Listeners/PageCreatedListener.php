<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

use App\Events\PageCreatedEvent;

class PageCreatedListener implements ShouldQueue
{
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
    public function handle(PageCreatedEvent $event)
    {
        echo 'Page Service - Page Created Listener';
        // Http::post('NOTIFICATION_SERVICE_URL' . '/notify/page/created', [
        //     'post' => $event->post,
        // ]);
    }
}
