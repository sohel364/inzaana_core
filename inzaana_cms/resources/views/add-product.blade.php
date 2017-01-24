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
                            <h5>Results on Inzaana.com &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b>1</b> to <b>{{ count($productsBySearch) > 0 ? $productsBySearch->count() : 0 }}</b> of <b>{{ count($productsBySearch) > 0 ? $productsBySearch->total() : 0 }}</b> results.</h5>
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
                                            <td id="photo">
                                                <a  data-toggle="modal" 
                                                    data-product_url="{{ route('user::products.quick.view', [$productFromSearch]) }}"
                                                    data-target="#_view_detail_{{ $productFromSearch->id }}">
                                                    <img src="{{ $productFromSearch->thumbnail() }}" height="50px" width="80px"/></a>
                                            </td>

                                            <td id="product">{{ $productFromSearch->title }}</td>
                                            <td id="category">{{ $productFromSearch->marketProduct()->category->name or 'Uncategorized' }}</td>
                                            <td id="sellyours">
                                                <form method="POST">
                                                    {!! csrf_field() !!}
                                                    <input formaction="{{ route('user::products.sell-yours', [$productFromSearch]) }}" class="btn btn-info btn-flat btn-sm" type="submit" value="Sell yours">
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                            <div class="col-sm-12 noPadMar text-center">
                                
                                {{ count($productsBySearch) > 0 ? $productsBySearch->appends([ 'search-box' => $search_terms ])->links() : '' }}

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
                                                    @foreach(Inzaana\Product::EXISTANCE_TYPE as $key => $type)
                                                        <option value="{{ $key }}" {{ (isset($product) && $key == $product->type) ? ' selected' : '' }}> {{ $type }} </option>
                                                    @endforeach
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
                                                        @if(isset($product))
                                                            @foreach(Inzaana\Product::STATUS_FLOWS as $status)
                                                                <option {{ $status == $product->status ? ' selected' : '' }}> {{ $status }} </option>
                                                            @endforeach
                                                        @endif
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
                                                            <img id="preview-image-1" src="{{ isset($product) ? $product->previewImage(0) : Inzaana\Product::defaultImage() }}">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="thumbnail">
                                                        <a href="" target="_blank">
                                                            <img id="preview-image-2" src="{{ isset($product) ? $product->previewImage(1) : Inzaana\Product::defaultImage() }}">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="thumbnail">
                                                        <a href="" target="_blank">
                                                            <img id="preview-image-3" src="{{ isset($product) ? $product->previewImage(2) : Inzaana\Product::defaultImage() }}">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="thumbnail">
                                                        <a href="" target="_blank">
                                                            <img id="preview-image-4" src="{{ isset($product) ? $product->previewImage(3) : Inzaana\Product::defaultImage() }}">
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
                                                <label><input id="has_embed_video" name="has_embed_video" type="checkbox" value="{{ isset($product) && !$product->hasEmbedVideo() ? 'checked' : '' }}"{{ isset($product) && !$product->hasEmbedVideo() ? ' checked' : '' }}>Or Embed a Video.</label>
                                            </div>
                                        </div>

                                        <div class="form-group{{ (isset($product) && $product->hasEmbedVideo()) ? '' : ' hidden' }} embed_video_form_group">
                                            <label for="" class="col-sm-3 control-label"></label>
                                            <div class="col-sm-8">
                                                <div class="embed-responsive embed-responsive-4by3">
                                                    <div id="embed_iframe">

                                                        @if(isset($product) && $product->hasEmbedVideo())

                                                            {!! $product->videoEmbedUrl()['url'] !!}

                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group embed_video{{ $errors->has('embed_video_url') ? ' has-error' : '' }}">
                                            <label for="embed_video" class="col-sm-3 control-label">Embed Video:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control"
                                                       id="embed_video_url" name="embed_video_url" placeholder="<iframe> url </iframe>"
                                                       value="{{ isset($product) ? $product->videoEmbedUrl()['url'] : '' }}">

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
                            <textarea name="description" class="textarea" placeholder="Product Description"
                                      style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"
                            >{{ isset($product) ? $product->description : old('description') }}</textarea>
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
                                                    <label for="optradio_1"><input type="radio" id="optradio" name="optradio">---</label>
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
                                            <input name="spec_count" id="spec_count" type="text" value="{{ isset($product) ? count($product->specialSpecs()) : 0 }}" hidden>
                                            <table id="spac_table" class="table table-hover table-condensed table-bordered text-center spec-table">
                                                <thead>
                                                <tr>
                                                    <th>Spec Title</th>
                                                    <th>Option Type</th>
                                                    <th>Values</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody><!-- $product->specialSpecs() -->
                                                @if(isset($product))

                                                    @each('includes.product-special-specs', $product->specialSpecs(), 'properties', 'includes.product-specs-empty')

                                                @else

                                                    @include('includes.product-specs-empty')

                                                @endif
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
                                                    <label><input id="is_public" name="is_public" type="checkbox" {{ isset($product) ? ($product->is_public ? 'checked="checked"' : old('is_public')) : '' }}>Make this product public.</label>
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
                                        <tr id="product_{{ $product->id }}">
                                            <!-- <td id="child"><a href="">001</a> </td> -->
                                            <td id="child"><a href="">{{ $product->title }}</a></td>
                                            <td id="child"><a href="">{{ $product->categoryName() }}</a></td>
                                            <td id="child"><a href=""></a></td> <!-- sub category-->
                                            <td id="child"><a href="">{{ $product->mrp }}</a></td>
                                            <td id="child"><a href="">{{ $product->discount }} %</a></td>
                                            <td id="child"><a href="">₹ {{ $product->marketProduct()->price }}</a></td>
                                            <td id="child">
                                                <a data-toggle="modal" id="view_detail" data-product_url="{{ route('user::products.quick.view', [$product]) }}"  data-target="#_view_detail_{{ $product->id }}">
                                                    <img src="{{ $product->thumbnail() }}" height="60px" width="90px"/>
                                                </a>
                                            </td>
                                            <td id="child"><a href="">{{ $product->available_quantity }}</a></td> <!-- Available quantity-->
                                            <td id="child"><a href="">{{ $product->return_time_limit }}</a></td> <!-- Time limit for return-->
                                            <td id="child">@include('includes.approval-label', [ 'status' => $product->status, 'labelText' => $product->getStatus() ])</td>
                                            <td class="text-center" id="child">
                                                <form id="product-modification-form" class="form-horizontal" method="POST" >
                                                    {!! csrf_field() !!}
                                                    <input formaction="{{ route('user::products.edit', [$product]) }}" id="product-edit-btn" class="btn btn-info btn-flat btn-xs" type="submit" value="Edit">
                                                    <input class="btn btn-info btn-flat btn-xs" type="button" data-toggle="modal" data-target="#confirm_remove_{{ $product->id }}_disabled" data-product_id="{{ $product->id }}" data-url="{{ route('user::products.delete', [$product]) }}" id="product_del_btn" value="Delete">
                                                </form>
                                            </td>
                                        </tr>

                                    @endif

                                @endforeach
                            @endif
                        </table>
                        <div class="col-sm-12 noPadMar text-center">
                        {{ $products->links() }}
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>

        <!--end of recently added product-->

        @each('includes.product-delete-confirm-modal', $products, 'product')

        <div id="modal_container">{{--Modal load here--}}</div>

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
                /* Sk Asadur Rahman Script*/
                $(document).on('click','#view_detail', function (e) {
                    e.preventDefault();
                    var url = $(this).data('product_url');
                    //alert(id);
                    $.ajax({
                        async: true,
                        type: 'GET',
                        url: url, // you need change it.
                        processData: false, // high importance!
                        success: function (data) {
                            //alert(data);
                            $('#modal_container').html(data);
                            $('#modal_open').modal('show');
                        },
                        error: function(data){

                        },
                        timeout: 10000
                    });
                });

                $(document).on('click','#product_del_btn',function(e){
                    e.preventDefault();
                    var c = confirm("Are you sure want to delete this product?");
                    if(c) {
                        var id = $(this).data('product_id')
                        var product_id = "#product_" + id;
                        //$(product_id).closest('tr').remove();
                        var url = $(this).data('url');
                        var formData = $(this).serialize();
                        $.ajax({
                            async: true,
                            type: 'POST',
                            data: formData,
                            url: url, // you need change it.
                            processData: false, // high importance!
                            success: function (data) {
                                if(data['status'] == 1){
                                    $(product_id).closest('tr').remove();
                                    alert(data['msg']);
                                }

                            },
                            error: function (data) {

                            },
                            timeout: 10000
                        });
                    }

                });
            </script>
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
                        console.log('Changed action to:' + $('#product-create-form').attr("action"));

                        // var defaultSetter = function(index, input) {

                        //       $(this).val("");
                        // };
                        // $('#product-create-form').find("select").each(defaultSetter);
                        // $('#product-create-form').find("input").each(defaultSetter);
                        // $("select#status").addClass("hidden");
                        // console.log($("select#status").is(":hidden"));
                    });

                    $('#embed_video_url').focusout(onUrlPaste);
                }

                function specControlEvents()
                {
                    $('#input').prop("hidden", "");
                    $('.add-option').prop("hidden", "hidden");

                    $('#control_type').val("input");
                    $('#control_type').change();

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
                            $('.add-option').prop("hidden", "hidden");
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

                    var isEdit = $('div.is-edit').length > 0;
                    var specs = '';
                    var spec_count = $('#spec_count').val();
                    var options = '';
                    var optionCount = 0;
                    var firstTime = true;

                    $('#apply_spec').click( function(e) {

                        e.preventDefault();

                        ++spec_count;

                        var specValues = optionCount > 0 ? '' : $('#single_spec').val();

                        var selectedControlType = $('#control_type').val();
                        console.log(selectedControlType);

                        if(selectedControlType == 'dropdown')
                        {
                            specValues = $('select#optdropdown option').map( function() {
                                return this.value;
                            }).get().join(",");
                        }
                        if(selectedControlType == 'options')
                        {
                            specValues = $("input[type='radio']").map(function() {
                                var idVal = $(this).attr("id");
                                return $("label[for='"+idVal+"']").text();
                            }).get().join(",");
                        }
                        if(selectedControlType == 'spinner')
                        {
                            specValues = $('#optspinner_min').val() + ' ~ ' + $('#optspinner_max').val();
                        }

                        specs += '<tr>';
                        specs += '<td>' + $('#spec_title').val() + ' <input name="title_' + spec_count + '" type="text" value="' + $('#spec_title').val() + '" hidden></td>';
                        specs += '<td>' +  $('#control_type').val() + ' <input name="option_' + spec_count + '" type="text" value="' +  $('#control_type').val() + '" hidden></td>';
                        specs += '<td>' + specValues + ' <input name="values_' + spec_count + '" type="text" value="' + specValues + '" hidden></td>';
                        specs += '<td><a href="#" id="delete_me" class="btn btn-xs btn-danger">x</a></td>';
                        specs += '</tr>';

                        console.log(specValues);
                        if($('#spec_count').val() == 0)
                            $('table.spec-table tbody').html(specs);
                        else
                            $('table.spec-table tbody').append(specs);

                        specs = '';

                        $('#spec_count').val($('table.spec-table tbody tr').length);

                        console.log('applied specs: ' + $('#spec_count').val());

                        $('#option_input').val("");
                        $('#spec_title').val("");
                        $('#single_spec').val("");

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
                        }
                        if(selectedControlType == 'options')
                        {
                            ++optionCount;
                            options += '<div class="radio">';
                            options += '<label for="optradio_' + optionCount + '"><input type="radio" id="optradio_' + optionCount + '" name="optradio_' + optionCount + '">' + optionInput + '</label>';
                            options += '</div>';
                            $('#options').html(options);
                        }
                        $('#option_input').val("");
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

                        if(!$('#has_embed_video').is(':checked'))
                        {
                            $( "#has_embed_video" ).prop('checked', 'checked');
                        }
                    }
                    if($('#has_embed_video').is(':checked') || $( ".embed_video" ).hasClass( "has-error" ))
                    {
                        $( ".embed_video" ).show( 1000 );
                    }
                    else
                    {
                        $( ".embed_video" ).hide( "fast", function() {});
                        $( ".embed_video" ).removeClass( "has-error" );
                        $( ".embed_video" ).find("strong").html("");
                    }
                }
            </script>
            <script>
                $(document).on('click','#delete_me',function(e){
                    e.preventDefault();
                    $('#delete_me').parent().parent().remove();
                });
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

                    var imgHTML = $('#preview-image-' + (++totalMediaLoaded));
                    var imageIndexToLoad = totalMediaLoaded;
                    while(imageIndexToLoad++)
                    {
                        if(imgHTML.attr("src").indexOf('default_product.jpg') > -1)
                        {
                            setBackgroundImage( imgHTML , reader.result);
                            break;
                        }
                        imgHTML = $('#preview-image-' + imageIndexToLoad);
                    }
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
