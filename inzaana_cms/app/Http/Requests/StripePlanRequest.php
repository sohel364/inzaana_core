<?php

namespace Inzaana\Http\Requests;

use Inzaana\Http\Requests\Request;

class StripePlanRequest extends Request
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
            'plan_name'=> 'required|regex:/^[(a-zA-Z\s)]+$/u|unique:stripe_plans,name',
            'plan_amount'=> 'required|numeric',
            'plan_des'=> 'max:22'
        ];
    }
}
