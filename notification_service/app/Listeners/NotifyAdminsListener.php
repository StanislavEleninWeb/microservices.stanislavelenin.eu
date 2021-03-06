<?php

namespace App\Listeners;

use App\Events\NotifyAdminsEvent as Event;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;

use App\Notifications\NotifyAdminsNotification;
use App\Models\User;

class NotifyAdminsListener implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\ExampleEvent  $event
     * @return void
     */
    public function handle(Event $event)
    {
        $response = Http::get(env('USER_SERVICE_URL') . '/users');

        if($response->failed())
            throw new \Exception('NotifyAdminsListener no valid response data', ResponseCodes::HTTP_BAD_REQUEST);

        $admins = User::find(collect($response->json())->pluck('id'));
        
        Notification::send($admins, new NotifyAdminsNotification($event));
    }
}
