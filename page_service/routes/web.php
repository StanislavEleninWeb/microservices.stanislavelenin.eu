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

/*
|--------------------------------------------------------------------------
| Source Routes
|--------------------------------------------------------------------------
|
| Here is where you can CRUD source
|
*/
$router->get('/source', 'SourceController@index');
$router->get('/source/{id}', 'SourceController@show');
$router->post('/source', 'SourceController@store');
$router->patch('/source/{id}', 'SourceController@update');
$router->delete('/source/{id}', 'SourceController@destroy');

/*
|--------------------------------------------------------------------------
| Source Routes
|--------------------------------------------------------------------------
|
| Here is where you can CRUD source
|
*/
$router->get('/page', 'PageController@index');
$router->get('/page/{id}', 'PageController@show');
$router->post('/page', 'PageController@store');
$router->patch('/page/{id}', 'PageController@update');
$router->delete('/page/{id}', 'PageController@destroy');


/*
|--------------------------------------------------------------------------
| Page Info Rating AVG, MIN, MAX
|--------------------------------------------------------------------------
|
| Here is where you get rating information
|
*/
$router->post('/pages/last/quarter/rating', 'PageController@lastQuarterRating');

/*
|--------------------------------------------------------------------------
| Source Routes
|--------------------------------------------------------------------------
|
| Here is where you can CRUD source
|
*/
$router->get('/test', 'TestController@index');
$router->get('/test/generate/url/request', 'TestController@testGenerateUrlRequest');
$router->get('/test/analyze/content', 'TestController@testAnalyzeContent');
$router->get('/test/images', 'TestController@images');
$router->get('/failed/jobs', 'TestController@failedJobs');
