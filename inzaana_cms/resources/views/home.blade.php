@extends('layouts.master')

@section('title', 'Home')

@section('content')
    <div class="row">
      <div class="col-md-12 animatedParent animateOnce" data-sequence="500">
        <div class="section-title">
          <h1 class="animated growIn delay-250" data-id='1'>How It Works</h1>
          <div class="title-separator animated fadeInLeft delay-250" data-id='2'><span></span></div>
          <p class="animated fadeInRight delay-250" data-id='3'>You Can Build Your Own Online Store In Just 3 Steps!!!</p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 animatedParent animateOnce">
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
              <p>Lorem ipsum dolor sit amet, consectetur Unlimited ColorsCras pulvin, mauris at so mauris at lectus lectus.</p>
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
              <p>Lorem ipsum dolor sit amet, consectetur Unlimited ColorsCras pulvin, mauris at so mauris at lectus lectus.</p>
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
              <p>Lorem ipsum dolor sit amet, consectetur Unlimited ColorsCras pulvin, mauris at so mauris at lectus lectus.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 animatedParent animateOnce">
        <img src="images/slide1.gif" class="img-responsive img-thumbnail maxHeightWidth animated fadeInRightShort delay-250" />
      </div>
    </div>
@endsection