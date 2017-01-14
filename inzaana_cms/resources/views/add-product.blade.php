@extends('layouts.admin-master')
@section('title', 'Add Product')

@section('header-style')
<link href="{{ URL::asset('css/select2.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('css/dragdrop.css') }}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('css/newStyle.css') }}" rel="stylesheet" type="text/css">

<!--for date picker only-->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
<!--end of date picker css-->
@endsection

@section('breadcumb')
<h1>Product
<small>Add Product</small>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Home</a></li>
    <li>Product</li>
    <li class="active">Add Product</li>
</ol>
@endsection

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Add Product</h3>
    </div>
    
    <div class="box-body">
        <div class="row padTB"> 
            <!--form-->
            <form action="{{ route('user::products.search') }}" method="GET">
                <div class="col-lg-6 col-lg-offset-3">
                <div class="box box-widget">
                    <div class="box-header with-border">
                        <h4 class="boxed-header">Find it on Inzaana</h4>
                    </div>
                    <div class="box-body">
                    <div class="input-group">
                        <input id="search-box" name="search-box" type="text" class="form-control">
                        <span class="input-group-btn">
                          <button id="product-search-btn" class="btn btn-info btn-flat" type="submit"><i class="fa fa-lg fa-search"><!-- Search --></i></button>
                        </span>
                    </div>
                    </div>
                    <div class="box-footer box-comments{{ $productsCount == 0 ? '' : ' hidden' }}">
                        <div class="box-comment">
                            <div class="col-lg-6">
                                <h4 class="C-header">If it is not in Inzaana's catalog:</h4>
                            </div>
                           <div class="col-lg-6 text-right">
                               <button id="product-form-open-button" class="btn btn-info btn-flat laravel-bootstrap-modal-form-open" data-toggle="modal" data-target="#addProduct" type="button"><i class="fa fa-lg fa-plus-square"></i>&ensp; Add Product</button>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </form>
            <!--end of form-->
            
            <div class="col-lg-6 col-lg-offset-3 boxPadTop">
                <div class="box box-down box-info{{ $productsCount == 0 ? ' hidden' : '' }}">
                    <div class="boxed-header">
                        <h5>Results on Inzaana.com &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b>1</b> to <b>{{ $productsCount < 5 ? $productsCount : 5 }}</b> of <b>{{ $productsCount }}</b> results.</h5>
                    </div>
                <div class="box-body no-padding">
                  <table id="parent" class="table table-hover">
                    <tr>
                      <th>Image</th>
                      <th>Product Name</th>
                      <th>Category</th>
                      <th>Action</th>
                    </tr>
                    @if(isset($productsBySearch))
                      @foreach($productsBySearch as $productFromSearch)
                      <tr>
                          <td id="photo"><a data-toggle="modal" data-target="#viewImage"><img src="{{ $productFromSearch->photo_name or 'http://lorempixel.com/400/200/food/' }}" height="50px" width="80px"/></a></td>
                          <td id="product">{{ $productFromSearch->title }}</td>
                          <td id="category">{{ $productFromSearch->marketProduct()->category->name or 'Uncategorized' }}</td>
                          <td id="sellyours">
                            <form method="POST">
                              {!! csrf_field() !!}
                              <input formaction="{{ route('user::products.sell-yours', [$productFromSearch]) }}" class="btn btn-info btn-flat btn-sm" type="submit" value="Sell yours"></input>
                            </form>
                          </td>
                      </tr>
                      @endforeach
                    @endif
                  </table>
                    <div class="col-sm-12 noPadMar text-center">
                        <ul class="pagination pagination-sm noPadMar">
                            <li class="active"><a href="#">1</a></li>
                            @for ($i = 0; $i < ($productsCount / 5) - 1; $i++)
                                <li><a href="#">{{ $i }}</a></li>
                            @endfor
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        
    <!--add product modal-->
