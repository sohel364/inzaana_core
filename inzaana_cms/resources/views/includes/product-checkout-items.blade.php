<tr>
    <td class="col-sm-8 col-md-6">
    <div class="media">
        <a class="thumbnail pull-left" href="#"> <img class="media-object" src="{{ $cart_item->image_url }}" style="width: 72px; height: 72px;"> </a>
        <div class="media-body">
            <h4 class="media-heading"><a href="#">{{ $cart_item->title }}</a></h4>
            <h5 class="media-heading"> by <a href="#">{{ $cart_item->product_manufacturer }}</a></h5>
            <span>Status: </span><span class="text-success"><strong>{{ $cart_item->product_status }}</strong></span>
        </div>
    </div></td>
    <td class="col-sm-1 col-md-1" style="text-align: center">
    <input type="text" class="form-control" id="quantity_{{ $cart_item->product_id }}" name="quantity_{{ $cart_item->product_id }}" value="{{ $cart_item->quantity }}">
    </td>
    <td class="col-sm-1 col-md-1 text-center"><strong>{{ $cart_item->mrp }}</strong></td>
    <td class="col-sm-1 col-md-1 text-center"><strong>{{ ( $cart_item->mrp * $cart_item->quantity ) }}</strong></td>
    <td class="col-sm-1 col-md-1">
      <form method="GET">
        <button formaction="{{ route('guest::cart.checkout.remove', [ 'product_id' => $cart_item->product_id, 'name' => $cart_item->store_name, 'domain' => $cart_item->domain ]) }}" id="cart-item-checkout-remove-btn" class="btn btn-danger" type="submit">
        <span class="glyphicon glyphicon-remove"></span> Remove</button>
      </form>
    </td>
</tr>