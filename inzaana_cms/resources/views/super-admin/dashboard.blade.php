@extends('layouts.super-admin-master')
@section('title', 'Super Admin Dashboard')
@section('header-style')
<style>
.subscribe_box{
    border: 1px solid #eee;
    padding: 10px;
    text-align: center;

}
</style>
@endsection

@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left mediaCr">
            <div class="page-title titleEx">
                Inzaana
            </div>
            <div class="page-title hidden-xs">
                | Super Admin Dashboard</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="index.html">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Dashboard</li>
        </ol>
        <div class="clearfix">
        </div>
    </div>
    <!--END TITLE & BREADCRUMB PAGE-->
    <!--BEGIN CONTENT-->
    <div class="page-content" style="background-color:#fff;">
        <div id="tab-general">
            <div class="row">

            <h2 class="text-center">Super Admin Home</h2>






            </div>
        </div>
    </div>
    <!--END CONTENT-->
@endsection

@section('footer-scripts')

@endsection