<div id="addProduct" class="modal fade laravel-bootstrap-modal-form" role="dialog">

  <div id="has_error" class="hidden{{ count($errors) > 0 ? ' has-error' : '' }}"></div>
  <div id="is_edit" class="hidden{{ isset($product) ? ' is-edit' : '' }}"></div>
    
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
          <div class="custom_tab">
              <ul class="nav nav-tabs">
                <li class="{{ ($tab == 'single_product_entry_tab') ? 'active' : '' }}"><a href="#tab-edit" data-toggle="tab">Add Product Details</a></li>
                <li class="{{ ($tab == 'bulk_product_entry_tab') ? 'active' : '' }}"><a href="#tab-messages" data-toggle="tab">Upload Products</a></li>
              </ul>
          </div>
      </div>
        
        <!--Custom tab content start from here-->
        <div id="generalTabContent" class="tab-content">

            @include('errors')
            <div id="tab-edit" class="tab-pane fade in{{ ($tab == 'single_product_entry_tab') ? ' active' : '' }}">

             <!-- form start -->
             <!-- route('user::products.create') -->
             <!-- enctype="multipart/form-data" -->
              <form id="product-create-form" class="form-horizontal"
                    action="{{ isset($product) ? route('user::products.update', [$product]) : route('user::products.create') }}"
                    enctype="multipart/form-data"
                    method="POST">

                {!! csrf_field() !!}

                <h4 class="block-title">Product Summary</h4>
                <div class="block-of-block">

                    <div class="modal-body">

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Select store</label>
                            <div class="col-sm-7">
                                    
                              <select name="store_name" id="store_name" class="form-control select2" data-placeholder="Select Store" style="width: 100%;">
                                @foreach($stores as $name_as_url => $name)
                                    <option value="{{ $name_as_url }}"{{ (isset($product) && $product->store) && ($product->store->name_as_url == $name_as_url || old('store_name') == $name_as_url) ? ' selected' : '' }}> {{ $name_as_url }}.inzaana.com ( {{ $name }} ) </option>                                    
                                @endforeach
                              </select>
                              @if ($errors->has('store_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('store_name') }}</strong>
                                    </span>
                              @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                          <label  class="col-sm-3 control-label">Product Category:</label>
                          <div class="col-sm-2">
                            <select name="category" id="category" class="form-control select2" data-placeholder="Select a Category" style="width: 100%;">

                            @if(isset($categories))
                              @foreach( $categories as $category )
                                <option value="{{ $category->id }}"{{ (isset($product) && $product->category) && ($product->category->id == $category->id || old('category') == $category->id) ? ' selected' : '' }}>{{ $category->name or 'Uncategorized' }}</option>
                              @endforeach
                            @else                              
                              <option>{{ 'Uncategorized' }}</option>
                            @endif
                            </select>
                            @if ($errors->has('category'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('category') }}</strong>
                                  </span>
                            @endif
                          </div>
                          <div class="col-sm-2">
                              <button formmethod="GET" formaction="{{ route('user::categories') }}" class="btn btn-default btn-flat"><i class="fa fa-plus"></i> </button>
                          </div>
                        </div>
                       <!-- <div class="form-group">
                            <label  class="col-sm-3 control-label">Product Sub Category:</label>
                            <div class="col-sm-7">
                                <select name="subcategory" class="form-control select2" multiple="multiple" data-placeholder="Select a sub Category" style="width: 100%;">

                                    {{--@if(isset($categories))--}}
                                        {{--@foreach( $categories as $category )--}}
                                            {{--<option>{{ $category->category_name or 'Uncategorized' }}</option>--}}
                                        {{--@endforeach--}}
                                    {{--@endif--}}
                                </select>
                            </div>
                            {{--<div class="col-sm-2">--}}
                                {{--<button formmethod="GET" formaction="{{ route('user::categories') }}" class="btn btn-info btn-flat"><i class="fa fa-plus"></i> </button>--}}
                            {{--</div>--}}
                        </div>-->
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                          <label for="title" class="col-sm-3 control-label">Product Title:</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="title" name="title" placeholder="ex: kitkat 5RS" value="{{ isset($product) ? $product->title : old('title') }}">
                            @if ($errors->has('title'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('title') }}</strong>
                                  </span>
                            @endif
                          </div>
                        </div>
                        <div class="form-group{{ $errors->has('manufacturer_name') ? ' has-error' : '' }}">
                          <label for="Manufacturer" class="col-sm-3 control-label">Manufacturer</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="manufacturer_name" name="manufacturer_name" placeholder="ex: dairy milk" value="{{ isset($product) ? $product->marketManufacturer() : old('manufacturer_name') }}">
                            @if ($errors->has('manufacturer_name'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('manufacturer_name') }}</strong>
                                  </span>
                            @endif
                          </div>
                        </div>
                        <div class="form-group">
                          <label  class="col-sm-3 control-label">Product Type:</label>
                          <div class="col-sm-3">
                            <select name="product_type" class="form-control select2" multiple="multiple" data-placeholder="Select a Category" style="width: 100%;">
                              <option>Physical Product</option>
                              <option>Downloadable Product</option>
                            </select>
                          </div>
                        </div>
                        <!--<div class="form-group{{ $errors->has('mrp') ? ' has-error' : '' }}">
                          <label for="mrp" class="col-sm-3 control-label">MRP:</label>
                          <div class="col-sm-2">
                            <input type="text" class="form-control" id="mrp" name="mrp" placeholder="ex: 3₹">
                            @if ($errors->has('mrp'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('mrp') }}</strong>
                                  </span>
                            @endif
                          </div>
                            {{--<div class="col-sm-7 padT5"><b>$</b></div>--}}
                        </div>-->
                        <!--<div class="form-group{{ $errors->has('discount') ? ' has-error' : '' }}">
                          <label for="discount" class="col-sm-3 control-label">Discount:</label>
                          <div class="col-sm-2">
                            <input type="text" class="form-control" id="discount" name="discount" value="{{ isset($product) ? $product->discount : '' }}" placeholder="ex: 30%">
                            @if ($errors->has('discount'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('discount') }}</strong>
                                  </span>
                            @endif
                          </div>
                            {{--<div class="col-sm-7 padT5"><b>%</b></div>--}}
                        </div>-->
                        
                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                          <label for="price" class="col-sm-3 control-label">Price:</label>
                          <div class="col-sm-2">
                            <input type="text" class="form-control" id="price" name="price" placeholder="ex: 3₹" value="{{ isset($product) ? $product->marketPrice() : old('price') }}">
                            @if ($errors->has('price'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('price') }}</strong>
                                  </span>
                            @endif
                          </div>
                        </div>

                        @if(isset($product))
                        <div class="form-group">
                          <label for="status" class="col-sm-3 control-label">Status:</label>
                          <div class="col-sm-2">
                              <select name="status" id="status" class="form-control select2" style="width: 100%;"{{ isset($product) ? '' : ' hidden' }}>
                                @foreach(Inzaana\Product::STATUS_FLOWS as $status)
                                    <option {{ $status == $product->status ? ' selected' : '' }}> {{ $status }} </option>                                    
                                @endforeach
                              </select>             
                          </div>
                        </div>
                        @endif
                        <!--<div class="form-group">
                            <label class="col-xs-3 control-label">Created Date:</label>
                            <div class="col-sm-2 date">
                                <div class="input-group input-append date" id="dateRangePicker">
                                    <input type="text" class="form-control" name="date" />
                                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                        </div>-->
                        
                       <!-- <div class="form-group{{ $errors->has('upload-image') ? ' has-error' : '' }}">
                          <label for="upload-image" class="col-sm-3 control-label">Upload Image:</label>
                          <div class="col-sm-9">
                            <input type="file" class="form-control" id="upload-image" name="upload-image">
                            @if ($errors->has('upload-image'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('upload-image') }}</strong>
                                  </span>
                            @endif
                          </div>
                        </div>-->

                        <div class="form-group{{ $errors->has('available_quantity') ? ' has-error' : '' }}">
                            <label for="available_quantity" class="col-sm-3 control-label">Available Quantity:</label>
                            <div class="col-sm-2">
                               <div class="input-group spinner">
                                  <input type="text" name="available_quantity" class="form-control"
                                         value="{{ isset($product) ? $product->available_quantity : Inzaana\Product::MIN_AVAILABLE_QUANTITY }}"
                                         min="{{ Inzaana\Product::MIN_AVAILABLE_QUANTITY }}"
                                         max="{{ Inzaana\Product::MAX_AVAILABLE_QUANTITY }}">

                                  <div class="input-group-btn-vertical">
                                    <button class="btn btn-default" type="button"><i class="fa fa-caret-up"></i></button>
                                    <button class="btn btn-default" type="button"><i class="fa fa-caret-down"></i></button>
                                  </div>
                                </div>
                                @if ($errors->has('available_quantity'))
                                  <span class="help-block">
                                    <strong>{{ $errors->first('available_quantity') }}</strong>
                                  </span>
                                @endif
                            </div>
                        </div>
                        

                        <!--<div class="form-group{{ $errors->has('return_time_limit') ? ' has-error' : '' }}">
                            <label for="return_time_limit" class="col-sm-3 control-label">Time limit For Return (in days)</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="return_time_limit" name="return_time_limit" placeholder="2 days">
                                @if ($errors->has('return_time_limit'))
                                  <span class="help-block">
                                    <strong>{{ $errors->first('return_time_limit') }}</strong>
                                  </span>
                                @endif
                            </div>
                            {{--<div class="col-sm-7 padT5"><b>$</b></div>--}}
                        </div>-->

                    </div>
                </div>
                
                
                <h4 class="block-title">Upload Media</h4>
                <div class="block-of-block">
                    <div id="product-create-upload-image" class="form-horizontal">

                        @for($i = 1; $i <= 4; ++$i)
                          <div class="form-group{{ ($errors->has('upload_image_' . $i)) ? ' has-error' : '' }}">
                            
                            <label for="upload_image" class="col-sm-3 control-label"> {{ $i == 1 ? 'Upload Image:' : '' }} </label>
                            
                            <div class="col-sm-3">
                              <input id="upload_image_{{ $i }}" name="upload_image_{{ $i }}" type="file" style="margin-top: 7px" placeholder="Include some file">
                              @if ($errors->has('upload_image_' . $i))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('upload_image_' . $i) }}</strong>
                                    </span>
                              @endif
                            </div>
                          </div>
                        @endfor

                        <div class="from-group">
                            <div class="row">
                               <label for="" class="col-sm-3 control-label"></label>
                                <div class="col-md-2">
                                  <div class="thumbnail">
                                    <a href="" target="_blank">
                                      <img id="preview-image-1" src="{{ isset($product) ? $product->thumbnail() : 'http://lorempixel.com/400/200/sports/' }}">
                                    </a>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="thumbnail">
                                    <a href="" target="_blank">
                                      <img id="preview-image-2" src="{{ isset($product) ? $product->thumbnail() : 'http://lorempixel.com/400/200/sports/' }}">
                                    </a>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="thumbnail">
                                    <a href="" target="_blank">
                                      <img id="preview-image-3" src="{{ isset($product) ? $product->thumbnail() : 'http://lorempixel.com/400/200/sports/' }}">
                                    </a>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="thumbnail">
                                    <a href="" target="_blank">
                                      <img id="preview-image-4" src="{{ isset($product) ? $product->thumbnail() : 'http://lorempixel.com/400/200/sports/' }}">
                                    </a>
                                  </div>
                                </div>
                             </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('upload_video') ? ' has-error' : '' }}">
                          <label for="upload_video" class="col-sm-3 control-label">Upload Video:</label>
                              <div class="col-sm-3">
                                <input id="upload_video" name="upload_video" type="file" style="margin-top: 7px" placeholder="Include some file">

                                @if ($errors->has('upload_video'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('upload_video') }}</strong>
                                      </span>
                                @endif
                              </div>                              
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label"></label>
                          <div class="checkbox col-sm-8">
                            <label><input id="has_embed_video" name="has_embed_video" type="checkbox" value="{{ isset($product_video_url) ? 'checked' : '' }}">Or Embed a Video.</label>
                          </div>
                        </div>

                        <div class="form-group{{ (isset($product) && isset($product_video_url)) ? '' : ' hidden' }} embed_video_form_group">
                           <label for="" class="col-sm-3 control-label"></label>
                            <div class="col-sm-8">
                                <div class="embed-responsive embed-responsive-4by3">
                                <iframe class="embed-responsive-item" src="{{ isset($product_video_url) ? $product_video_url : 'https://www.youtube.com/embed/5ixc2E7W-ec' }}"></iframe>
                            </div>
                            </div>
                        </div>
                        
                        <div class="form-group embed_video{{ $errors->has('embed_video_url') ? ' has-error' : '' }}">
                          <label for="embed_video" class="col-sm-3 control-label">Embed Video:</label>
                              <div class="col-sm-8">
                                <input type="text" class="form-control" id="embed_video_url" name="embed_video_url" placeholder="<iframe> url </iframe>">
                                <span class="help-block{{ $errors->has('embed_video_url') ? '' : ' hidden' }}">
                                    <strong>{{ $errors->first('embed_video_url') }}</strong>
                                </span>
                              </div>
                        </div>
                    </div>
                </div>
                
                <h4 class="block-title">Description</h4>
                <div class="block-of-block">
                    <div class="box-body">
                        <div>
                            <textarea class="textarea" placeholder="Product Description" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>
                    </div>
                </div>
                        
                <h4 class="block-title">Product Spec</h4>
                <div class="block-of-block">
                    <div id="product-create-spec" class="form-horizontal">
                        <div class="form-group">
                              <label for="spec_title" class="col-sm-3 control-label">Spec Title:</label>
                              <div class="col-sm-3">
                                <input type="text" class="form-control" id="spec_title" name="spec_title" placeholder="">
                                <input type="button" hidden>
                                      <!--<span class="help-block">
                                          <strong></strong>
                                      </span>-->
                              </div>
                                   
                                <!--<div class="col-sm-7 padT5"><b></b></div>-->
                        </div>
                        <div class="form-group">
                          <label  class="col-sm-3 control-label">Control Type:</label>
                          <div class="col-sm-3">
                            <select id="control_type" name="control_type" class="form-control"  data-placeholder="Control Type" style="width: 100%;">
                              @foreach(Inzaana\Product::VIEW_TYPES['group'] as $id => $control)
                                <option value="{{ $id }}">{{ $control }}</option>
                              @endforeach
                              @foreach(Inzaana\Product::VIEW_TYPES['single'] as $id => $control)
                                <option value="{{ $id }}">{{ $control }}</option>
                              @endforeach
                            </select>
                            <input type="button" hidden>
                          </div>
                        </div>
                        <div class="form-group">

                          <label class="col-sm-3 control-label">Value:</label>

                          <div id="input" class="col-sm-3 spec-controls" hidden="">
                            <input type="text" class="form-control" id="single_spec" name="single_spec" placeholder="">
                            <input type="button" hidden>
                          </div>
                          
                          <div id="options" class="col-sm-3 spec-controls" hidden="">
                            <div class="radio">
                                  <label><input type="radio" id="optradio" name="optradio">---</label>
                            </div>
                          </div>
                          
                          <div id="dropdown" class="col-sm-3 spec-controls" hidden="">
                            <select id="optdropdown" name="optdropdown" class="form-control"  data-placeholder="" style="width: 100%;">
                              <option>---</option>
                            </select>
                          </div>
                          
                          <div id="spinner" class="spec-controls" hidden="">
                              <div class="col-sm-1">
                                <div class="input-group spinner">
                                    <input type="text" class="form-control" id="optspinner_min" name="optspinner_min" placeholder=""> 
                                  </div>
                              </div>
                              <div class="col-sm-1">
                                  <label  class="col-sm-1 control-label">To</label>
                              </div>
                              <div class="col-sm-1">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="optspinner_max" name="optspinner_max" placeholder=""> 
                                  </div>
                              </div>
                          </div>
                          
                          <div class="col-sm-2 add-option" hidden="">
                              <button id="add-option-btn" class="btn btn-default btn-flat"><i class="fa fa-plus"></i> </button>
                          </div>
                          
                        </div>
                        <div class="form-group">

                          <label class="col-sm-3 control-label"></label>

                          <div class="col-sm-3 add-option">
                            <input type="text" class="form-control" id="option_input" name="option_input" placeholder="Type new value to add above">
                          </div>

                        </div>
                        <div class="form-group">
                          <label  class="col-sm-3 control-label"></label>
                          <div class="col-sm-3">
                            <button id="apply_spec" name="apply_spec" class="btn btn-default btn-flat">Apply</button>                            
                          </div>
                        </div>
                    </div>
                    
                    <div class="panel">
                    <div class="panel-body">
                        <input name="spec_count" id="spec_count" type="text" value="0" hidden>
                        <table class="table table-hover table-condensed table-bordered text-center spec-table">
                            <thead>
                            <tr>
                                <th>Spec Title</th>
                                <th>Option Type</th>
                                <th>Values</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>---- <input name="title_1" type="text" value="" hidden></td>
                                <td>---- <input name="option_1" type="text" value="" hidden></td>
                                <td>---- <input name="values_1" type="text" value="" hidden></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
                        
                <h4 class="block-title">Availability</h4>
                <div class="block-of-block">
                    <div id="product-create-privacy" class="form-horizontal">
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"></label>
                            <div class="col-sm-3" >
                                <div class="checkbox">
                                  <label><input id="is_public" name="is_public" type="checkbox" value="checked">Make this product public.</label>
                                </div>
                          </div>
                        </div>
                    </div>
                </div>        
                                
                
                <div class="modal-footer">
                  <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary btn-flat">Save</button>
                  <input id="btn-reset-product-form" type="reset" value="Reset" hidden>
                </div>

              </form>
              <!-- form ends -->

            </div>
            

            <div id="tab-messages" class="tab-pane fade in{{ ($tab == 'bulk_product_entry_tab') ? ' active' : '' }}">
                <div class=" form-horizontal">

                      <form action="{{ route('user::products.upload.csv') }}" method="POST" enctype="multipart/form-data" id="js-upload-form">
                        
                        {!! csrf_field() !!}

                        <div>
                          <label class="col-sm-3 control-label">Select store</label>
                            <div class="col-sm-7">
                                    
                              <select name="stores" id="stores" class="form-control select2" multiple="multiple" data-placeholder="Select Store" style="width: 100%;">
                                @foreach($stores as $name_as_url => $name)
                                    <option value="{{ $name_as_url }}"> {{ $name_as_url }}.inzaana.com ( {{ $name }} ) </option>                                    
                                @endforeach
                              </select>
                            </div>
                        </div>
                        
                        <br>

                        <div class="text-center">
                             
                          <!-- Standard Form -->
                          <h3>Select files from your computer</h3>


                          <div class="form-inline">
                            <div class="form-group">
                              <input type="file" name="csv" id="csv" multiple>
                            </div>                              
                          </div>

                          <!-- Drop Zone -->
                          <h4>Or drag and drop files below</h4>
                          <div class="upload-drop-zone" id="drop-zone">
                            Just drag and drop files here
                          </div>
                        </div>
                        
                        <div class="modal-footer">

                          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary btn-flat">Upload Files</button>
                        </div>

                      </form>
                      

                </div>
            </div>
        </div>
      
    </div>
  </div>
    
