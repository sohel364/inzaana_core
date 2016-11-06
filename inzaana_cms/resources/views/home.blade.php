@extends('layouts.master')

@section('title', 'Home')

@section('content')

    <link href="{{ URL::asset('css/homebladetab.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('css/style-front-gallerys.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ URL::asset('js/homebladetab.js') }}"></script>

    {{--Tab starts--}}
    <div class="grid1 col-md-12" class="tab">
        <div class=" col-md-6"><a href="javascript:void(0)" class="tablinks centering"
                                  onclick="openCity2(event, 'products')">Go to Market</a></div>
        <div class=" col-md-6 shadow"><a href="javascript:void(0)" class="tablinks centering"
                                         onclick="openCity(event, 'works')" id="defaultOpen">How It Works</a></div>
    </div>
    {{--Tab ends--}}

    {{--how it works tab start--}}
    <div id="works" class=" tabcontent col-md-12 animatedParent animateOnce">
        <p class="title-separator animated fadeInLeft delay-250" data-id='2'><span></span></p>
        <p class="animated fadeInRight delay-250" data-id='3'>You Can Build Your Own Online Store In Just 3 Steps!!!</p>
        <div class="grid3 col-md-6 animatedParent animateOnce">
            <div class="col-md-12">
                <div class="media feature_col animated fadeInLeftShort delay-250" id="trigger">
                    <div class="pull-left" href="#">
                        <div class="icon-circle">
                            <span>1</span>
                            <i class="fa fa-plus fa-2x"></i>
                        </div>
                    </div>
                    <div class="media-body">
                        <h3><a href="#">Create a shop &amp; Select a template</a></h3>
                        <p>Lorem ipsum dolor sit amet, consectetur Unlimited ColorsCras pulvin, mauris at so mauris at
                            lectus lectus.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="media feature_col animated fadeInLeftShort delay-250" id="trigger">
                    <div class="pull-left" href="#">
                        <div class="icon-circle">
                            <span>2</span>
                            <i class="fa fa-arrows fa-2x"></i>
                        </div>
                    </div>
                    <div class="media-body">
                        <h3><a href="#">Drag &amp; Drop Your Content</a></h3>
                        <p>Lorem ipsum dolor sit amet, consectetur Unlimited ColorsCras pulvin, mauris at so mauris at
                            lectus lectus.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="media feature_col animated fadeInLeftShort delay-250" id="trigger">
                    <div class="pull-left" href="#">
                        <div class="icon-circle">
                            <span>3</span>
                            <i class="fa fa-paper-plane-o fa-2x"></i>
                        </div>
                    </div>
                    <div class="media-body">
                        <h3><a href="#">Launch Your Store &amp; Enjoy</a></h3>
                        <p>Lorem ipsum dolor sit amet, consectetur Unlimited ColorsCras pulvin, mauris at so mauris at
                            lectus lectus.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 animatedParent animateOnce">
            <img src="images/slide1.gif"
                 class="img-responsive img-thumbnail maxHeightWidth animated fadeInRightShort delay-250"/>
        </div>

    </div>
    {{--how it works end--}}

    {{--Market gallery starts--}}

    <div id="products" class="tabcontent col-md-12 animatedParent animateOnce">
        <div class="title-separator animated fadeInLeft delay-250" data-id='2'><span></span></div>
        <div class="animated fadeInRight delay-250" data-id='3'>Explore the Products!!!</div>
        {{--product gallery starts--}}

        <div>
            {{--product1--}}
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 positioning-front-gallerys">
                <div class="hovereffect-front-gallerys positioning-front-gallerys">
                    <img class="img-responsive " src="/images/front_image_gallery/electronics.jpg" alt="">
                    <div class="overlay">
                        <h2>Electronics</h2>
                        <a class="info" href="#">more...</a>
                        <a href="#" class="btn btn-info btn-sm centering-cart-front-gallerys">
                            <span class="glyphicon glyphicon-shopping-cart"></span> Add to Cart
                        </a>
                        <span class="rating">
                             <input type="radio" class="rating-input" id="rating-input-1-5" name="rating-input-1">
                            <label for="rating-input-1-5" class="rating-star"></label>
                            <input type="radio" class="rating-input" id="rating-input-1-4" name="rating-input-1">
                            <label for="rating-input-1-4" class="rating-star"></label>
                            <input type="radio" class="rating-input" id="rating-input-1-3" name="rating-input-1">
                            <label for="rating-input-1-3" class="rating-star"></label>
                             <input type="radio" class="rating-input" id="rating-input-1-2" name="rating-input-1">
                            <label for="rating-input-1-2" class="rating-star"></label>
                            <input type="radio" class="rating-input" id="rating-input-1-1" name="rating-input-1">
                            <label for="rating-input-1-1" class="rating-star"></label>
                        </span>
                        <div class="old-price ">&#8377 180.00</div>
                        <div class="new-price">&#8377 110.00</div>
                    </div>
                </div>

             </div>
            {{--product2--}}
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 positioning-front-gallerys">
                <div class="hovereffect-front-gallerys positioning-front-gallerys">
                    <img class="img-responsive " src="/images/front_image_gallery/books.jpg" alt="">
                    <div class="overlay">
                        <h2>Books</h2>
                        <a class="info" href="#">more...</a>
                        <a href="#" class="btn btn-info btn-sm centering-cart-front-gallerys">
                            <span class="glyphicon glyphicon-shopping-cart"></span> Add to Cart
                        </a>
                        <span class="rating">
                             <input type="radio" class="rating-input" id="rating-input-1-5" name="rating-input-1">
                            <label for="rating-input-1-5" class="rating-star"></label>
                            <input type="radio" class="rating-input" id="rating-input-1-4" name="rating-input-1">
                            <label for="rating-input-1-4" class="rating-star"></label>
                            <input type="radio" class="rating-input" id="rating-input-1-3" name="rating-input-1">
                            <label for="rating-input-1-3" class="rating-star"></label>
                             <input type="radio" class="rating-input" id="rating-input-1-2" name="rating-input-1">
                            <label for="rating-input-1-2" class="rating-star"></label>
                            <input type="radio" class="rating-input" id="rating-input-1-1" name="rating-input-1">
                            <label for="rating-input-1-1" class="rating-star"></label>
                        </span>
                        <div class="old-price ">&#8377 180.00</div>
                        <div class="new-price">&#8377 110.00</div>
                    </div>
                </div>

            </div>
            {{--product3--}}
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 positioning-front-gallerys">
                <div class="hovereffect-front-gallerys positioning-front-gallerys">
                    <img class="img-responsive " src="/images/front_image_gallery/cars.jpg" alt="">
                    <div class="overlay">
                        <h2>Cars</h2>
                        <a class="info" href="#">more...</a>
                        <a href="#" class="btn btn-info btn-sm centering-cart-front-gallerys">
                            <span class="glyphicon glyphicon-shopping-cart"></span> Add to Cart
                        </a>
                        <span class="rating">
                             <input type="radio" class="rating-input" id="rating-input-1-5" name="rating-input-1">
                            <label for="rating-input-1-5" class="rating-star"></label>
                            <input type="radio" class="rating-input" id="rating-input-1-4" name="rating-input-1">
                            <label for="rating-input-1-4" class="rating-star"></label>
                            <input type="radio" class="rating-input" id="rating-input-1-3" name="rating-input-1">
                            <label for="rating-input-1-3" class="rating-star"></label>
                             <input type="radio" class="rating-input" id="rating-input-1-2" name="rating-input-1">
                            <label for="rating-input-1-2" class="rating-star"></label>
                            <input type="radio" class="rating-input" id="rating-input-1-1" name="rating-input-1">
                            <label for="rating-input-1-1" class="rating-star"></label>
                        </span>
                        <div class="old-price ">&#8377 180.00</div>
                        <div class="new-price">&#8377 110.00</div>
                    </div>
                </div>

            </div>
            {{--product4--}}
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 positioning-front-gallerys">
                <div class="hovereffect-front-gallerys positioning-front-gallerys">
                    <img class="img-responsive " src="/images/front_image_gallery/computer.jpg" alt="">
                    <div class="overlay">
                        <h2>Computer and Accessories</h2>
                        <a class="info" href="#">more...</a>
                        <a href="#" class="btn btn-info btn-sm centering-cart-front-gallerys">
                            <span class="glyphicon glyphicon-shopping-cart"></span> Add to Cart
                        </a>
                        <span class="rating">
                             <input type="radio" class="rating-input" id="rating-input-1-5" name="rating-input-1">
                            <label for="rating-input-1-5" class="rating-star"></label>
                            <input type="radio" class="rating-input" id="rating-input-1-4" name="rating-input-1">
                            <label for="rating-input-1-4" class="rating-star"></label>
                            <input type="radio" class="rating-input" id="rating-input-1-3" name="rating-input-1">
                            <label for="rating-input-1-3" class="rating-star"></label>
                             <input type="radio" class="rating-input" id="rating-input-1-2" name="rating-input-1">
                            <label for="rating-input-1-2" class="rating-star"></label>
                            <input type="radio" class="rating-input" id="rating-input-1-1" name="rating-input-1">
                            <label for="rating-input-1-1" class="rating-star"></label>
                        </span>
                        <div class="old-price ">&#8377 180.00</div>
                        <div class="new-price">&#8377 110.00</div>
                    </div>
                </div>

            </div>
            {{--product2--}}
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 positioning-front-gallerys">
                <div class="hovereffect-front-gallerys positioning-front-gallerys">
                    <img class="img-responsive " src="/images/front_image_gallery/cospetics.jpg" alt="">
                    <div class="overlay">
                        <h2>Cosmetics</h2>
                        <a class="info" href="#">more...</a>
                        <a href="#" class="btn btn-info btn-sm centering-cart-front-gallerys">
                            <span class="glyphicon glyphicon-shopping-cart"></span> Add to Cart
                        </a>
                        <span class="rating">
                             <input type="radio" class="rating-input" id="rating-input-1-5" name="rating-input-1">
                            <label for="rating-input-1-5" class="rating-star"></label>
                            <input type="radio" class="rating-input" id="rating-input-1-4" name="rating-input-1">
                            <label for="rating-input-1-4" class="rating-star"></label>
                            <input type="radio" class="rating-input" id="rating-input-1-3" name="rating-input-1">
                            <label for="rating-input-1-3" class="rating-star"></label>
                             <input type="radio" class="rating-input" id="rating-input-1-2" name="rating-input-1">
                            <label for="rating-input-1-2" class="rating-star"></label>
                            <input type="radio" class="rating-input" id="rating-input-1-1" name="rating-input-1">
                            <label for="rating-input-1-1" class="rating-star"></label>
                        </span>
                        <div class="old-price ">&#8377 180.00</div>
                        <div class="new-price">&#8377 110.00</div>
                    </div>
                </div>

            </div>
            {{--product2--}}
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 positioning-front-gallerys">
                <div class="hovereffect-front-gallerys positioning-front-gallerys">
                    <img class="img-responsive " src="/images/front_image_gallery/furniture.jpg" alt="">
                    <div class="overlay">
                        <h2>Furnitures</h2>
                        <a class="info" href="#">more...</a>
                        <a href="#" class="btn btn-info btn-sm centering-cart-front-gallerys">
                            <span class="glyphicon glyphicon-shopping-cart"></span> Add to Cart
                        </a>
                        <span class="rating">
                             <input type="radio" class="rating-input" id="rating-input-1-5" name="rating-input-1">
                            <label for="rating-input-1-5" class="rating-star"></label>
                            <input type="radio" class="rating-input" id="rating-input-1-4" name="rating-input-1">
                            <label for="rating-input-1-4" class="rating-star"></label>
                            <input type="radio" class="rating-input" id="rating-input-1-3" name="rating-input-1">
                            <label for="rating-input-1-3" class="rating-star"></label>
                             <input type="radio" class="rating-input" id="rating-input-1-2" name="rating-input-1">
                            <label for="rating-input-1-2" class="rating-star"></label>
                            <input type="radio" class="rating-input" id="rating-input-1-1" name="rating-input-1">
                            <label for="rating-input-1-1" class="rating-star"></label>
                        </span>
                        <div class="old-price ">&#8377 180.00</div>
                        <div class="new-price">&#8377 110.00</div>
                    </div>
                </div>

            </div>
            {{--product2--}}
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 positioning-front-gallerys">
                <div class="hovereffect-front-gallerys positioning-front-gallerys">
                    <img class="img-responsive " src="/images/front_image_gallery/jwellary.jpg" alt="">
                    <div class="overlay">
                        <h2>Jwellary</h2>
                        <a class="info" href="#">more...</a>
                        <a href="#" class="btn btn-info btn-sm centering-cart-front-gallerys">
                            <span class="glyphicon glyphicon-shopping-cart"></span> Add to Cart
                        </a>
                        <span class="rating">
                             <input type="radio" class="rating-input" id="rating-input-1-5" name="rating-input-1">
                            <label for="rating-input-1-5" class="rating-star"></label>
                            <input type="radio" class="rating-input" id="rating-input-1-4" name="rating-input-1">
                            <label for="rating-input-1-4" class="rating-star"></label>
                            <input type="radio" class="rating-input" id="rating-input-1-3" name="rating-input-1">
                            <label for="rating-input-1-3" class="rating-star"></label>
                             <input type="radio" class="rating-input" id="rating-input-1-2" name="rating-input-1">
                            <label for="rating-input-1-2" class="rating-star"></label>
                            <input type="radio" class="rating-input" id="rating-input-1-1" name="rating-input-1">
                            <label for="rating-input-1-1" class="rating-star"></label>
                        </span>
                        <div class="old-price ">&#8377 180.00</div>
                        <div class="new-price">&#8377 110.00</div>
                    </div>
                </div>

            </div>
            {{--product2--}}
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 positioning-front-gallerys">
                <div class="hovereffect-front-gallerys positioning-front-gallerys">
                    <img class="img-responsive " src="/images/front_image_gallery/mobilegallary.jpg" alt="">
                    <div class="overlay">
                        <h2>Mobile Gallery</h2>
                        <a class="info" href="#">more...</a>
                        <a href="#" class="btn btn-info btn-sm centering-cart-front-gallerys">
                            <span class="glyphicon glyphicon-shopping-cart"></span> Add to Cart
                        </a>
                        <span class="rating">
                             <input type="radio" class="rating-input" id="rating-input-1-5" name="rating-input-1">
                            <label for="rating-input-1-5" class="rating-star"></label>
                            <input type="radio" class="rating-input" id="rating-input-1-4" name="rating-input-1">
                            <label for="rating-input-1-4" class="rating-star"></label>
                            <input type="radio" class="rating-input" id="rating-input-1-3" name="rating-input-1">
                            <label for="rating-input-1-3" class="rating-star"></label>
                             <input type="radio" class="rating-input" id="rating-input-1-2" name="rating-input-1">
                            <label for="rating-input-1-2" class="rating-star"></label>
                            <input type="radio" class="rating-input" id="rating-input-1-1" name="rating-input-1">
                            <label for="rating-input-1-1" class="rating-star"></label>
                        </span>
                        <div class="old-price ">&#8377 180.00</div>
                        <div class="new-price">&#8377 110.00</div>
                    </div>
                </div>

            </div>

        </div>

        {{--products gallery starts--}}
    </div>
    {{--Market gallery Ends--}}

    <script>
        document.getElementById("defaultOpen").click();
        document.getElementById("defaultOpen").style.color = "#5BC0DE";
    </script>


@endsection

