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
use Inzaana\Mailers\AppMailer;

class StoreController extends Controller
{
    
    private $_viewData = [];
    private $_rules = [];

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
            'sub_domain' => 'required',
            'domain' => 'required',
            'description' => 'max:1000'
        ]);
    }

    private function viewUserStore(array $data)
    {
        return view('add-store', $data)->withUser(Auth::user()->id)
                                ->withStores(Auth::user()->stores)
                                ->withTypes(collect(Store::types())->first());
    }

    public function index()
    {
        return $this->viewUserStore([]);
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
        return $this->viewUserStore(compact('store'));
    }

    public function postUpdate(StoreRequest $request, Store $store)
    {
        $storeName = $request->input('store_name');
        $data = collect([
            'name' => $storeName,
            'sub_domain' => 'inzaana',
            'domain' => str_replace('.', '', '.net'),
            'description' => $request->input('description')

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
        $validator = $this->validator($data, $this->_rules->toArray());
        if ($validator->fails())
        {            
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }        
        $store = Store::create([
            'name' => $store,
            'user_id' => Auth::user()->id,
            'name_as_url' => strtolower(str_replace(' ', '', $store)),
            'sub_domain' => $data['sub_domain'],
            'domain' => $data['domain'],
            'description' => $data['description'],
            'status' => 'ON_APPROVAL',
        ]);        
        $store->name_as_url = str_replace('.', '', $store->name_as_url); // removes '.' character
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

        $store = Store::create([
            'name' => $name,
            'user_id' => Auth::user()->id,
            'name_as_url' => $storeNameUrl,
            'sub_domain' => $subdomain,
            'domain' => $domain,
            'status' => 'ON_APPROVAL',
        ]);
        $store->name_as_url = str_replace('.', '', $store->name_as_url); // removes '.' character
        if(!$store)
        { 
            $errors['store'] = 'Failed to create store! Please check your shop name again.';
            return response()->view('home', [ 'errors' => collect($errors) ]);  
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
        if($request->input('confirmation-select') == 'approve')
            $store->status = 'APPROVED';
        if($request->input('confirmation-select') == 'reject')
            $store->status = 'REJECTED';
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
}
