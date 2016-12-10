@extends('layouts.admin-master')
@section('title', 'Inzaana Tools')

@section('breadcumb')
<h1>Tools</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Home</a></li>
    <li>Tool</li>
    <li class="active">Download Inzaana tools </li>
</ol>
@endsection

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Inzaana Tools</h3>
    </div>

    <div class="box-body">
      <div class="row padTB">
       <div class="col-md-6">          
               <p class="text-primary"></p>
               <div>
                  <p>Download Inzaana Tools</p>
                  <div class="panel panel-default">
                    <table class="table table-bordered">
                      <thead>
                      <tr>
                          <th>SL</th>
                          <th data-sort="name">
                              Tool Name                                                    
                          </th>
                          <th>
                              Download
                          </th>
                          <th>
                              Download Count
                          </th>
                      </tr>
                      </thead>
                    <tbody>                     
                      <tr>
                        <td>1</td>
                        <td>Onlyne</td>
                        <td><a href="/tools/Onlyne.zip" download>Onlyne.zip</a></td>
                        <td><a href="/tools/Onlyne.zip" download>1</a></td>
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
