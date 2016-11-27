<?php

namespace Inzaana;

use Illuminate\Database\Eloquent\Model;

class StripePlanFeature extends Model
{
    public $feature_list = ['Store','Categories','Products','FAQ','Orders','Customers','Coupons','Taxes','Localisation','Promotional Pages','Pages','Extensions','Sales','Authority','Inventory & Stock Manager','Point Of Sale','Reports','Browse Templates','My Templates'];
    protected $table = 'stripe_plan_features';
    protected $fillable = [
        'feature_name'
    ];
    //public $primaryKey = false;
    public $timestamps = false;
    protected $primaryKey = "feature_id";

   /* public function plan() wrong code
    {
        return $this->hasMany('Inzaana\StripePlan','stripe_plan_has_features','plan_id','feature_id');
        //->withPivot('position_id','create_at');
    }*/
}
