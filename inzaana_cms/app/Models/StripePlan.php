<?php

namespace Inzaana;

use Illuminate\Database\Eloquent\Model;

class StripePlan extends Model
{
    protected $table = 'stripe_plans';
    protected $fillable = [
        'plan_id','name', 'amount', 'currency','interval','active','auto_renewal','trial_period_days','statement_descriptor','created',
    ];
    //public $primaryKey = false;
    public $timestamps = false;

    public function planFeature()
    {
        return $this->belongsToMany('Inzaana\StripePlanFeature','stripe_plan_has_features','plan_id','feature_id');
            //->withPivot('position_id','create_at');
    }
}
