<?php

namespace Inzaana;

use Illuminate\Database\Eloquent\Model;

class StripePlan extends Model
{
    protected $table = 'stripeplans';
    protected $fillable = [
        'plan_id','name', 'amount', 'currency','interval','active','trial_period_days','statement_descriptor','created',
    ];
    //public $primaryKey = false;
    public $timestamps = false;
}
