@extends('layouts.admin-master')
@section('title', 'Inzaana Tools')

@section('breadcumb')
<h1>Manage License</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Home</a></li>
    <li>Tool</li>
    <li class="active">Manage Licenses </li>
</ol>
@endsection

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Manage Licenses</h3>
    </div>

    <div class="box-body">
      <div class="row padTB">
       <div class="col-md-6">          
               <p class="text-primary"></p>
               <div>
                  <p>Get License</p>
                  <div class="panel panel-default">
                    <table class="table table-bordered">
                      <thead>
                      <tr>
                          <th>SL</th>
                          <th data-sort="name">
                              Tool Name                                                    
                          </th>
                          <th>
                              License Used
                          </th>
                          <th>
                              Click to Get
                          </th>
                      </tr>
                      </thead>
                    <tbody>                     
                      <tr>
                        <td>1</td>
                        <td>Tool-1</td>
                        <td><a href="">XBN6-7#HHJ-HLPO-POPSRD</a></td>
                        <td>
                          <button type="button" class="btn">Get Key</button>
                          <p>1 of 3 Used</p>
                        </td>
                      </tr>
                    </tbody>
                    </table>
                  </div>
               </div>
               <div>
                  <p>Get License</p>
                  <div class="panel panel-default">
                    <table class="table table-bordered">
                      <thead>
                      <tr>
                          <th>SL</th>
                          <th data-sort="name">
                              Tool Name                                                    
                          </th>
                          <th>
                              License Used
                          </th>
                          <th>
                              Click to Get
                          </th>
                      </tr>
                      </thead>
                    <tbody>                     
                      <tr>
                        <td>1</td>
                        <td>Onlne POS System</td>
                          <td>
                            <a href="">XBN6-7#HHJ-HLPO-POPSRD</a>
                            <p><a href="">XBN6-7#HHJ-HLPO-POPSRD</a></p>
                          </td>
                        <td>
                          <button type="button" class="btn">Get Key</button>
                          <p>2 of 3 Used</p>
                        </td>
                      </tr>
                    </tbody>
                    </table>
                  </div>
               </div>
       </div>

      </div>
    </div>
</div>

@endsection
