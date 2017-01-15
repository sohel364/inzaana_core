
<!--View product remove confirm modal-->

@if($product->marketProduct())

<div id="confirm_remove_{{ $product->id }}" class="modal fade" role="dialog">
    
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Remove product - Confirm</h4>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <h3 class="padmar0 headtext1">{{ $product->title }}</h3>            
              <h5>You are going to remove a product. Are you sure?</h5>
            </div>
          </div>
      </div>
      <div class="modal-footer">
          <div class="row">
            <div class="col-md-1">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancel</button>
            </div>
            <div class="col-md-1">
                <form method="POST">
                  {!! csrf_field() !!}
                  <button formaction="{{ route('user::products.delete', [$product]) }}" id="product-delete-btn" class="btn btn-default btn-flat" type="submit">Confirm</button>
                </form>
            </div>
          </div>
      </div>
    </div>
  </div>
    
</div>
@endif
<!--end View product remove confirm modal-->