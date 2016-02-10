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

	Route::get('/register/confirm/{token}', 'Auth\AuthController@confirmEmail');
	Route::get('/{role_name}/login/', 'UserController@login');
	Route::get('/r/{role_name}/u/{user_id}/dashboard', 'UserController@dashboard');

	Route::get('/create-store', [ 'uses' => 'StoreController@create', 'as' => 'stores.create' ]);

    Route::auth();

    Route::group([ 'as' => 'user::' ], function() {

    	Route::get('/dashboard', [ 'uses' => 'UserController@index', 'as' => 'home' ]);
        Route::get('/products', [ 'uses' => 'ProductController@index', 'as' => 'products' ]);
        Route::get('/template_view', [ 'uses' => 'ProductController@gettemplate', 'as' => 'template' ]);
        Route::get('/add_category', [ 'uses' => 'ProductController@viewcategory', 'as' => 'category' ]);
        Route::get('/user_dashboard', [ 'uses' => 'ProductController@userdashboard', 'as' => 'udashboard' ]);
        Route::get('/user_my_order', [ 'uses' => 'ProductController@usermyorder', 'as' => 'umyorder' ]);
        Route::get('/user_product_return', [ 'uses' => 'ProductController@userproductreturn', 'as' => 'uproductreturn' ]);
        Route::get('/user_reward_points', [ 'uses' => 'ProductController@userrewardpoints', 'as' => 'urewardpoints' ]);
        Route::get('/user_wallet', [ 'uses' => 'ProductController@userwallet', 'as' => 'uwallet' ]);
        Route::get('/products/search', [ 'uses' => 'ProductController@search', 'as' => 'products.search' ]);
        Route::get('/products/search/{terms?}', [ 'uses' => 'ProductController@searchTerms', 'as' => 'products.search-terms' ]);
        Route::get('/products/create', [ 'uses' => 'ProductController@store', 'as' => 'products.store' ]);
        Route::post('/products/create', [ 'uses' => 'ProductController@create', 'as' => 'products.create' ]);
    });
});
