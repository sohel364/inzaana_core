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
</head>

<body>
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
        </div>
      </nav>
    </div>
  </div>
  <!--End of Nav-->

  <!--Slider-->
  <!-- <div class="container">
    <div class="row sliderrow">
      <div class="col-md-6 col-sm-6 box1">
        <h1 class="slideText">MODERN <br>DESIGN <br>MEETS COZY <br>COMFORT</h1>
        <br>
        <p class="slidePara">Create the perfect space</p>
      </div>
  
      <div class="col-md-6 col-sm-6 box2">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
          Wrapper for slides
          <div class="carousel-inner" role="listbox">
            <div class="item active">
              <img src="images/sl1.jpg" alt="slider">
            </div>
  
            <div class="item">
              <img src="images/sl2.jpg" alt="slider">
            </div>
  
            <div class="item">
              <img src="images/sl3.jpg" alt="slider">
            </div>
  
          </div>
        </div>
      </div>
    </div>
  </div> -->
  <!--End of Slider-->

  <!--Product View-->
  <div class="container pad20">
    <div class="well well-sm">
      <strong>Category Title</strong>
      <div class="btn-group">
        <a href="#" id="list" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-th-list">
            </span>List</a> <a href="#" id="grid" class="btn btn-default btn-sm"><span
                class="glyphicon glyphicon-th"></span>Grid</a>
      </div>
    </div>
    <div id="products" class="row list-group">
      <div class="item  col-xs-4 col-lg-4">
        <div class="thumbnail">
         <a href="product_details.html"> <img class="group list-group-image" src="{{ asset('images/1.png') }}" alt="" width="400px" height="250px" /></a>
          <div class="caption">
            <h4 class="group inner list-group-item-heading">
                        Product title</h4>
            <p class="group inner list-group-item-text">
              Product description... Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
            <div class="row">
              <div class="col-xs-12 col-md-6">
                <p class="lead">
                  $21.000</p>
              </div>
              <div class="col-xs-12 col-md-6">
                <a class="btn btn-success" href="#">Add to cart</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="item  col-xs-4 col-lg-4">
        <div class="thumbnail">
          <a href="product_details.html"> <img class="group list-group-image" src="{{ asset('images/2.png') }}" alt="" width="400px" height="250px" /></a>
          <div class="caption">
            <h4 class="group inner list-group-item-heading">
                        Product title</h4>
            <p class="group inner list-group-item-text">
              Product description... Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
            <div class="row">
              <div class="col-xs-12 col-md-6">
                <p class="lead">
                  $21.000</p>
              </div>
              <div class="col-xs-12 col-md-6">
                <a class="btn btn-success" href="#">Add to cart</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="item  col-xs-4 col-lg-4">
        <div class="thumbnail">
          <a href="product_details.html"> <img class="group list-group-image" src="{{ asset('images/3.png') }}" alt="" width="400px" height="250px" /></a>
          <div class="caption">
            <h4 class="group inner list-group-item-heading">
                        Product title</h4>
            <p class="group inner list-group-item-text">
              Product description... Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
            <div class="row">
              <div class="col-xs-12 col-md-6">
                <p class="lead">
                  $21.000</p>
              </div>
              <div class="col-xs-12 col-md-6">
                <a class="btn btn-success" href="#">Add to cart</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="item  col-xs-4 col-lg-4">
        <div class="thumbnail">
        <a href="product_details.html"> <img class="group list-group-image" src="{{ asset('images/4.png') }}" alt="" width="400px" height="250px" /></a>
          <div class="caption">
            <h4 class="group inner list-group-item-heading">
                        Product title</h4>
            <p class="group inner list-group-item-text">
              Product description... Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
            <div class="row">
              <div class="col-xs-12 col-md-6">
                <p class="lead">
                  $21.000</p>
              </div>
              <div class="col-xs-12 col-md-6">
                <a class="btn btn-success" href="#">Add to cart</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="item  col-xs-4 col-lg-4">
        <div class="thumbnail">
          <a href="product_details.html"> <img class="group list-group-image" src="{{ asset('images/5.png') }}" alt="" width="400px" height="250px" /></a>
          <div class="caption">
            <h4 class="group inner list-group-item-heading">
                        Product title</h4>
            <p class="group inner list-group-item-text">
              Product description... Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
            <div class="row">
              <div class="col-xs-12 col-md-6">
                <p class="lead">
                  $21.000</p>
              </div>
              <div class="col-xs-12 col-md-6">
                <a class="btn btn-success" href="#">Add to cart</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="item  col-xs-4 col-lg-4">
        <div class="thumbnail">
        <a href="product_details.html"> <img class="group list-group-image" src="{{ asset('images/6.png') }}" alt="" width="400px" height="250px" /></a>
          <div class="caption">
            <h4 class="group inner list-group-item-heading">
                        Product title</h4>
            <p class="group inner list-group-item-text">
              Product description... Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
            <div class="row">
              <div class="col-xs-12 col-md-6">
                <p class="lead">
                  $21.000</p>
              </div>
              <div class="col-xs-12 col-md-6">
                <a class="btn btn-success" href="#">Add to cart</a>
              </div>
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

  <!--End Footer -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/js-m/product.js') }}"></script>
  <script src="{{ asset('js/js-m/bootstrap-magnify.min.js') }}"></script>
</body>

</html>