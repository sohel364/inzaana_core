<?php

namespace Inzaana\Http\Controllers;

use Crypt;
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
        return view('super-admin.stripe.create-plan');
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

        Stripe::setApiKey(getenv('STRIPE_SECRET'));
        $plan = Plan::create(array(
            "id" => $request->plan_id,
            "name" => $request->plan_name,
            "currency" => $request->plan_currency,
            "amount" => $request->plan_amount,
            "interval" => $request->plan_interval,
            "trial_period_days" => $request->plan_trial,
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
            "interval" => $request->plan_interval,
            "trial_period_days" => $request->plan_trial,
            "statement_descriptor" => $request->plan_des,
            "created"=> date('Y-m-d H:i:s')
        ]);

        return redirect()->route('planForm')->with(['success'=>'Successfully Created Plan.']);

    }
    /*
     * Retrieve All Plan information
     * This information get from local Database Using Laravel Cashier
     * Method call from *** Route::get('super-admin/view-plan', [ 'uses' => 'StripeController@viewPlan', 'as'=> 'viewPlan']);
     * */
    public function viewPlan()
    {
        $allPlan = StripePlan::all();
        return view('super-admin.stripe.view-plan',compact('allPlan'));
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

        return redirect()->route('viewPlan')->with(['success'=>'Successfully Deleted.']);
    }
    /*
     * Plan view update
     * View Active Plan
     * Method call from *** Route::get('super-admin/view-plan/ajax/update/{id}', [ 'uses' => 'StripeController@updateStatus', 'as'=> 'updateStatus']);
     * This method return JSON Response
     * */
    public function updateStatus(Request $data)
    {
        //dd($data->all());
        $id = Crypt::decrypt($data->plan_id);
        $plan = StripePlan::where('plan_id',$id)->update(['active' => $data->status_id]);
        return Response::json(['id'=> $data->status_id]);
    }
    /*
     * View All Subscriber
     * */
    public function viewSubscriber()
    {
        Stripe::setApiKey(getenv('STRIPE_SECRET'));
        dd(Subscription::all());
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
}
