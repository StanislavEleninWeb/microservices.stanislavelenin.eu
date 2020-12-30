<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

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
        $post = [];

        if(isset($event->page['price']))
            $post['price'] = $event->page['price'];
        if(isset($event->page['price_per_square']))
            $post['price_per_square'] = $event->page['price_per_square'];
        if(isset($event->page['space']))
            $post['space'] = $event->page['space'];
        if(isset($event->page['build_type']))
            $post['build_type'] = $event->page['build_type'];
        if(isset($event->page['building_type']))
            $post['building_type'] = $event->page['building_type'];
        if(isset($event->page['city']))
            $post['city'] = $event->page['city'];
        if(isset($event->page['region']))
            $post['region'] = $event->page['region'];
        if(isset($event->page['keywords']))
            $post['keywords'] = $event->page['keywords'];

        $response = Http::post(env('USER_SERVICE_URL') . '/users/by/preference', $post);

        if($response->failed())
            throw new Exception("Error Processing. Http request failed. Users not found", 403);

        // Pluck user ids and return User object
        $users = User::find(collect($response->json())->pluck('id'));
        
        // Notify users by preference
        Notification::send($users, new PageCreatedNotification($event->page));
    }
}
