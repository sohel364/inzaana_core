
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <span class="glyphicon cart_anchor"></span> <span id="cart_items_count">{{ $cart->items_count }}</span> - Items<span class="caret"></span></a>
<ul class="dropdown-menu dropdown-cart" role="menu">
    @each('includes.shopping-cart-items', $cart->items, 'cart_item')
    <li class="divider"></li>
    <li><a class="text-center" href="{{ count($cart->items) > 0 ? route('guest::cart.checkout', [ 'store_name' => $store_name, 'domain' => $domain, 'cart_id' => $cart->fingerprint ]) : '#' }}">View Cart</a></li>
</ul>