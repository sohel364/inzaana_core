@extends('layouts.super-admin-master')
@section('title', 'Manage Approvals')

@section('breadcumb')
<h1>Approvals
<small>Manage Approvals</small>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Home</a></li>
    <li>Approvals</li>
    <li class="active">Manage Approvals</li>
</ol>
@endsection

@section('content')   
    <!--recently added questions-->
    <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Manage Vendor Approvals </h3>
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
                      <th class="text-center">Approval Type</th>
                      <th class="text-center">Approval Title</th>
                      <th class="text-center">Submitted by</th>
                      <th class="text-center">Status</th>
                      <th class="text-center">Action</th>
                    </tr>
                    @foreach(collect($approvals) as $type => $approval)
                      @forelse($approval['data'] as $title => $id)
                      <tr>
                        <!-- <th class="text-center hidden">ID</th> -->
                        <td class="text-center">{{ $approval['type'] }}</td>
                        <td class="text-center">{{ $title }}</td>
                        <td class="text-center">{{ 'Unknown' }}</td>
                        <td class="text-center">
                          @if($approval['type'] == Inzaana\Category::class)
                            @include('includes.approval-label', [ 'status' => Inzaana\Category::find($id)->status ])
                          @elseif($approval['type'] == Inzaana\Product::class)
                            @include('includes.approval-label', [ 'status' => Inzaana\Product::find($id)->status ])
                          @endif
                        </th>
                        <td class="text-center">
                          @if($approval['type'] == Inzaana\Category::class)
                            @include('includes.approval-buttons', [ 'status' => Inzaana\Category::find($id)->status, 'route' => [ 'namespace' => 'user::', 'type' => $type ], 'id' => $id ])
                          @elseif($approval['type'] == Inzaana\Product::class)
                            @include('includes.approval-buttons', [ 'status' => Inzaana\Product::find($id)->status, 'route' => [ 'namespace' => 'user::', 'type' => $type ], 'id' => $id ])
                          @endif
                        </td>
                      </tr>
                      @empty
                      <tr>
                        <td class="text-center" colspan="5"> <span class="label label-success"> No Approvals for {{ $type }} </span></td>
                      </tr>
                      @endforelse
                    @endforeach
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div>
    <!--end of recently added faq-->

@endsection