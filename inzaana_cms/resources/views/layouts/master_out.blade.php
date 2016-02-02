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
	
     
    @include('flash')
    @yield('content')
	 
  <div class="clearfix"></div>
  <!-------Footer-------------------------------->
  
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