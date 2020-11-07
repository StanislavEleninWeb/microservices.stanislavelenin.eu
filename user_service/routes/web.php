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

$router->group(['namespace' => 'Auth'], function() use ($router) {

	$router->post('/login', 'LoginController@login');
	$router->post('/logout', 'LoginController@logout');
	$router->post('/register', 'RegisterController@register');

	$router->post('/email/resend', [
		'as' => 'verification.resend',
		'uses' => 'VerificationController@resend'
	]);

	$router->get('/email/verify/{id}/{hash}', [
		'as' => 'verification.verify',
		'uses' => 'VerificationController@verify'
	]);

	$router->post('/password/confirm', [
		'as' => 'password.confirm',
		'uses' => 'ConfirmPasswordController@confirm'
	]);

	$router->post('/password/email', [
		'as' => 'password.email',
		'uses' => 'ForgotPasswordController@ressendResetLinkEmailet'
	]);

	$router->post('/password/reset', [
		'as' => 'password.update',
		'uses' => 'ResetPasswordController@reset'
	]);
});

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/users', 'UserController@index');

$router->group(['middleware' => 'auth'], function () use ($router) {

    $router->get('/user/{id}', function($id){
    	dd($id);
    });

});
