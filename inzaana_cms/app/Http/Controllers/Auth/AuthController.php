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
        // dd($data);
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|confirmed|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'phone_number' => 'required|numeric|digits:11',
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

    // /**
    //  * Shows secured registration form
    //  *
    //  * @return \Illuminate\Http\Response
    //  */

    // public function showRegistrationForm()
    // {
    //     // if($this->getPreviousRouteName() != 'guest::signup')
    //     // {
    //     //     if(!session('storeName') || !session('store'))
    //     //     {
    //     //         return redirect()->route('guest::home');                
    //     //     }
    //     //     session()->forget('site');
    //     //     session()->forget('store');
    //     // }
    //     return $this->showRegisterFormParent()->withErrors(['Has errors']);
    // }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'] . ' ' . $data['last_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'country' => array_has($data, 'country') ? $data['country'] : '',
            'address' =>  array_has($data, 'address') ? $data['address'] : '',
            'verified' => false,
            'password' => bcrypt($data['password']),
            'trial_ends_at' => Carbon::now()->addDays(10),
        ]);
        session([ 'business' => array_has($data, 'business') ? $data['business'] : '' ]);
        // dd($data);
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
    public function confirmEmail($token, $site, $store, $business)
    {
        // USED TO -> 'Auth\AuthController@create'
        session(compact('site', 'store', 'business'));
        return $this->confirmEmailCustomer($token);
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
            session()->forget('site');
            session()->forget('store');
            session()->forget('business');
            return redirect()->route('guest::home', [ 'errors' => collect($errors) ]);
        }
        flash('You are now confirmed. Please login.');
        return redirect('/login');
    }

    /**
     * Navigates to signup form for signup or back to guest home
     */
    public function showSignupForm(AuthRequest $request)
    {
        if(!$request->exists('store_name') || !$request->has('store_name'))
        {
            return redirect()->route('guest::home');
        }

        $store = $request->query('store_name');
        $business = $request->query('business');
        $subdomain = strtolower($request->query('subdomain'));
        $domain = $request->query('domain');
        $site = strtolower(str_replace('.', '', str_replace(' ', '', $store))); // trimes spaces and removes dot (.) characters
        $site .= '.' . $subdomain . '.' . $domain;

        $inputsWithTableNames = [
            'name' => $store,
            'sub_domain' => $subdomain,
            'domain' => $domain
        ];
        $validator = Validator::make($inputsWithTableNames, [
            'name' => 'required|unique:stores|max:30',
            'sub_domain' => 'required',
            'domain' => 'required',
        ]);
        if ($validator->fails())
        {
            return response()->view('home', [ 'errors' => $validator->errors() ]);
        }
        // USED TO -> UserController@index
        session(compact('site', 'store', 'business'));

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
        return redirect()->guest('/register');
    }

    public function redirectToCustomerSignup()
    {
        return view('auth.register-customer', ['errors' => session()->has('errors') ? session('errors') : collect([])] );
    }

    public function mailToAdminForSpecialSignup(AdminMailer $mailer)
    {
        $mailer->sendEmailToAdminForSignupUrl();
        $errors['ADMIN_LOGIN_ATTEMPT'] = 'You are not authorized to signup as super admin!';
        return response()->view('home', [ 'errors' => collect($errors) ]);  
    }
}
