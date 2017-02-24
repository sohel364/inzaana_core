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
</head>
<body>
    <!--top login onfo bar-->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
          <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle slimline" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-user"></span> 
                        <strong>demo@demo.com</strong>
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
                                        <p class="text-left"><strong>demo@domo.com</strong></p>
                                        <p class="text-left small">demo@demo.com</p>
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
                    <tr>
                        <td class="col-sm-8 col-md-6">
                        <div class="media">
                            <a class="thumbnail pull-left" href="#"> <img class="media-object" src="{{ asset('images/1.png') }}" style="width: 72px; height: 72px;"> </a>
                            <div class="media-body">
                                <h4 class="media-heading"><a href="#">Product name</a></h4>
                                <h5 class="media-heading"> by <a href="#">Brand name</a></h5>
                                <span>Status: </span><span class="text-success"><strong>In Stock</strong></span>
                            </div>
                        </div></td>
                        <td class="col-sm-1 col-md-1" style="text-align: center">
                        <input type="email" class="form-control" id="exampleInputEmail1" value="3">
                        </td>
                        <td class="col-sm-1 col-md-1 text-center"><strong>$4.87</strong></td>
                        <td class="col-sm-1 col-md-1 text-center"><strong>$14.61</strong></td>
                        <td class="col-sm-1 col-md-1">
                        <button type="button" class="btn btn-danger">
                            <span class="glyphicon glyphicon-remove"></span> Remove
                        </button></td>
                    </tr>
                    <tr>
                        <td class="col-md-6">
                        <div class="media">
                            <a class="thumbnail pull-left" href="#"> <img class="media-object" src="{{ asset('images/2.png') }}" style="width: 72px; height: 72px;"> </a>
                            <div class="media-body">
                                <h4 class="media-heading"><a href="#">Product name</a></h4>
                                <h5 class="media-heading"> by <a href="#">Brand name</a></h5>
                                <span>Status: </span><span class="text-warning"><strong>Out of Stock</strong></span>
                            </div>
                        </div></td>
                        <td class="col-md-1" style="text-align: center">
                        <input type="email" class="form-control" id="exampleInputEmail1" value="2">
                        </td>
                        <td class="col-md-1 text-center"><strong>$4.99</strong></td>
                        <td class="col-md-1 text-center"><strong>$9.98</strong></td>
                        <td class="col-md-1">
                        <button type="button" class="btn btn-danger">
                            <span class="glyphicon glyphicon-remove"></span> Remove
                        </button></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h5>Subtotal</h5></td>
                        <td class="text-right"><h5><strong>$24.59</strong></h5></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h5>Estimated shipping</h5></td>
                        <td class="text-right"><h5><strong>$6.94</strong></h5></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h3>Total</h3></td>
                        <td class="text-right"><h3><strong>$31.53</strong></h3></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td>
                        <button type="button" class="btn btn-default">
                            <span class="glyphicon glyphicon-shopping-cart"></span> Continue Shopping
                        </button></td>
                        <td>
                        <button type="button" class="btn btn-success">
                            Checkout <span class="glyphicon glyphicon-play"></span>
                        </button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
        

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
  <script src="{{ asset('data-requests/product/cart.js') }}"></script>
  <script src="{{ asset('js/js-m/bootstrap-magnify.min.js') }}"></script>

</body>

</html>