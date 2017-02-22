
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <span class="glyphicon cart_anchor"></span> <span id="cart_items_count">{{ $cart->items_count }}</span> - Items<span class="caret"></span></a>
<ul class="dropdown-menu dropdown-cart" role="menu">
    @each('includes.shopping-cart-items', $cart->items, 'cart_item')
    <li class="divider"></li>
    <li><a class="text-center" href="">View Cart</a></li>
</ul>