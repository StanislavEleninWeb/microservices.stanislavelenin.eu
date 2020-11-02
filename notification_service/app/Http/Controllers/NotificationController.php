<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

use App\Notifications\PageRecorded;

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
    public function notify(Request $request)
    {
        // Send post http request and process image urls
        $users = Http::get(env('USER_SERVICE_URL') . '/users', [
            'page' => $page_id,
            'images' => $results['images'],
        ]);

        Notification::send($users, new PageRecorded($page));

        return new Response('Successfully queued for upload.', 200);
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
