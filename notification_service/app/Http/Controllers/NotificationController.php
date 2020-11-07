<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;

use App\Notifications\PageRecordedNotification;

class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function notifyPageCreated(Request $request)
    {
        // Send post http request and process image urls
        $usersResponse = Http::post(env('USER_SERVICE_URL') . '/users', [
            'key' => $request->all(),
        ]);

        if($usersResponse->failed())
            return new Response('Could not load users', 400);

        $users = collect($usersResponse->json());

        Notification::send($users->pluck(['email']), new PageRecordedNotification($request->all()));

        return new Response('Successfully queued notifications.', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function notifyViaEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'to.*' => 'required|email',
            'cc.*' => 'nullable|email',
            'message' => 'required|string',
        ]);

        dispatch(new ProcessImageFileJob($request->input('page'), $image));

        return new Response('Successfully queued for upload.', 200);
    }


}
