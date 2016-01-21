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

Route::get('/', function () {
	return view('home');
});

Route::group(array('before' => 'guest'), function () {
	
// Authentication routes...
// Registration routes...
Route::controller('/auth', 'Auth\AuthController', [
    'getRegister' => 'auth.get.register',
    'postRegister' => 'auth.post.register',
    'postLogin' => 'auth.post.login',
    'getLogin' => 'auth.get.login',
    'getLogout' => 'auth.get.logout',
]);

});

Route::get('/dashboard', ['uses' => 'UserController@create', 'as' => 'user.home']);