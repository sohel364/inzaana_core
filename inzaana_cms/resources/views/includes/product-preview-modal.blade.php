<!--View product modal-->
@if($product->marketProduct())
<div id="view_detail_{{ $product->id }}" class="modal fade" role="dialog">
    
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Product Details - Quick View</h4>
      </div>
      <div class="modal-body">
          <div class="row">
      <div class="col-md-6  padT10">
        <img class="img-responsive imgborder" data-toggle="magnify" src="{{ $product->thumbnail() }}" />
      </div>
      <div class="col-md-6">
        <h3 class="padmar0 headtext1">{{ $product->title }}</h3>
        <p>Category: {{ $product->categoryName() }}</p>
        <h4>₹{{ $product->marketProduct()->price }}</h4>
        <p class="sku">{{ $product->discount }}% discount!</p>
          @include('includes.approval-label', [ 'status' => $product->status, 'labelText' => $product->getStatus() ])
        <hr>
        <h5>Product Info</h5>
        <p class="slidePara1">{!! $product->description or '<i>No description is found to this product</i>' !!}</p>
        <h5>Product Spec</h5>
        <p class="slidePara1">@each('includes.product-special-specs', $product->specialSpecs(), 'properties', 'includes.product-specs-empty')</p>
      </div>
    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
    
</div>
@endif
<!--end View product modal-->