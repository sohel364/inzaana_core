@extends('layouts.super-admin-master')
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
              <form role="form" action="{{ route('admin::faqs.create') }}" method="POST">

                {!! csrf_field() !!}

                <div class="box-body">
                  <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    <label for="title">FAQ</label>
                    <input type="text" class="form-control" value="" id="title" name="title" maxlength="255" placeholder="Add Question title here..." value="{{ old('title') }}">
                    @if ($errors->has('title'))
                          <span class="help-block">
                              <strong>{{ $errors->first('title') }}</strong>
                          </span>
                    @endif
                  </div>
                  <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                    <label for="description">Question Details</label>
                    <textarea placeholder="Add Question details..." class="form-control" rows="5" id="description" maxlength="1000" name="description"></textarea>
                    @if ($errors->has('description'))
                          <span class="help-block">
                              <strong>{{ $errors->first('description') }}</strong>
                          </span>
                    @endif
                      <div id="charNum"></div>
                  </div>
                </div><!-- /.box-body -->

                <div class="box-footer text-right">
                  <button type="submit" class="btn btn-info btn-flat">{{ isset($faq) ? 'Update' : 'Add' }} FAQ</button>
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
                    @forelse($faqs as $description => $title)
                    <tr>
                      <!-- <th class="text-center hidden">ID</th> -->
                      <td class="text-center">{{ $title  }}</td>
                      <td class="text-center">{{ $description }}</td>
                    </tr>
                    @empty
                    <tr>
                      <!-- <th class="text-center hidden">ID</th> -->
                      <td class="text-center">No FAQs added yet!</td>
                    </tr>                      
                    @endforelse
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div>
    <!--end of recently added faq-->

@endsection

@section('footer-scripts')
        <script src="{{ URL::asset('super-admin-asset/faqs.js') }}"></script>
@endsection