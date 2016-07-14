<?php

namespace Inzaana\Http\Controllers;

use Illuminate\Http\Request as StoreRequest;

use Inzaana\Http\Requests;
use Inzaana\Http\Controllers\Controller;

use Auth;
use Redirect as StoreRedirect;

use Inzaana\Store;

class StoreController extends Controller
{
    //
	/**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create($name, $site)
    {
        $keywords = preg_split("/[.]+/", $site);

        if(count($keywords) < 3)
        {     
            $errors['store'] = 'Failed to create store! Please check your shop name again.';
            return response()->view('home', [ 'errors' => collect($errors) ]);       
        }

        $storeNameUrl = $keywords[0];
        $subdomain = $keywords[1];
        $domain = $keywords[2];

        $store = Store::create([
            'name' => $name,
            'user_id' => Auth::user()->id,
            'name_as_url' => $storeNameUrl,
            'sub_domain' => $subdomain,
            'domain' => $domain
        ]);

        if(!$store)
        { 
            $errors['store'] = 'Failed to create store! Please check your shop name again.';
            return response()->view('home', [ 'errors' => collect($errors) ]);  
        }

        // @NOTE: Example code for site redirection
        // return StoreRedirect::to('http://' . $site . '/stores');
        return redirect()->route('user::stores.dashboard');
    }

    // View to vendor admin dashboard
    public function redirectToDashboard()
    {
        return view('admin')->with('user', Auth::user());
    }

}
