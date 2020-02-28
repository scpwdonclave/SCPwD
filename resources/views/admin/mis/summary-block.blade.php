@extends('layout.master')
@section('title', 'Summary Block')
@section('parentPageTitle', 'MIS')

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix social-widget">
        <div class="col-lg-3 col-md-2 col-6">
            <a href="{{route('admin.mis.tp-tc_wise_block')}}">
            <div class="card blk info-box-2 hover-zoom-effect twitter-widget">
                <div class="icon"><i class="zmdi zmdi-tab zmdi-hc-2x"></i></div>
                <span class="text-muted" style="font-size:20px;">TP-TC Wise</span>
            </div>
        </a>
        </div>
        <div class="col-lg-3 col-md-2 col-6">
            <a href="{{route('admin.mis.candidate_wise_block')}}">
            <div class="card blk info-box-2 hover-zoom-effect google-widget">
                <div class="icon"><i class="zmdi zmdi-receipt"></i></div>
                <span class="text-muted" style="font-size:20px;">Candidate Wise</span>
            </div>
        </a>
        </div>
        <div class="col-lg-3 col-md-2 col-6">
            <a href="{{route('admin.mis.job_dsbl_wise_block')}}">
            <div class="card blk info-box-2 hover-zoom-effect linkedin-widget">
                <div class="icon"><i class="zmdi zmdi-assignment-returned"></i></div>
                <span class="text-muted" style="font-size:20px;">Job & Disability Wise</span>
            </div>
        </a>
        </div>
        <div class="col-lg-3 col-md-2 col-6">
            <a href="{{route('admin.mis.agency_wise_block')}}">
            <div class="card blk info-box-2 hover-zoom-effect behance-widget">
                <div class="icon"><i class="zmdi zmdi-collection-text"></i></div>
                <span class="text-muted" style="font-size:20px;">Agency Wise</span>
            </div>
        </a>
        </div>
        <div class="col-lg-3 col-md-2 col-6">
            <a href="{{route('admin.mis.placement_wise_block')}}">
            <div class="card blk info-box-2 hover-zoom-effect behance-widget">
                <div class="icon"><i class="zmdi zmdi-account-box-phone"></i></div>
                <span class="text-muted" style="font-size:20px;">Placement</span>
            </div>
        </a>
        </div>
        
    </div>
   
    
    
</div>


@stop
@section('page-script')

@stop