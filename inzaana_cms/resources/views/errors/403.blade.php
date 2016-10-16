@extends('layouts.master_out')

@section('title', '403 - Forbidden action')

@section('header-style')
 <link href="{{ URL::asset('css/404.css') }}" rel="stylesheet" type="text/css">  
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="error-template">
                <h1>Ooops!</h1>
                <div class="col-xs-12 col-md-8 col-md-offset-2 marTop100 text-center">
                    <div class="error-details">
                        <h2 class="text-center text-warning">Sorry, you are forbidden in this area.</h2>
                        <p class="text-center text-info">If you want to use this feature upgrade your plan.</p>
                    </div>
                    <div> @include('errors') </div> 
                </div>              
                <div class="error-actions col-xs-12 col-md-8 col-md-offset-2 marTop100 text-center">
                    <a href="{{ url(URL::previous()) }}" class="btn btn btn-info"><span class="glyphicon glyphicon-home"></span>Take Me Back</a>
                    <a href="#" class="btn btn-default "><span class="glyphicon glyphicon-envelope"></span> Contact Support </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection