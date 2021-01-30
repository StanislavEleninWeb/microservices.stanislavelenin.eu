<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response as ResponseCodes;

use App\Events\NotifyAdminsEvent;
use App\Events\PageCreatedEvent;
use App\Events\UserCreatedEvent;

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
        
    }

    /**
     * Notify admins
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function notifyAdmins(Request $request)
    {
        event(new NotifyAdminsEvent($request->all()));

        return response(null, ResponseCodes::HTTP_NO_CONTENT);
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
        $response = Http::get(env('USER_SERVICE_URL') . '/users', [
            'key' => $request->all(),
        ]);

        if($response->failed())
            return response('User service no valid response data', ResponseCodes::HTTP_BAD_REQUEST);

        event(new PageCreatedEvent($response->json(), $request->all()));

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

    /**
     * Get user unread notifications from database
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUnreadNotifications($id)
    {
        $user = User::findOrFail($id);
        return response($user->unreadNotifications, ResponseCodes::HTTP_OK);
    }

    /**
     * Get user notifications from database
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getNotifications($id)
    {
        $user = User::findOrFail($id);
        return response($user->notifications, ResponseCodes::HTTP_OK);
    }

    /**
     * Mark user notification as read
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function markNotificationAsRead($id)
    {
        DB::table('notifications')->where('id', $id)->update([
            'read_at' => Carbon::now(),
        ]);
        return response('Successfully marked as read!', ResponseCodes::HTTP_ACCEPTED);
    }

    /**
     * Mark user notification as read
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getNotificationById($id)
    {
        $notification = DB::table('notifications')->where('id', $id)->get();
        return response($notification, ResponseCodes::HTTP_OK);
    }

    public function googleMail(){
        return Mail::to('stanislaveleninweb@gmail.com')->send(new \App\Mail\UserCreatedMail());
    }

}
