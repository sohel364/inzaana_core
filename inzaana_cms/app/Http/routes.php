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

Route::get('/signin', function () {
	return view('signin');
<<<<<<< HEAD
});
=======
});

Route::get('/sign-up', function () {
	return view('signup');
});
>>>>>>> f4f97d5417756a72600203a524f7d204f3dfa1b7
