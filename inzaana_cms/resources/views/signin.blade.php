@extends('layouts.master')
@section('header-style')
 <link href="{{ URL::asset('css/signIn.css') }}" rel="stylesheet" type="text/css">  
@endsection

<body>
  <div class="container-fluid">

    <div class="row">
      <div class="col-md-6 firstpart animatedParent animateOnce" >
         <div class="row" style="margin-top:100px">
      <div class="col-xs-12 col-sm-8 col-md-8 col-sm-offset-2 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading text-center panHead">
           <h2 class="CustomHead animated fadeInLeftShort" ><i class="fa fa-sign-in"></i> Login Here</h2>
          </div>
          <div class="panel-body pad50">
          <form role="form">
          <fieldset>
            <div class="form-group animated fadeInLeftShort">
              <input type="email" name="email" id="email" class="form-control" placeholder="Email Address">
            </div>
            <div class="form-group animated fadeInLeftShort">
              <input type="password" name="password" id="password" class="form-control" placeholder="Password">
            </div>
            <span class="button-checkbox animated fadeInLeftShort">
					<button type="button" class="btn" data-color="info">Remember Me</button>
                    <input type="checkbox" name="remember_me" id="remember_me" checked="checked" class="hidden">
					<a href="" class="btn btn-link pull-right animated fadeInLeftShort">Forgot Password?</a>
				</span>
            <hr class="mar30">
            <div class="row">
               <div class="col-xs-12 col-md-6 col-md-offset-3 animated growIn">
                <input type="submit" value="Log In" class="btn btn-lg btn-info btn-block">
              </div>
            </div>
          </fieldset>
        </form>
          </div>
        </div>
      </div>
    </div>
      </div>
      
      <div class="col-md-6 backgroundWhite animatedParent animateOnce">
        <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2 marTop100 text-center">
            <img class="img-responsive animated fadeInRightShort" src="images/signInResponsive.png">
            <h1 class="text-center pad30 animated fadeInRightShort CustomHead">Inzaana <small>Simply Business!</small></h1>
            <p class="text-center animated fadeInRightShort paraDeco">Choose your Business Website from our thousands of free Responsive Template!</p>
           <label class="padDown animated growIn">Dont have any account yet?<a href="index.html" class="btn btn-link">Create your own store!</a></label>
          </div>
        </div>
      </div>

    </div>

  </div>

@section('footer-script')
  <script src="js/signIn.js"></script>
@endsection

</body>