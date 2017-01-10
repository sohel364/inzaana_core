@extends('layouts.master_out')

@section('title', '500 Server Error')

@section('header-style')
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="stylesheet" href="/http500res/vendor.css">
    <link rel="stylesheet" href="/http500res/css" type="text/css">
    <link rel="stylesheet" href="/http500res/main.css">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page_overlay animated fadeOut" style="display: none;">
                  <div class="loader-inner ball-pulse">
                    <div></div>
                    <div></div>
                    <div></div>
                  </div>
                </div>
                <div class="five00wrap animated fadeIn">
                  <div class="row-flex">
                    <div class="messge500">
                      <h1><span>500</span> <br>
                      Server error</h1>
                      <p>Go back</p>
                    </div>
                    <div class="scene-3">
                      <img src="/http500res/scene-500.png" alt="">
                      <div class="charecter-4">
                        <img src="/http500res/charecter-4.png" alt="">
                        <div class="hand-part1"><img src="/http500res/charecter-4-hand-part.png" alt=""></div>
                        <div class="eye"><img src="/http500res/charecter-4-eye.gif" alt=""></div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-scripts')

  <script src="/http500res/vendor.js.download"></script>
  <script src="/http500res/plugins.js.download"></script>
  <script src="/http500res/main.js.download"></script>

@endsection