<?php

namespace Inzaana;

use Illuminate\Database\Eloquent\Model;

class StripePlan extends Model
{
    protected $table = 'stripeplans';
    protected $fillable = [
        'plan_id','name', 'amount', 'currency','interval','trial_period_days','statement_descriptor','created',
    ];
    protected $hidden = [ ];
    public $primaryKey = false;
    public $timestamps = false;
}
