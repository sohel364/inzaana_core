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
    <div class="pull-right"><a href="#">Export to XLS </a> </div>
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

            <div class="subscribe_dom" id="subscribe_dom">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>SLN</th>
                        <th data-sort="name" data-order="{{ $order }}" id="click_by_sort">
                            <a href="#">Subscriber
                                @if($order == 'ASC' && $sort == 'name')
                                    <i class="fa fa-caret-up" aria-hidden="true"></i>
                                @elseif($order == 'DESC' && $sort == 'name')
                                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                                @endif
                            </a>
                        </th>
                        <th data-sort="name" data-order="{{ $order }}" id="click_by_sort">
                            <a href="#">E-mail
                                @if($order == 'ASC' && $sort == 'email')
                                    <i class="fa fa-caret-up" aria-hidden="true"></i>
                                @elseif($order == 'DESC' && $sort == 'email')
                                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            Contact
                        </th>
                        <th>
                            Address
                        </th>
                        <th data-sort="name" data-order="{{ $order }}" id="click_by_sort">
                            <a href="#">Plan
                                @if($order == 'ASC' && $sort == 'plan')
                                    <i class="fa fa-caret-up" aria-hidden="true"></i>
                                @elseif($order == 'DESC' && $sort == 'plan')
                                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            Store
                        </th>
                        <th>
                            Discount
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Trial
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($subscribers as $subscriber)
                        <tr>
                            <td> {{ $sln++ }} </td>
                            <td>{{ $subscriber->subscriber_name }}</td>
                            <td>{{ $subscriber->email }}</td>
                            <td>{{ $subscriber->contact }}</td>
                            <td>{{ $subscriber->address }}</td>
                            <td>
                                @if($subscriber->coupon_id != null)
                                    {{ $subscriber->plan_name }} (<s>{{ $subscriber->amount }}/{{ $subscriber->interval }}</s> {{ $subscriber->coupon['discount_price'] }}/{{ $subscriber->interval }})
                                @else
                                    {{ $subscriber->plan_name }} ({{ $subscriber->amount }}/{{ $subscriber->interval }})
                                @endif


                            </td>
                            <td>
                                @foreach($subscriber->store_name as $store)
                                    <li style="list-style: none;padding: 0;margin: 0;">
                                        @if($store[1]=='APPROVED')
                                            <span class="text-green"><i class="fa fa-check" aria-hidden="true"></i> </span> {{ $store[0] }}
                                        @else
                                            <span class="text-red"><i class="fa fa-times" aria-hidden="true"></i> </span>{{ $store[0] }}
                                        @endif
                                    </li>
                                @endforeach

                            </td>
                            <td>
                                @if($subscriber->coupon_id != null)
                                    {{ $subscriber->coupon['coupon_name'] }}<br>
                                    {{--{{ $subscriber->coupon['discount'] }}<br>
                                    {{ $subscriber->coupon['redeem_by'] }}<br>--}}
                                @else
                                    No Discount
                                @endif
                            </td>
                            <td><span class="label label-success">Active</span></td>
                            <td>{{ $subscriber->trial }}</td>
                            <td>
                                <!--<button class="btn btn-primary btn-xs" data-id="{{ $subscriber->stripe_id }}" id="user_details">Details</button>-->

                                @include('includes.approval-buttons', [ 'status' => 'ON_APPROVAL', 'route' => [ 'namespace' => 'admin::', 'type' => 'subscribers' ], 'id' => $subscriber->id])

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
<!--END CONTENT-->
@endsection

@section('footer-scripts')
    <script src="{{ URL::asset('super-admin-asset/stripe/subscriber.js') }}"></script>
@endsection
