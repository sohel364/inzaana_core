<?php

namespace Inzaana\Http\Controllers;

use Illuminate\Http\Request as ProductRequest;

use Inzaana\Http\Requests;
use Inzaana\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the products. get method
     * Show the form for creating a new product. get method
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $productsCount = 0;
        return view('add-product', compact('productsCount'));
    }

    /**
     * Show the form for creating a new product. post method
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return redirect()->route('user::products');
    }

    /**
     * Show the form for creating a new product. post method
     *
     * @return \Illuminate\Http\Response
     */
    public function newProduct()
    {
        //
        $productsCount = 0;
        return view('add-product', compact('productsCount'));
    }

    public function search(ProductRequest $request)
    {        
        if($request->exists('search-box') && $request->has('search-box'))
        {
            $search_terms = $request->query('search-box');
            $search_terms_slugged = str_slug($search_terms);
            return redirect()->route('user::products.search-terms', [$search_terms_slugged])->with('search_terms', $search_terms);
        }
        return redirect()->route('user::products');
    }

    public function searchTerms($terms)
    {   
        $productsCount = 0;
        if(session()->has('search_terms'))
        {
            // search from database
            return  str_slug($terms). ' FOUND FROM ' . session('search_terms');
            // comment above code and run below with real data
            $products = null;
            return redirect()->route('user::products.search-terms', [$terms])
                    ->with('products', $products)
                    ->with('productsCount', $productsCount);
        }
        return 'nothing taj';
    }
}