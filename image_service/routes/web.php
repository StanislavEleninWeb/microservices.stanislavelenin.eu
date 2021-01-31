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

$router->get('/page/{id}/images', 'ImageController@index');
$router->post('/images', 'ImageController@store');
$router->get('/image/{id}', 'ImageController@show');
$router->delete('/image/{id}', 'ImageController@destroy');

/*
|--------------------------------------------------------------------------
| Failed jobs Routes
|--------------------------------------------------------------------------
|
| Here is where you can manage failed jobs
|
*/
$router->get('/failed/jobs', 'FailedJobsController@getFailedJobs');