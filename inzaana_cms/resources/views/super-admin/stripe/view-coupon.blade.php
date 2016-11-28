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
        <div class="pull-right"><a href="#">Export to XLS</a></div>
        <div class="clearfix"></div>
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
                <div class="plan-area" id="coupon-area">
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
                                            <input type="hidden" name="order" value="{{ $order }}">
                                            <input type="hidden" name="sort" value="{{ $sort }}">
                                            <select name="confirm_action" id="select_action" onchange="setFormActionOnChange(this)">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                                <option value="{{ $coupon['coupon_id'] }}">Edit</option>
                                                <option value="Delete" >Delete</option>
                                            </select>
                                            <input type="submit" class="btn btn-info btn-sm btn-flat" id="submit-{{ $coupon['coupon_id'] }}" data-toggle="modal" data-target="" value="Confirm">
                                        </form>
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

@section('footer-scripts')
    {{--<script src="{{ URL::asset('super-admin-asset/stripe/super-admin-plan-view.js') }}"></script>--}}
    <script src="{{ URL::asset('super-admin-asset/stripe/super-admin-coupon-view.js') }}"></script>
@endsection
