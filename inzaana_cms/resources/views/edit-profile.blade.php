@extends('layouts.' . ( $user->email == config('mail.admin.address') ? 'super-' : ( ($user->stores()->count() == 0) ? 'user-' : ''  )) . 'admin-master')

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
                <h3 class="box-title">Profile Image</h3>
              </div>

              @if(isset($user))
              <!-- form start -->
              <form role="form" action="{{ route('user::update', [$user]) }}" method="POST">

                {!! csrf_field() !!}

                <div class="box-body">							
        				  <div class="form-group{{ $errors->has('profile_image') ? ' has-error' : '' }}">
        						<img src="{{ asset('/dist/img/user2-160x160.jpg') }}" class="img-rounded" alt="Cinque Terre" width="304" height="236">										
        						<input id="file-input" type="file"/>
        				 </div>
				 
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
                    <input type="text" class="form-control" value="{{ $user->phone_number or '' }}" id="phone_number" name="phone_number" placeholder="Your contact number...">            

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
				  
				          @if($user->email_alter)
				          <div class="form-group{{ $errors->has('email_alter') ? ' has-error' : '' }}">
                    <label for="email_alter">Inzaana web-mail</label>
                    <input type="text" class="form-control" value="{{ $user->email_alter }}" id="email_alter" name="email_alter" placeholder="Your inzaana web-email.." readonly>            

                    @if ($errors->has('email_alter'))
                        <span class="help-block">
                              <strong>{{ $errors->first('email_alter') }}</strong>
                          </span>
                    @endif
                  </div>
                  @endif
				  
                  <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" value="{{ $user->address or '' }}" id="mailing-address" name="mailing-address" placeholder="Your mailing address..">            

                    @if ($errors->has('address'))
                        <span class="help-block">
                              <strong>{{ $errors->first('address') }}</strong>
                          </span>
                    @endif
                  </div>
				  
        				  <div class="form-group{{ $errors->has('oldpass') ? ' has-error' : '' }}">
        				  	<label for="oldpass">Reset password</label>
                    <input type="password" name="oldpass" id="oldpass" class="form-control input-sm" placeholder="Old Password" tabindex="5">

        					  @if ($errors->has('oldpass'))
        						  <span class="help-block">
        								<strong>{{ $errors->first('oldpass') }}</strong>
        							</span>
        					  @endif
        				  </div>        				  
        				  
          				<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
          						<input type="password" name="password" id="password" class="form-control input-sm" placeholder="New Password" tabindex="6">

          						@if ($errors->has('password'))
          							<span class="help-block">
          								  <strong>{{ $errors->first('password') }}</strong>
          							  </span>
          						@endif
          				</div>

          				<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
          						<input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-sm" placeholder="Confirm Password" tabindex="7">

          						@if ($errors->has('password_confirmation'))
          							<span class="help-block">
          								  <strong>{{ $errors->first('password_confirmation') }}</strong>
          							  </span>
          						@endif
          				</div>	

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