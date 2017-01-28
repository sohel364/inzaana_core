<?php

namespace Inzaana\Http\Controllers;

use DB;
use Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Log;
use Validator;
use Exception;
use Illuminate\Http\Request as ProductRequest;

use Inzaana\Http\Requests;
use Inzaana\Http\Controllers\Controller;

use Inzaana\Product;
use Inzaana\Store;
use Inzaana\MarketProduct;
use Inzaana\ProductMedia;
use Inzaana\Category;
use Inzaana\Mailers\AppMailer;
use Inzaana\BulkExportImport\ProductImporter;

use \Symfony\Component\HttpFoundation\File\UploadedFile;
use \Symfony\Component\HttpFoundation\File\Exception\FileException;

// import the Intervention Image Manager Class
use Intervention\Image\Image;
use Intervention\Image\ImageManager;

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
        $productsCount = 0;
        $products = Auth::user()->products;
        //dd($products);
        $categories = Category::all();
        $tab = !session()->has('selected_tab') ? self::PRODUCT_ENTRY_TABS[0] : session('selected_tab');
        $viewData = [ 
            'productsCount' => session()->has('productsBySearch') ? session('productsBySearch')->count() : 0,
            'productsBySearch' => session()->has('productsBySearch') ? session('productsBySearch') : [],
            'search_terms' => session()->has('search_terms') ? session('search_terms') : '',
            'products' => Auth::user()->products()->orderBy('title','ASC')->paginate(15),
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

    private function validateProduct(ProductRequest $request, Product $product = null)
    {
        $image_file_rule = ProductMedia::getMediaRule('IMAGE');

        $title_rule = $product ? 'bail|required|unique:products,title,' . $product->id . ',id,deleted_at,NULL|max:200' : 'bail|required|unique:products,title,NULL,id,deleted_at,NULL|max:200';

        // dd($title_rule);
        // dd($image_file_rule);
        return Validator::make(
            $request->all(),
            [
                'store_name' => 'bail|required',
                'category' => 'bail|required',
                'title' => $title_rule,
                'price' => 'bail|required|numeric',
                'manufacturer_name' => 'required|max:200',
                'upload_image_1' => $image_file_rule,
                'upload_image_2' => $image_file_rule,
                'upload_image_3' => $image_file_rule,
                'upload_image_4' => $image_file_rule,
                'upload_video'   => ProductMedia::getMediaRule('VIDEO'),
                // 'embed_video_url' => 'required_unless:has_embed_video,checked|url',
                // 'embed_video_url' => 'url',
            ]
        );
    }

    /**
     * Show the form for creating a new product. post method
     *
     * @return \Illuminate\Http\response
     */
    public function create(ProductRequest $request)
    {
        //dd($request->all());
        $validation = $this->validateProduct($request);

        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        $uploadedFiles = [];
        if($request->hasFile('upload_video'))
            $uploadedFiles []= $request->file('upload_video');
        for($i = 1; $i <= ProductMedia::MAX_ALLOWED_IMAGE; ++$i)
        {
            if($request->hasFile('upload_image_' . $i))
                $uploadedFiles [$i]= $request->file('upload_image_' . $i);
        }
        if (!collect($uploadedFiles)->isEmpty())
        {
            try
            {
                $uploadResponse = ProductMedia::upload($uploadedFiles);
                $errors = $uploadResponse['errors'];
                if(!collect($errors)->isEmpty())
                {
                    return redirect()->back()->withErrors(array_collapse($errors));
                }
                $uploadedFiles = $uploadResponse['server_files'];                
            }
            catch(\Exception $e)
            {
                Log::error($e->getMessage());
                return redirect()->back()->withErrors([ 'Something went wrong during media upload! ' . $e->getMessage()]);
            }
        }

        $specs = array();
        if($request->has('spec_count'))
        {
            for($specCount = 1; $specCount <= $request->input('spec_count'); ++$specCount)
            {
                if(!$request->has('title_' . $specCount))
                    continue;
                $specs[$request->input('title_' . $specCount)] = [ 'values' => $request->input('values_' . $specCount), 'view_type' => $request->input('option_' . $specCount) ];
            }
        }
        // dd($specs);

        $store_name_as_url = $request->input('store_name');
        $store = Store::whereNameAsUrl($store_name_as_url)->get()->first();
        $data = [
            'category_id' => $request->input('category'),
            'store_id' => $store->id,
            'manufacturer_name' => $request->input('manufacturer_name'),
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'is_public' => $request->has('is_public') ? true : false,
            'discount' => 0,
            'spec' => $specs,
            'available_quantity' => $request->input('available_quantity'),
            'return_time_limit' => 1,
            'uploaded_files' => $uploadedFiles,
            'embed_url' => $request->input('embed_video_url'),
            'has_embed_video' => $request->input('has_embed_video') == 'checked' ? true : false,
            'description' => $request->input('description'),
            'product_type' => $request->input('product_type'),
        ]; 

        // dd($data);       

        try
        {
            if(!self::createProduct($data))
            {
                return redirect()->back()->withErrors([ ProductImporter::BULK_UPLOAD_ERRORS['unknown'] ]);
            }
        }
        catch(\Exception $e)
        {
            Log::error('[Inzaana][Product saving error: ' . $e->getMessage() . ' ]');
            return redirect()->back()->withErrors([ 'Something went wrong during saving your product! We have already know the reason. Try again or please contact Inzaana admnistrator.' ]);
        }
        flash()->success('Your product is submitted for approval. Will be available and notified by mail when approved.');
        return redirect()->route('user::products');
    }

    public function search(ProductRequest $request)
    {   
        if($request->exists('search-box') && $request->has('search-box'))
        {
            $search_terms = $request->query('search-box');
            $search_terms_slugged = str_slug($search_terms);

            // NOTE: like -> searches case sensitive
            // $productsBySearch = Product::where('title', $search_terms)->orWhere('title', 'like', '%' . $search_terms . '%')->get();

            // NOTE: ilike -> seaches case insensitive
            $productsBySearch = Product::where('title', $search_terms)->orWhere('title', 'ilike', '%' . $search_terms . '%')->get();
            $productsBySearchPaginated = Product::where('title', $search_terms)->orWhere('title', 'ilike', '%' . $search_terms . '%')->paginate(2);
            $productsBySearch = $productsBySearch->reject(function ($product) {
                return $product->trashed() || $product->is_public === false;
            });
            $productsCount = $productsBySearch->count();

            $productsBySearch = $productsBySearchPaginated;
            $productsBySearch->setPath('products/search');

            return redirect()->route('user::products')
                             ->with(compact('productsBySearch', 'productsCount', 'search_terms'));
        }
        return redirect()->route('user::products');
    }

    public function edit(Product $product)
    {
        return redirect()->route('user::products')->withProduct($product)->withEmbedUrl($product->videoEmbedUrl()['url']);
    }

    // Added by Asad

    public function bulkDelete($product_id)
    {
        $productId = explode(',',$product_id);
        Product::destroy($productId);
        return 1;
    }

    // TODO:: Need to add log
    public function imageDelete($imageTitle)
    {
        $imagePATH = Input::get('imagePath');
        $productImage = ProductMedia::Where('title','=',$imageTitle)->first();
        $productImage->delete();
        $message = "Delete Image from remote server.";
        if(File::exists($imagePATH))
        {
            File::delete($imagePATH);
        }else{
            $message = "Image not found!!!";
        }
        return Response::json(['msg' => $message,'status' => 1]);

    }

    public function update(ProductRequest $request, Product $product)
    {
        // dd($request);
        $validation = $this->validateProduct($request, $product);

        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        $uploadedFiles = [];
        if($request->hasFile('upload_video'))
            $uploadedFiles []= $request->file('upload_video');
        for($i = 1; $i <= ProductMedia::MAX_ALLOWED_IMAGE; ++$i)
        {
            if($request->hasFile('upload_image_' . $i))
                $uploadedFiles [$i]= $request->file('upload_image_' . $i);
        }
        if (!collect($uploadedFiles)->isEmpty())
        {
            try
            {
                $uploadResponse = ProductMedia::upload($uploadedFiles);
                $errors = $uploadResponse['errors'];
                if(!collect($errors)->isEmpty())
                {
                    return redirect()->back()->withErrors(array_collapse($errors));
                }
                $uploadedFiles = $uploadResponse['server_files'];                
            }
            catch(\Exception $e)
            {
                Log::error($e->getMessage());
                return redirect()->back()->withErrors([ 'Something went wrong during media upload! ' . $e->getMessage()]);
            }
        }

        $specs = array();

        // dd($request->input('spec_count'));

        if($request->has('spec_count'))
        {
            for($specCount = 1; $specCount <= $request->input('spec_count'); ++$specCount)
            {
                if(!$request->has('title_' . $specCount))
                    continue;
                $specs[$request->input('title_' . $specCount)] = [ 'values' => $request->input('values_' . $specCount), 'view_type' => $request->input('option_' . $specCount) ];
            }
        }
        // dd($specs);
        $store_name_as_url = $request->input('store_name');
        $store = Store::whereNameAsUrl($store_name_as_url)->get()->first();
        $data = [
            'category_id' => $request->input('category'),
            'store_id' => $store->id,
            'manufacturer_name' => $request->input('manufacturer_name'),
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'is_public' => $request->has('is_public') ? true : false,
            'discount' => 0,
            'spec' => $specs,
            'available_quantity' => $request->input('available_quantity'),
            'return_time_limit' => 1,
            'uploaded_files' => $uploadedFiles,
            'embed_url' => $request->input('embed_video_url'),
            'has_embed_video' => $request->input('has_embed_video') == 'checked' ? true : false,
            'description' => $request->input('description'),
            'product_type' => $request->input('product_type'),
        ];

        // dd($data);
        // dd($request->input('is_public'));

        // save product

        $product->store_id = $data['store_id'];

        $marketProduct = $product->marketProduct();

        $marketProduct->category_id = $data['category_id'];
        $marketProduct->manufacturer_name = $data['manufacturer_name'];
        $marketProduct->price = $data['price'];
        $marketProduct->title = $data['title'];
        $marketProduct->save();

        $product->title = $data['title'];
        $product->is_public = $data['is_public'];
        $product->special_specs = collect($data['spec'])->toJson();
        $product->available_quantity = $data['available_quantity'];
        $product->description = collect($data)->has('description') ? $data['description'] : '';
        $product->type = collect($data)->has('product_type') ? $data['product_type'] : '';

        try
        {
            // Media update
            if(!$product->saveMedias($data))
            {
                // You may revert all files by deleting and undoing stored media entry
                // Right here
                throw new \Exception("Some uploaded files did not store.");
            } 

            if(!$product->saveDiscountedPrice())
            {
                Log::info('[Inzaana][User:: ' . Auth::user()->name . '][error:: Product (' . $data['title'] . ') MRP not saved.]');
            }

        }
        catch(\Exception $e)
        {
            Log::error('[Inzaana][Product update error: ' . $e->getMessage() . ' ]');
            return redirect()->back()->withErrors([ 'Something went wrong during saving your product! We have already know the reason. Try again or please contact Inzaana admnistrator.' ]);
        }
        flash()->success('Your product is updated.');
        return redirect()->route('user::products');        
    }

    public function delete(Product $product)
    {
        //delete the product
        $delete = 0;
        if($product)
        {
            $message = 'Your product (' . $product->title . ') is removed from your product list.';
            //$product->delete();
            $delete = 1;
            //flash($message);
        }
        else
        {
            $message = 'Your product (' . $product->title . ') is NOT removed from your product list.';
            $message .= 'Product is NOT found to your product list.';
            $message .= 'Contact your administrator to know about product removing policy';
            //flash($message);
        }
        //return redirect()->route('user::products');
        //Response::json(['plan_id'=>$id,'confirm' => $all_data['confirm_action']]);
        return Response::json(['msg' => $message,'status' => $delete]);
    }

    public function copy(Product $product)
    {
        $productExists = Auth::user()->products()->find($product->id);
        if($productExists)
        {
            flash()->warning('Your selected product (' . $productExists->title . ') is from YOUR product list.');
        }
        else
        {
            if(!$product)
            {
                return redirect()->back()->withErrors(['Your selected product is invalid. Please contact your administrator.']);
            }
            if(!$product->is_public)
            {
                return redirect()->back()->withErrors(['You can not own this product to your stores due to it\'s original owner\' privacy.']);
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
        catch(FileException $fe)
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
        $product->description = collect($data)->has('description') ? $data['description'] : '';
        $product->type = collect($data)->has('product_type') ? $data['product_type'] : 'DOWNLOADABLE';

        if(!$product->save())
        {
            $marketProduct->forceDelete();
            Log::error('[Inzaana][User:: ' . Auth::user() . '][error:: Product (' . $data['title'] . ') not added.]');
            return false;
        }

        // Media entry        
        if(!$product->saveMedias($data))
        {
            // You may revert all files by deleting and undoing stored media entry
            // Right here
            throw new \Exception("Some uploaded files did not store.");
        } 

        if(!$product->saveDiscountedPrice())
        {
            Log::info('[Inzaana][User:: ' . Auth::user() . '][error:: Product (' . $data['title'] . ') MRP not saved.]');
            return false;
        }
        return true;
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
                    return redirect()->back()->withErrors([ ProductImporter::BULK_UPLOAD_ERRORS['unknown'] ]);
                }
            }
            flash()->success('Successfully uploaded all products.');
            return redirect()->back();//Product::where('special_specs->camera->values', 10)->get();
        }
        catch(\Exception $e)
        {
            session(['selected_tab' => self::PRODUCT_ENTRY_TABS[1]]);
            Log::critical('[Inzaana][' . $e->getMessage() . ']');
            return redirect()->back()->withErrors([ 'Something went wrong during bulk upload! We already know the reason. Please contact your administrator.']);
        }
    }

    // 1_51_Home_container_section-2_img-2_b995a302bc6ffe2d463d69f016a78042.jpeg
    // sources:
    // http://stackoverflow.com/questions/30191330/laravel-5-how-to-access-image-uploaded-in-storage-within-view
    // http://image.intervention.io/api/response
    public function image($file_name)
    {
        $manager = new ImageManager();
        return $manager->make(ProductMedia::getStoragePath('IMAGE') . $file_name)->response();
    }
    public function quickView($product_id)
    {
        $view_data = [
            'product' => Product::find($product_id),
        ];

        return response()->view('includes.product-preview-modal', $view_data)
            ->header('Content-Type', 'html');
    }
}
