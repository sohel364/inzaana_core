<?php

namespace Inzaana;

use Illuminate\Database\Eloquent\Model;

class StripeCoupon extends Model
{
    protected $table = 'coupons';
    public $currency_symbol = ['' =>null, 'INR' =>'&#8377;','USD' => '&#36;','BDT' => '&#x9f3;'];
    public $sln = 0;
    protected $fillable = [
        'coupon_id','coupon_name', 'percent_off', 'amount_off','currency','duration','duration_in_months','max_redemptions','redeem_by'
    ];
}
