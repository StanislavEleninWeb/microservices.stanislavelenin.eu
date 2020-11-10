<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;

use App\Notifications\PageRecordedNotification;

use Illuminate\Support\Facades\Mail;
use App\Mail\PageRecordedMail;

use App\Models\User;

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

        // Mail::to('stanislaveleninweb@gmail.com')->send(new PageRecordedMail($request->all()));

        // dd($request->all());

        // Send post http request and process image urls
        $usersResponse = Http::post(env('USER_SERVICE_URL') . '/users', [
            'key' => $request->all(),
        ]);

        if($usersResponse->failed())
            return new Response('Could not load users', 400);

        $user = new User;

        $users = collect($usersResponse->json())
        ->map(function($item) use ($user) {
            $user = clone($user);

            $user->id = $item['id'];
            $user->name = $item['name'];
            $user->email = $item['email'];

            return $user;
        });

        Notification::send($users, new PageRecordedNotification($request->all()));

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

    public function test(){
        return app('db')->select('SELECT exception FROM failed_jobs');
    }


}
