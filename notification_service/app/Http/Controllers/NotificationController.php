<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseCodes;

use App\Events\PageCreatedEvent;
use App\Events\UserCreatedEvent;

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
            return response('User service no valid response data', ResponseCodes::HTTP_BAD_REQUEST);

        event(new PageCreatedEvent($usersResponse->json(), $request->all()));

        return response(null, ResponseCodes::HTTP_NO_CONTENT);
    }

    /**
     * Dispatch UserCreatedEvent and notify user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function notifyUserCreated(Request $request)
    {
        event(new UserCreatedEvent($request->all()));

        return response('Event successfully executed!', ResponseCodes::HTTP_CREATED);
    }

}
