@extends('layouts.super-admin-master')
@section('title', 'Super Admin Dashboard')
@section('header-style')
    <link type="text/css" rel="stylesheet" href="{{ asset('css/loading.css') }}">
    @endsection

    @section('content')
            <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left mediaCr">
            <div class="page-title titleEx">
                Inzaana
            </div>
            <div class="page-title hidden-xs">
                | Super Admin Dashboard</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="index.html">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Dashboard</li>
        </ol>
        <div class="clearfix">
        </div>
    </div>
    <!--END TITLE & BREADCRUMB PAGE-->
    <!--BEGIN CONTENT-->
    <div class="page-content" style="background-color:#fff;">
        <div id="tab-general">
            <div class="row">

                {{-- Success & Error Message --}}
                @if(session('success'))
                    <p class="text-primary">{{ session('success') }}</p>
                @endif
{{ dd($allCoupon) }}
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                {{--End of Success & Error Message--}}
                <div class="plan-area" id="plan-area">
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
                                    <td>{{ $coupon->percent_off }}</td>
                                    <td>{{ $coupon->amount_off ."". $coupon->currency_symbol[$coupon->currency] }}/{{ $coupon->duration }}</td>
                                    <td>{{ $coupon->max_redemptions }} {{ ($coupon->max_redemptions > 1)? " Peoples":" People" }} </td>
                                    <td>{{ $coupon->redeem_by }}</td>
                                    <td>
                                        {{--<label for="" id="{{ $plan['plan_id'] }}" class="label {{ $plan['active'] ? "label-success": "label-warning" }}">{{ $plan['active'] ? "Active": "Inactive" }}</label>--}}
                                        {{--<div id="update_button{{ str_replace(':','_',$plan->plan_id) }}">
                                            @if($plan->active)
                                                <input type="submit" class="btn btn-warning btn-xs" data-status="0" id="update_status"  data-id="{{ $plan->plan_id }}" value="Hide">
                                            @else
                                                <input type="submit" class="btn btn-success btn-xs" data-status="1" id="update_status" data-id="{{ $plan->plan_id }}" value="Show">
                                            @endif
                                        </div>--}}
                                    </td>
                                    <td>
                                        {{--<a href="{{ action('StripeController@editPlanFeatureView',$plan) }}" class="btn btn-warning btn-xs" style="display: none;">Edit</a>

                                        <form action="view-plan/ajax/update" method="post" name="action" id="{{ $plan['plan_id'] }}" class="form-horizontal change_status">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="plan" id="plan_id" value="{{ $plan['plan_id'] }}--}}{{--{{ Crypt::encrypt($plan['plan_id']) }}--}}{{--">
                                            <select name="confirm_action" id="select_action" onchange="setFormActionOnChange(this)">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                                <option value="{{ $plan['plan_id'] }}">Edit</option>
                                                <option value="Delete" >Delete</option>
                                            </select>
                                            <input type="submit" class="btn btn-info btn-sm btn-flat" id="submit-{{ $plan['plan_id'] }}" data-toggle="modal" data-target="" value="Confirm">
                                        </form>--}}

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
                </div>

            </div>
        </div>
    </div>
    <!--END CONTENT-->
    <div class="modal"><!-- This modal for waiting gif image.... --></div>

    <div id="modal_container">{{--Modal load here--}}</div>
@endsection

@section('footer-script')
    {{--<script src="{{ URL::asset('super-admin-asset/stripe/super-admin-plan-view.js') }}"></script>--}}
    <script src="{{ URL::asset('super-admin-asset/stripe/super-admin-plan-view-new.js') }}"></script>
@endsection
