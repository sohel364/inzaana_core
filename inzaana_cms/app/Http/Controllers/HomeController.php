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
        return view('home');
    }

    public function redirectToStore($name, $domain)
    {
        // return redirect()->route('guest::home');
        // return HomeRedirect::to('http://' . $site . '/');
        // return 'THIS IS PUBLIC PAGE (' . $name . '.inzaana.' . $domain . '/showcase) FOR VENDOR\'S STORE';

        $products = Store::whereNameAsUrl($name)->first()->user->products;

        // dd($products->first()->product_title);

        return view('vendor-store')->withProducts($products)->withSubDomain($name . '.inzaana.' . $domain)->withStoreNameUrl($name);
    }
}
