<?php

namespace Inzaana\Http\Controllers;

use Illuminate\Http\Request as OrderRequest;

use Inzaana\Http\Requests;

use Auth;

class ProductOrderController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(OrderRequest $request)
    {
        $cart = session('cart');

        if(!session()->has('cart') || count($cart->items) == 0)
        {
            flash()->error('Your shopping cart is empty!');
        }

        // place your order here

        // if($order->save())
        // {
        //     flash()->success('Your order is placed successfully! Track your order here.');
        // }

        // send mail to cutomer, admin and vendor to send link of their respective tracking page

        $user = Auth::user();
        $viewName = 'order-tracking-';
        if($user->isAdmin())
        {
        	$viewName .= 'admin';
        }
        else if($user->isCustomer())
        {
        	$viewName .= 'customer';
        }
        else
        {
        	$viewName .= 'admin';
        }
        return view($viewName);
    }
}
