<?php

namespace Inzaana\Http\Controllers;

use Inzaana\User;
use Inzaana\StripePlan;
use Illuminate\Http\Request;
use Inzaana\Http\Requests;
use Inzaana\Http\Requests\StripePlanRequest;
use Inzaana\Http\Controllers\Controller;

/*
 * Stripe Api lib
 * */
use \Stripe\Plan;
use \Stripe\Stripe;

class StripeController extends Controller
{
    public function payment(Request $request)
    {
        //$user = User::find(1);
        //$user->newSubscription('main', '6024')->create($request->stripeToken);
        //$user->subscription('main')->cancel();
        //dd($user->subscribed());
    }
    public function showPlan()
    {
        return view('stripe.plan');
    }
    public function createPlan(StripePlanRequest $request)
    {
        //dd($request->all());
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
        //$stripePlan->save();
        //dd($stripePlan);

        return redirect('stripe.all-plan')->with(['allPlan'=>'Successfully Create Plan.']);

    }
    public function allPlan()
    {
        $allPlan = StripePlan::all();
        return view('stripe.all-plan',compact('allPlan'));
    }
    public function deletePlan($id)
    {
        Stripe::setApiKey(getenv('STRIPE_SECRET'));
        Plan::retrieve($id)->delete();

        StripePlan::where('plan_id','=',$id)->delete(); // Delete From local database

        return redirect('stripe.all-plan')->with(['success'=>'Successfully Delete.']);
    }
    public function viewSubscribed()
    {
        $user = User::find(Auth::user()->id);
        $invoices = $user->invoices();
        return view('stripe.invoice',compact('invoices'));
    }
    public function downloadInvoice($invoiceId)
    {

        return Auth::user()->downloadInvoice($invoiceId, [
            'vendor' => 'OMG Shopping Center',
            'product' => 'INZAANA Hosting',
        ]);

    }
}
