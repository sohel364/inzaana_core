@extends('layouts.admin-master')
@section('title', 'Dashboard')


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
            <form>
                <div class="col-lg-5 col-lg-offset-3 text-right">
                <div class="input-group">
                <input type="text" class="form-control">
                  <span class="input-group-btn">
                    <button class="btn btn-info btn-flat" type="button"><i class="fa fa-lg fa-search"></i></button>
                  </span>
                </div>
                </div>
                <div class="col-lg-1 text-left">
                    <button class="btn btn-info btn-flat" data-toggle="modal" data-target="#addProduct" type="button"><i class="fa fa-lg fa-plus-square"></i></button>
                </div>
            </form>
            <!--end of form-->
            
            <div class="col-lg-5 col-lg-offset-3 boxPadTop">
                <div class="box box-info">
                <div class="box-body no-padding">
                  <table class="table table-condensed">
                    <tr>
                      <th>Product Name</th>
                      <th>Category</th>
                    </tr>
                    <tr>
                      <td>Kitkat 5RS</td>
                      <td>Chocolate</td>
                    </tr>
                    <tr>
                       <td>Kitkat 10RS</td>
                      <td>Chocolate</td>
                    </tr>
                    <tr>
                       <td>Kitkat 15 RS</td>
                      <td>Chocolate</td>
                    </tr>
                    <tr>
                       <td>Kitkat Ice Cream</td>
                      <td>Chocolate Ice Cream</td>
                    </tr>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
    
    <!--add product modal-->
<div id="addProduct" class="modal fade" role="dialog">
    
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Product Details</h4>
      </div>
      <div class="modal-body">

                <!-- form start -->
                <form class="form-horizontal">
                  
                    <div class="form-group">
                      <label for="product-title" class="col-sm-3 control-label">Product Title:</label>
                      <div class="col-sm-9">
                        <input type="email" class="form-control" id="product-title" placeholder="ex: kitka 5RS">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="Manufacturer" class="col-sm-3 control-label">Manufacturer</label>
                      <div class="col-sm-9">
                        <input type="password" class="form-control" id="Manufacturer" placeholder="ex: dairy milk">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="mrp" class="col-sm-3 control-label">MRP:</label>
                      <div class="col-sm-2">
                        <input type="password" class="form-control" id="mrp" placeholder="ex: 3$">
                      </div>
                        <div class="col-sm-7 padT5"><b>$</b></div>
                    </div>
                    <div class="form-group">
                      <label for="discount" class="col-sm-3 control-label">Discount:</label>
                      <div class="col-sm-2">
                        <input type="password" class="form-control" id="discount" placeholder="ex: 30%">
                      </div>
                        <div class="col-sm-7 padT5"><b>%</b></div>
                    </div>
                    <div class="form-group">
                      <label for="selling-price" class="col-sm-3 control-label">Selling Price:</label>
                      <div class="col-sm-2">
                        <input type="password" class="form-control" id="selling-price" placeholder="ex: 3$">
                      </div>
                        <div class="col-sm-7 padT5"><b>$</b></div>
                    </div>
                </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-info btn-flat" data-dismiss="modal">Save</button>
      </div>
    </div>
  </div>
    
</div>
    <!--end add product modal-->

@endsection