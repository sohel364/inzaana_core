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
        return view('add-product', compact('productsCount', 'products', 'categories'))->with('user', Auth::user());
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
            'available_quantity' => $request->input('available_quantity'),
            'return_time_limit' => $request->input('return_time_limit'),
            'status' => 'ON_APPROVAL',
        ]);
        if($product)
        {
            flash('Your product (' . $product->product_title . ') is successfully added.');
        }
        else
        {
            flash('Your product (' . $product->product_title . ') is failed to add. Please contact your administrator for assistance.');
        }
        return redirect()->route('user::products')->with(compact('products', 'categories'));
    }

    public function search(ProductRequest $request)
    {   
        $products = Auth::user()->products;
        $categories = Category::all();   
        if($request->exists('search-box') && $request->has('search-box'))
        {
            $search_terms = $request->query('search-box');
            $search_terms_slugged = str_slug($search_terms);

            $productsBySearch = Product::where('product_title', $search_terms)->orWhere('product_title', 'like', '%' . $search_terms . '%')->get();;
            $productsCount = $productsBySearch->count();
            return redirect()->route('user::products.search-terms', [$search_terms_slugged])
                                ->with(compact('productsBySearch', 'productsCount'));
        }
        return redirect()->route('user::products')->with(compact('products', 'categories'));
    }

    public function searchTerms($terms)
    {   
        $productsCount = session()->has('productsCount') ? session('productsCount') : 0;
        $categories = Category::all();
        $products = Auth::user()->products;
        $productsBySearch = session('productsBySearch');
        // return redirect()->route('user::products')->with(compact('productsCount', 'products', 'categories', 'productsBySearch'));
        return view('add-product', compact('productsCount', 'products', 'categories', 'productsBySearch'))->with('user', Auth::user());
    }

    public function edit($product_id)
    {
        //edit the product
        $productsCount = 0;
        $products = Auth::user()->products;
        $product = $products->find($product_id);
        $categories = Category::all();
        // return redirect()->route('user::products')->with(compact('productsCount', 'products', 'categories'));
        return view('add-product', compact('productsCount', 'products', 'categories'))->withUser(Auth::user());
    }

    public function delete($product_id)
    {
        //delete the product
        $products = Auth::user()->products;
        $product = $products->find($product_id);
        $message = 'Your product (' . $product->product_title . ') is removed from your product list.';
        if($product)
        {
            $product->delete();
        }
        else
        {
            $message = 'Your product (' . $product->product_title . ') is NOT removed from your product list.';
            $message .= 'Product is NOT found to your product list.';
            $message .= 'Contact your administrator to know about product removing policy';
        }
        flash($message);
        return redirect()->route('user::products');
    }

    public function copy($id)
    {
        // $products = Auth::user()->products;
        $product = Auth::user()->products()->find($id);
        // $product = Product::find($id); 
        if($product)
        {
            flash()->warning('Your selected product (' . $product->product_title . ') is from YOUR product list.');
        }
        else
        {
            $product = Product::find($id);
            if(!$product)
            {
                return redirect()->back()->withErrors(['Your selected product is invalid. Please conatct your administrator.']);
            }
            $product->user_id = Auth::user()->id;
            $product->status != 'APPROVED' ? $product->status : 'APPROVED';
            $productSerialized = collect($product->toArray());
            $productSerialized->forget('id');
            $productSerialized->forget('created_at');
            $productSerialized->forget('updated_at');
            $productCopied = Product::create($productSerialized->toArray());
            if(!$productCopied)
            {
                return redirect()->back()->withErrors(['Something went wrong during creating your product (' . $product->product_title . '). Please try again or contact your administrator.']);
            }
            flash()->success('Your selected product (' . $productCopied->product_title . ') is copied to your product list.');
        }
        return redirect()->route('user::products');
    }

    public function approvals()
    {
        $products = collect(Product::whereStatus('ON_APPROVAL')->orWhere('status', 'REJECTED')->orWhere('status', 'APPROVED')->get())->pluck( 'id', 'product_title' );
        $approvals = [
            'products' => [
                'type' => Product::class,
                'data' => $products
            ]
        ];
        $response = redirect()->route('admin::approvals.manage');
        if(session()->has('approvals'))
        {
            $approvals = collect(session('approvals'))->merge($approvals)->toArray();
        }
        return $response->withApprovals($approvals);
    }

    public function confirmApproval(ProductRequest $request, $id)
    {
        $product = Product::find($id);
        if(!$product)
            redirect()->back()->withErrors(['Product not found to approve!']);
        if($request->has('confirmation-select'))
        {
            if($request->input('confirmation-select') == 'approve')
                $product->status = 'APPROVED';
            if($request->input('confirmation-select') == 'reject')
                $product->status = 'REJECTED';
            if(!$product->save())
                redirect()->back()->withErrors(['Failed to confirm product approval!']);
            flash()->success('Your have ' . strtolower($product->getStatus()) . ' product (' . $product->product_title . ').');
        }
        return redirect()->back();
    }
}