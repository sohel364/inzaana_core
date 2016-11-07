<?php

namespace Inzaana\Http\Controllers;

use Auth;
use Crypt;
use DB;
use Illuminate\Support\Facades\Input;
use Inzaana\StripePlanFeature;
use Inzaana\User;
use Inzaana\StripePlan;
use Illuminate\Http\Request;
use Inzaana\Http\Requests;
use Inzaana\Http\Requests\StripePlanRequest;
use Inzaana\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

/*
 * Stripe Api lib
 * */
use \Stripe\Plan;
use \Stripe\Stripe;
use \Stripe\Subscription;

class StripeController extends Controller
{
    public function payment(Request $request)
    {
        //$user = User::find(1);
        //$user->newSubscription('main', '6024')->create($request->stripeToken);
        //$user->subscription('main')->cancel();
        //dd($user->subscribed());
    }

    /*
     * Show Stripe Plan Create Form
     * Call from Route::get('super-admin/create-plan', [ 'uses' => 'StripeController@planForm', 'as'=> 'planForm']);
     * */
    public function planForm()
    {
        $features = StripePlanFeature::all();
        return view('super-admin.stripe.create-plan')->with(['user'=> Auth::user(),'features'=>$features]);
    }

    /*
     * User Subscription using laravel cashier
     * Stripe take card info like Card number, Expire Date, cvc(Card Verification Value)
     * Method call from
     *
     * http://stackoverflow.com/questions/24220706/laravel-cashier-multiple-subscriptions-for-a-single-user
     * */

    public function subscriptionPlan(Request $request)
    {
        //dd($request->all());
        $user = User::find(Auth::user()->id);
        //dd($user->newSubscription($request->_plan_name, $request->_plan_id));
        $msg = "You have already subscribed.";
        if(!Auth::user()->subscribed($request->_plan_name)){
            $user->newSubscription($request->_plan_name, $request->_plan_id)
                ->trialDays((INT)$request->_trial_days)
                ->create($request->stripeToken);
            /*
             * Auto renewal disable
             * */
            if($request->auto_renewal == null){
                $user->subscription($request->_plan_name)->cancel();
            }
            $msg = "Successfully Subscribed.";
        }

        //dd($msg);
        return redirect()->route('user::viewMySubscription')->with(['success'=>$msg]);

    }

    /*
     * Plan Swaping
     * */
    public function swapSubscriptionPlan(Request $request)
    {
        $user = Auth::user();
        //dd($request->all());
        $user->subscription($request->_plan_name)->swap($request->_plan_id);
        $user->updateSubscription($request->_plan_id);
        return redirect()->back();
    }