</div>
    <!--end add product modal-->
    
    <!--recently added product-->
    <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Recently Added product</h3>
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
                      <!-- <th>ID</th> -->
                      <th>Product Name</th>
                      <th>Category</th>
                      <th>Sub Category</th>
                      <th>MRP</th>
                      <th>Discount</th>
                      <th>Price</th>
                      <th>Image</th>
                      <th>Available Quantity</th>
                      <th>Time Limit For Return (in days)</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>

                  @if(isset($products))
                    @foreach( $products as $product )

                      @if($product->marketProduct())
                        <tr>
                          <!-- <td id="child"><a href="">001</a> </td> -->
                          <td id="child"><a href="">{{ $product->title }}</a></td>
                          <td id="child"><a href="">{{ $product->categoryName() }}</a></td>
                          <td id="child"><a href=""></a></td> <!-- sub category-->
                          <td id="child"><a href="">{{ $product->mrp }}</a></td>
                          <td id="child"><a href="">{{ $product->discount }} %</a></td>
                          <td id="child"><a href="">$ {{ $product->marketProduct()->price }}</a></td>
                          <td id="child">
                            <!-- <a data-toggle="modal" data-target="#viewImage"> -->
                            <a data-toggle="modal" data-target="">
                              <img src="{{ $product->thumbnail() }}" height="60px" width="90px"/>
                            </a>
                          </td>
                          <td id="child"><a href="">{{ $product->available_quantity }}</a></td> <!-- Available quantity-->
                          <td id="child"><a href="">{{ $product->return_time_limit }}</a></td> <!-- Time limit for return-->
                          <td id="child">@include('includes.approval-label', [ 'status' => $product->status, 'labelText' => $product->getStatus() ])</td>
                          <td class="text-center" id="child">
                            <form id="product-modification-form" class="form-horizontal" method="POST" >
                              {!! csrf_field() !!}
                              <input formaction="{{ route('user::products.edit', [$product]) }}" id="product-edit-btn" class="btn btn-info btn-flat btn-xs" type="submit" value="Edit"></input>
                              <input formaction="{{ route('user::products.delete', [$product]) }}" id="product-delete-btn" class="btn btn-info btn-flat btn-xs" type="submit" value="Delete"></input>
                            </form>
                          </td>
                        </tr>
                      @endif

                    @endforeach
                  @endif
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
    </div>

    <!--end of recently added product-->

