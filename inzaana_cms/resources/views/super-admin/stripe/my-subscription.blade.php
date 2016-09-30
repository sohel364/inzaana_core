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
            {{--{{dd($subscriber)}}--}}
            <h4>Plan Name: {{ $subscriber->plan_name }}</h4>
            @if($user->onTrial())
                  <h4>Trial Left: {{ $user->getTrialTimeString() }}</h4>
            @endif
            <h4>Plan Cost: {{ $user->getPlanCost() }}</h4>
            <h4>Remaining Days: {{ $user->getPlanRemainDays() }}</h4>
            <h4>Plan End Date: {{ $user->getPlanEndDate() }}</h4>

            </div>
        </div>
    </div>
    <!--END CONTENT-->
@endsection

@section('footer-script')
    {{--<script src="{{ URL::asset('super-admin-asset/stripe/super-admin-plan-view.js') }}"></script>--}}
@endsection
