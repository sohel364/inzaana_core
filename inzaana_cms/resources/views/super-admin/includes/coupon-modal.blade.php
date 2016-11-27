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
                        <form method="POST" class="form-inline test" id="coupon_update" >
                            {{ csrf_field() }}
                            <input type="hidden" name="coupon_id" value="{{ $coupon_data['coupon_id'] }}">
                            <input type="hidden" name="order_edit" value="{{ $coupon_data['order'] }}">
                            <input type="hidden" name="sort_edit" value="{{ $coupon_data['sort'] }}">
                            <span class="plan-edit-errors text-danger"></span>
                            <div class="form-group" style="display: block">
                                <label>
                                    <span>Coupon Name:</span>
                                </label>
                                <input type="text" name="coupon_name" value="{{ $coupon_data['coupon_name'] }}">
                            </div>
                            <div class="form-group" style="display: block;">
                                <label>
                                    <span>Discount:</span>
                                    <span>{{ $coupon_data['discount'] }}</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label>
                                    <span>Max Redeemtion:</span>
                                </label>
                                <input type="text" class="form-control" name="redem" value="{{ $coupon_data['max_redemptions'] }}" disabled>
                            </div><br>
                            <div class="form-group">
                                <label>
                                    <span>Redeem By:</span>
                                </label>
                                <input type="text" class="form-control" name="description" value="{{ $coupon_data['redeem_by'] }}" disabled>
                            </div><br>
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
    <script src="{{ URL::asset('super-admin-asset/stripe/super-admin-coupon-view.js') }}"></script>
@endsection