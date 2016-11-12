@extends('layouts.admin-master')
@section('title', 'Add Store')

@section('breadcumb')
<h1>Store
<small>Add Store</small>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Home</a></li>
    <li>Store</li>
    <li class="active">Add Store</li>
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
<script src="/form-validation/edit-store-validation.js"></script>
<script>
    $().ready(onReadyEditStoreValidation);

    $( "input[name='store_name']" ).focusout(function(event) {

        var prefix = 'Try :';
        // event.currentTarget.removeClass('hidden');
        $('#suggestions').html(isEmpty(event.currentTarget.value) ? '' : prefix);
        requestForStoreSuggestions($.trim(event.currentTarget.value), 
        function(data) {
            //JSON.stringify(data.store)
            $('#suggestions').html( isEmpty(data.store) ? '' : ($('#suggestions').html() + data.store));
            // $('#suggestions').html($('#suggestions').html() + 'GOT IT!');
        }, function(xhr, textStatus) {
            // $('#suggestions').html('Suggestion not available!');
            // event.currentTarget.addClass('hidden');
        });
    });

    // callbacks & ajax
    function requestForStoreSuggestions(input, onSuccess, onError)
    {
        var routing_url = '/stores/suggest/input/' + input;
        var request = $.ajax({
            type: "GET",
            url: routing_url,
            dataType: 'json',
            statusCode: {
                404: function() {
                    $('#suggestions').html(isEmpty($.trim(input)) ? '' : 'Something went wrong!');
                }
            }
        });
        request.done(onSuccess).fail(onError);
    }

    function isEmpty(value) {
        return value == "none" || value == "undefined" || value == "";
    }

</script>
@endsection

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Add Store</h3>
    </div>
    
    <div class="box-body">
      <div class="row padTB"> 
          <div class="col-lg-6 col-lg-offset-3">
            <div class="box box-noborder">

              <div class="box-header with-border">
                <h3 class="box-title">Add your Store</h3>
              </div>

              <!-- form start -->
              <form role="form" id="edit-store-form" action="{{ isset($store) ? route('user::stores.update', [$store]) : route('user::stores.create') }}" method="POST">

                {!! csrf_field() !!}

                <div class="box-body">
                  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="Store-name">Store</label>
                    <input type="text" class="form-control" value="{{ isset($store) ? $store->name : '' }}" id="store_name" name="store_name" placeholder="Add your Store name here...">
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif            					
                    
                    <!--Store name suggestion. Just change the visibility to show/hide it : visible/hide-->
                    <div class="input-group input-group-lg">
                    <p>
                    <label>
                      <span class="glyphicon glyphicon-random"></span>
                      <label id="suggestions"></label>
                    </label>
                    </p>
                    </div> 

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
                    <select name="state" class="form-control" placeholder="Select State">
                            <option>Andhra Pradesh</option>
                            <option>Assam</option>
                            <option>Bihar</option>
                    </select>
                   <label for="postcode">Postcode</label>
                   <input type="text" class="form-control" value="{{ $address['POSTCODE'] or '' }}" id="postcode" name="postcode" placeholder="Postcode">
                  </div>

                  <div class="form-group">
                    <label for="store-type">I am going to sell</label>

                    <select name="business" class="form-control" placeholder="Select a business area">
                      @foreach($types as $store_type)
                      <option value="{{ $store_type['id'] }}" {{ ($store_type['id'] == (isset($store) ? $store->attributes['store_type'] : 'NOT_SURE') ) ? ' selected' : '' }}>{{ $store_type['title'] }}</option>
                      @endforeach
                    </select>
                
                  </div>

                  <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                    <label for="description">Store Description</label>
                    <textarea placeholder="Add Store description here..." class="form-control" rows="5" id="description" name="description">{{ isset($store) ? $store->description : '' }}</textarea>
                    @if ($errors->has('description'))
                        <span class="help-block">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                  </div>
                </div><!-- /.box-body -->

                <div class="box-footer text-right">
                  <button type="submit" class="btn btn-info btn-flat">{{ isset($store) ? 'Update' : 'Add' }} Store</button>
                </div>
              </form>
              <!--end of form-->

            </div>
          </div>
    </div>
</div>
    
    <!--recently added product-->
    <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">My Store List</h3>
                  <div class="box-tools">
                    <div class="input-group" style="width: 150px;">
                      <input type="text" name="table_search" class="form-control input-sm pull-right" placeholder="Search">
                      <div class="input-group-btn">
                        <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                      </div>
                    </div>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table id="parent" class="table table-hover">
                    <tr>
                      <!-- <th class="text-center hidden">ID</th> -->
                      <th class="text-center">Store Name</th>

                      <th class="text-center">Address</th>
                      <th class="text-center">Store URL</th>
                      <th class="text-center">Store Type</th>
                      <th class="text-center">Store Description</th>
                      <th class="text-center">Status</th>
                      <th class="text-center">Action</th>
                    </tr>
                    @if(isset($stores))
                      @foreach($stores as $store)
                        <?php $address = Inzaana\User::getAddress($store->address ? $store->address : Auth::user()->address) ?>
                      <tr>
                        <!-- <td class="text-center" id="child"><a href="">001</a> </td> -->
                        <td class="text-center" id="child"><a href="#">{{ $store->name }}</a></td>

                        <td class="text-center" id="child">{{ $address['HOUSE'] . ', ' . $address['STREET'] . ', ' . $address['LANDMARK'] . ', ' . $address['TOWN'] }}</td>

                        <td class="text-center" id="child">
                          <a target="_blank" href="{{ route('user::stores.redirect', [ 'site' => str_replace('.', '', $store->name_as_url) . '.' . $store->sub_domain . '.' . $store->domain ] ) }}">{{ str_replace('.', '', $store->name_as_url) . '.' . $store->sub_domain . '.' . str_replace('.', '', $store->domain) }}</a>
                        </td>

                        <td class="text-center" id="child">{{ $store->store_type }}</td>

                        <td class="text-center" id="child">{{ $store->description or 'This is a store named ' . $store->name }}</td>

                        <td class="text-center" id="child">@include('includes.approval-label', [ 'status' => $store->status, 'labelText' => $store->getStatus() ])</td>

                        <td class="text-center" id="child">
                          <form id="store-modification-form-edit" class="form-horizontal" method="GET" >
                            <input formaction="{{ route('user::stores.edit', [$store]) }}" id="store-edit-btn" class="btn btn-info btn-flat btn-xs" type="submit" value="Edit"></input>
                          </form>
                          <form id="store-modification-form-delete" class="form-horizontal" method="POST" >
                            {!! csrf_field() !!}
                            <input formaction="{{ route('user::stores.delete', [$store]) }}" id="store-delete-btn" class="btn btn-info btn-flat btn-xs" type="submit" value="Delete"></input>
                          </form>
                        </td>

                      </tr>
                      @endforeach
                    @endif
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div>
    <!--end of recently added product-->

@endsection