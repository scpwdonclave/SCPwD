@extends('layout.master')
@section('title', 'Old Mis')
@section('parentPageTitle', 'MIS')

@section('page-style')


@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
       <div class="col-lg-3 col-sm-6">
            <a href="{{route('admin.mis.old-document-part',['data' => 'freezed' ])}}">

            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-book zmdi-hc-3x col-cyan"></i></h6>
                    <span>Freezed Data</span>
                <h3 class="m-b-10 number count-to" data-from="0" data-to="4" data-speed="2000" data-fresh-interval="700">4</h3>
                    
                </div>
            </div>
            </a>
        </div>
       <div class="col-lg-3 col-sm-6">
            <a href="{{route('admin.mis.old-document-part',['data' => 'flowing' ])}}">

            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-book zmdi-hc-3x col-cyan"></i></h6>
                    <span>Flowing Data</span>
                <h3 class="m-b-10 number count-to" data-from="0" data-to="4" data-speed="2000" data-fresh-interval="700">4</h3>
                    
                </div>
            </div>
            </a>
        </div>
       <div class="col-lg-3 col-sm-6">
            <a href="{{route('admin.mis.old-document-block',['data' => 'formats' ])}}">

            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-book zmdi-hc-3x col-cyan"></i></h6>
                    <span>Formats</span>
                <h3 class="m-b-10 number count-to" data-from="0" data-to="4" data-speed="2000" data-fresh-interval="700">4</h3>
                    
                </div>
            </div>
            </a>
        </div>
       
    </div>
    
    
</div>


@stop
@section('page-script')

@stop