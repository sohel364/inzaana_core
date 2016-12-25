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
    Route::get('/suggest/input/{input}', [ 'uses' => 'HomeController@suggest', 'as' => 'suggest.home.stores' ]);
    // Subdomain routing
    Route::group(array('domain' => '{name}.inzaana.{domain}'), function() {
        
        Route::get('/showcase', [ 'uses' => 'HomeController@redirectToStore', 'as' => 'showcase' ]); 
    });
});

Route::get('/robi', function(){

    return view('robi');
});

Route::group(['middleware' => 'web'], function () {

    Route::get('/swap-plan', [ 'uses' => 'StripeController@swapPlan', 'as' => 'swap' ]); // Plan swaping
    Route::get('/subscribe', [ 'uses' => 'UserController@redirectToVendorPlan', 'as' => 'subscribe' ]); //When onTrial time expired middleware redirect every request to this route
    Route::post('/subscribe', [ 'uses' => 'StripeController@subscriptionPlan', 'as' => 'vendor.subscriptionPlan' ]);
    Route::post('/plan-swap', [ 'uses' => 'StripeController@swapSubscriptionPlan', 'as' => 'swapSubscriptionPlan' ]);

    Route::group(['as' => 'admin::'], function () {
        //Email notifications
        Route::post('/super-admin/email-notification', [ 'uses' => 'StripeController@emailNotifications', 'as'=> 'email.notification']);
        //Stripe Route for Super Admin
        Route::get('/super-admin/create-coupon', [ 'uses' => 'StripeController@couponForm', 'as'=> 'couponForm']);
        Route::post('/super-admin/create-coupon', [ 'uses' => 'StripeController@createCoupon', 'as'=> 'create.coupon']);
        Route::get('/super-admin/view-coupon', [ 'uses' => 'StripeController@viewCoupon', 'as'=> 'viewCoupon']);
        Route::post('/super-admin/delete-coupon', [ 'uses' => 'StripeController@deleteCoupon', 'as'=> 'deleteCoupon']);
        Route::post('/super-admin/view-coupon/ajax/update', [ 'uses' => 'StripeController@updateCouponStatus', 'as'=> 'updateCouponStatus']);

        Route::get('/super-admin/edit-coupon/{id}', [ 'uses' => 'StripeController@editCouponView', 'as'=> 'editCoupon']);
        Route::post('/super-admin/edit-coupon', [ 'uses' => 'StripeController@couponUpdate', 'as'=> 'couponUpdate']);

        Route::get('/super-admin/create-plan', [ 'uses' => 'StripeController@planForm', 'as'=> 'planForm']);
        Route::post('/super-admin/create-plan', [ 'uses' => 'StripeController@createPlan', 'as'=> 'create.plan']);
        Route::get('/super-admin/view-plan', [ 'uses' => 'StripeController@viewPlan', 'as'=> 'viewPlan']);
        Route::post('/super-admin/delete-plan', [ 'uses' => 'StripeController@deletePlan', 'as'=> 'deletePlan']);
        Route::post('/super-admin/view-plan/ajax/update', [ 'uses' => 'StripeController@updateStatus', 'as'=> 'updateStatus']);

        Route::get('/super-admin/edit-feature/{id}', [ 'uses' => 'StripeController@editPlanFeatureView', 'as'=> 'editPlanFeature']);
        Route::post('/super-admin/edit-feature', [ 'uses' => 'StripeController@planFeatureUpdate', 'as'=> 'planFeatureUpdate']);

        Route::get('/super-admin/view-subscriber', [ 'uses' => 'StripeController@viewSubscriber', 'as'=> 'viewSubscriber']);
        Route::post('/super-admin/view-subscriber/approvals/confirm/{id}', [ 'uses' => 'StripeController@changeState', 'as'=> 'subscribers.approvals.confirm']);

        Route::get('/super-admin/approvals', [ 'uses' => 'UserController@approvals', 'as'=> 'approvals']);
        Route::get('/super-admin/approvals/manage', [ 'uses' => 'UserController@manageApprovals', 'as'=> 'approvals.manage']);
        Route::get('/super-admin/faqs', [ 'uses' => 'UserController@faqs', 'as'=> 'faqs']);
        Route::post('/super-admin/faqs/create', [ 'uses' => 'UserController@createFaqs', 'as'=> 'faqs.create']);
    });

    Route::auth();

    // Routing grouped by namespace
    Route::group(['namespace' => 'Auth'], function() {

        Route::group([ 'as' => 'guest::' ], function() {

            Route::get('/register/confirm/{token}/site/{site}/store/{store}/business/{business}', [ 'uses' => 'AuthController@confirmEmail', 'as' => 'register.confirm.vendor' ]);
            Route::get('/register/confirm/{token}', [ 'uses' => 'AuthController@confirmEmailCustomer', 'as' => 'register.confirm.customer' ]);
            Route::get('/signup', [ 'uses' => 'AuthController@showSignupForm', 'as' => 'signup' ]);

            // TODO: routes for way to register from different user like: super admin/ vendor/ customer
            Route::get('/signup/customer', [ 'uses' => 'AuthController@redirectToCustomerSignup', 'as' => 'signup.customer' ]);
            Route::get('/signup/admin', [ 'uses' => 'AuthController@mailToAdminForSpecialSignup', 'as' => 'signup.mailto.admin' ]);
            Route::get('/signup/admin/t/{token}/o/{original}', [ 'uses' => 'AuthController@redirectToAdminSignup', 'as' => 'signup.admin' ]);
        });

    });

    Route::get('/edit/mail/confirm/users/{user}/name/{name}/email/{email}/phone/{phone}/password/{password?}/address/{address?}',
        [ 'uses' => 'UserController@confirmProfileUpdate', 'as' => 'edit.confirm' ])
        ->where([ 'address' => '.*', 'phone' => '[+0-9]{3,4}+[-]+[0-9]+', 'password' => '.*' ]); // validation phone => (?:\s+|)((0|(?:(\+|)91))(?:\s|-)*(?:(?:\d(?:\s|-)*\d{9})|(?:\d{2}(?:\s|-)*\d{8})|(?:\d{3}(?:\s|-)*\d{7}))|\d{10})(?:\s+|);

    Route::group([ 'as' => 'user::' ], function() {


        Route::get('/user_my_order', [ 'uses' => 'UserController@usermyorder', 'as' => 'orders' ]);
        Route::get('/user_product_return', [ 'uses' => 'UserController@userproductreturn', 'as' => 'products.return' ]);
        Route::get('/user_reward_points', [ 'uses' => 'UserController@userrewardpoints', 'as' => 'reward-points' ]);
        Route::get('/user_wallet', [ 'uses' => 'UserController@userwallet', 'as' => 'wallet' ]);
        Route::get('/who-am-i', [ 'uses' => 'UserController@user', 'as' => 'info' ]);

        // routes grouped by /dashboard
        Route::group(['prefix' => 'dashboard'], function () {

            // User controller
            Route::get('/', [ 'uses' => 'UserController@index', 'as' => 'home' ]);

            // route: /dashboard/
            Route::get('/admin', [ 'uses' => 'UserController@redirectToDashboardAdmin', 'as' => 'admin.dashboard' ]);
            Route::get('/customer', [ 'uses' => 'UserController@redirectToDashboardCustomer', 'as' => 'customer.dashboard' ]);
            Route::get('/edit/users/{user}', [ 'uses' => 'UserController@edit', 'as' => 'edit' ]);
            Route::post('/edit/mail/users/{user}', [ 'uses' => 'UserController@verifyProfileChanges', 'as' => 'edit.email' ]);

            // Route::get('/postcodes/country/{country}', [ 'uses' => 'UserController@getPostCodes', 'as' => 'postcodes' ]);
            // Route::get('/states/country/{country}', [ 'uses' => 'UserController@getStates', 'as' => 'states' ]);

            // routes grouped by /vendor
            // route: /dashboard/vendor/
            Route::group(['prefix' => 'vendor'], function () {

                Route::get('/', [ 'uses' => 'UserController@redirectToDashboard', 'as' => 'vendor.dashboard' ]); 
                Route::get('/plan', [ 'uses' => 'UserController@redirectToVendorPlan', 'as' => 'vendor.plan' ]);
                Route::post('/plan', [ 'uses' => 'StripeController@subscriptionPlan', 'as' => 'vendor.subscriptionPlan' ]);
                Route::get('/view-my-subscription', [ 'uses' => 'StripeController@viewMySubscription', 'as'=> 'viewMySubscription']);
            });
        });

        // Featured group
        Route::group(['middleware' => ['feature','subscription'] ], function() {

            // routes grouped by /vendor
            // route: /dashboard/vendor/
            Route::group(['prefix' => 'vendor'], function () {

                Route::get('/tools', [ 'uses' => 'UserController@downloadTools', 'as'=>'vendor.tools']);
                Route::get('/licenses', [ 'uses' => 'UserController@getLicenseKeys', 'as'=>'vendor.licenses']);
            });

            // Store controller
            Route::group(['prefix' => 'stores'], function () {

                Route::get('/', [ 'uses' => 'StoreController@index', 'as' => 'stores' ]);           
                Route::get('/redirect/site/{site}', [ 'uses' => 'StoreController@redirectUrl', 'as' => 'stores.redirect' ]);           
                Route::get('/create/name/{name}/site/{site}/business/{business}', [ 'uses' => 'StoreController@createOnSignUp', 'as' => 'stores.create-on-signup' ]);           
                Route::post('/create', [ 'uses' => 'StoreController@create', 'as' => 'stores.create' ]);           
                Route::post('/{store}', [ 'uses' => 'StoreController@postUpdate', 'as' => 'stores.update' ]);           
                Route::get('/{store}/edit/', [ 'uses' => 'StoreController@update', 'as' => 'stores.edit' ]);           
                Route::post('/{store}/delete/', [ 'uses' => 'StoreController@delete', 'as' => 'stores.delete' ]); 
                Route::get('/approvals', [ 'uses' => 'StoreController@approvals', 'as' => 'stores.approvals' ]);
                Route::post('/approvals/confirm/{id}', [ 'uses' => 'StoreController@confirmApproval', 'as' => 'stores.approvals.confirm' ]);          
                Route::get('/suggest/input/{input}', [ 'uses' => 'StoreController@suggest', 'as' => 'stores.suggest' ]);          
            });

            // Template Controller
            Route::get('/templates/gallery', [ 'uses' => 'TemplateController@index', 'as' => 'templates' ]);
            Route::get('/templates/saved', [ 'uses' => 'TemplateController@showSaved', 'as' => 'templates.saved' ]);
            
            Route::get('/templates/info/{template_id}', [ 'uses' => 'TemplateController@info', 'as' => 'templates.info' ]);
            Route::get('/templates/template/{template_id}', [ 'uses' => 'TemplateController@show', 'as' => 'templates.show' ]);
            Route::get('/templates/category/{category_name}', [ 'uses' => 'TemplateController@categories', 'as' => 'templates.categories.show' ]);

            Route::get('/editor/{category}/{template}', [ 'uses'=>'TemplateController@browse', 'as'=>'templates.editor.browse' ]);
            Route::get('/editor/{category}/{template}/{template_id}', [ 'uses'=>'TemplateController@editor', 'as'=>'templates.editor.edit' ]);

            Route::get('/viewer/{saved_name}/{template_id}', [ 'uses'=>'TemplateController@show', 'as'=>'templates.viewer' ]);

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
            Route::get('/products/approvals', [ 'uses' => 'ProductController@approvals', 'as' => 'products.approvals' ]);
            Route::post('/products/approvals/confirm/{id}', [ 'uses' => 'ProductController@confirmApproval', 'as' => 'products.approvals.confirm' ]);
            Route::get('/products/import/csv/raw/records', function() {
                //$pi('product_inzaana_asset.csv')->getRaw()
                try
                {
                    $pi = new Inzaana\BulkExportImport\ProductImporter('product_inzaana_asset.csv');
                    return $pi->getProducts()['raw'];
                }
                catch(\Exception $e)
                {
                    return $e->getMessage();
                }
            });

            // Category controller
            Route::get('/categories', [ 'uses' => 'CategoryController@index', 'as' => 'categories' ]);
            Route::post('/categories/create', [ 'uses' => 'CategoryController@create', 'as' => 'categories.create' ]);
            Route::get('/categories/edit/{category_id}', [ 'uses' => 'CategoryController@edit', 'as' => 'categories.edit' ]);
            Route::post('/categories/edit/{category_id}', [ 'uses' => 'CategoryController@postEdit', 'as' => 'categories.update' ]);
            Route::post('/categories/delete/{category_id}', [ 'uses' => 'CategoryController@delete', 'as' => 'categories.delete' ]);
            Route::get('/categories/approvals', [ 'uses' => 'CategoryController@approvals', 'as' => 'categories.approvals' ]);
            Route::post('/categories/approvals/confirm/{id}', [ 'uses' => 'CategoryController@confirmApproval', 'as' => 'categories.approvals.confirm' ]);

            // HTML view menu controller
            Route::post('/html-view-menus/{template_id}', [ 'uses' => 'HtmlViewMenuController@contents', 'as' => 'menus.contents' ]);
            Route::post('/html-view-menus/content-default/{template_id}', [ 'uses' => 'HtmlViewMenuController@baseContent', 'as' => 'menus.content.default' ]);
            Route::post('/html-view-menus/create/{template_id}', [ 'uses' => 'HtmlViewMenuController@create', 'as' => 'menus.create' ]);

            // HTML view content controller
            Route::post('/html-view-contents/create', [ 'uses' => 'HtmlViewContentController@create', 'as' => 'html-view-contents.create' ]);

            // Media Archive Controller
            Route::post('/medias/save', [ 'uses' => 'MediaController@save', 'as' => 'medias.save' ]);
            Route::get('/medias/template/{template_id}', [ 'uses' => 'MediaController@reload', 'as' => 'medias.reload' ]);
            Route::get('/medias/images/{filename}', [ 'uses' => 'MediaController@image', 'as' => 'medias.image' ]);
        });
    });
});
