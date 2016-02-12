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
    Route::get('/editor/{category}/{template}', ['as'=>'editor', function($category, $template){
        return view('editor.template-editor', ['category'=>$category, 'template'=>$template]);
    }]); 
});

Route::group(['middleware' => 'web'], function () {

	Route::get('/register/confirm/{token}', 'Auth\AuthController@confirmEmail');

	Route::get('/create-store', [ 'uses' => 'StoreController@create', 'as' => 'stores.create' ]);

    Route::auth();

    Route::group([ 'as' => 'user::' ], function() {

        // User controller
    	Route::get('/dashboard', [ 'uses' => 'UserController@index', 'as' => 'home' ]);

        Route::get('/template_view', [ 'uses' => 'ProductController@gettemplate', 'as' => 'template' ]);
        Route::get('/user_dashboard', [ 'uses' => 'ProductController@userdashboard', 'as' => 'udashboard' ]);
        Route::get('/user_my_order', [ 'uses' => 'ProductController@usermyorder', 'as' => 'umyorder' ]);
        Route::get('/user_product_return', [ 'uses' => 'ProductController@userproductreturn', 'as' => 'uproductreturn' ]);
        Route::get('/user_reward_points', [ 'uses' => 'ProductController@userrewardpoints', 'as' => 'urewardpoints' ]);
        Route::get('/user_wallet', [ 'uses' => 'ProductController@userwallet', 'as' => 'uwallet' ]);

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
