<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inzaana | @yield('title')</title>

  <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ URL::asset('css/main.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ URL::asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ URL::asset('css/theme-menu.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ URL::asset('css/fonts/fonts.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ URL::asset('css/font-awesome-4.2.0/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ URL::asset('css3-animate-it-master/css/animations.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ URL::asset('css/font-awesome-animation.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ URL::asset('css/select2.css') }}" rel="stylesheet" type="text/css">  
  @yield('header-style')
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  @yield('header-script')
  <!--[if lte IE 9]>
       <link href="css3-animate-it-master/css/animations-ie-fix.css') }}" rel="stylesheet"/>
<![endif]-->
  <!--[if IE]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script type="text/javascript">
    $('a').click( function() { 
            alert("Create Test");
        return false; 
    } );
  </script>

  @yield('head')
    
</head>
	
<body>
	<header class="masthead">
				<section id="top">
				  <div class="container">
					<div class="row">
					  <div class="col-md-6">
						<ul class="nav nav-pills nav-top">
						  <li><a href="#"><i class="fa fa-envelope-o"></i>{{ isset($admin_user) ? $admin_user->phone_number : '7042247526' }}</a></li>
						  <li><a href="#"><i class="fa fa-phone"></i>{{ isset($admin_user) ? $admin_user->email : 'admin@inzaana.com' }}</a></li>
						</ul>
					  </div>
					  <div class="col-md-6">
						<ul class="nav nav-pills nav-top navbar-right">
						  <li class="dropdown langs">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">English <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
							  <li><a href="#">English</a></li>
							  <li><a href="#">Hindi</a></li>
							  <li><a href="#">English</a></li>
							  <li><a href="#">Hindi</a></li>
							  <li><a href="#">English</a></li>
							  <li><a href="#">Hindi</a></li>

							</ul>
						  </li>

						  <li>
                @if(Auth::check())
                  <a href="{{ route('user::home') }}" class="animated">Dashboard</a>
                @else
                  <a href="{{ url('/login') }}" class="animated">Login</a>
                @endif

              </li>
  						<li class="dropdown langs">
  							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Register As <span class="caret"></span></a>
  							<ul class="dropdown-menu" role="menu">
  							  <li><a href="{{ route('guest::signup.customer') }}">Customer</a></li>
                  @if(Inzaana\User::count() == 0)
                  <li><a href="{{ route('guest::signup.mailto.admin') }}">Super Admin</a></li>
                  @endif
  							</ul>
  						</li>
						</ul>

					  </div>
					</div>
				  </div>
				</section>
			  </header>


			  <!-- Begin Navbar -->
			  <div id="nav">
				<div class="navbar navbar-default navbar-static animatedParent animateOnce">
				  <div class="container animated fadeInDownShort">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
					  <a class="navbar-brand" href="/"><!-- <img alt="Logo" src="images/logo.png" class="img-responsive"> --><span>In</span>zaana</a>
					  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					  </button>
					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

					  <ul class="nav navbar-nav navbar-right text-center">
						<li class="active"><a href="/">Home</a></li>
						<li><a href="#">About us</a></li>
						<li><a href="template.html">Templates</a></li>
						<li><a href="#">Explore</a></li>
						<li><a href="#">Support</a></li>
						<li><a href="#">Contact</a></li>
						<div class="search">
						  <input type="text" class="form-control input-sm" maxlength="64" placeholder="Search" />
						  <button type="submit" class="btn btn1"><i class="fa fa-search"></i></button>
						</div>
					  </ul>
					</div>
					<!-- /.navbar-collapse -->
				  </div>
				</div>
				<!-- /.navbar -->
			  </div>
        
        @include('flash')
        @include('errors')

			  <!--Home-->
			  <section>
				<div class="box animatedParent animateOnce" data-sequence="500">

				  <div class="overlay">
              <h1 class="heading1 animated growIn delay-500 go" data-id="1">Give a nice name to your online store!</h1>
              <div class="col-md-5 col-md-offset-3 col-xs-8 col-xs-offset-2">

                  <form role="form" method="GET" action="{{ route('guest::signup') }}">

                      <div class="input-group input-group-lg">
                          <input name="store_name" type="text" class="form-control animated fadeInLeft go" data-id="2" placeholder="Your Store Name...">

                          <span class="input-group-btn input-group-lg ">
                              <input name="subdomain" type="text" class="form-control animated growIn CreateInput go removeBCarve" data-id="2" value="Inzaana" style="width: 106px; left: 0px; top: 0px;">
                              <label class="animated growIn go" data-id="3">
                                  <select name="domain" class="form-control" placeholder="Select a domain" style="height: 46px; left: 0px; top: 0px; width: 78px;">
                                      <option value="com" class="placehold" selected="">.com</option>
                                      <option value="net">.net</option>
                                      <option value="org">.org</option>
                                  </select>
                              </label>
                              <button class="btn btn-info animated fadeInRight btn-poss go" data-id="4" type="submit">Create Store!</button>
                          </span>

                      </div>
                  </form>
              </div>
            </div>
				</div>
			  </section>
			  <!--End of Home-->
	<div class="clearfix"></div>
     
	<div class="container">
    @yield('content')
  </div>
	 
  <div class="clearfix"></div>
  <!-------Footer-------------------------------->
  <footer class="footer animatedParent animateOnce" id="footer-1">
    <div class="links-social animatedParent animateOnce">
      <div class="container-class container">
        <div class="links-social-inner">
          <div class="row">
            <div class="link-groups">
              <div class="col-sm-3">
                <div class="links">
                  <h3 class="title animated fadeInLeft">ABOUT US</h3>
                  <p class="animated fadeInLeft">We at Inzaana believe that we have this insatiable urge and capacity to challenge the conventional, because unless we do so, we will cease to progress. We believe that whatever is "out there" can be and should be made better.</p>
                </div>
              </div>
              <!-- /.col -->

              <div class="col-sm-3 animated growIn">
                <div class="links">
                  <h3 class="title">INFORMATION</h3>
                  <ul>
                    <li><a href="#"><i class="fa fa-angle-right"></i>About us</a></li>
                    <li><a href="#"><i class="fa fa-angle-right"></i>Template</a></li>
                    <li><a href="#"><i class="fa fa-angle-right"></i>Service</a></li>
                    <li><a href="#"><i class="fa fa-angle-right"></i>Template</a></li>
                    <li><a href="#"><i class="fa fa-angle-right"></i>Contact</a></li>
                  </ul>
                </div>
              </div>
              <!-- /.col -->

              <div class="col-sm-3 animated growIn">
                <div class="links">
                  <h3 class="title">USEFUL LINKS</h3>
                  <ul class="tags-cloud clearfix">
                    <li><a href="#">Website</a></li>
                    <li><a href="#">Template</a></li>
                    <li><a href="#">Html</a></li>
                    <li><a href="#">Bootstrap</a></li>
                    <li><a href="#">Css</a></li>
                  </ul>
                </div>
              </div>
              <!-- /.col -->

              <div class="col-md-3">
                <div class="social-newsletter">
                  <div class="social-links">
                    <h3 class="title animated fadeInRight">CONNECT WITH US</h3>
                    <ul class="social list-unstyled bordered big">
                      <li><a href="#." class="facebook animated fadeInRight"><i class="fa fa-facebook"></i></a></li>
                      <li><a href="#." class="twitter animated fadeInRight"><i class="fa fa-twitter"></i></a></li>
                      <li><a href="#." class="googleplus animated fadeInRight"><i class="fa fa-google-plus"></i></a></li>
                      <li><a href="#." class="linkedin animated fadeInRight"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                  </div>
                  <!-- /.social-links -->

                  <div class="newsletter">
                    <h3 class="title animated fadeInRight">GET NEWSLETTER</h3>
                    <div class="input-group animated fadeInRight">
                      <input type="text" class="form-control" placeholder="Email Address">
                      <span class="input-group-btn">
											<button class="btn btn-default" type="button">Subscribe</button>
										</span>
                    </div>
                  </div>

                </div>
              </div>

            </div>
            <!-- /.row -->

          </div>
        </div>
      </div>
      <!-- /.container -->
    </div>

    <div class="copyright animatedParent"> <a href="#" class="animated fadeInUpShort">Copyright 2015 Inzaana. All rights reserved.</a>
    </div>
  </footer>
  <!--Scroll To Top-->
  <a href="#top" class="hc_scrollup"><i class="fa fa-chevron-up"></i></a>
  <!--/Scroll To Top-->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ URL::asset('css3-animate-it-master/js/css3-animate-it.js') }}"></script>
  <script src="{{ URL::asset('js/scroll.js') }}"></script>
  <script src="{{ URL::asset('js/smothScrolling.js') }}"></script>

  @yield('footer-script')

  <script>
    $('#nav').affix({
      offset: {
        top: $('header').height()
      }
    });

    $('#sidebar').affix({
      offset: {
        top: 200
      }
    });
  </script>

</body>
</html>