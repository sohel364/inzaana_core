<?php

namespace Inzaana\Http\Controllers;

use Inzaana\Http\Requests;
use Illuminate\Http\Request as HomeRequest;
use Redirect as HomeRedirect;
use Inzaana\Mailers\AppMailer as AdminMailer;

use Inzaana\User;
use Inzaana\Store;
use Inzaana\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::whereEmail(config('mail.admin.address'))->first();
        return view('home')->withAdminUser($user);
    }

    public function suggest($input)
    {
        $storeNames = Store::whereNameAsUrl(str_replace(' ', '', strtolower($input)))->get();
        if(!$storeNames->first())
            return response()->json([ 'store' => collect([]) ]);
        $storeNames = Store::suggest($input, 10);
        $suggestions = array();
        foreach ($storeNames as $name)
        {
            $storeNames = Store::whereNameAsUrl(str_replace(' ', '', strtolower($name)))->get();
            if(!$storeNames->first())
                $suggestions []= $name;
        } 
        $stores = empty($suggestions) ? $storeNames : $suggestions;
        return response()->json([ 'store' => collect($stores)->take(5) ]);
    }
}
