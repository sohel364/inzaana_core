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
if (file_exists(__DIR__.'/Controllers/ServerDeploymentController.php'))
{
    Route::get('/deploy', 'ServerDeploymentController@deploy');
}

Route::get('/', function () {
	return view('home');
});

Route::get('/sign-in', function () {
	return view('signin');
});


