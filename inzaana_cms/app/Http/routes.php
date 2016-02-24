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

	Route::get('/create-store', [ 'uses' => 'StoreController@create', 'as' => 'stores.create' ]);

    Route::auth();

    Route::group([ 'as' => 'user::' ], function() {

        // User controller
    	Route::get('/dashboard', [ 'uses' => 'UserController@index', 'as' => 'home' ]);
        Route::get('/user_dashboard', [ 'uses' => 'UserController@userdashboard', 'as' => 'home.customer' ]);
        Route::get('/user_my_order', [ 'uses' => 'UserController@usermyorder', 'as' => 'orders' ]);
        Route::get('/user_product_return', [ 'uses' => 'UserController@userproductreturn', 'as' => 'products.return' ]);
        Route::get('/user_reward_points', [ 'uses' => 'UserController@userrewardpoints', 'as' => 'reward-points' ]);
        Route::get('/user_wallet', [ 'uses' => 'UserController@userwallet', 'as' => 'wallet' ]);

        // Template Controller
        Route::get('/templates/gallery', [ 'uses' => 'TemplateController@index', 'as' => 'templates' ]);
        Route::get('/templates/info/{template_id}', [ 'uses' => 'TemplateController@info', 'as' => 'templates.info' ]);
        Route::get('/templates/template/{template_id}', [ 'uses' => 'TemplateController@show', 'as' => 'templates.show' ]);
        Route::get('/templates/category/{category_name}', [ 'uses' => 'TemplateController@categories', 'as' => 'templates.categories.show' ]);

        Route::get('/editor/{category}/{template}', [ 'uses'=>'TemplateController@browse', 'as'=>'templates.editor.browse' ]);
        Route::get('/editor/{category}/{template}/{template_id}', [ 'uses'=>'TemplateController@editor', 'as'=>'templates.editor.edit' ]);

        Route::post('/templates/create', [ 'uses' => 'TemplateController@create', 'as' => 'templates.create' ]);
        Route::post('/templates/edit/{template_id}', [ 'uses' => 'TemplateController@edit', 'as' => 'templates.edit' ]);

        // Product controller
        Route::get('/products', [ 'uses' => 'ProductController@index', 'as' => 'products' ]);
        Route::get('/products/search', [ 'uses' => 'ProductController@search', 'as' => 'products.search' ]);
        Route::get('/products/search/{terms?}', [ 'uses' => 'ProductController@searchTerms', 'as' => 'products.search-terms' ]);
        Route::post('/products/create', [ 'uses' => 'ProductController@create', 'as' => 'products.create' ]);
        Route::post('/products/sell-yours/{id}', [ 'uses' => 'ProductController@copy', 'as' => 'products.sell-yours' ]);
        Route::post('/products/edit/{product_id}', [ 'uses' => 'ProductController@edit', 'as' => 'products.edit' ]);
        Route::post('/products/delete/{product_id}', [ 'uses' => 'ProductController@delete', 'as' => 'products.delete' ]);

        // Category controller
        Route::get('/categories', [ 'uses' => 'CategoryController@index', 'as' => 'categories' ]);
        Route::post('/categories/create', [ 'uses' => 'CategoryController@create', 'as' => 'categories.create' ]);
        Route::post('/categories/edit/{category_id}', [ 'uses' => 'CategoryController@edit', 'as' => 'categories.edit' ]);
        Route::post('/categories/delete/{category_id}', [ 'uses' => 'CategoryController@delete', 'as' => 'categories.delete' ]);
    });
});