<!--View product modal-->
<div id="viewImage" class="modal fade" role="dialog">
    
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Product Details - Quick View</h4>
      </div>
      <div class="modal-body">
          <div class="row">
      <div class="col-md-6  padT10">
        <img class="img-responsive imgborder" data-toggle="magnify" src="{{ URL::asset('images/kitkat-300x300.jpg') }}" />
      </div>
      <div class="col-md-6">
        <h3 class="padmar0 headtext1">Kitkat 25RS</h3>
        <p>ID:0001</p>
        <p>Category: Chocolate</p>
        <h4>$2.99</h4>
        <p class="sku">30% discount!</p>
          <span class="label label-success">In Stock</span>
        <hr>
        <h5>Product Info</h5>
        <p class="slidePara1">I'm a product details. Quibusdam minim occaecat, eu fugiat lorem ea cupidatat. Do et enim deserunt nam duis imitarentur occaecat noster eiusmod. Ita iis tamen quorum aliqua e quamquam sunt mandaremus arbitror. Occaecat concursionibus ne doctrina, do hic anim labore noster.</p>
      </div>
    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
    
</div>
    <!--end View product modal-->

@endsection

@section('footer-scripts')

  <script src="{{ asset('data-requests/element-data-manager-1.1.js') }}" type="text/javascript"></script>
  <script src="{{ asset('form-validation/add-product-validation.js') }}" type="text/javascript"></script>
  
