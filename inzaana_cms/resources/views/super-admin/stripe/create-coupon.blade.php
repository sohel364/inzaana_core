@extends('layouts.super-admin-master')
@section('title', 'Super Admin Dashboard')


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
<div class="page-content">
    <div id="tab-general">
        <div class="row">

            <div class="col-md-8 col-md-offset-2 stripe_coupon">
                @if(session('success'))
                    <p class="text-success">{{ session('success') }}</p>
                @endif
                <p class="text-success text-right"><span class="text-red">*</span> Mandatory field.</p>
                <form class="form-horizontal" id="create_coupon" {{--action="{{ route('admin::create.plan') }}"--}} method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" class="form-control" value="{{ str_random(12) }}" name="coupon_id">
                    @if($errors->first('coupon_id')) <p class="text-danger text-sm danger_text">Please refresh this page and try again.</p> @endif
                    <div class="form-group">
                        <label for="">Coupon name: <span class="text-red text-md">*</span></label>
                        <input type="text" class="form-control" value="{{old('coupon_name')}}" name="coupon_name" id="" placeholder="Give a good name for coupon [like Eid offer]...">
                        @if($errors->first('coupon_name')) <p class="text-danger text-sm danger_text">{{ $errors->first('coupon_name') }}</p> @endif
                    </div>
                    <div class="form-group" id="percent_off_block">
                        <label for="">Percent Off: </label>
                        <input type="text" class="form-control amount" value="{{old('percent_off')}}" name="percent_off" id="percent_off" placeholder="15">
                        @if($errors->first('percent_off')) <p class="text-danger text-sm danger_text">{{ $errors->first('percent_off') }}</p> @endif
                    </div>
                    <div class="form-group">
                        <label><input type="checkbox" name="amount_off_checked" value="1" id="enable_amount_off">Amount Off</label>
                    </div>
                    <div id="amount_off_block" style="display: none">
                        <div class="form-group">
                            <label for="">Currency:</label>
                            <select name="coupon_currency" id="currency">
                                <option value="INR">Indian Rupee</option>
                                <option value="USD">USD</option>
                                <option value="BDT">Bangladesh</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Amount Off: <span class="text-red text-md">*</span></label><span id="symbol"> &#8377;</span>
                            <input type="text" class="form-control amount" value="{{old('amount_off')}}" name="amount_off" id="amount_off" placeholder="36.5">
                            @if($errors->first('amount_off')) <p class="text-danger text-sm danger_text">{{ $errors->first('amount_off') }}</p> @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Duration: <span class="text-red">*</span></label>
                        <select name="duration" id="repeating">
                            <option value="once">Once</option>
                            <option value="repeating">Multi-Month</option>
                            <option value="forever">Forever</option>
                        </select>
                        <div class="repeating" id="view_repeating" style="display: none">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="duration_in_months" value="0" maxlength="3" class="" id="duration_in_months" style="width: 10%">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Max Redemptions: <span class="text-red text-md"><a href="#" data-toggle="tooltip" title="Maximum number of times this coupon can be redeemed, in total, before it is no longer valid.">?</a></span></label>
                        <input type="text" class="form-control" value="{{old('max_redemptions')}}" name="max_redemptions" id="max_redemptions">
                        @if($errors->first('max_redemptions')) <p class="text-danger text-sm danger_text">{{ $errors->first('max_redemptions') }}</p> @endif
                    </div>
                    <div class="form-group">
                        <label for="">Redemp By:</label>
                        <input type="text" class="form-control" value="{{old('redeem_by')}}" name="redeem_by" data-date-format="dd/mm/yyyy" id="redem_by">
                        @if($errors->first('redeem_by')) <p class="text-danger text-sm danger_text">{{ $errors->first('redeem_by') }}</p> @endif
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-sm" value="Create Coupon">
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
<!--END CONTENT-->
@endsection
@section('footer-scripts')
    <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('js/numeric.js') }}"></script>
    <script src="{{ URL::asset('super-admin-asset/stripe/coupon-create.js') }}"></script>
@endsection