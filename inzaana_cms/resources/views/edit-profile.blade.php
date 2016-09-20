@extends('layouts.admin-master')
@section('title', 'Update Profile')

@section('breadcumb')
<h1>Edit
<small>Update Profile</small>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Home</a></li>
    <li>Profile</li>
    <li class="active">Update profile</li>
</ol>
@endsection

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Your Profile Details</h3>
    </div>
    
    <div class="box-body">
      <div class="row padTB"> 
          <div class="col-lg-6 col-lg-offset-3">
            <div class="box box-noborder">

              <div class="box-header with-border">
                <h3 class="box-title">Update your profile below</h3>
              </div>

              @if(isset($user))
              <!-- form start -->
              <form role="form" action="{{ route('user::update', [$user]) }}" method="POST">

                {!! csrf_field() !!}

                <div class="box-body">
                  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" value="{{ $user->name or '' }}" id="name" name="name" placeholder="Your name..">

                    @if ($errors->has('name'))
                        <span class="help-block">
                              <strong>{{ $errors->first('name') }}</strong>
                          </span>
                    @endif
                  </div>

                  <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                    <label for="contact-number">Contact Number</label>
                    <input type="text" class="form-control" value="{{ $user->phone_number or '' }}" id="contact-number" name="contact-number" placeholder="Your contact number...">            

                    @if ($errors->has('phone_number'))
                        <span class="help-block">
                              <strong>{{ $errors->first('phone_number') }}</strong>
                          </span>
                    @endif
                  </div>

                  <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email">Email Address</label>
                    <input type="text" class="form-control" value="{{ $user->email or '' }}" id="email" name="email" placeholder="Your email address..">            

                    @if ($errors->has('email'))
                        <span class="help-block">
                              <strong>{{ $errors->first('email') }}</strong>
                          </span>
                    @endif
                  </div>
                  <div class="form-group ">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" value="{{ $user->address or '' }}" id="mailing-address" name="mailing-address" placeholder="Your mailing address..">            

                    @if ($errors->has('address'))
                        <span class="help-block">
                              <strong>{{ $errors->first('address') }}</strong>
                          </span>
                    @endif
                  </div>

                  <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group animated fadeInLeftShort{{ $errors->has('password') ? ' has-error' : '' }}" data-id="9">
                                <input type="password" name="password" id="password" class="form-control input-sm" placeholder="Password" tabindex="5">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                          <strong>{{ $errors->first('password') }}</strong>
                                      </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group animated fadeInRightShort{{ $errors->has('password_confirmation') ? ' has-error' : '' }}" data-id="10">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-sm" placeholder="Confirm Password" tabindex="6">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                          <strong>{{ $errors->first('password_confirmation') }}</strong>
                                      </span>
                                @endif
                            </div>
                        </div>
                  </div>
                  
                </div><!-- /.box-body -->

                <div class="box-footer text-right">
                  <button type="submit" class="btn btn-info btn-flat">Update Profile</button>
                </div>
              </form>
              <!--end of form-->
              @else

                  <h2>Oops! Looks like you are incognito! Come back again by logging in again.</h2>

              @endif

            </div>
          </div>
    </div>
</div>    
<!--end of recently added product-->
@endsection