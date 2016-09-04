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
              <form role="form" action="{{ isset($StoreEdit) ? route('user::categories.update', $StoreEdit->id) : route('user::categories.create') }}" method="POST">

                {!! csrf_field() !!}

                <div class="box-body">
                  <div class="form-group">
                    <label for="Store-name">Store</label>
                    <input type="text" class="form-control" value="{{ isset($StoreEdit) ? $StoreEdit->Store_name : '' }}" id="Store-name" name="Store-name" placeholder="Add your Store name here...">
                  </div>

                  <div class="form-group">
                    <label for="Store-type">I am going to sell</label>
                    
                    <select name="business" class="form-control" placeholder="Select a business area">
                      <option value="" class="placehold" selected="">I'm not sure yet.</option>
                      <option value="">Animal &amp; Pet</option>
                      <option value="">Art &amp; Entertainment</option>
                      <option value="">Hardware or Home/Garden Improvement</option>
                      <option value="">Others / something elase...</option>
                    </select>
                
                  </div>

                  <div class="form-group">
                    <label for="description">Store Description</label>
                    <textarea placeholder="Add Store description here..." class="form-control" rows="5" id="description" name="description">{{ isset($StoreEdit) ? $StoreEdit->description : '' }}</textarea>
                  </div>
                </div><!-- /.box-body -->

                <div class="box-footer text-right">
                  <button type="submit" class="btn btn-info btn-flat">{{ isset($StoreEdit) ? 'Update' : 'Add' }} Store</button>
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
                      <th class="text-center">Store Type</th>
                      <th class="text-center">Store Description</th>
                      <th class="text-center">Action</th>
                    </tr>
                    @foreach($categories as $Store)
                    <tr>
                      <!-- <td class="text-center" id="child"><a href="">001</a> </td> -->
                      <td class="text-center" id="child"><a href="">store-1</a></td>
                      <td class="text-center" id="child"><a href=""></a>Mobiles</td>
                      <td class="text-center" id="child"><a href="">Store description goes here</a></td>
                      <td class="text-center" id="child">
                        <form id="Store-modification-form" class="form-horizontal" method="GET" >
                          <input formaction="#" id="Store-edit-btn" class="btn btn-info btn-flat btn-xs" type="submit" value="Edit"></input>
                        </form>
                        <form id="Store-modification-form" class="form-horizontal" method="POST" >
                          {!! csrf_field() !!}
                          <input formaction="#" id="Store-delete-btn" class="btn btn-info btn-flat btn-xs" type="submit" value="Delete"></input>
                        </form>
                      </td>
                    </tr>
                    @endforeach
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div>
    <!--end of recently added product-->

@endsection