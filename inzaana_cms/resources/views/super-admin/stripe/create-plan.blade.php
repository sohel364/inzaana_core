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

                <div class="col-md-8 col-md-offset-2 stripe_plan">
                    @if(session('success'))
                        <p class="text-success">{{ session('success') }}</p>
                    @endif
                        <p class="text-success text-right"><span class="text-red">*</span> Mandatory field.</p>
                    <form class="form-horizontal" {{--action="{{ route('admin::create.plan') }}"--}} method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" class="form-control" value="{{ str_random(12) }}" name="plan_id">
                        @if($errors->first('plan_id')) <p class="text-danger text-sm danger_text">Please refresh this page and try again.</p> @endif
                        <div class="form-group">
                            <label for="">Plan name: <span class="text-red text-md">*</span></label>
                            <input type="text" class="form-control" value="{{old('plan_name')}}" name="plan_name" id="" placeholder="Enter Plan Name...">
                            @if($errors->first('plan_name')) <p class="text-danger text-sm danger_text">{{ $errors->first('plan_name') }}</p> @endif
                        </div>
                        <div class="form-group">
                            <label for="">Currency:</label>
                            <select name="plan_currency" id="currency">
                                <option value="INR">Indian Rupee</option>
                                <option value="USD">USD</option>
                                <option value="BDT">Bangladesh</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Amount: <span class="text-red text-md">*</span></label><span id="symbol"> &#8377;</span>
                            <input type="text" class="form-control" value="{{old('plan_amount')}}" name="plan_amount" id="plan_amount" placeholder="5.25">
                            @if($errors->first('plan_amount')) <p class="text-danger text-sm danger_text">{{ $errors->first('plan_amount') }}</p> @endif
                        </div>
                        <div class="form-group">
                            <label for="">Interval:</label>
                            <select name="plan_interval" id="">
                                <option value="day">Daily</option>
                                <option value="month">Monthly</option>
                                <option value="year">Yearly</option>
                                <option value="week">Weekly</option>
                                <option value="3-month">Every 3 months</option>
                                <option value="6-month">Every 6 months</option>
                                <option value="custom">Custom</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Trial period days: <span class="text-red text-md" id="required_field"></span></label>
                            <input type="text" class="form-control" value="{{old('plan_trial')}}" name="plan_trial" id="required_input" disabled>
                        </div>
                        <div class="form-group">
                            <label for="">Statement description:</label>
                            <input type="text" class="form-control" value="{{old('plan_des')}}" name="plan_des" id="field" maxlength="22">
                            <div id="charNum"></div>
                            @if($errors->first('plan_des')) <p class="text-danger text-sm danger_text">{{ $errors->first('plan_des') }}</p> @endif
                        </div>
						
						<div class="form-group">
						<label for="autorenew">Enable Auto-renewal: </label>
							<div class="checkbox">
								<label><input type="checkbox" name="auto_renewal" value="1" checked>Auto Renew</label>
							</div>
                        </div>
                        <div class="form-group">
                            <label for="Features">Select features for the plan : </label>
                            <div class="side-by-side clearfix">
                                <div>
                                    <select data-placeholder="Choose a Country..." style="width:350px;" multiple
                                            tabindex="3">
                                        @foreach($features as $feature)
                                            <option value="{{ $feature->feature_id }}">{{ $feature->feature_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-sm" value="Create Plan">
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
    <!--END CONTENT-->
@endsection
@section('footer-script')
    <script src="{{ URL::asset('super-admin-asset/stripe/plan-create.js') }}"></script>
@endsection