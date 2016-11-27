<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Update Plan Information.</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form method="POST" class="form-inline test" id="plan_update" >
                            {{ csrf_field() }}
                            <input type="hidden" name="plan_id" value="{{ $plan_data['id'] }}">
                            <input type="hidden" name="order_edit" value="{{ $plan_data['order'] }}">
                            <input type="hidden" name="sort_edit" value="{{ $plan_data['sort'] }}">
                            <span class="plan-edit-errors text-danger"></span>
                            <div class="form-group" style="display: block">
                                <label>
                                    <span>Plan Name:</span>
                                </label>
                                <input type="text" name="plan_name" value="{{ $plan_data['plan_name'] }}">
                            </div>
                            <div class="form-group" style="display: block;">
                                <label>
                                    <span>Price:</span>
                                    <span>{{ $plan_data['price'] }}</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label>
                                    <span>Trial Period:</span>
                                </label>
                                <input type="text" size="4" class="form-control" name="trial" value="{{ $plan_data['trial'] }}">
                            </div><br>
                            <div class="form-group">
                                <label>
                                    <span>Description:</span>
                                </label>
                                <input type="text" class="form-control" name="description" value="{{ $plan_data['description'] }}">
                            </div><br>

                            <div class="form-group">
                                <div class="checkbox">
                                    <label><input type="checkbox" name="discount" id="discount" value="1" {{ isset($plan_data['coupon_id']) ? "checked":'' }}>Apply Discount</label>
                                </div>
                            </div><br>

                            <div class="discount_block" id="discount_block" style="display: {{ isset($plan_data['coupon_id']) ? "block":"none" }}">
                                <div class="form-group">
                                    <label for="">Coupon Name: </label>
                                    <select name="stripe_coupon" id="coupon">
                                        <option value="" selected>---select---</option>
                                        @foreach($coupons as $coupon)
                                            @if($plan_data['coupon_id'] == $coupon['coupon_id'])
                                                <option value="{{ $coupon['coupon_id'] }}" selected>{{ $coupon['coupon_name'] }}</option>
                                            @else
                                                <option value="{{ $coupon['coupon_id'] }}">{{ $coupon['coupon_name'] }}</option>
                                            @endif
                                        @endforeach

                                    </select>
                                </div>
                            </div><br>

                            <div class="form-group">
                                <label for="autorenew">Auto-renewal: </label>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="auto_renewal" value="1" {{ $plan_data['renewal'] ? "checked":"" }}>Auto Renew</label>
                                </div>
                            </div><br>
                            <div class="form-group">
                                <label for="Features">Select features for the plan : </label>
                                <select name="feature_id[]" id="" multiple>
                                    @foreach($feature as $index => $value)
                                        <option value="{{ $index }}" {{ (isset($plan_data['feature']) && in_array($value, $plan_data['feature']) )? "selected":"" }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" id="modal_submit"  value="Update">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>

@section('footer-script')
    <script src="{{ URL::asset('super-admin-asset/stripe/super-admin-plan-view-new.js') }}"></script>
@endsection