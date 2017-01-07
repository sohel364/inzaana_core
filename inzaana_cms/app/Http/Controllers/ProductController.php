<?php

namespace Inzaana\Http\Controllers;

use DB;
use Auth;
use Log;
use Validator;
use Exception;
use Illuminate\Http\Request as ProductRequest;

use Inzaana\Http\Requests;
use Inzaana\Http\Controllers\Controller;
use Inzaana\Product;
use Inzaana\Store;
use Inzaana\MarketProduct;
use Inzaana\Category;
use Inzaana\Mailers\AppMailer;
use Inzaana\BulkExportImport\ProductImporter;
use Inzaana\MediaUploader;
use Inzaana\ImageUploader;

class ProductController extends Controller
{
    const PRODUCT_ENTRY_TABS = [ 'single_product_entry_tab', 'bulk_product_entry_tab' ];


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
        $tab = !session()->has('selected_tab') ? self::PRODUCT_ENTRY_TABS[0] : session('selected_tab');
        $viewData = [ 
            'productsCount' => session()->has('productsBySearch') ? session('productsBySearch')->count() : 0,
            'productsBySearch' => session()->has('productsBySearch') ? session('productsBySearch') : [],
            'products' => Auth::user()->products,
            'product' => session()->has('product') ? session('product') : null,
            'categories' => Category::all(),
        ];
        session()->forget('selected_tab');
        session()->forget('productsBySearch');
        session()->forget('product');
        return view('add-product', $viewData)->withUser(Auth::user())
                                             ->withStores(Auth::user()->stores->pluck('name', 'name_as_url'))
                                             ->withTab($tab);
    }

    /**
     * Show the form for creating a new product. post method
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ProductRequest $request)
    {
        /** @var \Illuminate\Contracts\Validation\Validator $validation */
        $validation = Validator::make(
            $request->all(),
            [
                'store_name' => 'bail|required',
                'category' => 'bail|required',
                'title' => 'bail|required|unique:market_products|alpha_dash|max:200',
                'price' => 'required|numeric|regex:^[0-9]*\.?[0-9]{2}$',
                'manufacturer_name' => 'required|unique:market_products|alpha_dash|max:200',
                'discount' => 'numeric|max:100|min:0',
                'category_specs' => 'present|json',
            ]
        );

        if ($validation->fails()) {
            // dd($validation->getMessageBag()->all());
            return redirect()->back()->withErrors($validation->errors());
        }

        $store_name_as_url = $request->input('stores');
        $data = [
            'category_id' => $categories->count() == 0 ? 0 : $categories->first()->id,
            'store_id' => $store->id,
            'manufacturer_name' => $value['manufacturer_name'],
            'title' => $value['title'],
            'price' => $value['price'],
            'is_public' => $value['is_public'],
            'discount' => $value['discount'],
            'spec' => $value['spec'],
            'available_quantity' => $value['available_quantity'],
            'return_time_limit' => $value['return_time_limit']
        ];
        $store = Store::whereNameAsUrl($store_name_as_url)->get()->first();
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
        return redirect()->route('user::products');
    }

    public function search(ProductRequest $request)
    {   
        $products = Auth::user()->products;
        $categories = Category::all();   
        if($request->exists('search-box') && $request->has('search-box'))
        {
            $search_terms = $request->query('search-box');
            $search_terms_slugged = str_slug($search_terms);

            // NOTE: like -> searches case sensitive
            // $productsBySearch = Product::where('title', $search_terms)->orWhere('title', 'like', '%' . $search_terms . '%')->get();

            // NOTE: ilike -> seaches case insensitive
            $productsBySearch = Product::where('title', $search_terms)->orWhere('title', 'ilike', '%' . $search_terms . '%')->get();
            $productsCount = $productsBySearch->count();

            return redirect()->route('user::products')
                             ->with(compact('productsBySearch', 'productsCount'));
        }
        return redirect()->route('user::products');
    }

    public function edit(Product $product)
    {
        //edit the product
        return redirect()->route('user::products')->withProduct($product);
    }

    public function update(ProductRequest $request, Product $product)
    {
        return response($product, 200);
    }

    public function delete(Product $product)
    {
        //delete the product
        if($product)// && $product->marketProduct() && $product->marketProduct()->delete()
        {
            $message = 'Your product (' . $product->title . ') is removed from your product list.';
            $product->delete();
            flash($message);
        }
        else
        {
            $message = 'Your product (' . $product->title . ') is NOT removed from your product list.';
            $message .= 'Product is NOT found to your product list.';
            $message .= 'Contact your administrator to know about product removing policy';
            flash($message);
        }
        return redirect()->route('user::products');
    }

    public function copy(Product $product)
    {
        // $products = Auth::user()->products;
        $productExists = Auth::user()->products()->find($product->id);
        // $product = Product::find($id); 
        if($productExists)
        {
            flash()->warning('Your selected product (' . $productExists->title . ') is from YOUR product list.');
        }
        else
        {
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

    private function getUploadedFileName(ProductRequest $request)
    {
        $errors = [];
        if (!$request->hasFile('csv'))
        {
            $errors['has_input'] = 'No file is uploaded';
            flash()->error($errors['has_input']);
            return $errors;
        }
        $uploadingFile = $request->file('csv');
        if (!$uploadingFile->isValid())
        {
            $errors['corrupted_file'] = 'Upladed file is corrupted';
            flash()->error($errors['corrupted_file']);
            return $errors;
        }

        if($uploadingFile->getSize() >= $uploadingFile->getMaxFilesize())
        {
            $errors['size_limit_exits'] = 'Please keep your file size below ' . ($uploadingFile->getMaxFilesize() / 1000);
            flash()->warning($errors['size_limit_exits']);
            return $errors;
        }
        if(!ProductImporter::isSupportedExtension($uploadingFile->getClientOriginalExtension()))
        {
            $errors['ext_not_supported'] = 'Upladed file (*.' . $uploadingFile->getClientOriginalExtension() . ') is not supported!';
            flash()->warning($errors['ext_not_supported']);
            return $errors;
        }

        //Display File Name
        $out = 'File Name: '.$uploadingFile->getClientOriginalName();
        Log::info('[Inzaana][' . $out . ']');
        //Display File Extension
        $out = ', File Extension: '. $uploadingFile->getClientOriginalExtension();
        Log::info('[Inzaana][' . $out . ']');
        //Display File Real Path
        $out = ', File Real Path: '.$uploadingFile->getRealPath();
        Log::info('[Inzaana][' . $out . ']');
        //Display File Size
        $out = ', File Size: '.$uploadingFile->getSize();
        Log::info('[Inzaana][' . $out . ']');
        //Display File Mime Type
        $out = ', File Mime Type: '.$uploadingFile->getMimeType();        
        Log::info('[Inzaana][' . $out . ']');
        try
        {
            //Move Uploaded File
            $serverFile = $uploadingFile->move(ProductImporter::getStoragePath(), $uploadingFile->getClientOriginalName());
            if(!$serverFile)
            {
                $errors['file_move_error'] = 'Upladed file did not move!';
                flash()->error('Something went wrong during upload. We have already logged the problems. Please contact Inzaana help line for further assistance.');
                return $errors;
            }      
            Log::info('[Inzaana][ Upload success to ' . $serverFile->getRealPath() . ']');
            return $serverFile->getBasename();
        }
        catch(\Symfony\Component\HttpFoundation\File\Exception\FileException $fe)
        {
            $errors['unknown_file_error'] = '[Inzaana][ Upload failed: ' . $fe->getMessage() . ']';
            Log::critical($errors['unknown_file_error']);
        }
        return $errors;
    }

    private static function createProduct(array $data)
    {
        $marketProduct = new MarketProduct();
        $marketProduct->category_id = $data['category_id'];
        $marketProduct->title = $data['title'];
        $marketProduct->manufacturer_name = $data['manufacturer_name'];
        $marketProduct->price = $data['price'];

        if(!$marketProduct->save())
        {
            Log::error('[Inzaana][User:: ' . Auth::user() . '][error:: Market product (' . $data['title'] . ') not added.]');
            return false;
        }
        $product = new Product();
        $product->user_id = Auth::user()->id;
        $product->store_id = $data['store_id'];
        $product->market_product_id = $marketProduct->id;
        $product->is_public = $data['is_public'];
        $product->title = $marketProduct->title;
        $product->discount = $data['discount'];
        $product->mrp = $product->discountedPrice();
        $product->special_specs = collect($data['spec'])->toJson();
        $product->available_quantity = $data['available_quantity'];
        $product->return_time_limit = $data['return_time_limit'];
        if(!$product->save())
        {
            $marketProduct->forceDelete();
            Log::error('[Inzaana][User:: ' . Auth::user() . '][error:: Product (' . $data['title'] . ') not added.]');
            return false;
        }
        if(!$product->saveDiscountedPrice())
        {
            Log::info('[Inzaana][User:: ' . Auth::user() . '][error:: Product (' . $data['title'] . ') MRP not saved.]');
        }
        return false;
    }

    public function uploadCSV(ProductRequest $request)
    {        
        try
        {
            $result = $this->getUploadedFileName($request);
            if(is_array($result) && count($result) > 0)
            {
                session(['selected_tab' => self::PRODUCT_ENTRY_TABS[1]]);
                return redirect()->back()->withErrors($result);
            }

            if(!$request->has('stores'))
            {
                session(['selected_tab' => self::PRODUCT_ENTRY_TABS[1]]);
                return redirect()->back()
                                 ->withErrors(['Please give a store name to upload your products.']);
            }     
                
            $store_name_as_url = $request->input('stores');
            $store = Store::whereNameAsUrl($store_name_as_url)->get()->first();
            if(!$store)
            {
                session(['selected_tab' => self::PRODUCT_ENTRY_TABS[1]]);
                return redirect()->back()
                                 ->withErrors(['We did not find any store name of yours named ' . $store_name_as_url . '.inzaana.com.']);
            }

            $pi = new ProductImporter($result);
            $csv = $pi->getProducts()['raw'];
            foreach($csv as $value)
            {
                $categories = collect(Category::whereName($value['category_name'])->get());

                $data = [
                    'category_id' => $categories->count() == 0 ? 0 : $categories->first()->id,
                    'store_id' => $store->id,
                    'manufacturer_name' => $value['manufacturer_name'],
                    'title' => $value['title'],
                    'price' => $value['price'],
                    'is_public' => $value['is_public'],
                    'discount' => $value['discount'],
                    'spec' => $value['spec'],
                    'available_quantity' => $value['available_quantity'],
                    'return_time_limit' => $value['return_time_limit']
                ];

                if(!self::createProduct($data))
                {
                    flash()->error(ProductImporter::BULK_UPLOAD_ERRORS['unknown']);
                }
            }
            flash()->success('Successfully uploaded all products.');
            return redirect()->back();//Product::where('special_specs->camera->values', 10)->get();
        }
        catch(\Exception $e)
        {
            session(['selected_tab' => self::PRODUCT_ENTRY_TABS[1]]);
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }
}