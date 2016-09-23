@extends('layouts.admin-master')
@section('title', 'Add FAQ')

@section('breadcumb')
<h1>FAQ
<small>Add FAQ</small>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Home</a></li>
    <li>FAQ</li>
    <li class="active">Add FAQ</li>
</ol>
@endsection

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Add FAQ</h3>
    </div>
    
    <div class="box-body">
      <div class="row padTB"> 
          <div class="col-lg-6 col-lg-offset-3">
            <div class="box box-noborder">

              <div class="box-header with-border">
                <h3 class="box-title">Add FAQ</h3>
              </div>

              <!-- form start -->
              <form role="form" action="#" method="POST">

                {!! csrf_field() !!}

                <div class="box-body">
                  <div class="form-group">
                    <label for="faq-name">FAQ</label>
                    <input type="text" class="form-control" value="" id="faq-name" name="faq-name" placeholder="Add Question title here...">
                  </div>
                  <div class="form-group">
                    <label for="description">Question Details</label>
                    <textarea placeholder="Add Question details..." class="form-control" rows="5" id="description" name="description"></textarea>
                  </div>
                </div><!-- /.box-body -->

                <div class="box-footer text-right">
                  <button type="submit" class="btn btn-info btn-flat">{{ isset($categoryEdit) ? 'Update' : 'Add' }} FAQ</button>
                </div>
              </form>
              <!--end of form-->

            </div>
          </div>
    </div>
</div>
    
    <!--recently added questions-->
    <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Recently Added questions</h3>
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
                      <th class="text-center">Question title</th>
                      <th class="text-center">Details</th>
                    </tr>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div>
    <!--end of recently added faq-->

@endsection