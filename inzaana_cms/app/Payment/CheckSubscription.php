<?php
/**
 * Created by PhpStorm.
 * User: Sk Asadur Rahman
 * Date: 8/25/2016
 * Time: 2:51 PM
 */

namespace Inzaana\Payment;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Inzaana\Payment\PaymentException;
use Carbon\Carbon;
use Inzaana\StripePlan;
use Inzaana\StripePlanFeature;

trait CheckSubscription {

    public function userAccessPermission()
    {
        return false;
        if($this->getPlanEndDate())
            dd($this->getPlanEndDate());
        return $this->getPlanEndDate();
    }

    public function  featureAccessPermission($uri)
    {
        $uri = explode('/',$uri);
        $features = StripePlanFeature::whereIn('feature_name',$uri)->get();
        if($features->isEmpty())
        {
            return true;
        }else{
            foreach($features as $feature){
                $isPermitted = DB::table('stripe_plan_has_features')
                                ->where('plan_id','=',$this->getPlanId())
                                ->where('feature_id','=',$feature->feature_id)
                                ->count();
                if(!$isPermitted && $this->id != 1)
                    return false;
            }
            return true;
        }
    }

    /*
     * Get the user trial information
     * @param int user_id
     * @return Remaining days with string like "6 days"
     * */
    public function getTrialTimeString()
    {
        /*
         * Using Carbon for date format
         * trial_ends_at get from database
         * Carbon::parse return date object
         * Carbon::now() create real time object
         * */

        $trial_days = $this->getFromDatabase('trial_ends_at') ? $this->getFromDatabase('trial_ends_at') : array();
        if(empty($trial_days)){
            return false;
        }else{
            $created = Carbon::parse($trial_days[0]->trial_ends_at);
            $now = Carbon::now();

            if($created>=$now){
                $remain = ($created->diffInDays($now)) ? (($created->diffInDays($now)==1) ? $created->diffInDays($now)." Day" : $created->diffInDays($now)." Days"):                    // return Day
                        (($created->diffInHours($now)) ? (($created->diffInHours($now)==1) ? $created->diffInHours($now)." Hour" : $created->diffInHours($now)." Hours") :              // return Hour
                        (($created->diffInMinutes($now)) ? (($created->diffInMinutes($now)==1)? $created->diffInMinutes($now)." Minute" :$created->diffInMinutes($now)." Minutes"):     // return Minute
                        (($created->diffInSeconds($now)) ?  (($created->diffInSeconds($now)==1)? $created->diffInSeconds($now)." Second" : $created->diffInSeconds($now)." Seconds") :  // return Second
                        false))) ;
                return $remain;
            }
            else{
                return false;
            }
        }
    }

    /*
     * Get the user trial information
     * @param int user_id
     * @return int like 6
     * */
    public function getTrialTimeInt()
    {
        /*
         * Using Carbon for date format
         * trial_ends_at get from database
         * Carbon::parse return date object
         * Carbon::now() create real time object
         * */

        $trial_days = $this->getFromDatabase('trial_ends_at') ? $this->getFromDatabase('trial_ends_at') : array();
        if(empty($trial_days)){
            return false;
        }else{
            $created = Carbon::parse($trial_days[0]->trial_ends_at);
            $now = Carbon::now();

            if($created>=$now){
                $remain = ($created->diffInDays($now)) ? $created->diffInDays($now):                    // return Day
                    (($created->diffInHours($now)) ? $created->diffInHours($now):              // return Hour
                        (($created->diffInMinutes($now)) ? $created->diffInMinutes($now):     // return Minute
                            (($created->diffInSeconds($now)) ? $created->diffInSeconds($now):  // return Second
                                false))) ;
                return $remain;
            }
            else{
                return false;
            }
        }
    }

    public function getPlanName()
    {
        $plan_name = $this->getFromDatabase('name as plan_name');
        return $plan_name ? $plan_name[0]->plan_name : false;

    }

    public function getPlanId()
    {
        $plan_name = $this->getPlanName();
        if($plan_name)
        {
            $plan_id = DB::table('stripe_plans')->select('id')->where('name','=',$plan_name)->get();
            return $plan_id ? $plan_id[0]->id : false;
        }else{
            return false;
        }
    }

    public function getPlanEndDate()
    {
        $end_date = $this->getFromDatabase('ends_at as end_date') ? $this->getFromDatabase('ends_at as end_date') : array();
        if(empty($end_date)){
            return "Unlimited(Auto renewal feature is on)";
        }else{
            $plan_date = Carbon::parse($end_date[0]->end_date);
            return $plan_date->toFormattedDateString();
        }
    }

    public function getPlanRemainDays()
    {
        /*
         * Using Carbon for date format
         * ends_at get from database
         * Carbon::parse return date object
         * Carbon::now() create real time object
         * */

        $trial_days = $this->getFromDatabase('ends_at') ? $this->getFromDatabase('ends_at'): array();
        if(empty($trial_days))
            return "Unlimited(Auto renewal feature is on)";

        $created = Carbon::parse($trial_days[0]->ends_at);
        $now = Carbon::now();

        if($created>=$now){
            $remain = ($created->diffInDays($now)) ? (($created->diffInDays($now)==1) ? $created->diffInDays($now)." Day" : $created->diffInDays($now)." Days"):                    // return Day
                (($created->diffInHours($now)) ? (($created->diffInHours($now)==1) ? $created->diffInHours($now)." Hour" : $created->diffInHours($now)." Hours") :              // return Hour
                    (($created->diffInMinutes($now)) ? (($created->diffInMinutes($now)==1)? $created->diffInMinutes($now)." Minute" :$created->diffInMinutes($now)." Minutes"):     // return Minute
                        (($created->diffInSeconds($now)) ?  (($created->diffInSeconds($now)==1)? $created->diffInSeconds($now)." Second" : $created->diffInSeconds($now)." Seconds") :  // return Second
                            false))) ;
            return $remain;
        }
        else{
            return false;
        }
    }

    public function getPlanCost()
    {
        $query = DB::table('subscriptions')
                ->join('stripe_plans','subscriptions.stripe_plan','=','stripe_plans.plan_id')
                ->select('amount','currency')
                ->where('user_id','=',$this->id)
                ->get();
        return $query? $query[0]->amount."/".$query[0]->currency : false;
    }

    public function getFeature($plan_name, $feature_name)
    {
        if($plan_name != null){
            $feature = StripePlan::with('planFeature')->whereName($plan_name)->first();
            return in_array($feature_name, array_column($feature->planFeature->toArray(),'feature_name'));
        }
        return false;
    }

    protected function getFromDatabase($select_column)
    {

        $data_query = DB::table('subscriptions')->select($select_column)->where('user_id','=',$this->id)->get();
        return $data_query ? $data_query : false;
    }

}