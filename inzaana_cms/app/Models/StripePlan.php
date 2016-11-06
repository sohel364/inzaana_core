<?php

namespace Inzaana;

use Illuminate\Database\Eloquent\Model;

class StripePlan extends Model
{
    protected $table = 'stripe_plans';
    public $currency_symbol = ['INR' =>'&#8377;','USD' => '&#36;','BDT' => '&#x9f3;'];
    public $sln = 0;
    protected $fillable = [
        'plan_id','name', 'amount', 'currency','interval','interval_count','active','auto_renewal','trial_period_days','statement_descriptor','created',
    ];
    //public $primaryKey = false;
    public $timestamps = false;

    public function planFeature()
    {
        return $this->belongsToMany('Inzaana\StripePlanFeature','stripe_plan_has_features','plan_id','feature_id');
            //->withPivot('position_id','create_at');
    }
}
