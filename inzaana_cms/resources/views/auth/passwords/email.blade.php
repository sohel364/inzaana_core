@extends('layouts.master_out')
@section('title', 'Reset passwors')
@section('header-style')
 <link href="{{ URL::asset('css/email.css') }}" rel="stylesheet" type="text/css">  
@endsection

<!-- Main Content -->
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
        <div class="panel panel-default padPtop">
          <div class="panel-heading text-center panHead">
           <h2 class="CustomHead" ><i class="fa fa-key"></i> Reset Your Password</h2>
          </div>
          <div class="panel-body pad50">

            
            <form class="emailPad" role="form" method="POST" action="{{ url('/password/email') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                            <div class="col-md-12">
                                <input type="email" placeholder="Your Email Address" class="form-control" name="email" value="{{ old('email') }}">
                                <span class="help-block">
                                    <strong>::::: Please Enter a vaild email id::::</strong>
                                </span>

                                <!--@if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif-->
                            </div>
                        </div>

                        <div class="form-group padtop">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-info">
                                    <i class="fa fa-btn fa-envelope"></i> Reset
                                </button>
                                <a href="{{ url('/') }}" class="btn btn btn-info"><span class="glyphicon glyphicon-home"></span>
                        Take Me Home </a>
                            </div>
                        </div>
                    </form>
          </div>
        </div>
        </div>
    </div>
</div>
@endsection
