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
}
