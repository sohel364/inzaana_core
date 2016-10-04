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
                        <th>Subscriber Name</th>
                        <th>Subscriber E-mail</th>
						<th>Contact Number</th>
						<th>Address</th>
                        <th>Plan</th>
						<th>Status</th>
                        <th>Trial</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($subscribers as $subscriber)
                        <tr>
                            <td>{{ $subscriber->subscriber_name }}</td>
                            <td>{{ $subscriber->email }}</td>
							<td>0173043343</td>
							<td>33/A eskaton garden</td>
                            <td>{{ $subscriber->plan_name }} ({{ $subscriber->amount }}/{{ $subscriber->interval }})</td>
							<td><a href=""><span class="label label-success">Active</span></a></td>
                            <td>{{ $subscriber->trial }}</td>
                            <td>
                                <!--<button class="btn btn-primary btn-xs" data-id="{{ $subscriber->stripe_id }}" id="user_details">Details</button>-->

								@include('includes.approval-buttons', [ 'status' => 'ON_APPROVAL', 'route' => [ 'namespace' => 'admin::', 'type' => 'subscribers' ], 'id' => '0'])
                          
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
    {{--<script src="{{ URL::asset('super-admin-asset/stripe/super-admin-plan-view.js') }}"></script>--}}
@endsection
