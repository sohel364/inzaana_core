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
        @if(!$plan->isEmpty())
            @foreach($plan as $single_plan)
                <div class="col-md-4">
                    <div class="subscribe_box" style="border: 1px solid #d0d0d0;margin-right: 5px;padding: 10px;">
                        <h2 class="text-center">{{ $single_plan['name'] }}</h2>
                        <ul>
                            @foreach($single_plan->planFeature as $feature)
                                <li>{{ $feature->feature_name }}</li>
                            @endforeach
                        </ul>
                        <p class="text-center label-info"><strong>Price: {{ $single_plan['amount']  }}</strong></p>
                        <div class="text-center"><button class="btn btn-primary " data-toggle="modal" data-name="{{ $single_plan['name'] }}" data-id="{{ $single_plan['plan_id'] }}" data-target="#myModal">Subscribe</button></div>
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
              // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
              // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
               $('#plane_name').val(plan_name);
               $('#plane_id').val(plan_id);
              /*var modal = $(this)
              modal.find('#plan_name').val(plan_id)
              modal.find('#plan_id').val(plan_name)*/
            })
    </script>
@endsection