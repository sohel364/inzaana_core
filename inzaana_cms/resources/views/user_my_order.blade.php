@extends('layouts.user-admin-master')
@section('title', 'My Orders')


@section('content')
<!--BEGIN TITLE & BREADCRUMB PAGE-->
        <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
          <div class="page-header pull-left mediaCr">
            <div class="page-title titleEx">
              Inzaana
            </div>
            <div class="page-title hidden-xs">
              | My Orders</div>
          </div>
          <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="index.html">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">My Orders</li>
          </ol>
          <div class="clearfix">
          </div>
        </div>
        <!--END TITLE & BREADCRUMB PAGE-->
        <!--BEGIN CONTENT-->
        <div class="page-content">         
          <div id="tab-general">
           <div class="row">
            
            
                <div class="col-md-12 padB10 text-right">
                <a class="btn btn-info btn-lg">Balance: 100$</a>
              </div>
            
             <div class="col-lg-12">
                    <div class="panel panel-blue" style="background:#FFF;">
                            <div class="panel-heading">Order History</div>
                            <div class="panel-body">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Product Name</th>
                                        <th>Date of Order</th>
                                        <th>$Cost</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><a href="#">#7471</a></td>
                                        <td><a href="#">Baby Gentle Soap, Baby Powder, Baby Shampo, Baby Tow...</a></td>
                                        <td>dd/mm/yyyy</td>
                                        <td>23</td>
                                        <td><span class="label label-sm label-success">Approved</span></td>
                                    </tr>
                                    <tr>
                                        <td><a href="#">#7474</a></td>
                                        <td><a href="#">Baby Gentle Soap, Baby Powder, Baby Shampo, Baby Tow...</a></td>
                                        <td>dd/mm/yyyy</td>
                                        <td>45</td>
                                        <td><span class="label label-sm label-info">Pending</span></td>
                                    </tr>
                                    <tr>
                                        <td><a href="#">#7473</a></td>
                                        <td><a href="#">Baby Gentle Soap, Baby Powder, Baby Shampo, Baby Tow...</a></td>
                                        <td>dd/mm/yyyy</td>
                                        <td>30</td>
                                        <td><span class="label label-sm label-warning">Suspended</span></td>
                                    </tr>
                                    <tr>
                                        <td><a href="#">#7478</a></td>
                                        <td><a href="#">Baby Gentle Soap, Baby Powder, Baby Shampo, Baby Tow...</a></td>
                                        <td>dd/mm/yyyy</td>
                                        <td>15</td>
                                        <td><span class="label label-sm label-danger">Delevered</span></td>
                                    </tr>
                                        <tr>
                                        <td><a href="#">#7473</a></td>
                                        <td><a href="#">Baby Gentle Soap, Baby Powder, Baby Shampo, Baby Tow...</a></td>
                                        <td>dd/mm/yyyy</td>
                                        <td>30</td>
                                        <td><span class="label label-sm label-warning">Suspended</span></td>
                                    </tr>
                                    <tr>
                                        <td><a href="#">#7478</a></td>
                                        <td><a href="#">Baby Gentle Soap, Baby Powder, Baby Shampo, Baby Tow...</a></td>
                                        <td>dd/mm/yyyy</td>
                                        <td>15</td>
                                        <td><span class="label label-sm label-danger">Delevered</span></td>
                                    </tr>
                                        <tr>
                                        <td><a href="#">#7473</a></td>
                                        <td><a href="#">Baby Gentle Soap, Baby Powder, Baby Shampo, Baby Tow...</a></td>
                                        <td>dd/mm/yyyy</td>
                                        <td>30</td>
                                        <td><span class="label label-sm label-warning">Suspended</span></td>
                                    </tr>
                                    <tr>
                                        <td><a href="#">#7478</a></td>
                                        <td><a href="#">Baby Gentle Soap, Baby Powder, Baby Shampo, Baby Tow...</a></td>
                                        <td>dd/mm/yyyy</td>
                                        <td>15</td>
                                        <td><span class="label label-sm label-danger">Delevered</span></td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th><i>Total cost</i></th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>                    
                </div>
               <div class="col-lg-12 text-center">
                   <ul class="pagination mtm mbm">
                        <li><a href="#">&laquo;</a></li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#">&raquo;</a></li>
                    </ul>
                   <p>Showing 1 to 10 of 37 (4 Pages)</p>
               </div>
            
         </div>
          </div>
        </div>
        <!--END CONTENT-->
@endsection