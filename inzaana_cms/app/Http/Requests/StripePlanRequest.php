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
            'plan_id'=> 'required|unique:stripeplans,plan_id',
            'plan_name'=> 'required',
            'plan_amount'=> 'required',
            'plan_des'=> 'max:22'
        ];
    }
}
