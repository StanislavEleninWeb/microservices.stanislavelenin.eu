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

$router->get('/notifications/unread/user/{id}', 'NotificationController@getUnreadNotifications');
$router->get('/notifications/user/{id}', 'NotificationController@getNotifications');
$router->get('/notifications/{id}/read', 'NotificationController@markNotificationAsRead');
$router->get('/notifications/{id}', 'NotificationController@getNotificationById');

$router->post('/notify/admin', 'NotificationController@notifyAdmin');
$router->post('/notify/user/created', 'NotificationController@notifyUserCreated');
$router->post('/notify/page/created', 'NotificationController@notifyPageCreated');
