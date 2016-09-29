@extends('layouts.admin-master')
@section('title', 'My subscription')

@section('breadcumb')
<h1>Plan</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Home</a></li>
    <li>Plan</li>
    <li class="active">My Subscription</li>
</ol>
@endsection

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">My Subscription Information</h3>
    </div>

    <div class="box-body">
      <div class="row padTB">

       @if(session('success'))
           <p class="text-primary">{{ session('success') }}</p>
       @endif

       @if(isset($subscriber))
         <h4>Plan Name: {{ $subscriber->plan_name }}</h4>
         @if($user->onTrial())
               <h4>Trial Left: {{ $user->getTrialTimeString() }}</h4>
         @endif
         <h4>Plan Cost: {{ $user->getPlanCost() }}</h4>
         <h4>Remaining Days: {{ $user->getPlanRemainDays() }}</h4>
         <h4>Plan End Date: {{ $user->getPlanEndDate() }}</h4>
       @else
            <p class="text-center text-warning" style="font-size:22px;">You are not subscribed any plan.</p>
            <p class="text-center text-black" style="font-size:18px;">For Subscription <a href="plan">click</a> here.</p>
       @endif

      </div>
    </div>
</div>

@endsection
