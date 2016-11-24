<div>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>SLN</th>
            <th data-sort="name" data-order="{{ $order }}" id="click_by_sort">
                <a href="#">Plan Name
                    @if($order == 'ASC' && $sort == 'name')
                        <i class="fa fa-caret-up" aria-hidden="true"></i>
                    @elseif($order == 'DESC' && $sort == 'name')
                        <i class="fa fa-caret-down" aria-hidden="true"></i>
                    @endif
                </a>
            </th>
            <th data-sort="price" data-order="{{ $order }}" id="click_by_sort">
                <a href="#">Price
                    @if($order == 'ASC' && $sort == 'price')
                        <i class="fa fa-caret-up" aria-hidden="true"></i>
                    @elseif($order == 'DESC' && $sort == 'price')
                        <i class="fa fa-caret-down" aria-hidden="true"></i>
                    @endif
                </a>
            </th>
            <th data-sort="trial" data-order="{{ $order }}" id="click_by_sort">
                <a href="#">Trial Period
                    @if($order == 'ASC' && $sort == 'trial')
                        <i class="fa fa-caret-up" aria-hidden="true"></i>
                    @elseif($order == 'DESC' && $sort == 'trial')
                        <i class="fa fa-caret-down" aria-hidden="true"></i>
                    @endif
                </a>
            </th>
            <th>
                Description
            </th>
            <th>
                Feature
            </th>
            <th>
                Discount
            </th>
            <th>
                Status
            </th>
            <th width="20%">Action</th>
        </tr>
        </thead>
        <tbody>
        @if($allPlan->isEmpty())
            <p class="text-center text-red">Ooops! There's no plan.</p>
        @else
            @foreach($allPlan as $plan)
                <tr>
                    <td>{{ $sln++ }}</td>
                    <td>{{ $plan->name }}</td>
                    <td>
                        @if($plan->coupon_id != null)
                            <s>{{ $plan->amount."". $plan->currency_symbol[$plan->currency] }}/{{ $plan->interval }}</s>, {{ $plan->coupon['discount_price']."". $plan->currency_symbol[$plan->currency] }}/{{ $plan->interval }}
                        @else
                            {{ $plan->amount."". $plan->currency_symbol[$plan->currency] }}/{{ $plan->interval }}
                        @endif

                    </td>
                    <td>{{ $plan->trial_period_days }}</td>
                    <td>{{ $plan->statement_descriptor }}</td>
                    <td>
                        @foreach($plan->planFeature as $feature)
                            <p>{{ $feature->feature_name }}</p>
                        @endforeach
                    </td>
                    <td>
                        @if($plan->coupon_id != null)
                            {{ $plan->coupon['coupon_name'] }}
                        @else
                            No Offer
                        @endif
                    </td>
                    <td>
                        <label for="" id="{{ $plan['plan_id'] }}" class="label {{ $plan['active'] ? "label-success": "label-warning" }}">{{ $plan['active'] ? "Active": "Inactive" }}</label>

                    </td>
                    <td>
                        <a href="{{ action('StripeController@editPlanFeatureView',$plan) }}" class="btn btn-warning btn-xs" style="display: none;">Edit</a>

                        <form action="view-plan/ajax/update" method="post" name="action" id="{{ $plan['plan_id'] }}" class="form-horizontal change_status">
                            {{ csrf_field() }}
                            <input type="hidden" name="sort" value="{{ $sort }}">
                            <input type="hidden" name="order" value="{{ $order }}">
                            <input type="hidden" name="plan" id="plan_id" value="{{ $plan['plan_id'] }}{{--{{ Crypt::encrypt($plan['plan_id']) }}--}}">
                            <select name="confirm_action" id="select_action" onchange="setFormActionOnChange(this)">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                                <option value="{{ $plan['plan_id'] }}">Edit</option>
                                <option value="Delete" >Delete</option>
                            </select>
                            <input type="submit" class="btn btn-info btn-sm btn-flat" id="submit-{{ $plan['plan_id'] }}" data-toggle="modal" data-target="" value="Confirm">
                        </form>

                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>