<!-- <script src="{{ asset('data-requests/products-data-provider.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/product-search-events.js') }}" type="text/javascript"></script>
   -->
  <script src="{{ asset('js/select2.full.min.js') }}" type="text/javascript"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
  <script>
    function matchStart (term, text) {
      if (text.toUpperCase().indexOf(term.toUpperCase()) == 0) {
        return true;
      }
     
      return false;
    }
     
    $.fn.select2.amd.require(['select2/compat/matcher'], function (oldMatcher) {
      $("select").select2({
        matcher: oldMatcher(matchStart)
      })
    });
  </script>

  <script type="text/javascript">

    function productFormEvents()
    {
        $('#product-form-open-button').click(function(){

              console.log($('#product-create-form').attr("action"));
              $('#product-create-form').attr("action", "{{ route('user::products.create') }}");
              $('#btn-reset-product-form').click();
              $("select[id='status']").addClass("hidden");
              console.log($("select[id='status']").is(":hidden"));
              console.log('Changed action to:' + $('#product-create-form').attr("action"));
        });

        $('#embed_video_url').focusout(onUrlPaste);
    }

    function specResetOnly() {

        $(this.previousSibling).val(function() {
            return this.defaultValue;
        });
    }

    function specControlEvents()
    {
        $('#input').prop("hidden", "");
        $('.add-option').prop("hidden", "hidden");
        $( "input[type='button']" ).bind( "click", specResetOnly );

        $('#control_type').change( function(event) {

            var controlId = this.value;
            var showDefault = false;

            if(this.value == 'dropdown' || this.value == 'options')
            {
                $('#' + this.value).prop("hidden", "");
                $('.add-option').prop("hidden", "");
            }
            else if(this.value == 'spinner')
            {
                $('#' + this.value).prop("hidden", "");
            }
            else
            {
                showDefault = true;
            }
            $.each($('.spec-controls'), function(index, value) {

                if(value.id != controlId)
                {
                    $('#' + value.id).prop("hidden", "hidden");
                }
            });
            if(showDefault)
            {
                $('#input').prop("hidden", "");
                $('.add-option').prop("hidden", "hidden");
            }
        });

        var specs = '';
        var spec_count = 0;
        var options = '';
        var optionCount = 0;

        $('#apply_spec').click( function(e) {

            e.preventDefault();
            ;
            $('#spec_count').val(++spec_count);

            var specValues = optionCount > 0 ? '' : $('#single_spec').val();

            $('select#optdropdown option').each(function(index, option) {

                  specValues += $(option).val() + ', ';  
            });
            for(var charIndex = specValues.length - 1, charCount = 0; charCount < 2; --charIndex)
            {
                specValues[charIndex] = '';
            }
            console.log(specValues);

            specs += '<tr>';
            specs += '<td>' + $('#spec_title').val() + ' <input name="title_' + spec_count + '" type="text" value="' + $('#spec_title').val() + '" hidden></td>';
            specs += '<td>' +  $('#control_type').val() + ' <input name="option_' + spec_count + '" type="text" value="' +  $('#control_type').val() + '" hidden></td>';
            specs += '<td>' + $('#single_spec').val() + ' <input name="values_' + spec_count + '" type="text" value="' + specValues + '" hidden></td>';
            specs += '</tr>';

            $('table.spec-table tbody').html(specs);

            $( "input[type='button']" ).bind( "click", specResetOnly );

            // IMPORTANT to reset options entered last time
            options = '';
            optionCount = 0;
        });

        $('#add-option-btn').click(function(e) {

            e.preventDefault();

            var selectedControlType = $('#control_type').val();
            console.log(selectedControlType);

            var optionInput = $('#option_input').val();
            if(selectedControlType == 'dropdown')
            {
                ++optionCount;
                options += '<option>' + optionInput + '</option>';
                $('#optdropdown').html(options);
                return;
            }
            if(selectedControlType == 'options')
            {
                ++optionCount;
                options += '<div class="radio">';
                options += '<label><input type="radio" id="optradio_' + optionCount + '" name="optradio_' + optionCount + '">' + optionInput + '</label>';
                options += '</div>';
                $('#options').html(options);
                return;
            }
        });
    }
  
    $('#generalTabContent').ready(function() {
        var showModal = ($('div.has-error').length > 0 || $('div.is-edit').length > 0);
        $('#addProduct').modal({ 'show' : showModal });
        
        onChangeEmbedVideoCheck();
        $( "#has_embed_video" ).change(onChangeEmbedVideoCheck);

        spinnerEvents();
        specControlEvents();
        productFormEvents();
    });

    function onChangeEmbedVideoCheck() {
       
        if($('.embed_video').is(':hidden'))
        {
            $( ".embed_video" ).hide( "fast", function() {});
        }
        if($('#has_embed_video').is(':checked'))
        {
            $( ".embed_video" ).show( 1000 );
        }
        else
        {
            $( ".embed_video" ).hide( "fast", function() {});
        }
        if($('#has_embed_video').is(':checked') && $( ".embed_video" ).hasClass( "has-error" ) )
        {
            $( ".embed_video" ).show( 1000 );

            if(!$('#has_embed_video').is(':checked'))
            {
                $( "#has_embed_video" ).prop('checked', 'checked');
            }
        }
        else
        {
            $( ".embed_video" ).removeClass( "has-error" );
            $( ".embed_video" ).find("strong").html("");
        }
    }
  </script>

  <script>
              
    // + function($) {
    //       'use strict';

    //       // UPLOAD CLASS DEFINITION
    //       // ======================

    //       var dropZone = document.getElementById('drop-zone');
    //       var uploadForm = document.getElementById('js-upload-form');

    //       var startUpload = function(files) {
    //           console.log(files)
    //           // var fileView = '<ul>';
    //           // $.each(files, function(index, item){
    //           //     fileView += '<li>' + item.name + '</li>';
    //           // });
    //           // fileView += '<ul>';
    //           // $('#drop-zone').html(fileView);
    //       }


    //       // uploadForm.addEventListener('submit', function(e) {
    //       //     var uploadFiles = document.getElementById('csv').files;
    //       //     e.preventDefault()


    //       //     startUpload(uploadFiles)
    //       // });

    //       dropZone.ondrop = function(e) {
    //           e.preventDefault();
    //           this.className = 'upload-drop-zone';

    //           startUpload(e.dataTransfer.files)
    //       }

    //       dropZone.ondragover = function() {
    //           this.className = 'upload-drop-zone drop';
    //           return false;
    //       }

    //       dropZone.ondragleave = function() {
    //           this.className = 'upload-drop-zone';
    //           return false;
    //       }


    //   }(jQuery);

  </script>

