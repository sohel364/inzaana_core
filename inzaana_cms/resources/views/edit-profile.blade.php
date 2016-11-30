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

@section('header-style')
  <link rel="stylesheet" href="/jquery-validation/css/screen.css">
  <style type="text/css">

  #edit-profile-form label.error {
    margin-left: 10px;
    width: auto;
    display: inline;
  }

  </style>
@endsection

@section('footer-scripts')

  <script src="/jquery-validation/lib/jquery.js"></script>
  <script src="/jquery-validation/dist/jquery.validate.js"></script>
  <script src="/form-validation/edit-profile-validation.js"></script>
  <script src="/data-requests/postcodes-request.js"></script>

  <script type="text/javascript">
  // //just for the demos, avoids form submit
  // $.validator.setDefaults({
  //   submitHandler: function() {
  //     alert("submitted!");
  //   }
  // });
  $().ready(onReadyEditProfileValidation);
  $('#phone_number').keypress(validateNumber);

  ElementDataManager.timeout = 0;
  ElementDataManager.isCompleted = function() { return $('select#state option').length > 0 && $('select#postcode option').length > 0; };
  ElementDataManager.load('INDIA', function(context, data) {
      var options = '';
      var id = '';
      var addressKey = '';
      if(data.context == context[1])
      {
          addressKey = '$address[\'STATE\']';
          id = '#state';
      }
      else if(data.context == context[0])
      {
          addressKey = '$address[\'POSTCODE\']';
          id = '#postcode';
      }
      $.each(data.value, function( index, value ) {
          options += "<option value='" + index + "' {{ " + addressKey + " == '" + index + "' ? ' selected' : ''}} >" + value + "</option>";
      });

      $(id).html(options);
  });

  </script>

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
              <form role="form" id="edit-profile-form" action="{{ route('user::edit.email', [$user]) }}" method="POST">

                {!! csrf_field() !!}

                <div class="box-body">							
        				  <div class="form-group{{ $errors->has('profile_image') ? ' has-error' : '' }}">
        						<img src="{{ asset('/dist/img/avatar.png') }}" class="img-rounded" alt="Cinque Terre" width="304" height="236">
        						<input id="file-input" type="file"/>
        				 </div>
				 
                  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" value="{{ $user->name or '' }}" id="name" name="name" placeholder="Your name.." required>

                    @if ($errors->has('name'))
                        <span class="help-block">
                              <strong>{{ $errors->first('name') }}</strong>
                          </span>
                    @endif
                  </div>


                    <div>
                        <label for="contact-number"> Contact Number</label>

                        <div class="row col-sm-12 col-md-12 col-lg-12">
                            <div class="row col-sm-1 col-md-1 col-lg-1" style="text-align: right">code</div>
                            <div class="form-group col-sm-2 col-md-2 col-lg-2">
                                <div>
                                    <select name="code" text="code" class="form-control">
                                        <option {{ $phone_number[0] == 0 ? 'selected' : '' }}>+088</option>
                                        <option {{ $phone_number[0] == 1 ? 'selected' : '' }}>+465</option>
                                        <option {{ $phone_number[0] == 2 ? 'selected' : '' }}>+695</option>
                                    </select>
                                </div>

                            </div>
                            <div class="col-sm-7 col-md-7 col-lg-7 form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                                <input type="text" class="form-control" value="{{ $phone_number[1] or '' }}" id="phone_number" name="phone_number" placeholder="Phone number...">

                                @if ($errors->has('phone_number'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('phone_number') }}</strong>
                                  </span>
                                @endif
                            </div>
                            <div class="col-sm-1 col-md-1 col-lg-1"><button type="button" class="btn btn-primary">verify</button></div>
                        </div>
                    </div>

                  <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email">Email Address</label>
                    <input type="text" class="form-control" value="{{ $user->email or old('email') }}" id="email" name="email" placeholder="Your email address..">            

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
					           <input type="text" class="form-control" value="{{ $address['HOUSE'] or '' }}" id="address_flat_house_floor_building" name="address_flat_house_floor_building" placeholder="Flat / house no / floor / Building">
                    <br/>
                    <input type="text" class="form-control" value="{{ $address['STREET'] or '' }}" id="address_colony_street_locality" name="address_colony_street_locality" placeholder="Colony / Street / Locality">
                    <br/>
                    <input type="text" class="form-control" value="{{ $address['LANDMARK'] or '' }}" id="address_landmark" name="address_landmark" placeholder="Landmark (optional)">
                    <br/>
                    <input type="text" class="form-control" value="{{ $address['TOWN'] or '' }}" id="address_town_city" name="address_town_city" placeholder="Town / City">
                    <br/>
					
					         <label for="state">State</label>
                    <select id="state" name="state" class="form-control" placeholder="Select State">
                    </select>
					         
                   <label for="Postcode">Postcode</label>
                    <select id="postcode" name="postcode" placeholder="Postcode" class="form-control" placeholder="Select Postcode">
                    </select>
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