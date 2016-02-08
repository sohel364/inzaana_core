<?php

namespace Inzaana\Http\Controllers;

use Auth;
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
        return view('category_view', compact('productsCount'));
    }

    /**
     * Calculates selling price
     */
    protected function getSellingPrice($mrp, $discount)
    {
        return $mrp * ( 1 -  ( $discount / 100.0) );
    }

    /**
     * Show the form for creating a new product. post method
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ProductRequest $request)
    {
        //
        $this->validate($request, [
            'product_title' => 'required',
        ]);
        // $this->validate($request, [
        //     'product_title' => 'required|unique:products|max:100',
        //     'product_mrp' => 'required|numeric',
        //     'manufacture_name' => 'required|max:200',
        //     'product_discount' => 'numeric|max:100',
        //     'selling_price' => 'numeric',
        //     'photo_name' => 'required|url|active_url|image',
        // ]);

        // $mrp = $request->input('mrp');
        // $discount = $request->input('discount');

        // $product = Product::create([
        //     'user_id' => Auth::user()->id,
        //     'has_sub_category_id' => false,
        //     'category_subcategory_id' => 1,
        //     'product_title' => $request->input('product-title'),
        //     'manufacture_name' => $request->input('manufacturer'),
        //     'product_mrp' => $mrp,
        //     'product_discount' => $discount,
        //     'selling_price' => $this->getSellingPrice($mrp, $discount),
        //     'photo_name' => 'http://lorempixel.com/300/300/food',
        // ]);
        // if($product)
        // {
        //     flash( $product->attributes['product_title'] . ' is successfully added.');
        // }
        // else
        // {
        //     flash( $product->attributes['product_title'] . ' is failed to add.');
        // }
        return 'CREATED';//redirect()->route('user::products');
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