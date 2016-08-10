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
                        <th>Plan ID</th>
                        <th>Plan Name</th>
                        <th>Price</th>
                        <th>Trial Period</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allPlan as $plan)
                        <tr>
                            <td>{{ $plan->plan_id }}</td>
                            <td>{{ $plan->name }}</td>
                            <td>{{ $plan->amount }}/{{ $plan->interval }}</td>
                            <td>{{ $plan->trial_period_days }}</td>
                            <td>
                                <form method="POST" name="plan-status" id="plan-status">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="plan_id" value="{{ Crypt::encrypt($plan['plan_id']) }}">
                                    <div id="update_button">
                                        @if($plan->active)
                                            <input type="hidden" name="status_id" value="{{ !$plan->active }}">
                                            <input type="submit" class="btn btn-warning btn-xs" value="Hide">
                                        @else
                                            <input type="hidden" name="status_id" value="{{ !$plan->active }}">
                                            <input type="submit" class="btn btn-success btn-xs" value="Show">
                                        @endif
                                    </div>
                                </form>
                            </td>
                            <td>
                            <form method="POST" action="{{ action('StripeController@deletePlan') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="plan" value="{{ Crypt::encrypt($plan['plan_id']) }}">
                                <input type="submit" class="btn btn-danger btn-xs" value="Delete">
                            </form>
                            </td>
                        </tr>
                    @endforeach
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
