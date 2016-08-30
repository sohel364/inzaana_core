<?php

namespace Inzaana\Http\Controllers\Auth;

use Auth;
use Carbon\Carbon;
use Inzaana\User;
use Inzaana\Mailers\AppMailer;
use Illuminate\Http\Request;
use Validator;
use Inzaana\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

// @addedby tajuddin.khandaker.cse.ju@gmail.com
use Illuminate\Http\Request as AuthRequest;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use ThrottlesLogins;
    use AuthenticatesAndRegistersUsers {
        showRegistrationForm as showRegisterFormParent;
    }


    protected $redirectTo = '/dashboard';	

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout', 'getLogout']]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Get the route name from the previous url of session array
     *
     * @return User
     */
    public function getPreviousRouteName()
    {
        return $this->getRouteName(session()->previousUrl());
    }

    /**
     * Get the route name from the given url of session array
     *
     * @param  string  $url
     * @return string
     */
    protected function getRouteName($url)
    {
        return app('router')->getRoutes()->match(app('request')->create($url))->getName();
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */

    public function showRegistrationForm()
    {
        //dd(session());
        if(!session()->has('store'))
        {
            session()->forget('store');
            return redirect('/');
        }
        return $this->showRegisterFormParent();
    }


    protected function create(array $data)
    {

        if($this->getPreviousRouteName() == "guest::signup" && !session()->has('store'))
        {
            abort(403, 'Unauthorized action.');
        }
        if(!$this->getPreviousRouteName() && !session()->has('store'))
        {
            abort(403, 'Unauthorized action.');
        }
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'verified' => false,
            'password' => bcrypt($data['password']),
            'trial_ends_at' => Carbon::now()->addDays(10),
        ]);
        // USED TO -> UserController@index
        // session(compact('user'));
        return $user;
    }

    /**
     * Confirm a vendor user's email address.
     *
     * @param  string $token
     * @param  string $site
     * @param  string $store
     * @return mixed
     */
    public function confirmEmail($token, $site, $store)
    {

        $user = User::whereToken($token)->firstOrFail();
        $errors = [];

        if(!$user->confirmEmail())
        {
            if($user->remove())
            {
                $errors['AUTH_CONFIRM'] = 'User authentication is not confirmed. Please signup to create your store again. For assistance contact administrator.';
            }
            return redirect()->route('guest::home')->with('errors', collect($errors));
        }
        // USED TO -> 'Auth\AuthController@create'
        session(compact('site', 'store'));
        flash('You are now confirmed. Please login.');
        return redirect('/login');
    }

    /**
     * Confirm a customer's email address.
     *
     * @param  string $token
     * @return mixed
     */
    public function confirmEmailCustomer($token)
    {
        $user = User::whereToken($token)->firstOrFail();
        $errors = [];

        if(!$user->confirmEmail())
        {
            if($user->remove())
            {
                $errors['AUTH_CONFIRM'] = 'User authentication is not confirmed. Please signup to create your account again. For assistance contact administrator.';
            }
            return redirect()->route('guest::home')->with('errors', collect($errors));
        }
        flash('You are now confirmed. Please login.');
        return redirect('/login');
    }

    /**
     * Navigates to signup form for signup or back to guest home
     */
    public function showSignupForm(AuthRequest $request)
    {
        $errors = [];
        if(!$request->exists('store_name') || !$request->has('store_name'))
        {
            $errors['store'] = 'Please give your store a name to signup.';
        }
        if(count($errors) > 0)
            return response()->view('home', [ 'errors' => collect($errors) ]);

        $store = $request->query('store_name');
        $subdomain = strtolower($request->query('subdomain'));
        $domain = $request->query('domain');
        $site = strtolower(str_replace(' ', '', $store)) . '.' . $subdomain . '.' . $domain;

        // USED TO -> UserController@index
        session(compact('site', 'store'));

        return redirect('/register')->with('storeName', $store)
                                    ->with('subdomain', $subdomain)
                                    ->with('domain', $domain);
    }

    public function redirectToAdminSignup($token, $original)
    {
        if($token != bcrypt($original))
        {
            $errors['ADMIN_LOGIN_URL_INVALID'] = 'You are not authorized for this login!';
            return response()->view('home', [ 'errors' => collect($errors) ]); 
        }
        return redirect()->guest('/register')->with('role', 'ADMIN');
    }

    public function redirectToCustomerSignup()
    {
        return response()->view('auth.register-customer', [ 'errors' => collect([]) ]);
    }

    public function mailToAdminForSpecialSignup(AdminMailer $mailer)
    {
        $mailer->sendEmailToAdminForSignupUrl();
        $errors['ADMIN_LOGIN_ATTEMPT'] = 'You are not authorized to signup as super admin!';
        return response()->view('home', [ 'errors' => collect($errors) ]);  
    }
}
