@extends('layouts.vendor-store-master')

@section('title', 'Showcase')

@section('products')
    @parent

<!-- gallery start -->

    <div class="row text-center">


        <div class="col-md-4">

            <div class="thumbnail">
                <div id="myCarousel-1" class="carousel slide" data-ride="carousel" data-interval="false" >
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel-1" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel-1" data-slide-to="1"></li>
                        <li data-target="#myCarouse-l" data-slide-to="2"></li>
                        <li data-target="#myCarouse-l" data-slide-to="3"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">

                        <div class="item active">
                            <img src="/images/home/dsa.jpg" alt="Chania" class="img-responsive">
                            <div class="carousel-caption">
                                <h3>Chania</h3>
                                <p>The atmosphere in Chania has a touch of Florence and Venice.</p>
                            </div>
                        </div>

                        <div class="item">
                            <img src="/images/home/dsa.jpg" alt="Chania" width="460" height="345">
                            <div class="carousel-caption">
                                <h3>Chania</h3>
                                <p>The atmosphere in Chania has a touch of Florence and Venice.</p>
                            </div>
                        </div>


                    </div>

                    <!-- Left and right controls -->
                    <a class="carousel-control left" href="#myCarousel-1" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>
                    <a class="carousel-control right" href="#myCarousel-1" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                </div>


                <p>Description</p>
                <p>Price:5000BDT</p>

                <div class="gallery gallery-btn-info btn-lg gallery-div-hover">
                    <a href="" class="gallery-fonts">
                        <i class ="fa fa-shopping-cart"></i>
                        BUY
                    </a>
                </div>

            </div>
        </div>


    <!-- gallery End -->
    <!-- gallery start -->




        <div class="col-md-4">

            <div class="thumbnail">
                <div id="myCarousel-2" class="carousel slide" data-ride="carousel" data-interval="false" >
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel-2" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel-2" data-slide-to="1"></li>
                        <li data-target="#myCarouse-2" data-slide-to="2"></li>
                        <li data-target="#myCarouse-2" data-slide-to="3"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">

                        <div class="item active">
                            <img src="/images/home/dsa.jpg" alt="Chania" width=auto height="345">
                            <div class="carousel-caption">
                                <h3>Chania</h3>
                                <p>The atmosphere in Chania has a touch of Florence and Venice.</p>
                            </div>
                        </div>

                        <div class="item">
                            <img src="/images/home/dsa.jpg" alt="Chania" width="460" height="345">
                            <div class="carousel-caption">
                                <h3>Chania</h3>
                                <p>The atmosphere in Chania has a touch of Florence and Venice.</p>
                            </div>
                        </div>


                    </div>

                    <!-- Left and right controls -->
                    <a class="carousel-control left" href="#myCarousel-2" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>
                    <a class="carousel-control right" href="#myCarousel-2" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                </div>


                <p>Description</p>
                <p>Price:5000BDT</p>

                <div class="gallery gallery-btn-info btn-lg gallery-div-hover">
                    <a href="" class="gallery-fonts">
                        <i class ="fa fa-shopping-cart"></i>
                        BUY
                    </a>
                </div>

            </div>
        </div>




    <!-- gallery End -->
    <!-- gallery start -->




        <div class="col-md-4">

            <div class="thumbnail">
                <div id="myCarousel-3" class="carousel slide" data-ride="carousel" data-interval="false" >
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel-3" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel-3" data-slide-to="1"></li>
                        <li data-target="#myCarouse-3" data-slide-to="2"></li>
                        <li data-target="#myCarouse-3" data-slide-to="3"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">

                        <div class="item active">
                            <img src="/images/home/dsa.jpg" alt="Chania" width=auto height="345">
                            <div class="carousel-caption">
                                <h3>Chania</h3>
                                <p>The atmosphere in Chania has a touch of Florence and Venice.</p>
                            </div>
                        </div>

                        <div class="item">
                            <img src="/images/home/dsa.jpg" alt="Chania" width="460" height="345">
                            <div class="carousel-caption">
                                <h3>Chania</h3>
                                <p>The atmosphere in Chania has a touch of Florence and Venice.</p>
                            </div>
                        </div>


                    </div>

                    <!-- Left and right controls -->
                    <a class="carousel-control left" href="#myCarousel-3" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>
                    <a class="carousel-control right" href="#myCarousel-3" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                </div>


                <p>Description</p>
                <p>Price:5000BDT</p>

                <div class="gallery gallery-btn-info btn-lg gallery-div-hover">
                    <a href="" class="gallery-fonts">
                        <i class ="fa fa-shopping-cart"></i>
                        BUY
                    </a>
                </div>

            </div>
        </div>


     </div>

    <!-- gallery End -->

@endsection