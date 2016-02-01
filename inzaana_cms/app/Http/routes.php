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

Route::group([ 'as' => 'guest::' ], function() {

	Route::get('/', [ 'uses' => 'HomeController@index', 'as' => 'home' ]);
});

Route::group(['middleware' => 'web'], function () {

	Route::get('/auth/login', [ 'uses' => 'Auth\AuthController@getLogin', 'as' => 'login' ]);

    Route::auth();

    Route::group([ 'as' => 'user::' ], function() {
    	Route::get('/dashboard', [ 'uses' => 'UserController@index', 'as' => 'home' ]);
        Route::get('/products', [ 'uses' => 'ProductController@index', 'as' => 'products' ]);
        Route::post('/products/create', [ 'uses' => 'ProductController@create', 'as' => 'products.create' ]);
    });
});

