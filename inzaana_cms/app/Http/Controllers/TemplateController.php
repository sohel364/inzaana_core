<?php

namespace Inzaana\Http\Controllers;

use Illuminate\Http\Request;

use Inzaana\Http\Requests;
use Inzaana\Http\Controllers\Controller;

class TemplateController extends Controller
{
    //
    
    public function gettemplate()
    {
        //
        $productsCount = 0;
        return view('view_template', compact('productsCount'));
    }
    public function viewcategory()
    {
        //
        $productsCount = 0;
        return view('add_category', compact('productsCount'));
    }
    public function userdashboard()
    {
        //
        $productsCount = 0;
        return view('user_dashboard', compact('productsCount'));
    }
    public function usermyorder()
    {
        //
        $productsCount = 0;
        return view('user_my_order', compact('productsCount'));
    }
    public function userproductreturn()
    {
        //
        $productsCount = 0;
        return view('user_product_return', compact('productsCount'));
    }
    public function userrewardpoints()
    {
        //
        $productsCount = 0;
        return view('user_reward_points', compact('productsCount'));
    }
    public function userwallet()
    {
        //
        $productsCount = 0;
        return view('user_wallet', compact('productsCount'));
    }

}
