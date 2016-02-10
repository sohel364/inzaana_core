@extends('layouts.user-admin-master')
@section('title', 'Reward Points')


@section('content')
<!--BEGIN TITLE & BREADCRUMB PAGE-->
        <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
          <div class="page-header pull-left mediaCr">
            <div class="page-title titleEx">
              Inzaana
            </div>
            <div class="page-title hidden-xs">
              | Reward Points</div>
          </div>
          <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="index.html">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Reward Points</li>
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
                            <div class="panel-heading">Reward Points</div>
                        <div class="col-lg-12 padB10 padT10">
                            <p>Below is a summary of your Reward Points to date. For any information regarding Reward Points please <a href="#">click here.</a>
                            </p>
                            <span class="label label-success">CURRENT BALANCE: 300</span>
                        </div>
                            <div class="panel-body">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th  class="text-center">Date added</th>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">Received Points</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="text-center">
                                        <td>dd/mm/yyy</td>
                                        <td><a href="#">#7471</a></td>
                                        <td>23</td>
                                    </tr>
                                    <tr class="text-center">
                                        <td>dd/mm/yyy</td>
                                        <td><a href="#">#7471</a></td>
                                        <td>45</td>
                                    </tr>
                                    <tr class="text-center">
                                        <td>dd/mm/yyy</td>
                                        <td><a href="#">#7471</a></td>
                                        <td>30</td>
                                    </tr>
                                    <tr class="text-center">
                                        <td>dd/mm/yyy</td>
                                        <td><a href="#">#7471</a></td>
                                        <td>15</td>
                                    </tr>
                                    </tbody>
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