    /*
     * This method is using for Create Plan
     * Call from Route::post('super-admin/create-plan', [ 'uses' => 'StripeController@createPlan', 'as'=> 'create.plan']);
     * */
    public function createPlan(StripePlanRequest $request)
    {
        /*
         * Stripe Api Key Set
         * This ApiKey get from environment variable
         * Using Stripe lib for creating plan
         * */


        /*
         * Processing input data for stripe
         * */
        $amount = number_format($request->plan_amount,2);
        $amount = (INT)($amount * 100);
        $interval = strtolower($request->plan_interval);
        $interval_count = 1;

        if($interval == 'custom')
        {
            $interval_count = (INT)$request->interval_count;
            $interval = $request->coustom_interval;
        }else if($interval == '3-month' || $interval == '6-month'){
            $array = explode('-', $interval);
            $interval_count = (INT)$array[0];
            $interval = $array[1];
        }

        Stripe::setApiKey(getenv('STRIPE_SECRET'));
        $plan = Plan::create(array(
            "id" => $request->plan_id,
            "name" => $request->plan_name,
            "currency" => $request->plan_currency,
            "amount" => $amount,
            "interval" => $interval,
            "interval_count" => $interval_count,
            "trial_period_days" => (INT)$request->plan_trial,
            "statement_descriptor" => $request->plan_des
        ));

        /*
         * Stripe Plan insert in Local Database
         * Using Local Database for faster loading
         * */
        $stripePlan = StripePlan::create([
            "plan_id" => $request->plan_id,
            "name" => $request->plan_name,
            "amount" => $request->plan_amount,
            "currency" => $request->plan_currency,
            "interval" => $interval,
            "interval_count" => $interval_count,
            "auto_renewal" => (INT)$request->auto_renewal?$request->auto_renewal:0,
            "trial_period_days" => (INT)$request->plan_trial,
            "statement_descriptor" => $request->plan_des,
            "created"=> date('Y-m-d H:i:s')
        ]);

        $stripePlan->planFeature()->attach($request->feature_id);

        return redirect()->back()->with(['success'=>'Successfully Created Plan.']);

    }
    /*
     * Retrieve All Plan information
     * This information get from local Database Using Laravel Cashier
     * Method call from *** Route::get('super-admin/view-plan', [ 'uses' => 'StripeController@viewPlan', 'as'=> 'viewPlan']);
     * */
    public function viewPlan()
    {
        //$allPlan = StripePlan::all();
        $allPlan = StripePlan::with('planFeature')->get();
        $plan_collect = [];
        foreach($allPlan as $plan)
        {

            if($plan->interval_count > 1)
            {
                $plan->interval = "Every ". $plan->interval_count ." ".$plan->interval."s";
            }
            $plan_collect[] = $plan;

        }
        $allPlan = collect($plan_collect);
        $sln = 1;
        return view('super-admin.stripe.view-plan',compact('allPlan','sln'))->with('user', Auth::user());
    }
    /*
     * View Edit Plan Feature Interface
     * */
    public function editPlanFeature($plan_id)
    {
        $plan_info = StripePlan::with('planFeature')->where('plan_id','=',$plan_id)->first();
        $plan_data = [];
        if($plan_info)
        {
            if($plan_info->interval_count > 1)
            {
                $plan_info->interval = "Every ". $plan_info->interval_count ." ".$plan_info->interval."s";
            }
            $feature_list = [];
            foreach($plan_info->planFeature as $feature){
                $feature_list[] = $feature->feature_name;
            }
            $plan_data = [
                'id' => $plan_info->plan_id,
                'plan_name' => $plan_info->name,
                'price' => $plan_info->amount." ".$plan_info->currency_symbol[$plan_info->currency]."/".$plan_info->interval,
                'trial' => $plan_info->trial_period_days,
                'renewal' => $plan_info->auto_renewal,
                'description' => $plan_info->statement_descriptor,
                'feature' => $feature_list
            ];
        }
        $all_feature = StripePlanFeature::all();
        $feature = [];
        foreach($all_feature as $value)
        {
            $feature[$value->feature_id] = $value->feature_name;
        }

        return response()->view('includes.modal', compact('plan_data', 'feature'))
            ->header('Content-Type', 'html');

        //return response()->json(['dump_data' =>$dumping_data]);
    }
    /*
     * Edit Plan Feature Using Plan ID
     * This Method Edit Only Local Database
     * Don't Touch Strip Database
     * Method call  from *** Route::get('/super-admin/edit-feature', [ 'uses' => 'StripeController@editPlanFeature', 'as'=> 'editPlanFeature']);
     * */
    public function planFeatureUpdate(Request $request)
    {
        // Complete this code but test not yet.
        /*$plan_id = $request->plan_id;
        $plan_name = $request->plan_name;
        $trial = $request->trial;
        $description = $request->description;
        $renewal = isset($request->auto_renewal) ? 1 : 0;
        $feature = $request->feature_id;
        $stripe_plan = StripePlan::where('plan_id','=',$plan_id)
                        ->update([
                            'name' => $plan_name,
                            'trial_period_days'=>$trial,
                            'statement_descriptor'=>$description,
                            'auto_renewal'=>$renewal,
                        ]);

        $stripe_plan->planFeature()->attach($feature);*/

        // View generate
        $allPlan = StripePlan::with('planFeature')->get();
        $plan_collect = [];
        foreach($allPlan as $plan)
        {
            if($plan->interval_count > 1)
            {
                $plan->interval = "Every ". $plan->interval_count ." ".$plan->interval."s";
            }
            $plan_collect[] = $plan;

        }
        $sln = 1;
        $allPlan = collect($plan_collect);
        $allPlan = compact('allPlan', 'sln');

        return response()->view('includes.plan-dom',$allPlan)
            ->header('Content-Type', 'html');

    }
    /*
     * Delete Plan Using Plan ID
     * First Delete Remote Database Plan Then Delete Local Database Plan
     * Method call from *** Route::post('super-admin/delete-plan', [ 'uses' => 'StripeController@deletePlan', 'as'=> 'deletePlan']);
     * */
    public function deletePlan(Request $plan_id)
    {
        $this->validate($plan_id, [
            'plan' => 'required'
        ]);
        $plan_id = $plan_id->plan;
        //$plan_id = Crypt::decrypt($plan_id->confirm_action);

        //if($plan_id == null) //Todo List: Abort or redirect back same page with meaning full message.

        //Stripe::setApiKey(getenv('STRIPE_SECRET'));
        //Plan::retrieve($plan_id)->delete(); // Delete From Remote Database

        $stripe_plan = StripePlan::where('plan_id','=',$plan_id)->first();
        $plan_name = $stripe_plan->name;
        $plan_name = $plan_name."(Removed)";
        StripePlan::where('plan_id','=',$plan_id)->update(['name' => $plan_name,'active'=>0]);

        // view generate
        $allPlan = StripePlan::with('planFeature')->get();
        $plan_collect = [];
        foreach($allPlan as $plan)
        {
            if($plan->interval_count > 1)
            {
                $plan->interval = "Every ". $plan->interval_count ." ".$plan->interval."s";
            }
            $plan_collect[] = $plan;

        }
        $sln = 1;
        $allPlan = collect($plan_collect);
        $allPlan = compact('allPlan', 'sln');

        return response()->view('includes.plan-dom',$allPlan)
            ->header('Content-Type', 'html');

        //StripePlan::where('plan_id','=',$plan_id)->delete(); // Delete From local database
        return Response::json([true]);
        //return redirect()->route('admin::viewPlan')->with(['success'=>'Successfully Deleted.']);
    }

