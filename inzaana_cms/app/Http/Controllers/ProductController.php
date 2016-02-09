<?php

namespace Inzaana\Http\Controllers;

use Auth;
use Validator;
use Illuminate\Http\Request as ProductRequest;

use Inzaana\Http\Requests;
use Inzaana\Http\Controllers\Controller;
use Inzaana\Product;
use Inzaana\Category;

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
        $products = Auth::user()->products;
        $categories = Category::all();
        return view('add-product', compact('productsCount', 'products', 'categories'));
    }
    
    public function gettemplate()
    {
        //
        $productsCount = 0;
        return view('view_template', compact('productsCount'));
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
        $products = Auth::user()->products;
        $categories = Category::all();
        //
        // $validator = Validator::make($request->all(),[
        //     'product_title' => 'required|unique:products,product_title,manufacture_name,product_mrp,selling_price,photo_name|max:100',
        //     'product_mrp' => 'required|numeric',
        //     'manufacture_name' => 'required|max:200',
        //     'product_discount' => 'numeric|max:100',
        //     'selling_price' => 'numeric',
        //     'photo_name' => 'required|url|active_url|image',
        // ]);
        // $this->validate($request, [
        //     'product_title' => 'required|unique:products|max:100',
        //     'product_mrp' => 'required|numeric',
        //     'manufacture_name' => 'required|max:200',
        //     'product_discount' => 'numeric|max:100',
        //     'selling_price' => 'numeric',
        //     'photo_name' => 'required|url|active_url|image',
        // ]);

        // if($validator->fails())
        // {
        //     return redirect()->route('user::products')
        //                     ->withErrors($validator)
        //                     ->withInput();
        // }
        // session()->forget('errors');

        $mrp = $request->input('mrp');
        $discount = $request->input('discount');
        $category_name = $request->input('category');
        $category_id = $categories->where('category_name', $category_name)->first()->id;

        $product = Product::create([
            'user_id' => Auth::user()->id,
            'has_sub_category_id' => false,
            'category_subcategory_id' => $category_id ? $category_id : 0,
            'product_title' => $request->input('product-title'),
            'manufacture_name' => $request->input('manufacturer'),
            'product_mrp' => $mrp,
            'product_discount' => $discount,
            'selling_price' => $this->getSellingPrice($mrp, $discount),
            'photo_name' => 'http://lorempixel.com/300/300/food',
            'status' => 'OUT_OF_STOCK',
        ]);
        if($product)
        {
            flash( $product->attributes['product_title'] . ' is successfully added.');
        }
        else
        {
            flash( $product->attributes['product_title'] . ' is failed to add.');
        }
        return redirect()->route('user::products')->with(compact('products', 'categories'));
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
        $products = Auth::user()->products;
        $categories = Category::all();
        return view('add-product', compact('productsCount', 'products', 'categories'));
    }

    public function search(ProductRequest $request)
    {   
        $products = Auth::user()->products;
        $categories = Category::all();   
        if($request->exists('search-box') && $request->has('search-box'))
        {
            $search_terms = $request->query('search-box');
            $search_terms_slugged = str_slug($search_terms);

            $productsBySearch = Auth::user()->products->where('product_title', $search_terms);
            $productsCount = $productsBySearch->count();
            return redirect()->route('user::products.search-terms', [$search_terms_slugged])
                                ->with(compact('productsBySearch', 'productsCount'));
                                // ->with('productsBySearch', $productsBySearch)
                                // ->with('productsCount', $productsCount);

            // return redirect()->route('user::products.search-terms', [$search_terms_slugged])->with('search_terms', $search_terms);
        }
        return redirect()->route('user::products')->with(compact('products', 'categories'));
    }

    public function searchTerms($terms)
    {   
        $productsCount = session()->has('productsCount') ? session('productsCount') : 0;
        $categories = Category::all();
        $products = Auth::user()->products;
        $productsBySearch = session('productsBySearch');
        return view('add-product', compact('productsCount', 'products', 'categories', 'productsBySearch'));
    }
}