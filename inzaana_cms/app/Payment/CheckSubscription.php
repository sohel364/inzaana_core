<?php
/**
 * Created by PhpStorm.
 * User: sk
 * Date: 8/25/2016
 * Time: 2:51 PM
 */

namespace Inzaana\Payment;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Inzaana\Payment\PaymentException;
use Carbon\Carbon;

trait CheckSubscription {

    /*
     * Check if the use has access permission
     * @return boolean
     * */
    public function isAccess()
    {
        return false;
        if($this->getPlanEndDate())
            dd($this->getPlanEndDate());
        return $this->getPlanEndDate();
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

        $trial_days = $this->getFromDatabase('trial_ends_at');
        $created = Carbon::parse($trial_days->trial_ends_at);
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

        $trial_days = $this->getFromDatabase('trial_ends_at');
        $created = Carbon::parse($trial_days->trial_ends_at);
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

    public function getPlanName()
    {
        $plan_name = $this->getFromDatabase('name as plan_name');
        return $plan_name->plan_name;

    }

    public function getPlanEndDate()
    {
        $end_date = $this->getFromDatabase('ends_at as end_date');
        $plan_date = Carbon::parse($end_date->end_date);
        return $plan_date->toFormattedDateString();
    }

    public function getPlanRemainDays()
    {
        /*
         * Using Carbon for date format
         * ends_at get from database
         * Carbon::parse return date object
         * Carbon::now() create real time object
         * */

        $trial_days = $this->getFromDatabase('ends_at');
        $created = Carbon::parse($trial_days->ends_at);
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
                ->where('user_id','=',Auth::user()->id)
                ->first();
        return $query->amount."/".$query->currency;
    }

    protected function getFromDatabase($select_column)
    {
       return DB::table('subscriptions')->select($select_column)->where('user_id','=',Auth::user()->id)->first();
    }

} 