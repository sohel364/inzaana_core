<?php

namespace Inzaana\Http\Controllers;

use Illuminate\Http\Request as StoreRequest;

use Inzaana\Http\Requests;
use Inzaana\Http\Controllers\Controller;

use Auth;
use Validator as StoreValidator;
use Redirect as StoreRedirect;

use Inzaana\Store;
use Inzaana\User;

class StoreController extends Controller
{
    
    private $_viewData = [];

	/**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->_viewData = [
            'user' => Auth::user(),
            'stores' => Store::all()
        ];
    }

    public function index()
    {
        return view('add-store')->withUser(Auth::user())
                                ->withStores(Store::all())
                                ->withTypes(collect(Store::types())->first());
    }

    public function redirectUrl($site)
    {
        return StoreRedirect::to('http://' . $site . '/showcase');
    }

    private function validator(array $data)
    {
        return StoreValidator::make($data, [
            'name' => 'required|unique:stores|max:30',
            'sub_domain' => 'required',
            'domain' => 'required',
            // 'description' => 'max:1000'
        ]);
    }

    public function delete(Store $store)
    {
        if($store->user->stores()->count() == 1)
        {
            flash()->error('Sorry! You must have at least one shop to continue. Please contact your Inzaana administrator for any query.');
            return redirect()->back();
        }
        if(!$store->delete())
            return redirect()->back()->withErrors(['Sorry! we could not find the store named (' . $store->name . '). Please contact your Inzaana administrator for any query.']);
        flash()->success('Store (' . $store->name . ') information will be removed when approved by authority. Please contact Inzaana administrator for further assistance.');
        return redirect()->route('user::stores');
    }

    public function update(Store $store)
    {
        return view('add-store', compact('store'))->withUser(Auth::user())
                                ->withStores(Store::all())
                                ->withTypes(collect(Store::types())->first());
    }

    public function postUpdate(StoreRequest $request, Store $store)
    {
        $storeName = $request->input('store_name');
        $data = [
            'name' => $storeName,
            'sub_domain' => 'inzaana',
            'domain' => str_replace('.', '', '.net'),
            // 'description' => $request->input('description')

        ];
        $validator = $this->validator($data);
        if ($validator->fails())
        {            
            return redirect()->back()->withErrors($validator->errors())->withInputs();
        }

        $store->name = $data['name'];
        $store->name_as_url = strtolower(str_replace(' ', '', $data['name']));
        // $store->description = $data['description'];

        $errors['update_failed'] = 'The store (' . $store->name . ') update is failed!';
        if(!$store->save())
            return redirect()->back()->withErrors($errors)->withInputs();
        flash()->success('Store (' . $store->name . ') information will be updated when approved by authority. Please contact Inzaana administrator for further assistance.');
        return redirect()->route('user::stores');
    }

    public function create(StoreRequest $request)
    {
        $store = $request->input('store_name');
        $data = [
            'name' => $store,
            'sub_domain' => 'inzaana',
            'domain' => str_replace('.', '', '.net'),
            'description' => $request->input('description')

        ];
        $validator = $this->validator($data);
        if ($validator->fails())
        {            
            return redirect()->back()->withErrors($validator->errors())->withInputs();
        }        
        $store = Store::create([
            'name' => $store,
            'user_id' => Auth::user()->id,
            'name_as_url' => strtolower(str_replace(' ', '', $store)),
            'sub_domain' => $data['sub_domain'],
            'domain' => $data['domain'],
            // 'description' => $data['description']
        ]);
        if(!$store)
        {
            $message = 'Failed to create store named (' . $store->name . ')';
            return redirect()->back()->withErrors([$message]);
        }
        flash()->success('Store (' . $store->name . ') information will be published when approved by authority. Please contact Inzaana administrator for further assistance.');
        return redirect()->route('user::stores');
    }

    public function createOnSignUp($name, $site)
    {
        $keywords = preg_split("/[.]+/", $site);

        if(count($keywords) < 3)
        {     
            $errors['store'] = 'Failed to create store! Please check your shop name again.';
            return response()->view('home', [ 'errors' => collect($errors) ]);       
        }

        $storeNameUrl = $keywords[0];
        $subdomain = $keywords[1];
        $domain = $keywords[2];

        // dd(Auth::user()->id);

        $store = Store::create([
            'name' => $name,
            'user_id' => Auth::user()->id,
            'name_as_url' => $storeNameUrl,
            'sub_domain' => $subdomain,
            'domain' => $domain
        ]);

        if(!$store)
        { 
            $errors['store'] = 'Failed to create store! Please check your shop name again.';
            return response()->view('home', [ 'errors' => collect($errors) ]);  
        }

        // @NOTE: Example code for site redirection
        // return StoreRedirect::to('http://' . $site . '/stores');
        return redirect()->route('user::vendor.dashboard');
    }
}
