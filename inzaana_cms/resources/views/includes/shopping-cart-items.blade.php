<li>
    <span class="item">
      <span class="item-left">
          <img width="100px" height="60px" src="{{ $cart_item->image_url }}" alt="" />
          <span class="item-info">
              <span>{{ $cart_item->title . '(' . $cart_item->quantity . ')' }}</span>
              <span>{{ $cart_item->mrp }}</span>
          </span>
      </span>
      <span class="item-right">
          <form method="GET">
            <button formaction="{{ route('guest::cart.remove', [ 'product_id' => $cart_item->product_id, 'name' => $cart_item->store_name, 'domain' => $cart_item->domain ]) }}"
                    id="cart-item-remove-btn" data-pid="{{ $cart_item->product_id }}" class="btn btn-xs btn-danger pull-right" type="submit">x</button>
          </form>
      </span>
  </span>
</li>