<script>
    // $(document).ready(function() {
    //     $('#dateRangePicker').datepicker({
    //           format: 'mm/dd/yyyy',
    //           startDate: '01/01/2010',
    //           endDate: '12/30/2020'
    //       })
    //       .on('changeDate', function(e) {
    //           // Revalidate the date field
    //           $('#dateRangeForm').formValidation('revalidateField', 'date');
    //       });

    //       $('#dateRangeForm').formValidation({
    //           framework: 'bootstrap',
    //           icon: {
    //               valid: 'glyphicon glyphicon-ok',
    //               invalid: 'glyphicon glyphicon-remove',
    //               validating: 'glyphicon glyphicon-refresh'
    //           },
    //           fields: {
    //               date: {
    //                   validators: {
    //                       notEmpty: {
    //                           message: 'The date is required'
    //                       },
    //                       date: {
    //                           format: 'MM/DD/YYYY',
    //                           min: '01/01/2010',
    //                           max: '12/30/2020',
    //                           message: 'The date is not a valid'
    //                       }
    //                   }
    //               }
    //           }
    //       });
    // });
</script>

<script> /*for spinner*/
  function spinnerEvents()
  {
      $('.spinner .btn:first-of-type').on('click', function() {
          var btn = $(this);
          var input = btn.closest('.spinner').find('input');
          if (input.attr('max') == undefined || parseInt(input.val()) < parseInt(input.attr('max'))) {    
            input.val(parseInt(input.val(), 10) + 1);
          } else {
            btn.next("disabled", true);
          }
      });
      $('.spinner .btn:last-of-type').on('click', function() {
          var btn = $(this);
          var input = btn.closest('.spinner').find('input');
          if (input.attr('min') == undefined || parseInt(input.val()) > parseInt(input.attr('min'))) {    
            input.val(parseInt(input.val(), 10) - 1);
          } else {
            btn.prev("disabled", true);
          }
      });
  }

