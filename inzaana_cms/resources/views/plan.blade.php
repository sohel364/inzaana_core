@extends('layouts.admin-master')
@section('title', 'Add Category')

@section('breadcumb')
<h1>Plan
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Home</a></li>
    <li>Plan</li>
    <li class="active">Subscribe Plan</li>
</ol>
@endsection

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Choose Your Plan</h3>
    </div>

    <div class="box-body">
      <div class="row padTB">
        @if(!$allplan->isEmpty())
            @foreach($allplan as $single_plan)
                <div class="col-md-4">
                    <div class="subscribe_box" style="border: 1px solid #d0d0d0;margin-right: 5px;padding: 10px;">
                        <h2 class="text-center">{{ $single_plan['name'] }}</h2>
                        <p class="text-center text-info">Trial days: {{ $single_plan['trial_period_days'] }}</p>
                        <ul>
                            @foreach($single_plan->planFeature as $feature)
                                <li>{{ $feature->feature_name }}</li>
                            @endforeach
                        </ul>
                        <p class="text-center label-info"><strong>Price: {{ $single_plan['amount'] ."". $single_plan->currency_symbol[$single_plan->currency]  }}/{{ $single_plan->interval }}</strong></p>
                        <div class="text-center">
                            @if(isset($user->subscriptions[0]) && $user->stripe_id != null && $user->subscriptions[0]->stripe_plan != $single_plan['plan_id'])
                                <form method="post" action="{{ route('swapSubscriptionPlan') }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $user->subscriptions[0]->name }}" name="_plan_name">
                                    <input type="hidden" value="{{ $single_plan['plan_id'] }}" name="_plan_id">
                                    <input type="hidden" value="{{ $single_plan['coupon_id'] }}" name="_coupon_id">
                                    <input type="submit" value="Migrate Plan" class="btn btn-primary">
                                </form>
                            @elseif(isset($user->subscriptions[0]) && $user->subscriptions[0]->stripe_plan == $single_plan['plan_id'])
                                <button class="btn btn-success" onclick="showMessage()">Subscribed</button>
                            @else
                                <button class="btn btn-primary" data-toggle="modal" data-name="{{ (isset($user->subscriptions[0]) && ($user->stripe_id != null)) ? $user->subscriptions[0]->name : $single_plan['name'] }}" data-id="{{ $single_plan['plan_id'] }}" data-coupon="{{ $single_plan['coupon_id'] }}" data-trial="{{ $single_plan['trial_period_days'] }}" data-target="#myModal">Subscribe</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-center text-red" style="font-size:22px;">Ooops! There is no plan available here.</p>
         @endif


    {{--Plan Modal--}}

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Subscription</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form method="POST" class="form-inline" id="payment-form">
                                            {{ csrf_field() }}
                                            <span class="payment-errors text-danger"></span>
                                            <div class="form-group" style="display: block">
                                                <label>
                                                    <span>Card Number</span>
                                                    <input type="text" class="form-control" data-stripe="number">
                                                </label>
                                            </div>
                                            <div class="form-group" style="display: block;">
                                                <label>
                                                    <span>Expiration (MM/YY)</span>
                                                    <input type="text" class="form-control" size="2" data-stripe="exp_month">
                                                    <span> / </span>
                                                    <input type="text" size="2" class="form-control" data-stripe="exp_year">
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    <span>CVC</span>
                                                    <input type="text" size="4" class="form-control" data-stripe="cvc">
                                                </label>
                                            </div>
                                            <input type="hidden" name="_plan_name" id="plane_name">
                                            <input type="hidden" name="_plan_id" id="plane_id">
                                            <input type="hidden" name="_coupon_id" id="coupon_id">
                                            <input type="hidden" name="_trial_days" id="trial_days">

                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <label for="checkbox" class="pull-left">
                                    <input type="checkbox" name="auto_renewal" value="1" id="checkbox" checked> Auto renewal
                                </label>
                                <input type="submit" class="btn btn-primary" value="Subscribe">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
</div>

@endsection


@section('footer-scripts')
    <script src="{{ URL::asset('super-admin-asset/stripe/super-admin-plan-view.js') }}"></script>
    <script src="https://js.stripe.com/v2/"></script>
    <script src="{{ URL::asset('super-admin-asset/stripe/stripe.js') }}"></script>
    <script>

            $('#myModal').on('show.bs.modal', function (event) {
              var button = $(event.relatedTarget) // Button that triggered the modal
              var plan_id = button.data('id') // Extract info from data-* attributes
              var plan_name = button.data('name') // Extract info from data-* attributes
              var trial_days = button.data('trial') // Extract info from data-* attributes
                var coupon_id = button.data('coupon') //Extract coupon data from button
              // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
              // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
               $('#plane_name').val(plan_name);
               $('#plane_id').val(plan_id);
               $('#coupon_id').val(coupon_id);
               $('#trial_days').val(trial_days);
              /*var modal = $(this)
              modal.find('#plan_name').val(plan_id)
              modal.find('#plan_id').val(plan_name)*/
            })

            function showMessage()
            {
                alert("Already you are subscribed this plan.");
            }
    </script>
@endsection