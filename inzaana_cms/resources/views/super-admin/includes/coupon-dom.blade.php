<table class="table table-bordered">
    <thead>
    <tr>
        <th>SLN</th>
        <th data-sort="name" data-order="{{ $order }}" id="click_by_sort">
            <a href="#">Coupon Name
                @if($order == 'ASC' && $sort == 'name')
                    <i class="fa fa-caret-up" aria-hidden="true"></i>
                @elseif($order == 'DESC' && $sort == 'name')
                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                @endif
            </a>
        </th>
        <th data-sort="percent_off" data-order="{{ $order }}" id="click_by_sort">
            <a href="#">Percent Off
                @if($order == 'ASC' && $sort == 'percent_off')
                    <i class="fa fa-caret-up" aria-hidden="true"></i>
                @elseif($order == 'DESC' && $sort == 'price')
                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                @endif
            </a>
        </th>
        <th data-sort="amount_off" data-order="{{ $order }}" id="click_by_sort">
            <a href="#">Amount Off
                @if($order == 'ASC' && $sort == 'amount_off')
                    <i class="fa fa-caret-up" aria-hidden="true"></i>
                @elseif($order == 'DESC' && $sort == 'trial')
                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                @endif
            </a>
        </th>
        <th>
            Max Redemption
        </th>
        <th>
            Redeem By
        </th>
        <th>
            Status
        </th>
        <th width="20%">Action</th>
    </tr>
    </thead>
    <tbody>
    @if($allCoupon->isEmpty())
        <p class="text-center text-red">Ooops! There's no coupon.</p>
    @else
        @foreach($allCoupon as $coupon)
            <tr>
                <td>{{ $sln++ }}</td>
                <td>{{ $coupon->coupon_name }}</td>
                <td>{{ ($coupon->percent_off > 0) ? $coupon->percent_off."%": null }}</td>
                <td>{{ ($coupon->amount_off > 0)? $coupon->amount_off ."". $coupon->currency_symbol[$coupon->currency]."/". $coupon->duration : null }}</td>
                <td>{{ $coupon->max_redemptions }} {{ ($coupon->max_redemptions > 1)? " Peoples":" People" }} </td>
                <td>{{ $coupon->redeem_by }}</td>
                <td>
                    <label for="" id="{{ $coupon['coupon_id'] }}" class="label {{ $coupon['valid'] ? "label-success": "label-warning" }}">{{ $coupon['valid'] ? "Active": "Inactive" }}</label>
                </td>
                <td>
                    <form action="view-coupon/ajax/update" method="post" name="action" id="{{ $coupon['coupon_id'] }}" class="form-horizontal change_status">
                        {{ csrf_field() }}
                        <input type="hidden" name="coupon" id="coupon_id" value="{{ $coupon['coupon_id'] }}">
                        <select name="confirm_action" id="select_action" onchange="setFormActionOnChange(this)">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                            <option value="{{ $coupon['coupon_id'] }}">Edit</option>
                            <option value="Delete" >Delete</option>
                        </select>
                        <input type="submit" class="btn btn-info btn-sm btn-flat" id="submit-{{ $coupon['coupon_id'] }}" data-toggle="modal" data-target="" value="Confirm">
                    </form>

                    {{-- <form method="POST" action="{{ action('StripeController@deletePlan') }}">
                         {{ csrf_field() }}
                         <input type="hidden" name="plan" value="{{ Crypt::encrypt($plan['plan_id']) }}">
                         <input type="submit" class="btn btn-danger btn-xs" value="Delete">
                     </form>--}}

                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>