</script>

<!-- background image loader on browse -->
<script type="text/javascript">

  var totalMediaLoaded = 0;
  var fileLimit = 5;
  var reader = new FileReader();
  reader.addEventListener("load", function() {
     setBackgroundImage( $('#preview-image-' + (++totalMediaLoaded)) , reader.result);
  }, false);

  function setBackgroundImage(control, image_url) {
    // console.log("[DEBUG] Setting BG Image : " + control.attr("id") + " : " + image_url );
    // control.css("background-image", "url(" + image_url + ")");
    control.attr("src", image_url);
    // console.log("[DEBUG] BG Image URL : " + control.css("background-image"));
    // console.log("[DEBUG] BG Image URL : " + control.attr("src"));
  }
  function onBrowseFile(event) {
      // var fileName = $(this).val();
      // console.log(fileName);
      var file = event.target.files[0];
      if (file && totalMediaLoaded < fileLimit)
      {
          reader.readAsDataURL(file);
      }
  }

  for(var i = 1; i < fileLimit; ++i)
    $('#upload_image_' + i).change( onBrowseFile );
  
</script>
<script type="text/javascript">
  // $('#product-create-form').ready( function() {

  //     alert('Form');

  //     var contexts = [{ prefix: 'products', route: '/create' }];
  //     ElementDataManager.contexts = contexts;
  //     ElementDataManager.element = '#product-create-form';
  //     alert(ElementDataManager.element);
  //     ElementDataManager.send(null, function(data) {

  //         if(isEmpty(data) || isEmpty(data.context))
  //         {
  //             return;
  //         }
  //         if(data.context == 'products')
  //         {
  //             if(!data.success)
  //             {
  //                 return;
  //             }

  //             hideSavingIcon();

  //             alert(data.test);
  //         }
  //     });
  // });
</script>
@endsection
