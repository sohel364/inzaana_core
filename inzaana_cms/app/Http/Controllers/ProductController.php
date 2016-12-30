<?php

namespace Inzaana\Http\Controllers;

use DB;
use Auth;
use Validator;
use Illuminate\Http\Request as ProductRequest;

use Inzaana\Http\Requests;
use Inzaana\Http\Controllers\Controller;
use Inzaana\Product;
use Inzaana\MarketProduct;
use Inzaana\Category;
use Inzaana\Mailers\AppMailer;
use Inzaana\BulkExportImport\ProductImporter;

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
     * Show the form for creating a new product. post method
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ProductRequest $request)
    {
        $products = Auth::user()->products;
        $categories = Category::all();

        $viewData = compact('products', 'categories');
        //
        // $validator = Validator::make($request->all(),[
        //     'title' => 'required|unique:products,title,manufacture_name,product_mrp,selling_price,photo_name|max:100',
        //     'product_mrp' => 'required|numeric',
        //     'manufacture_name' => 'required|max:200',
        //     'product_discount' => 'numeric|max:100',
        //     'selling_price' => 'numeric',
        //     'photo_name' => 'required|url|active_url|image',
        // ]);
        // $this->validate($request, [
        //     'title' => 'required|unique:products|max:100',
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
        $is_public = $request->has('is_public') ? $request->input('is_public') : false;
        $store_id = $request->has('store') ? $request->input('store') : "";
        $category_id = $categories->where('category_name', $category_name)->first()->id;

        $marketProduct = MarketProduct::create([
            'category_id' => $category_id,
            'title' => $request->input('product-title'),
            'manufacturer_name' => $request->input('manufacturer'),
            'price' => $mrp,
            'status' => 'ON_APPROVAL',
        ]);
        if(!$marketProduct)
        {
            return redirect()->back()->with($viewData);
        }
        $product = Product::create([
            'user_id' => Auth::user()->id,
            'store_id' => $store_id,
            'market_product_id' => $marketProduct->id,
            'is_public' => $is_public,
            'title' => $marketProduct->title,
            'discount' => $discount,
            'available_quantity' => $request->input('available_quantity'),
            'return_time_limit' => $request->input('return_time_limit'),
            'status' => $marketProduct->status,
        ]);
        if($product)
        {
            $product->mrp = $product->discountedPrice();

            flash('Your product (' . $product->title . ') is successfully added.');
        }
        else
        {
            flash('Your product (' . $product->title . ') is failed to add. Please contact your administrator for assistance.');
        }
        return redirect()->route('user::products')->with($viewData);
    }

    public function search(ProductRequest $request)
    {   
        $products = Auth::user()->products;
        $categories = Category::all();   
        if($request->exists('search-box') && $request->has('search-box'))
        {
            $search_terms = $request->query('search-box');
            $search_terms_slugged = str_slug($search_terms);

            $productsBySearch = Product::where('title', $search_terms)->orWhere('title', 'like', '%' . $search_terms . '%')->get();;
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
        return view('add-product', compact('productsCount', 'products', 'categories', 'productsBySearch'))->with('user', Auth::user());
    }

    public function edit($product_id)
    {
        //edit the product
        $productsCount = 0;
        $products = Auth::user()->products;
        $product = $products->find($product_id);
        $categories = Category::all();
        return view('add-product', compact('productsCount', 'products', 'categories'))->withUser(Auth::user());
    }

    public function delete($product_id)
    {
        //delete the product
        $products = Auth::user()->products;
        $product = $products->find($product_id);
        $message = 'Your product (' . $product->title . ') is removed from your product list.';
        if($product)
        {
            $product->delete();
        }
        else
        {
            $message = 'Your product (' . $product->title . ') is NOT removed from your product list.';
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
            flash()->warning('Your selected product (' . $product->title . ') is from YOUR product list.');
        }
        else
        {
            $product = Product::find($id);
            if(!$product)
            {
                return redirect()->back()->withErrors(['Your selected product is invalid. Please conatct your administrator.']);
            }
            $product->user_id = Auth::user()->id;
            $productSerialized = collect($product->toArray());
            $productSerialized->forget('id');
            $productSerialized->forget('created_at');
            $productSerialized->forget('updated_at');
            $productCopied = Product::create($productSerialized->toArray());
            if(!$productCopied)
            {
                return redirect()->back()->withErrors(['Something went wrong during creating your product (' . $product->title . '). Please try again or contact your administrator.']);
            }
            flash()->success('Your selected product (' . $productCopied->title . ') is copied to your product list.');
        }
        return redirect()->route('user::products');
    }

    private function redirectWithMergedApprovals(array $approvals, \Illuminate\Http\RedirectResponse $route)
    {
        return $route->withApprovals(session()->has('approvals') ? collect(session('approvals'))->merge($approvals)->toArray() : $approvals);
    }

    public function approvals()
    {
        $products = collect(Product::whereStatus('ON_APPROVAL')->orWhere('status', 'REJECTED')->orWhere('status', 'APPROVED')->get())->pluck( 'id', 'title' );
        $approvals = [
            'products' => [
                'type' => Product::class,
                'data' => $products
            ]
        ];
        return $this->redirectWithMergedApprovals($approvals, redirect()->route('user::stores.approvals'));
    }

    public function confirmApproval(ProductRequest $request, AppMailer $mailer, $id)
    {
        $product = Product::find($id);
        if(!$product)
            return redirect()->back()->withErrors(['Product not found to approve!']);
        if(!$request->has('confirmation-select'))
            return redirect()->back()->withErrors(['Invalid request of approval confirmation!']);

        switch($request->input('confirmation-select'))
        {
            case 'approve': 
                $category->status = 'APPROVED';
            case 'reject':
                $category->status = 'REJECTED';
            case 'remove':
                $category->status = 'REMOVED';
        }
        
        if(!$product->save())
            return redirect()->back()->withErrors(['Failed to confirm product approval!']);
        flash()->success('Your have ' . strtolower($product->getStatus()) . ' product (' . $product->title . ').');

        // Sends approval mail to user who created the product
        $data['type'] = Product::class;
        $data['status'] = $product->getStatus();
        $data['item_name'] = $product->title;
        $data['created_at'] = $product->created_at;
        $mailer->sendEmailForApprovalNotificationTo($product->user, $data);
        return redirect()->back();
    }

    public function uploadCSV(ProductRequest $request)
    {        
        try
        {
            $pi = new ProductImporter('product_inzaana_asset.csv');
            $csv = $pi->getProducts()['raw'];
            foreach($csv as $value)
            {
                $categories = collect(Category::whereName($value['category_name'])->get());
                $category_id = $categories->count() == 0 ? 0 : $categories->first()->id;
                $store_id = $request->has('store') ? $request->input('store') : 0;

                $marketProduct = new MarketProduct();
                $marketProduct->category_id = $category_id;
                $marketProduct->title = $value['title'];
                $marketProduct->manufacturer_name = $value['manufacturer_name'];
                $marketProduct->price = $value['price'];

                if(!$marketProduct->save())
                {
                    return 'Market failed';
                }
                $product = new Product();
                $product->user_id = Auth::user()->id;
                $product->store_id = $store_id;
                $product->market_product_id = $marketProduct->id;
                $product->is_public = $value['is_public'];
                $product->title = $marketProduct->title;
                $product->discount = $value['discount'];
                $product->mrp = $product->discountedPrice();
                $product->special_specs = collect($value['spec'])->toJson();
                $product->available_quantity = $value['available_quantity'];
                $product->return_time_limit = $value['return_time_limit'];
                if(!$product->save())
                {
                    $marketProduct->forceDelete();
                    return 'Product NOT uploaded';
                }
                if(!$product->saveDiscountedPrice())
                {
                    return 'MRP not saved';
                }
            }
            return Product::where('special_specs->camera->values', 10)->get();
        }
        catch(\Exception $e)
        {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }
}