<?php

namespace Inzaana\Http\Controllers;

use Auth;
use Session;
use Inzaana\User;
use Inzaana\Mailers\AppMailer;
use Illuminate\Http\Request;
use Inzaana\StripePlan;

use Inzaana\Http\Requests;
use Inzaana\Http\Controllers\Controller;

// @addedby tajuddin.khandaker.cse.ju@gmail.com
use Illuminate\Support\Facades\Input as UserInput;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, AppMailer $mailer)
    {
        //
        if(Auth::guest())
        {
            flash()->error('Your session is timed out. Please login and confirm again.');
            return Auth::guest('/login');
        }
        if(!Auth::user()->verified) //&& $request->session()->has('user')
        {            
            // USED FROM -> 'Auth\AuthController@showSignupForm'
            // $user = session('user');
            $user = User::find(Auth::user()->id);

            // If it's a vendor user verification
            if(session()->has('site') && session('store'))
            {
                // USED FROM -> 'Auth\AuthController@showSignupForm'
                $data['site'] = session('site');
                $data['storeName'] = session('store');

                $mailer->sendEmailConfirmationTo($user, $data);  
            }
            // If it's a customer or super admin user verification
            else
            {
                $mailer->sendEmailConfirmationToCustomer($user);  
            } 
            
            flash('Please confirm your email address.');
            
            Auth::logout();

            return redirect('/login');
        }
        // If signup verified an usual login to proceed
        if(!session()->has('site') || !session()->has('store'))
        {
            $user = User::find(Auth::user()->id);
            if($user)
            {
                if($user->email == config('mail.admin.address'))
                {
                    return redirect()->route('user::admin.dashboard');
                }
                if($user->stores()->count() == 0)
                { 
                    return redirect()->route('user::customer.dashboard');
                }
                return redirect()->route('user::vendor.dashboard'); 
            }
            abort(404);
        }
        // If vendor user is verified after signup
        $site = session('site');
        $store = session('store');
        return redirect()->route('user::stores.create', compact('store', 'site'));
    }   

    // View to vendor admin dashboard
    public function redirectToDashboard()
    {
        if(session()->has('site') || session()->has('store'))
        {
            session()->forget('site');
            session()->forget('store');  
        }        
        $user = User::find(Auth::user()->id);
        if($user)
        {
            if($user->email == config('mail.admin.address'))
            {
                return redirect()->route('user::admin.dashboard');
            }
            if($user->stores()->count() == 0)
            { 
                return redirect()->route('user::customer.dashboard');
            }
        }
        return view('admin')->with('user', Auth::user());
    }    

    // View plan for vendor
    public function redirectToVendorPlan()
    {
        /*
         * View Plan for subscription
         * Using laravel cashier for plan retrieval
         * Method call from Route::get('/dashboard/vendor/plan', [ 'uses' => 'UserController@redirectToVendorPlan', 'as' => 'vendor.plan' ]);
         * */
        $plan = StripePlan::where('active','=','1')->get();
        return view('plan',compact('plan'))->with('user', Auth::user())
                                            ->with('authenticated', Auth::check());
    }

    // View plan for vendor
    public function redirectToDashboardAdmin()
    {
        $user = User::find(Auth::user()->id);
        if($user)
        {
            if($user->email == config('mail.admin.address'))
            {
                /*
                 * View Plan for subscription
                 * Using laravel cashier for plan retrieval
                 * Method call from Route::get('/dashboard/vendor/plan', [ 'uses' => 'UserController@redirectToVendorPlan', 'as' => 'vendor.plan' ]);
                 * */
                $plan = StripePlan::where('active','=','1')->get();
                return view('super-admin.dashboard',compact('plan'))->with('user', Auth::user())
                                                    ->with('authenticated', Auth::check());
            }
            if($user->stores()->count() == 0)
            { 
                return redirect()->route('user::customer.dashboard');
            }
            return redirect()->route('user::vendor.dashboard'); 
        }
        return redirect('/');
    }

    // view to customer dashboard
    public function redirectToDashboardCustomer()
    {
        $user = User::find(Auth::user()->id);
        if($user)
        {
            if($user->email == config('mail.admin.address'))
            {
                return redirect()->route('user::admin.dashboard');
            }
            if($user->stores()->count() == 0)
            {
                return view('user_dashboard')->with('user', Auth::user())
                                             ->with('authenticated', Auth::check());
            }
            return redirect()->route('user::vendor.dashboard'); 
        }
        return redirect('/');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    // Find who is authenticated currently
    public function user(Request $request)
    {
        if( $request->ajax() )
        {
            $success = true;
            $user = User::find(Auth::user()->id);
            if(!$user)
            {
                $success = false;
                $message = 'User not authenticated. Redirecting to home ...';
                return response()->json(compact('success', 'message', 'user'));    
            }
            return response()->json(compact('success', 'message', 'user'));
        }
        return redirect()->route('guest::home');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $hashed_user_id
     * @return \Illuminate\Http\Response
     */
    public function show($hashed_user_id)
    {
        $user = Auth::user();
        // if(bcrypt($user->id) == $hashed_user_id)
        if($user->id == $hashed_user_id)
        {
            return view('admin')->with('user', $user);
        }
        return redirect()->route('guest::home');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function usermyorder()
    {
        //
        return view('user_my_order');
    }

    public function userproductreturn()
    {
        //
        return view('user_product_return');
    }

    public function userrewardpoints()
    {
        //
        return view('user_reward_points');
    }

    public function userwallet()
    {
        //
        return view('user_wallet');
    }
}
