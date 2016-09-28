<?php

namespace Inzaana\Http\Controllers;

use Auth;
use Crypt;
use DB;
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
        return view('super-admin.stripe.create-plan')->with('user', Auth::user());
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
                ->create($request->stripeToken);
            $msg = "Successfully Subscribed.";
        }

        //dd($msg);
        return redirect()->route('user::viewMySubscription')->with(['success'=>$msg]);

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
        $amount = number_format($request->plan_amount,2);
        $amount = (INT)($amount * 100);
        Stripe::setApiKey(getenv('STRIPE_SECRET'));
        $plan = Plan::create(array(
            "id" => $this->getNextId('stripeplans'),
            "name" => $request->plan_name,
            "currency" => $request->plan_currency,
            "amount" => $amount,
            "interval" => $request->plan_interval,
            "trial_period_days" => $request->plan_trial,
            "statement_descriptor" => $request->plan_des
        ));

        /*
         * Stripe Plan insert in Local Database
         * Using Local Database for faster loading
         * */
        $stripePlan = StripePlan::create([
            "name" => $request->plan_name,
            "amount" => $request->plan_amount,
            "currency" => $request->plan_currency,
            "interval" => $request->plan_interval,
            "trial_period_days" => $request->plan_trial,
            "statement_descriptor" => $request->plan_des,
            "created"=> date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with(['success'=>'Successfully Created Plan.']);

    }
    /*
     * Retrieve All Plan information
     * This information get from local Database Using Laravel Cashier
     * Method call from *** Route::get('super-admin/view-plan', [ 'uses' => 'StripeController@viewPlan', 'as'=> 'viewPlan']);
     * */
    public function viewPlan()
    {
        $allPlan = StripePlan::all();
        return view('super-admin.stripe.view-plan',compact('allPlan'))->with('user', Auth::user());
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
        $plan_id = Crypt::decrypt($plan_id->plan);
        //if($plan_id == null) //Todo List: Abort or redirect back same page with meaning full message.

        Stripe::setApiKey(getenv('STRIPE_SECRET'));
        Plan::retrieve($plan_id)->delete(); // Delete From Remote Database

        StripePlan::where('plan_id','=',$plan_id)->delete(); // Delete From local database

        return redirect()->route('admin::viewPlan')->with(['success'=>'Successfully Deleted.']);
    }
    /*
     * Plan view update
     * View Active Plan
     * Method call from *** Route::get('super-admin/view-plan/ajax/update/{id}', [ 'uses' => 'StripeController@updateStatus', 'as'=> 'updateStatus']);
     * This method return JSON Response
     * */
    public function updateStatus(Request $data)
    {
        //dd(Input ('plan_id'));
        $all_data = $data->json()->all();
        $id = $all_data['plan_id'];

        $plan = StripePlan::where('plan_id',$id)->update(['active' => $all_data['status']]);

        return Response::json(['plan_id'=>$id ,'id'=> $all_data['status']]);
    }
    /*
     * View All Subscriber
     * Using Query Builder for join three tables(users, stripeplans, subscriptions)
     * Retrieve all subscribers from local database
     * Method call from Route::get('/super-admin/view-subscriber', [ 'uses' => 'StripeController@viewSubscriber', 'as'=> 'viewSubscriber']);
     * */
    public function viewSubscriber()
    {
        $subscribers = DB::table('subscriptions')
                    ->join('users','users.id','=','subscriptions.user_id')
                    ->join('stripeplans','stripeplans.plan_id','=','subscriptions.stripe_plan')
                    ->select('subscriptions.name as plan_name','subscriptions.stripe_id','subscriptions.quantity','users.name as subscriber_name','users.email','stripeplans.amount','stripeplans.interval','stripeplans.trial_period_days as trial')
                    ->get();
        return view('super-admin.stripe.view-subscriber',compact('subscribers'))->with('user', Auth::user());

    }
    /*
     * View a login user subscription plan
     * Using Query Builder for join three tables(users, stripeplans, subscriptions)
     * Retrieve single subscription from local database
     * Method call from Route::get('/dashboard/vendor/view-my-subscription', [ 'uses' => 'StripeController@viewMySubscription', 'as'=> 'viewMySubscription']);
     * */
    public function viewMySubscription()
    {
        $user = Auth::user();
        $subscriber = DB::table('subscriptions')
                    ->join('users','users.id','=','subscriptions.user_id')
                    ->join('stripeplans','stripeplans.plan_id','=','subscriptions.stripe_plan')
                    ->select('subscriptions.name as plan_name','subscriptions.stripe_id','subscriptions.quantity','users.name as subscriber_name','users.email','stripeplans.amount','stripeplans.interval','stripeplans.trial_period_days as trial')
                    ->where('users.id','=',Auth::user()->id)
                    ->first();
        return view('my-subscription',compact('subscriber','user'));

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
