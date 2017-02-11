<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Title</title>
  <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset('css/css-m/main.css')}}" rel="stylesheet">
  <link href="{{ asset('css/bootstrap-magnify.min.css')}}" rel="stylesheet">
  <link href="{{ asset('font-awesome-4.4.0/css/font-awesome.min.css')}}" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.add-to-cart').on('click',function(){
		//Scroll to top if cart icon is hidden on top
		$('html, body').animate({
			'scrollTop' : $(".cart_anchor").position().top
		});
		//Select item image and pass to the function
		var itemImg = $(this).parent().find('img').eq(0);
		flyToElement($(itemImg), $('.cart_anchor'));
	});
});
</script>

<style type="text/css">
.cart_anchor{ float:right; vertical-align:top; background: url({{ asset('images/cart-icon.png') }}) no-repeat center center / 100% auto;width: 25px;height: 25px;  padding-top: 75px;}
</style>
</head>

<body>
    <!--top login onfo bar-->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
          <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle slimline" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-user"></span> 
                        <strong>mohsin.ofcl@gmail.com</strong>
                        <span class="glyphicon glyphicon-chevron-down"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <div class="navbar-login">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <p class="text-center">
                                            <span class="glyphicon glyphicon-user icon-size"></span>
                                        </p>
                                    </div>
                                    <div class="col-lg-8">
                                        <p class="text-left"><strong>Shrabon Mohsin</strong></p>
                                        <p class="text-left small">mohsin.ofcl@gmail.com</p>
                                        <p class="text-left">
                                            <a href="#" class="btn btn-primary btn-block btn-sm">Account settings</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="navbar-login navbar-login-session">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p>
                                            <a href="#" class="btn btn-danger btn-block">Log Out</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
      </div>
    </nav>
    <!--End of top login onfo bar-->
    <div class="main-body">
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
          <a class="navbar-brand" href="index.html"><strong>INTERIOR</strong></a>
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
            <li class="dropdown">
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
						<a href="javascript:void(0);" class="btn btn-success add-to-cart">Add to Cart</a>
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
              <div class="col-sm-3 col-lg-3 col-md-3">
                    <div class="thumbnail">
                        <img src="{{ asset('images/4.png') }}" alt="">
                        <div class="caption">
                            <h4 class="pull-right">$24.99</h4>
                            <h4><a href="javascript:void(0);">Product Name</a></h4>
                            <p>This is product short description section.</p>
                        </div>
						<a href="javascript:void(0);" class="btn btn-success add-to-cart">Add to Cart</a>
                    </div>
                </div>
        
              <div class="col-sm-3 col-lg-3 col-md-3">
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
                </div>
              <div class="col-sm-3 col-lg-3 col-md-3">
                    <div class="thumbnail">
                        <img src="{{ asset('images/2.png') }}" alt="">
                        <div class="caption">
                            <h4 class="pull-right">$15.99</h4>
                            <h4><a href="javascript:void(0);">Product Name</a>
                            </h4>
                            <p>This is product short description section.</p>
                        </div>
						<a href="javascript:void(0);" class="btn btn-success add-to-cart">Add to Cart</a>
                    </div>
                </div>
              <div class="col-sm-3 col-lg-3 col-md-3">
                    <div class="thumbnail">
                        <img src="{{ asset('images/3.png') }}" alt="">
                        <div class="caption">
                            <h4 class="pull-right">$55.99</h4>
                            <h4><a href="javascript:void(0);">Product Name</a>
                            </h4>
                            <p>This is product short description section.</p>
                        </div>
						<a href="javascript:void(0);" class="btn btn-success add-to-cart">Add to Cart</a>
                    </div>
                </div>
                <div class="col-sm-3 col-lg-3 col-md-3">
                    <div class="thumbnail">
                        <img src="{{ asset('images/4.png') }}" alt="">
                        <div class="caption">
                            <h4 class="pull-right">$24.99</h4>
                            <h4><a href="javascript:void(0);">Product Name</a></h4>
                            <p>This is product short description section.</p>
                        </div>
						<a href="javascript:void(0);" class="btn btn-success add-to-cart">Add to Cart</a>
                    </div>
                </div>
        
              <div class="col-sm-3 col-lg-3 col-md-3">
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
                </div>
              <div class="col-sm-3 col-lg-3 col-md-3">
                    <div class="thumbnail">
                        <img src="{{ asset('images/2.png') }}" alt="">
                        <div class="caption">
                            <h4 class="pull-right">$15.99</h4>
                            <h4><a href="javascript:void(0);">Product Name</a>
                            </h4>
                            <p>This is product short description section.</p>
                        </div>
						<a href="javascript:void(0);" class="btn btn-success add-to-cart">Add to Cart</a>
                    </div>
                </div>
              <div class="col-sm-3 col-lg-3 col-md-3">
                    <div class="thumbnail">
                        <img src="{{ asset('images/3.png') }}" alt="">
                        <div class="caption">
                            <h4 class="pull-right">$55.99</h4>
                            <h4><a href="javascript:void(0);">Product Name</a>
                            </h4>
                            <p>This is product short description section.</p>
                        </div>
						<a href="javascript:void(0);" class="btn btn-success add-to-cart">Add to Cart</a>
                    </div>
                </div>
          </div>
      </div>
                
                
      
    </div>
    <div class="container text-center">
      <nav>
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
      </nav>
    </div>
  </div>
  <!--End of Product View-->

  <!--Start Footer -->
  <div class="fot">
    <div class="container pad35">
      <footer>
        <div class="row">
          <div class="col-sm-3 col-md-3">
            <p><strong>Contact Us</strong>
              <br><i class="fa fa-phone-square"></i> +1 377 283 8372
              <br><i class="fa fa-envelope"></i> info@yourdomain.com</p>
            <p> <a href="#" class="sym"><i class="fa fa-facebook fa-2x"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="sym"><i class="fa fa-twitter fa-2x"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="sym"><i class="fa fa-google-plus fa-2x"></i></a>
            </p>
          </div>
          <div class="col-sm-3 col-md-3">
            <p><strong>We Accept</strong>
              <br><i class="fa fa-paypal"> Paypal</i>
              <br><i class="fa fa-cc-visa"> Visa</i>
              <br><i class="fa fa-cc-mastercard"> Mastercard</i>
            </p>
          </div>
          <div class="col-sm-6 col-md-6">
            <p><strong>Subscribe for Update</strong>
            </p>
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Email....">
              <span class="input-group-btn">
        <button class="btn btn-default" type="button">Subscribe</button>
      </span>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>

  <div class="fot1">
    <div class="container">
      <footer>
        <div class="row text-center">
          <div class="col-lg-12">
            <p>Copyright &copy; 2015</p>
          </div>
        </div>
      </footer>
    </div>
  </div>

    </div>
  <!--End Footer -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/js-m/product.js') }}"></script>
  <script src="{{ asset('js/js-m/bootstrap-magnify.min.js') }}"></script>
  <script>
function flyToElement(flyer, flyingTo) {
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
}
    </script>
</body>

</html>