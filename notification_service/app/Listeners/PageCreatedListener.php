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
        $response = Http::post(env('USER_SERVICE_URL') . '/users/by/preference', [
            'price' => $event->page['price'];
            'price_per_square' => $event->page['price_per_square'],
            'space' => $event->page['space'],
            'build_type' => $event->page['build_type'],
            'building_type' => $event->page['building_type'],
            'region' => $event->page['region'],
            'keywords' => $event->page['keywords'],
        ]);

        if($response->fails())
            throw new Exception("Error Processing Request. Http request failed. Users not found", 403);
        // Pluck user ids and return User object
        $users = User::find(collect($response->json())->pluck('id'));
        
        // Notify users by preference
        Notification::send($users, new PageCreatedNotification($event->page));
    }
}
