<?php

namespace Inzaana;

use Illuminate\Database\Eloquent\Model;

class StripePlanFeature extends Model
{
    protected $table = 'stripe_plan_features';
    protected $fillable = [
        'feature_name'
    ];
    //public $primaryKey = false;
    public $timestamps = false;
    protected $primaryKey = "feature_id";
}
