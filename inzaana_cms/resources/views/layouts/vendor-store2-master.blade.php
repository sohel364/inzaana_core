<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <title>{{ $store_name_tidy }}  | @yield('title')</title>

  @yield('header-scripts')

</head>
<body>

  <!--top login onfo bar-->
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <ul class="nav navbar-nav navbar-right">
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle slimline" data-toggle="dropdown">
                      <span class="glyphicon glyphicon-user"></span> 
                      <strong>{{ $store_email }}</strong>
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
                                      <p class="text-left"><strong>{{ $store_owner->name }}</strong></p>
                                      <p class="text-left small">{{ $store_email }}</p>
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
  
    @include('flash')

  <div class="main-body">
    @yield('container')
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

  <!--End Footer -->

  @yield('footer-scripts')
  
</body>

</html>