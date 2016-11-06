<!DOCTYPE html>
<html lang="en">

<head>
  <title>Inzaana | @yield('title') </title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--Loading bootstrap css-->
  <link type="text/css" rel="stylesheet" href="{{ asset('user_admin_dashboard_asset/styles/jquery-ui-1.10.4.custom.min.css') }}">
  <link type="text/css" rel="stylesheet" href="{{ asset('user_admin_dashboard_asset/font-awesome-4.2.0/css/font-awesome.min.css') }}">
  <link type="text/css" rel="stylesheet" href="{{ asset('user_admin_dashboard_asset/styles/bootstrap.min.css') }}">
  <link type="text/css" rel="stylesheet" href="{{ asset('user_admin_dashboard_asset/styles/all.css') }}">
  <link type="text/css" rel="stylesheet" href="{{ asset('user_admin_dashboard_asset/styles/main.css') }}">
  <link type="text/css" rel="stylesheet" href="{{ asset('user_admin_dashboard_asset/styles/style-responsive.css') }}">
  <link type="text/css" rel="stylesheet" href="{{ asset('user_admin_dashboard_asset/styles/sidebar.css') }}">
  <link type="text/css" rel="stylesheet" href="{{ asset('user_admin_dashboard_asset/styles/chosen.css') }}">
  <link type="text/css" rel="stylesheet" href="{{ asset('user_admin_dashboard_asset/css3-animate-it-master/css/animations.css') }}">

     @yield('header-style')
</head>

