@extends('layouts.admin-master')
@section('title', 'Edit Profile')

@section('breadcumb')
<h1>Edit
<small>Edit Profile</small>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Home</a></li>
    <li>Profile</li>
    <li class="active">Edit profile</li>
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
                <h3 class="box-title">Edit your profile below</h3>
              </div>

              <!-- form start -->
              <form role="form" action="#" method="POST">

                {!! csrf_field() !!}

                <div class="box-body">
                  <div class="form-group">
                    <label for="first-name">First Name</label>
                    <input type="text" class="form-control" value="{{ isset($ProfileEdit) ? $ProfileEdit->Profile_name : '' }}" id="first-name" name="first-name" placeholder="Your first name..">
                  </div>

                  <div class="form-group">
                    <label for="first-name">Last Name</label>
                    <input type="text" class="form-control" value="{{ isset($ProfileEdit) ? $ProfileEdit->Profile_name : '' }}" id="last-name" name="last-name" placeholder="Your last name..">
                  </div>

                  <div class="form-group">
                    <label for="contact-number">Contact Number</label>
                    <input type="text" class="form-control" value="{{ isset($ProfileEdit) ? $ProfileEdit->Contact_number : '' }}" id="contact-address" name="contact-number" placeholder="Your contact number..">            
                  </div>

                  <div class="form-group">
                    <label for="email-address">Email Address</label>
                    <input type="text" class="form-control" value="{{ isset($ProfileEdit) ? $ProfileEdit->Email_address : '' }}" id="email-address" name="email-name" placeholder="Your email address..">            
                  </div>

                  <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" value="{{ isset($ProfileEdit) ? $ProfileEdit->Mailing_address : '' }}" id="mailing-address" name="mailing-address" placeholder="Your mailing address..">            
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
                  <button type="submit" class="btn btn-info btn-flat">{{ isset($ProfileEdit) ? 'Update' : 'Update' }} Profile</button>
                </div>
              </form>
              <!--end of form-->

            </div>
          </div>
    </div>
</div>    
<!--end of recently added product-->
@endsection