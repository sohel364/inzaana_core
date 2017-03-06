@extends('layouts.vendor-store2-master')

@section('title', 'Showcase')

@section('header-scripts')

  <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset('css/css-m/main.css')}}" rel="stylesheet">
  <link href="{{ asset('css/bootstrap-magnify.min.css')}}" rel="stylesheet">
  <link href="{{ asset('font-awesome-4.4.0/css/font-awesome.min.css')}}" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
/*$(document).ready(function(){
  $('.add-to-cart').on('click',function(){
    //Scroll to top if cart icon is hidden on top
    $('html, body').animate({
      'scrollTop' : $(".cart_anchor").position().top
    });
    //Select item image and pass to the function
    var itemImg = $(this).parent().find('img').eq(0);
    flyToElement($(itemImg), $('.cart_anchor'));
  });
});*/
</script>

<style type="text/css">
.cart_anchor{ float:right; vertical-align:top; background: url('{{ asset('images/cart-icon.png') }}') no-repeat center center / 100% auto;width: 25px;height: 25px;  padding-top: 75px;}
</style>

@endsection

@section('container')
        <!--Nav-->
  <div class="shadow">
    <div class="container">
      <nav class="navbar navbar-default navbar-static-top">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.html"><strong>{{ $store_name }}</strong></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav text-center">
            <li class="active"><a href="index.html">Home</a>
            </li>
            <li><a href="About.html">About</a>
            </li>
            <li><a href="contact.html">Contact</a>
            </li>
            <li><a href="kitchen.html">Kitchen</a>
            </li>
            <li><a href="decor.html">Decor</a>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown shopping-cart" id="add-item">
              @include('includes.shopping-cart', ['cart' => $cart ])
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </div>
  <!--End of Nav-->
  <!--Slider-->
   <div class="container">
    <div class="row sliderrow">
      <div class="col-md-6 col-sm-6 box1">
        
        <div class="row">
            <div class="col-md-8">
                <h3 class="PsliderCaption">Featured Products</h3>
            </div>
            <div class="col-md-4">
                <!-- Controls -->
                <div class="controls pull-right hidden-xs SliderButton">
                    <a class="left fa fa-chevron-left btn btn-success" href="#carousel-example"
                        data-slide="prev"></a><a class="right fa fa-chevron-right btn btn-success" href="#carousel-example"
                            data-slide="next"></a>
                </div>
            </div>
        </div>
        <div id="carousel-example" class="carousel slide hidden-xs" data-ride="carousel">
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
                    
                        <div class="col-sm-6 col-lg-6 col-md-6">
                    <div class="thumbnail mB0">
                        <img class="minimizeImage" src="{{ asset('images/1.png') }}" alt="">
                        <div class="caption">
                            <h4 class="pull-right">$64.99</h4>
                            <h4><a href="javascript:void(0);">Product Name</a>
                            </h4>
                            <p>This is product short description section.</p>
                        </div>
						<a href="javascript:void(0);" class="btn btn-success add-to-cart">Add to Cart</a>
                    </div>
                </div>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                    <div class="thumbnail mB0">
                        <img class="minimizeImage" src="{{ asset('images/1.png') }}" alt="">
                        <div class="caption">
                            <h4 class="pull-right">$64.99</h4>
                            <h4><a href="javascript:void(0);">Product Name</a>
                            </h4>
                            <p>This is product short description section.</p>
                        </div>
						<a href="javascript:void(0);" class="btn btn-success add-to-cart">Add to Cart</a>
                    </div>
                </div>
                        
                    
                </div>
                <div class="item">
                    
                        <div class="col-sm-6 col-lg-6 col-md-6">
                    <div class="thumbnail mB0">
                        <img class="minimizeImage" src="{{ asset('images/1.png') }}" alt="">
                        <div class="caption">
                            <h4 class="pull-right">$64.99</h4>
                            <h4><a href="javascript:void(0);">Product Name</a>
                            </h4>
                            <p>This is product short description section.</p>
                        </div>
						<a href="javascript:void(0);" class="btn btn-success add-to-cart">Add to Cart</a>
                    </div>
                </div>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                    <div class="thumbnail mB0">
                        <img class="minimizeImage" src="{{ asset('images/1.png') }}" alt="">
                        <div class="caption">
                            <h4 class="pull-right">$64.99</h4>
                            <h4><a href="javascript:void(0);">Product Name</a>
                            </h4>
                            <p>This is product short description section.</p>
                        </div>
						<a href="javascript:void(0);" class="btn btn-success add-to-carts">Add to Cart</a>
                    </div>
                </div>
                        
                    
                </div>
            </div>
        </div>
    
      </div>
  
      <div class="col-md-6 col-sm-6 box2">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
          
          <div class="carousel-inner" role="listbox">
            <div class="item active">
              <img src="{{ asset('images/sl1.jpg') }}" alt="slider">
            </div>
  
            <div class="item">
              <img src="{{ asset('images/sl2.jpg') }}" alt="slider">
            </div>
  
            <div class="item">
              <img src="{{ asset('images/sl3.jpg') }}" alt="slider">
            </div>
  
          </div>
        </div>
      </div>
    </div>
  </div> 
  <!--End of Slider-->

  <!--Product View-->
  <div class="container pad20">
    
    <div id="products" class="row list-group">
      <div class="col-lg-12">
          <div class="row">
              @foreach($paginated_products as $singleProduct)
                  <div class="col-sm-3 col-lg-3 col-md-3">
                      <div class="thumbnail">
                          <img src="{{ $singleProduct->thumbnail() }}" alt="">
                          {{--<img src="{{ asset('images/4.png') }}" alt="">--}}
                          <div class="caption">
                              <h4 class="pull-right">₹<span id="p-price">{{ $singleProduct->marketProduct()->price }}</span></h4>
                              <h4><a href="javascript:void(0);" id="p-title">{{ $singleProduct->title }}</a></h4>
                              <p>{!! $product->description or '<i>No description is found to this product</i>' !!}</p>
                          </div>
                          <a href="javascript:void(0);" class="btn btn-success add-to-cart" id="add_to_cart{{\Inzaana\ShoppingCart::existInArray($cart->items,$singleProduct->id)? "-inactive":"" }}" data-fingerprint="{{ $cart->fingerprint }}" data-pid="{{ $singleProduct->id }}">{{ \Inzaana\ShoppingCart::existInArray($cart->items,$singleProduct->id)? "Added": "Add to Cart"}}</a>
                      </div>
                  </div>
              @endforeach

              {{--<div class="col-sm-3 col-lg-3 col-md-3">
                    <div class="thumbnail">
                        <img src="{{ asset('images/1.png') }}" alt="">
                        <div class="caption">
                            <h4 class="pull-right">$64.99</h4>
                            <h4><a href="javascript:void(0);">Product Name</a>
                            </h4>
                            <p>This is product short description section.</p>
                        </div>
						<a href="javascript:void(0);" class="btn btn-success add-to-cart">Add to Cart</a>
                    </div>
                </div>--}}
          </div>
      </div>
                
                
      
    </div>
    <div class="container text-center">
      {{ $paginated_products->appends([ 'page' => $paginated_products->currentPage() ])->links() }}
      <!-- <nav>
        <ul class="pagination">
          <li class="disabled">
            <a href="#" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
          <li class="active"><a href="#">1</a>
          </li>
          <li><a href="#">2</a>
          </li>
          <li><a href="#">3</a>
          </li>
          <li><a href="#">4</a>
          </li>
          <li><a href="#">5</a>
          </li>
          <li>
            <a href="#" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
        </ul>
      </nav> -->
    </div>
  </div>
  <!--End of Product View-->

  @endsection

  @section('footer-scripts')
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/js-m/product.js') }}"></script>
  <script src="{{ asset('data-requests/product/cart.js') }}"></script>
  <script src="{{ asset('js/js-m/bootstrap-magnify.min.js') }}"></script>
  <script>
/*function flyToElement(flyer, flyingTo) {
  var $func = $(this);
  var divider = 3;
  var flyerClone = $(flyer).clone();
  $(flyerClone).css({position: 'absolute', top: $(flyer).offset().top + "px", left: $(flyer).offset().left + "px", opacity: 1, 'z-index': 1000});
  $('body').append($(flyerClone));
  var gotoX = $(flyingTo).offset().left + ($(flyingTo).width() / 2) - ($(flyer).width()/divider)/2;
  var gotoY = $(flyingTo).offset().top + ($(flyingTo).height() / 2) - ($(flyer).height()/divider)/2;
   
  $(flyerClone).animate({
    opacity: 0.4,
    left: gotoX,
    top: gotoY,
    width: $(flyer).width()/divider,
    height: $(flyer).height()/divider
  }, 700,
  function () {
    $(flyingTo).fadeOut('fast', function () {
      $(flyingTo).fadeIn('fast', function () {
        $(flyerClone).fadeOut('fast', function () {
          $(flyerClone).remove();
        });
      });
    });
  });
}*/
  </script>

@endsection