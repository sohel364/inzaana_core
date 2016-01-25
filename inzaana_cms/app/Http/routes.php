<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
| --------------------------
| Server deployment routing
| --------------------------
*/

Route::get('/', 'HomeController@index');

Route::group(array('before' => 'guest'), function () {
	
// Authentication routes...
// Registration routes...
// Route::controller('/auth', 'Auth\AuthController', [
//     'getRegister' => 'auth.get.register',
//     'postRegister' => 'auth.post.register',
//     'postLogin' => 'auth.post.login',
//     'getLogin' => 'auth.get.login',
//     'getLogout' => 'auth.get.logout',
// ]);

});

// Route::get('/dashboard', ['uses' => 'UserController@create', 'as' => 'user.home']);

// ==============  ADDED AFTER 5.2 LARAVEL MIGRATION ========================== //
Route::group(['middleware' => 'web'], function () {
	
	// Registration routes...
	Route::get('auth/register', 'Auth\AuthController@getRegister');
	Route::post('auth/register', 'Auth\AuthController@postRegister');

    Route::auth();

    Route::get('/dashboard/{id}', 'UserController@show');
});
