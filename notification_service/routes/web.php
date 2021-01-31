<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/markdown', function(){

	$user = App\Models\User::find(1);

	foreach ($user->unreadNotifications as $notification) {

		$page = $notification->data['page']['page'];


	    return new App\Mail\PageCreatedMail($page);

	    dd($notification->data);
	}
});

$router->get('/notifications/unread/user/{id}', 'NotificationController@getUnreadNotifications');
$router->get('/notifications/user/{id}', 'NotificationController@getNotifications');
$router->get('/notifications/{id}/read', 'NotificationController@markNotificationAsRead');
$router->get('/notifications/{id}', 'NotificationController@getNotificationById');

$router->post('/notify/admins', 'NotificationController@notifyAdmins');
$router->post('/notify/user/created', 'NotificationController@notifyUserCreated');
$router->post('/notify/page/created', 'NotificationController@notifyPageCreated');

$router->get('/notify/google/mail', 'NotificationController@googleMail');

/*
|--------------------------------------------------------------------------
| Failed jobs Routes
|--------------------------------------------------------------------------
|
| Here is where you can manage failed jobs
|
*/
$router->get('/failed/jobs', 'FailedJobsController@getFailedJobs');
