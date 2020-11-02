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

$router->get('/mail', function () use ($router) {
    return (new App\Notifications\PageRecorded())
                ->toMail('slavibio@abv.bg');
});
$router->get('/notify', 'NotificationController@notify');
$router->get('/notify/via/email', 'NotificationController@notifyViaEmail');