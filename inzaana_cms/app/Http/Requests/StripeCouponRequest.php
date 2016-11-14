<?php

namespace Inzaana\Http\Requests;

use Inzaana\Http\Requests\Request;

class StripeCouponRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'coupon_id'=> 'unique:coupons,coupon_id',
            'coupon_name'=> 'required|unique:coupons,coupon_name',
            'duration'=> 'required',
            'max_redemptions'=> 'required',
            'redeem_by'=> 'required',
        ];
    }
}
