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
    protected $redirectToGuestHome = '/';

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
        return redirect($this->redirectToGuestHome);
    }

    public function getLogin()
    {
        return view('signin');
    }

    public function postLogin()
    {
        return redirect($this->redirectTo);
    }

    public function postRegister(AuthRequest $request)
    {
        $storeName = $request->input("store_name", $this->defaultStoreName);
        if(empty($storeName)) 
            $storeName = $this->defaultStoreName;

        $validator = $this->validator($request->all());

        if($validator->fails())
        {
            return redirect('/register')->with('store_name' , $storeName)->withErrors($validator)->withInput($request->except('password'));
        }
        else
        {
            $user = $this->create([
                'name' => $request->input('name') . ' ' . $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ]);

            if($user)
            {
                return redirect()->route('user::home', [ 'hashed_user_id' => bcrypt($user->id) ]);
            }
        }
    }

    public function getRegister()
    {
        // $storeName = $request->query("store_name");
        $storeName = Request::input('store_name');
        if(empty($storeName)) 
            return redirect()->route('guest::home')->withErrors('message', 'You forgot to put the name of your shop!');
        // dd($request->query());
        return redirect('/register')->with('storeName' , $storeName);//view('auth.register')->with('store_name' , $storeName);
    }
}
