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

$router->group(['namespace' => 'Admin'], function() use ($router) {

	$router->post('/login', 'LoginController@login');
	$router->post('/register', 'RegisterController@register');

	$router->post('/email/resend', [
		'as' => 'verification.resend',
		'uses' => 'VerificationController@resend'
	]);

	$router->get('/email/verify/{id}/{hash}', [
		'as' => 'verification.verify',
		'uses' => 'VerificationController@verify'
	]);

	$router->get('/email/verify', [
		'as' => 'verification.notice',
		'uses' => 'VerificationController@show'
	]);
});

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/login', 'UserController@login');
$router->post('/register', 'UserController@register');

$router->group(['middleware' => 'auth'], function () use ($router) {

    $router->get('/user/{id}', function($id){
    	dd($id);
    });

});
