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

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Plan Name</th>
                        <th>Price</th>
                        <th>Trial Period</th>
                        <th>Description</th>
                        <th>Feature</th>
                        <th>Status</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                @if($allPlan->isEmpty())
                        <p class="text-center text-red">Ooops! There's no plan.</p>
                    @else
                        @foreach($allPlan as $plan)
                            <tr>
                                <td>{{ $plan->name }}</td>
                                <td>{{ $plan->amount }}/{{ $plan->interval }}</td>
                                <td>{{ $plan->trial_period_days }}</td>
                                <td>{{ $plan->statement_descriptor }}</td>
                                <td>
                                    @foreach($plan->planFeature as $feature)
                                        <p>{{ $feature->feature_name }}</p>
                                    @endforeach
                                </td>
                                <td>
                                    <div id="update_button{{ str_replace(':','_',$plan->plan_id) }}">
                                        @if($plan->active)
                                            <input type="submit" class="btn btn-warning btn-xs" data-status="0" id="update_status"  data-id="{{ $plan->plan_id }}" value="Hide">
                                        @else
                                            <input type="submit" class="btn btn-success btn-xs" data-status="1" id="update_status" data-id="{{ $plan->plan_id }}" value="Show">
                                        @endif
                                    </div>
                                </td>
                                <td>
                                <a href="{{ action('StripeController@editPlanFeature',$plan) }}" class="btn btn-warning btn-xs" style="display:none;">Edit</a>
                                <form method="POST" action="{{ action('StripeController@deletePlan') }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="plan" value="{{ Crypt::encrypt($plan['plan_id']) }}">
                                    <input type="submit" class="btn btn-danger btn-xs" value="Delete">
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
    <!--END CONTENT-->
@endsection

@section('footer-script')
    <script src="{{ URL::asset('super-admin-asset/stripe/super-admin-plan-view.js') }}"></script>
@endsection
