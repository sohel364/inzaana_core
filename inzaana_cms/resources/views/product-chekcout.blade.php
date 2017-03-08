@extends('layouts.vendor-store2-master')

@section('title', 'Checkout')

@section('header-scripts')


  <link href="{{ asset('/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset('/css/css-m/main.css')}}" rel="stylesheet">
  <link href="{{ asset('/css/bootstrap-magnify.min.css')}}" rel="stylesheet">
  <link href="{{ asset('/font-awesome-4.4.0/css/font-awesome.min.css')}}" rel="stylesheet">

@endsection

@section('container')
        <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-10 col-md-offset-1">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Total</th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody>                        
                        @each('includes.product-checkout-items', $cart->items, 'cart_item')
                        <tr>
                            <td>   </td>
                            <td>   </td>
                            <td>   </td>
                            <td><h5>Subtotal</h5></td>
                            <td class="text-right"><h5><strong>{{ '$' . $cart->sub_total }}</strong></h5></td>
                        </tr>
                        <tr>
                            <td>   </td>
                            <td>   </td>
                            <td>   </td>
                            <td><h5>Estimated shipping</h5></td>
                            <td class="text-right"><h5><strong>{{ '$6.94' }}</strong></h5></td>
                        </tr>
                        <tr>
                            <td>   </td>
                            <td>   </td>
                            <td>   </td>
                            <td><h3>Total</h3></td>
                            <td class="text-right"><h3><strong>{{ '$' . ($cart->sub_total + 6.94) }}</strong></h3></td>
                        </tr>
                        <tr>
                            <td>   </td>
                            <td>   </td>
                            <td>   </td>
                            <form method="GET">                             
                                <td>
                                <button formaction="{{ route('guest::showcase.continue', [ 'name' => $store_name, 'domain' => $domain, 'cart_id' => $cart->fingerprint ]) }}"
                                        id="continue-shopping-btn" class="btn btn-success" type="submit">
                                    <span class="glyphicon glyphicon-shopping-cart"></span> Continue Shopping
                                </button>
                                </td>
                            </form>
                            <form method="GET">
                                <td>
                                <button formaction="{{ route('guest::checkout', [ 'name' => $store_name, 'domain' => $domain ]) }}" id="checkout-btn" class="btn btn-success{{ count($cart->items) == 0 ? ' hidden' : '' }}" type="submit">
                                    <span class="glyphicon glyphicon-play"></span> Checkout
                                </button>
                            </td>
                            </form>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>

@endsection


@section('footer-scripts')

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('/js/js-m/bootstrap-magnify.min.js') }}"></script>
  
@endsection