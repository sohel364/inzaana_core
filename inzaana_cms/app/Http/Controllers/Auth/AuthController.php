<?php

namespace Inzaana\Http\Controllers\Auth;

use Inzaana\User;
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

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectTo = '/dashboard';
    protected $defaultStoreName = 'My New Store';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
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
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function getLogout()
    {
        return redirect('/');
    }

    public function getLogin()
    {
        return view('signin');
    }

    public function postLogin()
    {
        return redirect('/dashboard');
    }

    public function postRegister(AuthRequest $request)
    {
        $storeName = $request->input("store_name", $this->defaultStoreName);
        if(empty($storeName)) 
            $storeName = $this->defaultStoreName;

        $validator = $this->validator($request->all());

        if($validator->fails())
        {
            return redirect('/register')->with('store_name' , $storeName)->withErrors($validator)->withInput();
        }
        else
        {
            $user = $this->create([
                'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ]);
            if($user)
            {
                return redirect('/dashboard')->with('user', $user);
            }
        }
    }

    public function getRegister(AuthRequest $request)
    {
        $storeName = $request->query("store_name");
        if(empty($storeName)) 
            return redirect('/')->with('message', 'You forgot to put the name of your shop!');
        // dd($request->query());
        return view('auth.register')->with('store_name' , $storeName);
    }
}
