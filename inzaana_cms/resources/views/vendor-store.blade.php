@extends('layouts.vendor-store-master')

@section('title', 'Showcase')

@section('products')
    @parent

    <div class="row text-center">

    @forelse($products as $product)
    <!-- gallery start -->

        <div class="col-md-4">

            <div class="thumbnail">
                <div id="myCarousel-{{ $product->id }}" class="carousel slide" data-ride="carousel" data-interval="false" >
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel-{{ $product->id }}" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel-{{ $product->id }}" data-slide-to="1"></li>
                        <li data-target="#myCarousel-{{ $product->id }}" data-slide-to="2"></li>
                        <li data-target="#myCarousel-{{ $product->id }}" data-slide-to="3"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">

                        <div class="item active">
                            <img src="http://{{ $sub_domain }}/images/kitkat-300x300.jpg" alt="{{ $product->product_title }}" width=auto height="345">
                            <div class="carousel-caption">
                                <h3>{{ $product->product_title }}</h3>
                                <p>The atmosphere in Chania has a touch of Florence and Venice.</p>
                            </div>
                        </div>

                        <div class="item">
                            <img src="http://{{ $sub_domain }}/images/kitkat-300x300.jpg" alt="{{ $product->product_title }}" width="460" height="345">
                            <div class="carousel-caption">
                                <h3>{{ $product->product_title }}</h3>
                                <p>The atmosphere in Chania has a touch of Florence and Venice.</p>
                            </div>
                        </div>


                    </div>

                    <!-- Left and right controls -->
                    <a class="carousel-control left" href="#myCarousel-{{ $product->id }}" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>
                    <a class="carousel-control right" href="#myCarousel-{{ $product->id }}" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                </div>


                <p>Description</p>
                <p>Price: {{ $product->selling_price }} INR</p>

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
    @empty
    <div class="col-md-4">
        <span class="label label-success"> No products available </span>
    </div>
    @endforelse

@endsection