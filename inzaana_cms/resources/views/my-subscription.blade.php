@extends('layouts.admin-master')
@section('title', 'Add Category')

@section('breadcumb')
<h1>Plan
</h1>
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

@endsection
