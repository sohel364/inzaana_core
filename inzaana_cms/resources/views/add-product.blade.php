@extends('layouts.admin-master')
@section('title', 'Add Product')

@section('header-style')
 <link href="{{ URL::asset('css/select2.min.css') }}" rel="stylesheet" type="text/css">  
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
            <form action="/products/search" method="GET">
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
                                <h4 class="C-header">If it is not in Inaana's catalog:</h4>
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
                <div class="box box-down box-info">
                    <div class="boxed-header">
                        <h5>Results on Inzaana.com &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b>1</b> to <b>5</b> of <b>{{ $productsCount }}</b> results.</h5>
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
                      @foreach($productsBySearch as $product)
                      <tr>
                          <td id="photo"><a data-toggle="modal" data-target="#viewImage"><img src="{{ $product->photo_name }}" height="50px" width="80px"/></a></td>
                          <td id="product">{{ $product->product_title }}</td>
                          <td id="category">{{ $product->category->category_name or 'Uncategorized' }}</td>
                          <td id="sellyours">
                            <form method="POST">
                              {!! csrf_field() !!}
                              <input formaction="{{ route('user::products.sell-yours', [$product->id]) }}" class="btn btn-info btn-flat btn-sm" type="submit" value="Sell yours"></input>
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
    
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Product Details</h4>
      </div>
      <!-- form start -->
      <form id="product-create-form" class="form-horizontal" action="{{ route('user::products.create') }}" method="POST">

        {!! csrf_field() !!}

        @if (count($errors) > 1)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="modal-body">
            <div class="form-group">
              <label  class="col-sm-3 control-label">Product Category:</label>
              <div class="col-sm-7">
                <select name="category" class="form-control select2" multiple="multiple" data-placeholder="Select a Category" style="width: 100%;">

                @if(isset($categories))
                  @foreach( $categories as $category )
                  <option>{{ $category->category_name or 'Uncategorized' }}</option>
                  @endforeach
                @endif
                </select>
              </div>
              <div class="col-sm-2">
                  <button class="btn btn-info btn-flat"><i class="fa fa-plus"></i> </button>
              </div>
            </div>
            <div class="form-group{{ $errors->has('product_title') ? ' has-error' : '' }}">
              <label for="product-title" class="col-sm-3 control-label">Product Title:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="product-title" name="product-title" placeholder="ex: kitka 5RS">
                @if ($errors->has('product_title'))
                      <span class="help-block">
                          <strong>{{ $errors->first('product_title') }}</strong>
                      </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('manufacturer') ? ' has-error' : '' }}">
              <label for="Manufacturer" class="col-sm-3 control-label">Manufacturer</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="manufacturer" name="manufacturer" placeholder="ex: dairy milk">
                @if ($errors->has('manufacturer'))
                      <span class="help-block">
                          <strong>{{ $errors->first('manufacturer') }}</strong>
                      </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('mrp') ? ' has-error' : '' }}">
              <label for="mrp" class="col-sm-3 control-label">MRP:</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" id="mrp" name="mrp" placeholder="ex: 3$">
                @if ($errors->has('mrp'))
                      <span class="help-block">
                          <strong>{{ $errors->first('mrp') }}</strong>
                      </span>
                @endif
              </div>
                <div class="col-sm-7 padT5"><b>$</b></div>
            </div>
            <div class="form-group{{ $errors->has('discount') ? ' has-error' : '' }}">
              <label for="discount" class="col-sm-3 control-label">Discount:</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" id="discount" name="discount" placeholder="ex: 30%">
                @if ($errors->has('discount'))
                      <span class="help-block">
                          <strong>{{ $errors->first('discount') }}</strong>
                      </span>
                @endif
              </div>
                <div class="col-sm-7 padT5"><b>%</b></div>
            </div>
            <div class="form-group{{ $errors->has('selling-price') ? ' has-error' : '' }}">
              <label for="selling-price" class="col-sm-3 control-label">Selling Price:</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" id="selling-price" name="selling-price" placeholder="ex: 3$">
                @if ($errors->has('selling-price'))
                      <span class="help-block">
                          <strong>{{ $errors->first('selling-price') }}</strong>
                      </span>
                @endif
              </div>
                <div class="col-sm-7 padT5"><b>$</b></div>
            </div>
            <div class="form-group{{ $errors->has('upload-image') ? ' has-error' : '' }}">
              <label for="upload-image" class="col-sm-3 control-label">Upload Image:</label>
              <div class="col-sm-9">
                <input type="file" class="form-control" id="upload-image" name="upload-image">
                @if ($errors->has('upload-image'))
                      <span class="help-block">
                          <strong>{{ $errors->first('upload-image') }}</strong>
                      </span>
                @endif
              </div>
            </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btn-flat">Save</button>
        </div>

      </form>
      <!-- form ends -->

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
                      <th>MRP</th>
                      <th>Discount</th>
                      <th>Price</th>
                      <th>Image</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>

                  @if(isset($products))
                    @foreach( $products as $product )
                    <tr>
                      <!-- <td id="child"><a href="">001</a> </td> -->
                      <td id="child"><a href="">{{ $product->product_title }}</a></td>
                      <td id="child"><a href="">{{ $product->category ? $product->category->category_name : 'Uncategorized' }}</a></td>
                      <td id="child"><a href="">{{ $product->product_mrp }}</a></td>
                      <td id="child"><a href="">{{ $product->product_discount }} %</a></td>
                      <td id="child"><a href="">$ {{ $product->selling_price }}</a></td>
                      <td id="child"><a data-toggle="modal" data-target="#viewImage"><img src="{{ $product->photo_name }}" height="60px" width="90px"/></a></td>
                      <td id="child"><a href=""><span class="label label-success">{{ $product->getStatus() }}</span></a></td>
                      <td class="text-center" id="child">
                        <form id="product-modification-form" class="form-horizontal" method="POST" >
                          {!! csrf_field() !!}
                          <input formaction="{{ route('user::products.edit', [$product->id]) }}" id="product-edit-btn" class="btn btn-info btn-flat btn-xs" type="submit" value="Edit"></input>
                          <input formaction="{{ route('user::products.delete', [$product->id]) }}" id="product-delete-btn" class="btn btn-info btn-flat btn-xs" type="submit" value="Delete"></input>
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
  <script src="{{ asset('js/product-search-events.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/select2.full.min.js') }}" type="text/javascript"></script>
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
      $('#addProduct').modal({ 'show' : {{ session()->has('errors') }}  });
  </script>

@endsection