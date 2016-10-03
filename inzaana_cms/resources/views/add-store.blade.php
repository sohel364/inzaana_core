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
              <form role="form" action="{{ isset($store) ? route('user::stores.update', [$store]) : route('user::stores.create') }}" method="POST">

                {!! csrf_field() !!}

                <div class="box-body">
                  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="Store-name">Store</label>
                    <input type="text" class="form-control" value="{{ isset($store) ? $store->name : '' }}" id="store-name" name="store_name" placeholder="Add your Store name here...">
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                  </div>

                   <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                    <label for="Store-address">Address</label>
                    <input type="text" class="form-control" value="" id="address" name="address" placeholder="Add your Store addres here...">
                    @if ($errors->has('address'))
                        <span class="help-block">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="store-type">I am going to sell</label>

                    <select name="business" class="form-control" placeholder="Select a business area">
                      <option value="UNKNOWN" class="placehold">I'm not sure yet.</option>
                      <option value="ANIMAL_PET" selected>Animal &amp; Pet</option>
                      <option value="ART_ENTERTAINMENT">Art &amp; Entertainment</option>
                      <option value="HARDWARE_HOME">Hardware or Home/Garden Improvement</option>
                      <option value="OTHERS">Others / something else...</option>
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
                      <th class="text-center">I am going to sell</th>
                      <th class="text-center">Store Description</th>
                      <th class="text-center">Status</th>
                      <th class="text-center">Action</th>
                    </tr>
                    @if(isset($stores))
                      @foreach($stores as $store)
                      <tr>
                        <!-- <td class="text-center" id="child"><a href="">001</a> </td> -->
                        <td class="text-center" id="child"><a href="">{{ $store->name }}</a></td>

                        <td class="text-center" id="child"><a href="">{{ $store->adress }}</a></td>

                        <td class="text-center" id="child">
                          <a target="_blank" href="{{ route('user::stores.redirect', [ 'site' => str_replace('.', '', $store->name_as_url) . '.' . $store->sub_domain . '.' . $store->domain ] ) }}">{{ str_replace('.', '', $store->name_as_url) . '.' . $store->sub_domain . '.' . str_replace('.', '', $store->domain) }}</a>
                        </td>

                        <td class="text-center" id="child"><a href="">{{ $store->sell }}</a></td>

                        <td class="text-center" id="child"><a href="">{{ $store->description or 'This is a store named ' . $store->name }}</a></td>

                        <td class="text-center" id="child"><a href="">{{ $store->status }}</a></td>

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