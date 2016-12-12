<?php

namespace Inzaana\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Inzaana\StripeCoupon;
use Session;
use Stripe\Subscription;
use Validator;
use Inzaana\User;
use Inzaana\Mailers\AppMailer;
use Illuminate\Http\Request;
use Inzaana\StripePlan;
use Inzaana\Faq;

use Inzaana\Http\Requests;
use Inzaana\Http\Controllers\Controller;

// @addedby tajuddin.khandaker.cse.ju@gmail.com
use Illuminate\Support\Facades\Input as UserInput;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, AppMailer $mailer)
    {
        //
        if(Auth::guest())
        {
            flash()->error('Your session is timed out. Please login and confirm again.');
            return Auth::guest('/login');
        }
        if(!Auth::user()->verified) //&& $request->session()->has('user')
        {            
            // USED FROM -> 'Auth\AuthController@showSignupForm'
            $user = User::find(Auth::user()->id);

            // If it's a vendor user verification
            if(session()->has('site') && session()->has('store'))
            {
                // USED FROM -> 'Auth\AuthController@showSignupForm'
                $data['site'] = session('site');
                $data['storeName'] = session('store');
                $data['business'] = session('business');

                session()->forget('site');
                session()->forget('store');  
                session()->forget('business');

                $mailer->sendEmailConfirmationTo($user, $data);  
            }
            // If it's a customer or super admin user verification
            else
            {
                $mailer->sendEmailConfirmationToCustomer($user);  
            } 
            
            flash('Please confirm your email address.');
            
            Auth::logout();

            return redirect('/login');
        }
        // If signup verified an usual login to proceed
        if(!session()->has('site') || !session()->has('store'))
        {
            $user = User::find(Auth::user()->id);
            if($user)
            {
                if($user->email == config('mail.admin.address'))
                {
                    return redirect()->route('user::admin.dashboard');
                }
                if($user->stores()->count() == 0)
                { 
                    return redirect()->route('user::customer.dashboard');
                }
                return redirect()->route('user::vendor.dashboard'); 
            }
            abort(404);
        }
        // If vendor user is verified after signup
        $site = session('site');
        $store = session('store');
        $business = session('business');
        
        session()->forget('site');
        session()->forget('store');  
        session()->forget('business');  
        
        // If a vendor is verified create an web mail address as an alternative email address
        $user = Auth::user();
        $user->email_alter =  preg_replace("/(\w+)@(\w+.)+/", "$1@inzaana.com", $user->email);
        $user->save();

        return redirect()->route('user::stores.create-on-signup', compact('store', 'site', 'business'));
    }   

    // View to vendor admin dashboard
    public function redirectToDashboard()
    {
        if(Auth::guest())
        {
            flash()->error('Your session is timed out. Please login and confirm again.');
            return Auth::guest('/login');
        }
        if(session()->has('site') || session()->has('store'))
        {
            session()->forget('site');
            session()->forget('store');  
            session()->forget('business');  
        }        
        $user = User::find(Auth::user()->id);
        if($user)
        {
            if($user->email == config('mail.admin.address'))
            {
                return redirect()->route('user::admin.dashboard');
            }
            if($user->stores()->count() == 0)
            { 
                return redirect()->route('user::customer.dashboard');
            }
        }
        return view('admin')->with('user', Auth::user());
    }    

    // View plan for vendor
    public function redirectToVendorPlan()
    {
        if(Auth::guest())
        {
            flash()->error('Your session is timed out. Please login and confirm again.');
            return Auth::guest('/login');
        }
        /*
         * View Plan for subscription
         * Using laravel cashier for plan retrieval
         * Method call from Route::get('/dashboard/vendor/plan', [ 'uses' => 'UserController@redirectToVendorPlan', 'as' => 'vendor.plan' ]);
         * */

        //$plan = StripePlan::where('active','=','1')->get();
        //$subscribed_plan =Subscription::where('user_id', Auth::user()->id)->get()->first()->name;

        $allplan = StripePlan::with('planFeature')->where('active','=','1')->get();
        //dd($allplan);
        $coupon_all = StripeCoupon::all();
        $plan_collect = [];
        foreach($allplan as $plan)
        {

            if($plan->interval_count > 1)
            {
                $plan->interval = "Every ". $plan->interval_count ." ".$plan->interval."s";
            }

            $coupon_information = [];
            if($plan->coupon_id != null)
            {
                foreach($coupon_all as $coupon_single){
                    if($plan->coupon_id == $coupon_single->coupon_id){
                        $coupon_information['coupon_name'] = $coupon_single->coupon_name;
                        $coupon_information['coupon_id'] = $coupon_single->coupon_id;

                        if($coupon_single->percent_off != null){
                            $coupon_information['discount'] = $coupon_single->percent_off."%";
                            $coupon_information['discount_price'] = ($plan->amount - (($plan->amount * $coupon_single->percent_off)/100));
                        }
                        else{
                            $coupon_information['discount'] = ($coupon_single->amount_off/100)."/".$coupon_single->currency;
                            $coupon_information['discount_price'] = ($plan->amount - ($coupon_single->amount_off/100));
                        }

                        $coupon_information['currency'] = $coupon_single->currency;
                        $coupon_information['duration'] = $coupon_single->duration;
                        if($coupon_single->duration == 'repeating')
                            $coupon_information['duration'] = $coupon_single->duration_in_months." Months";
                        $coupon_information['max_redemptions'] = $coupon_single->max_redemptions;
                        $coupon_redeem = Carbon::parse($coupon_single->redeem_by);
                        $coupon_information['redeem_by'] = $coupon_redeem->toFormattedDateString();
                    }
                }
            }
            $plan->coupon = $coupon_information;
            $plan_collect[] = $plan;

        }
        $allplan = collect($plan_collect);

        $user = Auth::user();
        $user_subscriptions = User::with('subscriptions')->whereId($user->id)->first();

        return view('plan',compact('allplan'))->with('user', $user_subscriptions)
                                            ->with('authenticated', Auth::check());
    }

    // View plan for vendor
    public function redirectToDashboardAdmin()
    {
        if(Auth::guest())
        {
            flash()->error('Your session is timed out. Please login and confirm again.');
            return Auth::guest('/login');
        }
        $user = User::find(Auth::user()->id);
        if($user)
        {
            if($user->email == config('mail.admin.address'))
            {
                /*
                 * View Plan for subscription
                 * Using laravel cashier for plan retrieval
                 * Method call from Route::get('/dashboard/vendor/plan', [ 'uses' => 'UserController@redirectToVendorPlan', 'as' => 'vendor.plan' ]);
                 * */
                $plan = StripePlan::where('active','=','1')->get();
                $response = view('super-admin.dashboard',compact('plan'))->with('user', Auth::user())
                                                    ->with('authenticated', Auth::check());
                if(session()->has('approvals'))
                {
                    $approvals = session('approvals');
                    return $response->withApprovals($approvals)->withTotalApprovals($this->totalApprovals($approvals, ['categories', 'products', 'stores' ]));
                }
                return $response;
            }
            if($user->stores()->count() == 0)
            { 
                return redirect()->route('user::customer.dashboard');
            }
            return redirect()->route('user::vendor.dashboard'); 
        }
        return redirect('/');
    }

    // view to customer dashboard
    public function redirectToDashboardCustomer()
    {
        if(Auth::guest())
        {
            flash()->error('Your session is timed out. Please login and confirm again.');
            return Auth::guest('/login');
        }
        $user = User::find(Auth::user()->id);
        if($user)
        {
            if($user->email == config('mail.admin.address'))
            {
                return redirect()->route('user::admin.dashboard');
            }
            if($user->stores()->count() == 0)
            {
                return view('user_dashboard')->with('user', Auth::user())
                                             ->with('authenticated', Auth::check());
            }
            return redirect()->route('user::vendor.dashboard'); 
        }
        return redirect('/');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function downloadTools()
    {
        return view('inzaana-tools')->withUser(Auth::user());
    }

    public function getLicenseKeys()
    {
        return view('tools-license')->withUser(Auth::user());
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    // Find who is authenticated currently
    public function user(Request $request)
    {
        if( $request->ajax() )
        {
            $success = true;
            $user = User::find(Auth::user()->id);
            if(!$user)
            {
                $success = false;
                $message = 'User not authenticated. Redirecting to home ...';
                return response()->json(compact('success', 'message', 'user'));    
            }
            return response()->json(compact('success', 'message', 'user'));
        }
        return redirect()->route('guest::home');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $hashed_user_id
     * @return \Illuminate\Http\Response
     */
    public function show($hashed_user_id)
    {
        $user = Auth::user();
        // if(bcrypt($user->id) == $hashed_user_id)
        if($user->id == $hashed_user_id)
        {
            return view('admin')->with('user', $user);
        }
        return redirect()->route('guest::home');
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validator(array $data, array $rules)
    {
        return Validator::make($data, $rules);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $phoneNumber = User::decodePhoneNumber($user->phone_number);
        $address = User::decodeAddress($user->address);
        return view('edit-profile') ->withUser($user)
                                    ->withPhoneNumber($phoneNumber)
                                    ->withAddress($address)
                                    ->withAreaCodes(collect(User::areaCodes()))
                                    ->withStates(DB::table('states')->select('id', 'state_name')->simplePaginate(10))
                                    ->withPostCodes(DB::table('post_codes')->select('id', 'post_code')->simplePaginate(10));
    }

    public function verifyProfileChanges(Request $request, AppMailer $mailer, User $user)
    {
        $errors = $this->update($request, $user);

        if(!empty($errors))
        {
            return redirect()->back()->withErrors($errors);
        }

        $data['request_url']  = ('name/' . $user->name) . ('/email/' . $user->email);
        $data['request_url'] .= ('/phone/' . $user->phone_number);
        $data['request_url'] .= '/password/' . str_replace('/', '_', ($user->password ? $user->password : Auth::user()->password));
        $data['request_url'] .= '/address/' . str_replace('/', '_', $user->address);

        $mailer->sendEmailProfileUpdateConfirmationTo($user, $data);

        flash()->info('A verification mail is sent to ' . Auth::user()->email . '. Please check your mail inbox/ junk/ spam directives to confirm your changes verified.');

        return redirect()->back();
    }

    public function confirmProfileUpdate(Request $request, User $user, $name, $email, $phone, $password = null, $address = null)
    {
        // return 'Phone:' . $phone . ' Address:' . $address;
        if($user->id != Auth::user()->id)
        {
            return redirect()->route('user::edit', [Auth::user()])->withErrors(['The information you are going to update to your profile is not yours!']);
        }
        $user->name = $name;
        $user->email = $email;
        $user->address = str_replace('_', '/', $address);
        $user->phone_number = $phone;
        // dd($user);
        if($password)
            $user->password = str_replace('_', '/', $password);
        if(!$user->save())
            return redirect()->back()->withErrors(['Failed to update your profile.']);
        flash()->success('You have updated your profile successfully!');
        return redirect()->route('user::edit', [$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = collect([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone_number' => 'required|numeric|digits:11',
            'email_alter' => 'email',
        ]);

        $address = User::encodeAddress($request->only(
            'mailing-address', 'address_flat_house_floor_building', 'address_colony_street_locality', 'address_landmark', 'address_town_city', 'postcode', 'state'  
        ));

        $inputs = collect([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'code' => $request->input('code'),
            'address' => $address,
        ]);

        if($request->input('email') == $user->email)
        {
            $inputs = $inputs->forget('email');
            $rules = $rules->forget('email');
        }

        if($request->has('password'))
        {
            if(!Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('oldpass')]))
            {
                return [ 'oldpass' => 'Password did not match with existing.' ];
            }
            if($request->input('password') != $request->input('password_confirmation'))
            {
                return [ 'password_confirmation' => 'Password did not match with new one.' ];
            }
            if(count($request->input('password')) < 6)
            {
                return [ 'password' => 'Password must have minimum 6 characters' ];
            }
            $user->password = bcrypt($request->input('password'));
        }

        $validator = $this->validator($inputs->toArray(), $rules->toArray());
        if($validator->fails())
        {
            return $validator->errors();
        }
        $user->name = $inputs['name'];
        $user->address = $inputs['address'];
        if($inputs->has('email'))
            $user->email = $inputs['email'];
        
        $delimiter_phone_number = '-';
        $user->phone_number = $inputs['code'] . $delimiter_phone_number . $inputs['phone_number'];
        // no errors means empty array
        return [];
    }

    public function approvals()
    {
        return redirect()->route('user::categories.approvals');
    }

    public function manageApprovals()
    {
        if(session()->has('approvals'))
        {
            $approvals = session('approvals');
            // dd($approvals);
            return view('manage-approvals')->withUser(Auth::user())
                                           ->withApprovals($approvals)
                                           ->withTotalApprovals($this->totalApprovals($approvals, ['categories', 'products', 'stores' ]));          
        }
        return $this->approvals();
    }

    private static function totalApprovals(array $approvals, array $approvalTypes)
    {
        $total = 0;
        foreach ($approvalTypes as $type)
        {
            if(array_has($approvals, $type))
            {
                $total += $approvals[$type]['data']->count();   
            }
        }
        return $total;
    }

    /**
     * views response for frequently asks & questions
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */    
    public function faqs()
    {
        return view('add-faqs')->withUser(Auth::user())->withFaqs(Faq::all()->pluck('title', 'description'));
    }

    public function createFaqs(Request $request)
    {
        $this->validate($request, [            
            'title' => 'required|unique:faqs|max:255',
            'description' => 'required|max:1000',
        ]);
        $faq = Faq::Create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);
        if(empty($faq->title))
        {
            return redirect()->route('admin::faqs')->withErrors(['FAQ title is empty.']);
        }
        if(empty($faq->description))
        {
            return redirect()->route('admin::faqs')->withErrors(['FAQ description is empty.']);
        }
        if(!$faq)
        {
            flash()->error('Your FAQ is not published! Please contact your technical person for solution.');
        }
        flash()->success('Your FAQ is published!');
        return redirect()->back();
    }

    public function getPostCodes($country)
    {
        return response()->json([ 'context' => 'postcodes', 'value' => DB::table('post_codes')->select('id', 'post_code')->take(10) ]);
    }

    public function getStates($country)
    {
        return response()->json([ 'context' => 'states', 'value' => DB::table('states')->select('id', 'state_name')->take(10) ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function usermyorder()
    {
        //
        return view('user_my_order');
    }

    public function userproductreturn()
    {
        //
        return view('user_product_return');
    }

    public function userrewardpoints()
    {
        //
        return view('user_reward_points');
    }

    public function userwallet()
    {
        //
        return view('user_wallet');
    }
}
