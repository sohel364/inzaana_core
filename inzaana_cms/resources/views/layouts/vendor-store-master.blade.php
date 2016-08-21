<!DOCTYPE html>
<html lang="en">
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="./bootstrap-helper/css/bootstrap.min.css">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
        <link href="{{asset('css/banner_adress.css')}}" rel="stylesheet">
        <link href="{{asset('css/gallery.css')}}" rel="stylesheet">

        <title>@yield('title')</title>
    </head>

    <body>
</br>
</br>
</br>
<div class="container">

    @section('banner')

        <div class="container col-md-12 ">

            <!-- banner -->
            <div class="row grid1" class="container-fluid">

                <div class="col-md-9">

                        <img src="images/home/dsa.jpg" class="banner_image"  class="img-responsive" alt="" />
                </div>
                <!-- adress div start-->
                <div class="col-md-3">

                        <div class="address-wrap" >
                            <div class="address-table" >

                                <div class="address-table-row">
                                    <div class="address-table-cell address-table-icon">
                                        <i class="fa fa-envelope-o"></i>
                                    </div>
                                    <div class="address-table-cell shop-website">
                                        <a href="#">example@domain.com</a>
                                    </div>

                                </div>

                                <div class="address-table-row">
                                    <div class="address-table-cell address-table-icon">
                                        <i class="fa fa-external-link"></i>
                                    </div>
                                    <div class="address-table-cell shop-website">
                                        <a href="#" target="_blank"> https://example.domain.com</a>
                                    </div>
                                </div>

                                <div class="address-table-row">
                                    <div class="address-table-cell address-table-icon">
                                        <i class="fa fa-map-marker"></i>
                                    </div>
                                    <div class="address-table-cell shop-website">
                                        House No, Road no, area
                                    </div>
                                </div>

                                <div class="address-table-row">
                                    <div class="address-table-cell address-table-icon">
                                        <i class="fa fa-mobile"></i>
                                    </div>
                                    <div class="address-table-cell shop-website">
                                        <a href="tel:01911497595">01911497595</a>
                                    </div>
                                </div>

                            </div>
                         </div>

                 </div>
            </div>
            <!-- adress div end-->
            <!-- navigation bar start-->
            <div class="row" class="container-fluid ">
            <nav class="navbar" >
                <div class="container-fluid">

                    <div class="container-fluid ">
                        <ul class="nav navbar-nav">
                            <li class="active "><a href="#">Home</a></li>
                            <li><a href="#">About</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#"><span class="glyphicon glyphicon-shopping-cart "></span> Cart</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            </div>
            <!-- navigation bar end-->
        </div>

      @show

      <div class=" container-fluid positioning ">
        @yield('products')
      </div>

</div>
    </body>

</html>