<body>


    <!--BEGIN BACK TO TOP-->
    <a id="totop" href="#"><i class="fa fa-angle-up"></i></a>
    <!--END BACK TO TOP-->

    <!--BEGIN TOPBAR-->
    <div id="header-topbar-option-demo" class="page-header-topbar">

      <nav id="topbar" role="navigation" style="margin-bottom: 0;" data-step="3" class="navbar navbar-default navbar-fixed-top">
        <div class="navbar-header">
          <button type="button" data-toggle="collapse" data-target=".sidebar-collapse" class="navbar-toggle">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

          <a id="logo" href="/user_dashboard" class="navbar-brand">
            <span class="fa fa-rocket"></span>
            <span class="logo-text">Inzaana</span>
            <span style="display: none" class="logo-text-icon">µ</span>
          </a>
        </div>

        <div class="topbar-main">
          <a id="menu-toggle" href="#" class="hidden-xs">
            <i class="fa fa-bars"></i>
          </a>

          {{--<form id="topbar-search" action="" method="" class="hidden-sm hidden-xs">
            <div class="input-icon right text-white"><a href="#"><i class="fa fa-search"></i></a>
              <input type="text" placeholder="Search here..." class="form-control text-white" />
            </div>
          </form>--}}

          <ul class="nav navbar navbar-top-links navbar-right mbn">

            <li class="dropdown topbar-user">
              <a data-hover="dropdown" href="#" class="dropdown-toggle">
                <img src="{{ asset('/dist/img/user2-160x160.jpg') }}" alt="" class="img-responsive img-circle" />&nbsp;<span class="hidden-xs">Hi, {{ $user->name }}</span>&nbsp;<span class="caret"></span>
              </a>
              <ul class="dropdown-menu dropdown-user pull-right">
                <li><a href="{{ route('user::edit', [$user]) }}"><i class="fa fa-user"></i>My Profile</a></li>
                <li><a href="#"><i class="fa fa-calendar"></i>My Calendar</a></li>
                <li><a href="#"><i class="fa fa-envelope"></i>My Inbox</a></li>
                <li><a href="#"><i class="fa fa-tasks"></i>My Tasks</a></li>
                <li class="divider"></li>
                <li><a href="{{ url('/logout') }}"><i class="fa fa-key"></i>Log Out</a></li>
              </ul>
            </li>

          </ul>

        </div>
      </nav>
    </div>
    <!--END OF TOPBAR-->

    <div id="wrapper">
      <!--BEGIN SIDEBAR MENU-->
      <nav id="sidebar" role="navigation" data-step="2" data-position="right" class="navbar-default navbar-static-side nav-side-menu">

        <div class="sidebar-collapse menu-scroll menu-list">

          <ul id="side-menu" class="nav out">
            <div class="clearfix"></div>

            <li class="active">
              <a href="{{ route('user::home') }}">
                <i class="fa fa-home fa-fw"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>

            <li>
              <a href="{{ route('admin::approvals') }}">
                <i class="fa fa-thumbs-up fa-fw"></i>
                <span class="menu-title">Approvals {{ isset($total_approvals) ? '(' . $total_approvals . ')' : '' }}</span>
              </a>
            </li>

            <li>
              <a href="/super-admin/create-plan">
                <i class="fa fa-shopping-cart fa-fw"></i>
                <span class="menu-title">Create Plan</span>
              </a>
            </li>

            <li>
              <a href="/super-admin/view-plan">
                <i class="fa fa-shopping-cart fa-fw"></i>
                <span class="menu-title">View Plan</span>
              </a>
            </li>

            <li>
              <a href="/super-admin/view-subscriber">
                <i class="fa fa-tags fa-fw"></i>
                <span class="menu-title">Subscriber List</span>
              </a>
            </li>

            <li>
              <a href="{{ route('admin::faqs') }}">
                <i class="fa fa-tags fa-fw"></i>
                <span class="menu-title">FAQs ( {{ Inzaana\Faq::count() }} )</span>
              </a>
            </li>

            {{--<li>
              <a href="/user_reward_points">
                <i class="fa fa-users fa-fw"></i>
                <span class="menu-title"></span>
              </a>
            </li>

            <li>
              <a href="/user_wallet">
                <i class="fa fa-newspaper-o fa-fw"></i>
                <span class="menu-title"></span>
              </a>
            </li>

            <li>
              <a href="#">
                <i class="fa fa-bullhorn fa-fw"></i>
                <span class="menu-title"></span>
              </a>
            </li>--}}
          </ul>

        </div>
      </nav>

      <div id="page-wrapper">
        @include('flash')
        @include('errors')
        @yield('content')
      </div><!--END PAGE WRAPPER-->
    </div>
    
  <script src="{{ URL::asset('user_admin_dashboard_asset/script/jquery-1.10.2.min.js') }}"></script>
  <script src="{{ URL::asset('user_admin_dashboard_asset/script/jquery-migrate-1.2.1.min.js') }}"></script>
  <script src="{{ URL::asset('user_admin_dashboard_asset/script/jquery-ui.js') }}"></script>
  <script src="{{ URL::asset('user_admin_dashboard_asset/script/bootstrap.min.js') }}"></script>
  <script src="{{ URL::asset('user_admin_dashboard_asset/script/jquery.metisMenu.js') }}"></script>
  <script src="{{ URL::asset('user_admin_dashboard_asset/script/jquery.slimscroll.js') }}"></script>
  <script src="{{ URL::asset('user_admin_dashboard_asset/script/jquery.cookie.js') }}"></script>
  <script src="{{ URL::asset('user_admin_dashboard_asset/script/icheck.min.js') }}"></script>
  <script src="{{ URL::asset('user_admin_dashboard_asset/script/custom.min.js') }}"></script>
  <script src="{{ URL::asset('user_admin_dashboard_asset/script/jquery.menu.js') }}"></script>
  <script src="{{ URL::asset('user_admin_dashboard_asset/script/bootstrap-hover-dropdown.js') }}"></script>
  <script src="{{ URL::asset('user_admin_dashboard_asset/css3-animate-it-master/js/css3-animate-it.js') }}"></script>
  <!--CORE JAVASCRIPT-->
{{--  <script src="{{ URL::asset('user_admin_dashboard_asset/script/main.js') }}"></script>--}}
  <script src="{{ URL::asset('super-admin-asset/config.js') }}"></script>
    @yield('footer-script')
</body>

</html>