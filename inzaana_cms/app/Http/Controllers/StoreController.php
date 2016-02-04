<?php

namespace Inzaana\Http\Controllers;

use Illuminate\Http\Request;

use Inzaana\Http\Requests;
use Inzaana\Http\Controllers\Controller;

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
        $this->middleware('guest');
    }

    public function create(Request $request)
    {
    	if($request->exists('store_name') && $request->has('store_name'))
    	{
    		$storeName = $request->query('store_name');
    		return view('auth.register', compact('storeName'));
    	}
    	return redirect()->route('guest::home');
    }

}