    /*
     * Plan view update
     * View Active Plan
     * Method call from *** Route::get('super-admin/view-plan/ajax/update/{id}', [ 'uses' => 'StripeController@updateStatus', 'as'=> 'updateStatus']);
     * This method return JSON Response
     * */
    public function updateStatus(Request $data)
    {
        $all_data = $data->all();
        $id = $plan_id = $all_data['plan'];
        $plan = StripePlan::where('plan_id',$id)->update(['active' => $all_data['confirm_action']]);

        return Response::json(['plan_id'=>$id,'confirm' => $all_data['confirm_action']]);
    }
    /*
     * View All Subscriber
     * Using Query Builder for join three tables(users, stripe_plans, subscriptions)
     * Retrieve all subscribers from local database
     * Method call from Route::get('/super-admin/view-subscriber', [ 'uses' => 'StripeController@viewSubscriber', 'as'=> 'viewSubscriber']);
     * */
    public function viewSubscriber(Request $request)
    {
        /*$sql = "SELECT
                    users.name as name,s.id,s.name,s.stripe_id,s.quantity,users.name,users.email,sp.amount,sp.interval,sp.interval_count,sp.trial_period_days,
                      GROUP_CONCAT(stores.name) AS `store_name`
                    FROM users
                        JOIN subscriptions as s on s.user_id=users.id
                        JOIN stripe_plans as sp on sp.plan_id=s.stripe_plan
                       JOIN stores
                        ON users.id = stores.user_id
                        WHERE stores.status = 'APPROVED'
                    GROUP BY stores.user_id";*/

        $sort = 'name';
        $order = 'ASC';
        $loadView = 'super-admin.stripe.view-subscriber';
        if($request->ajax())
        {
            $sort = Input::get('sort');
            $order = (Input::get('order')=='DESC')? "ASC" : "DESC";
            $loadView = 'super-admin.includes.subscriber-dom';
        }
        switch($sort){
            case 'name':
                $sort = 'users.name';
                break;
            case 'plan':
                $sort = 'stripe_plans.name';
                break;
            case 'email':
                $sort = 'users.email';
                break;
            default:
                $sort = 'users.name';
                break;
        }

        $subscribers = DB::table('subscriptions')
                    ->join('users','users.id','=','subscriptions.user_id')
                    ->join('stripe_plans','stripe_plans.plan_id','=','subscriptions.stripe_plan')
                    ->join('stores','stores.user_id','=','users.id')
                    ->select('subscriptions.id','subscriptions.name as plan_name','subscriptions.stripe_id','subscriptions.quantity','users.name as subscriber_name','users.email','stripe_plans.amount','stripe_plans.interval','stripe_plans.interval_count','stripe_plans.trial_period_days as trial', DB::raw('GROUP_CONCAT(stores.name,"#",stores.status) AS store_name'))
                    /*->where('stores.status','=','APPROVED')*/
                    ->groupBy('stores.user_id')
                    ->orderBy($sort,$order)
                    ->get();
        $subscriber_collect = [];
        foreach($subscribers as $subscriber)
        {
            if($subscriber->interval_count > 1)
            {
                $subscriber->interval = "Every ". $subscriber->interval_count ." ".$subscriber->interval."s";
            }
            $store_name = $subscriber->store_name;
            $data_process = [];
            if($store_name != null)
            {
                $store_name = explode(',',$store_name);
                foreach ($store_name as $name) {
                    if($name != null){
                        $name = explode('#',$name);
                        $data_process[] = $name;
                    }
                }
            }
            $subscriber->store_name = collect($data_process);
        }

        $sln = 1;
        $user = Auth::user();
        $sort = Input::get('sort');
        return response()->view($loadView,compact('subscribers','sln','order','sort','user'))
            ->header('Content-Type', 'html');

        //return view('super-admin.stripe.view-subscriber',compact('subscribers','sln'))->with('user', Auth::user());

    }
    /*
     * View a login user subscription plan
     * Using Query Builder for join three tables(users, stripe_plans, subscriptions)
     * Retrieve single subscription from local database
     * Method call from Route::get('/dashboard/vendor/view-my-subscription', [ 'uses' => 'StripeController@viewMySubscription', 'as'=> 'viewMySubscription']);
     * */
    public function viewMySubscription()
    {
        $user = Auth::user();
        $subscriber = DB::table('subscriptions')
                    ->join('users','users.id','=','subscriptions.user_id')
                    ->join('stripe_plans','stripe_plans.plan_id','=','subscriptions.stripe_plan')
                    ->select('subscriptions.name as plan_name','subscriptions.stripe_id','subscriptions.quantity','users.name as subscriber_name','users.email','stripe_plans.amount','stripe_plans.interval','stripe_plans.trial_period_days as trial')
                    ->where('users.id','=',Auth::user()->id)
                    ->first();
        return view('my-subscription',compact('subscriber','user'));

    }

    public function changeState(Request $req, $id)
    {
        dd($req->all());
    }

    /*
     * Show All Invoice For Specific User
     * Using Laravel Cashier For Invoice Generating
     * Method Call from ****
     * */
    public function showInvoice()
    {
        $user = User::find(Auth::user()->id);
        $invoices = $user->invoices();
        return view('stripe.invoice',compact('invoices'));
    }
    /*
     * Download Invoice
     * Using dompdf package for Converting DOM to PDF
     * Method Call from ****
     * */
    public function downloadInvoice($invoiceId)
    {

        return Auth::user()->downloadInvoice($invoiceId, [
            'vendor' => 'OMG Shopping Center',
            'product' => 'INZAANA Hosting',
        ]);

    }
    /*--- Next auto increment id---*/
    public function getNextId($table){
        $id = DB::select('SHOW TABLE STATUS LIKE \''.$table.'\'');
        return $id[0]->Auto_increment;
    }
}
