<?php

namespace Inzaana\Http\Controllers;

use Illuminate\Http\Request as StoreRequest;
use Illuminate\Support\Facades\DB;

use Inzaana\Http\Requests;
use Inzaana\Http\Controllers\Controller;

use Auth;
use Validator as StoreValidator;
use Redirect as StoreRedirect;

use Inzaana\Store;
use Inzaana\User;
use Inzaana\Mailers\AppMailer;

class StoreController extends Controller
{
    
    private $_viewData = [];
    private $_rules = [];
    private $delimiter_phone_number = '-';

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

        $this->_rules = collect([
            'name' => 'required|unique:stores|max:30',
            // 'sub_domain' => 'required',
            // 'domain' => 'required',
            'description' => 'max:1000'
        ]);
    }

    private function viewUserStore(array $data)
    {
        return view('add-store', $data)->withUser(Auth::user()->id)
                                ->withStores(Auth::user()->stores)
                                ->withTypes(collect(Store::types()))
                                ->withAreaCodes(collect(User::areaCodes()))
                                ->withStates(Auth::user()->getStatesPaginated(10))
                                ->withPostCodes(Auth::user()->getPostCodesPaginated(10));
    }

    public function index()
    {
        $defaultData = [ 'phone_number' => [0, ''], 'address' =>  User::decodeAddress('') ];
        return $this->viewUserStore($defaultData);
    }

    public function redirectUrl($site)
    {
        return StoreRedirect::to('http://' . $site . '/showcase');
    }

    private function validator(array $data, array $rules)
    {
        return StoreValidator::make($data, $rules);
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
        $user = User::find($store->user_id);
        $phone_number = User::decodePhoneNumber($store->phone_number ? $store->phone_number : $user->phone_number);
        $address = User::decodeAddress($store->address ? $store->address : $user->address);
        return $this->viewUserStore(compact('store', 'phone_number', 'address'));
    }

    public function postUpdate(StoreRequest $request, Store $store)
    {
        $storeName = $request->input('store_name');

        $address = User::encodeAddress($request->only(
            'mailing-address', 'address_flat_house_floor_building', 'address_colony_street_locality', 'address_landmark', 'address_town_city', 'postcode', 'state'
        ));

        $data = collect([
            'name' => $storeName,
            // 'sub_domain' => 'inzaana',
            // 'domain' => 'com',//str_replace('.', '', '.net'),
            'description' => $request->input('description'),
            'address' => $address,
            'phone_number' => $request->input('code') . $this->delimiter_phone_number . $request->input('phone_number'),
            'store_type' => $request->input('business')
        ]);

        $rules = $this->_rules;
        if($storeName == $store->name)
        {
            $data = $data->forget('name');
            $rules = $rules->forget('name');
        }
        $validator = $this->validator($data->toArray(), $rules->toArray());
        if ($validator->fails())
        {            
            return redirect()->back()->withErrors($validator->errors());
        }
        if($data->has('name'))
        {
            $store->name = $data['name'];
            $store->name_as_url = strtolower(str_replace(' ', '', $data['name'])); // trims out the spaces
            $store->name_as_url = str_replace('.', '', $store->name_as_url); // removes '.' character
        }
        $store->description = $data['description'];
        $store->address = $data['address'];
        $store->store_type = $data['store_type'];
        $store->phone_number = $data['phone_number'];

        if(!$store->save())
            return redirect()->back()->withErrors(['The store (' . $store->name . ') update is failed!']);
        flash()->success('Store (' . $store->name . ') information will be updated when approved by authority. Please contact Inzaana administrator for further assistance.');
        return redirect()->route('user::stores');
    }

    public function create(StoreRequest $request)
    {
        $store_name = $request->input('store_name');

        $address = User::encodeAddress($request->only(
            'mailing-address', 'address_flat_house_floor_building', 'address_colony_street_locality', 'address_landmark', 'address_town_city', 'postcode', 'state'
        ));

        $data = [
            'name' => $store_name,
            'description' => $request->input('description'),
            'address' => $address,
            'phone_number' => $request->input('code') . $this->delimiter_phone_number . $request->input('phone_number'),
            'store_type' => $request->input('business')
        ];
        $validator = $this->validator($data, $this->_rules->toArray());
        if ($validator->fails())
        {            
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }        
        $store = Store::create([
            'name' => $store_name,
            'user_id' => Auth::user()->id,
            'name_as_url' => strtolower(str_replace('.', '', str_replace(' ', '', $store_name))),
            'description' => $data['description'],
            'address' => $data['address'],
            'phone_number' => $data['phone_number'],
            'store_type' => $data['store_type'],
            'status' => 'ON_APPROVAL',
        ]);
        if(!$store)
        {
            return redirect()->back()->withErrors(['Failed to create store named (' . $store->name . ')']);
        }
        flash()->success('Store (' . $store->name . ') information will be published when approved by the authority. Please contact Inzaana administrator for further assistance.');
        return redirect()->back();
    }

    public function createOnSignUp($name, $site, $business)
    {
        $keywords = preg_split("/[.]+/", $site);

        if(count($keywords) < 3)
        {
            session()->forget('site');
            session()->forget('store');  
            session()->forget('business');

            Auth::user()->delete();

            return response()->view('home', [ 'errors' => collect(['Failed to create store! Please check your shop name again.']) ]);       
        }

        $storeNameUrl = $keywords[0];
        $subdomain = $keywords[1];
        $domain = $keywords[2];

        $store = Store::create([
            'name' => $name,
            'user_id' => Auth::user()->id,
            'name_as_url' => $storeNameUrl,
            'store_type' => $business,
            'status' => 'ON_APPROVAL',
        ]);
        if(!$store)
        {
            session()->forget('site');
            session()->forget('store');  
            session()->forget('business');

            Auth::user()->delete();

            return response()->view('home', [ 'errors' => collect(['Failed to create store! Please check your shop name again.']) ]);  
        }
        return redirect()->route('user::vendor.dashboard');
    }

    private function redirectWithMergedApprovals(array $approvals, \Illuminate\Http\RedirectResponse $route)
    {
        return $route->withApprovals(session()->has('approvals') ? collect(session('approvals'))->merge($approvals)->toArray() : $approvals);
    }

    public function approvals()
    {
        $stores = collect(Store::whereStatus('ON_APPROVAL')->orWhere('status', 'REJECTED')->orWhere('status', 'APPROVED')->get())->pluck( 'id', 'name' );
        $approvals = [
            'stores' => [
                'type' => Store::class,
                'data' => $stores
            ]
        ];
        return $this->redirectWithMergedApprovals($approvals, redirect()->route('admin::approvals.manage'));
    }

    public function confirmApproval(StoreRequest $request, AppMailer $mailer, $id)
    {
        $store = Store::find($id);
        if(!$store)
            return redirect()->back()->withErrors(['Your requested store is not found to approve!']);
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
        
        if(!$store->save())
            return redirect()->back()->withErrors(['Failed to confirm store approval!']);
        flash()->success('Your have ' . strtolower($store->getStatus()) . ' store (' . $store->name . ').');
        // Sends approval mail to user who created the product
        $data['type'] = Store::class;
        $data['status'] = $store->getStatus();
        $data['item_name'] = $store->name;
        $data['created_at'] = $store->created_at;
        $mailer->sendEmailForApprovalNotificationTo($store->user, $data);
        return redirect()->back();
    }

    public function suggest($input)
    {
        $storeNames = Store::whereNameAsUrl(str_replace(' ', '', strtolower($input)))->get();
        if(!$storeNames->first())
            return response()->json([ 'store' => collect([]) ]);
        $storeNames = Store::suggest($input, 10);
        $suggestions = array();
        foreach ($storeNames as $name)
        {
            $storeNames = Store::whereNameAsUrl(str_replace(' ', '', strtolower($name)))->get();
            if(!$storeNames->first())
                $suggestions []= $name;
        } 
        $stores = empty($suggestions) ? $storeNames : $suggestions;
        return response()->json([ 'store' => collect($stores)->take(5) ]);
    }
}
