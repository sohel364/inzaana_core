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

  <link href="/css/select2.min.css" rel="stylesheet">
  <link href="/css/select2-bootstrap.css" rel="stylesheet">
@endsection

@section('footer-scripts')

  <script src="/jquery-validation/lib/jquery.js"></script>
  <script src="/jquery-validation/dist/jquery.validate.js"></script>
  <script src="/form-validation/edit-profile-validation.js"></script>

  <script type="text/javascript">
  // //just for the demos, avoids form submit
  // $.validator.setDefaults({
  //   submitHandler: function() {
  //     alert("submitted!");
  //   }
  // });
  $().ready(onReadyEditProfileValidation);
  $('#phone_number').keypress(validateNumber);

  </script>

  <script src="/js/select2.full.min.js"></script>
  <script type="text/javascript">

      function formatDataSelection(data)
      {
          return data.text;
      }

      function formatStatesData(data)
      {
          var addressKey = '$address[\'STATE\']';
          var id = '{{ ' + data.id + ' }}';
          var text = '{{ ' + data.text + ' }}';
          var selected = "{{ " + addressKey + " == " + id + " ? ' selected' : ''}}";
          return "<option value='" + id + "' " + selected + ">" + text + "</option>";
      }

      function formatPostCodesData(data)
      {
          var addressKey = '$address[\'POSTCODE\']';
          var id = '{{ ' + data.id + ' }}';
          var text = '{{ ' + data.text + ' }}';
          var selected = "{{ " + addressKey + " == " + id + " ? ' selected' : ''}}";
          return "<option value='" + id + "' " + selected + ">" + text + "</option>";
      }

      $(".load_async").select2({
          theme: "bootstrap",
          ajax: {
              delay: 250,
              allowClear: true,
              dataType: 'json',
              data: function (params) {
                var query = {
                  search: params.term,
                  page: params.page
                }

                // Query paramters will be ?search=[term]&page=[page]
                return query;
              },
              headers: {
                  "Accept": "application/json"
              },
              processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                  results: data.items,
                  pagination: {
                    more: (params.page * 10) < data.total_count

                  }
                };
              },
              escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
              minimumInputLength: 1,
              templateResult: ($(".load_async").attr('id') === 'state') ? formatStatesData : formatPostCodesData,
              templateSelection: formatDataSelection
          }
      })

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
                                      @foreach($area_codes as $key => $area_code)
                                        <option value="{{ $area_code }}" {{ $phone_number[0] == $key ? 'selected' : '' }}>{{ $area_code }}</option>
                                      @endforeach
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
                    <input type="email" class="form-control" value="{{ $user->email or old('email') }}" id="email" name="email" placeholder="Your email address..">            

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
					
                    <div class="row col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group col-sm-9 col-md-9 col-lg-9">
                          <label for="state">State</label>

                          @include('includes.select-box-searchable',
                          [ 
                            'route' => '/dashboard/states/country/INDIA', 
                            'default_text' => 'Select State',
                            'name' => 'state'                            
                          ])
                          <!-- <select id="state" name="state" class="form-control" placeholder="Select State">
                            {{--@foreach ($states as $state)
                              <option value='{{ $state->id }}' {{ $address['STATE'] == $state->id ? ' selected' : ''}} >{{ $state->state_name }}</option>
                            @endforeach--}}
                          </select> -->
                        </div>  
                    </div>     

                    <div class="row col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group col-sm-9 col-md-9 col-lg-9">
                          <label for="postcode">Postcode</label>
                          @include('includes.select-box-searchable',
                          [ 
                            'route' => '/dashboard/postcodes/country/INDIA', 
                            'default_text' => 'Select Postcode',
                            'name' => 'postcode'                            
                          ])
                          <!-- <select id="postcode" name="postcode" class="form-control" placeholder="Select Postcode">
                            {{--@foreach ($post_codes as $code)
                              <option value='{{ $code->id }}' {{ $address['POSTCODE'] == $code->id ? ' selected' : ''}} >{{ $code->post_code }}</option>
                            @endforeach--}}
                          </select> -->
                        </div> 
                    </div>
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