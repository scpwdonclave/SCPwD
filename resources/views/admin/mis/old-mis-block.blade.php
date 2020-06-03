@extends('layout.master')
@section('title', 'Old Mis')
@section('parentPageTitle', 'MIS')

@section('page-style')


@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
       <div class="col-lg-4 col-sm-6">
            <a href="{{route('admin.mis.old-document-part','candidates')}}">
                <div class="card text-center">
                    <div class="body">
                        <h6 class="m-b-20"><i class="zmdi zmdi-book zmdi-hc-3x col-cyan"></i></h6>
                        <span>Candidate Data</span>
                        <h3 class="m-b-10 number count-to" data-from="0" data-to="3" data-speed="2000" data-fresh-interval="700">3</h3>
                    </div>
                </div>
            </a>
        </div>
       <div class="col-lg-4 col-sm-6">
            <a href="{{route('admin.mis.old-document-part','formats')}}">
                <div class="card text-center">
                    <div class="body">
                        <h6 class="m-b-20"><i class="zmdi zmdi-book zmdi-hc-3x col-cyan"></i></h6>
                        <span>Formats</span>
                        <h3 class="m-b-10 number count-to" data-from="0" data-to="5" data-speed="2000" data-fresh-interval="700">5</h3>
                    </div>
                </div>
            </a>
        </div>
       <div class="col-lg-4 col-sm-6">
            <a href="{{route('admin.mis.old-document-part','tot-toa')}}">
                <div class="card text-center">
                    <div class="body">
                        <h6 class="m-b-20"><i class="zmdi zmdi-book zmdi-hc-3x col-cyan"></i></h6>
                        <span>ToT & ToA</span>
                        <h3 class="m-b-10 number count-to" data-from="0" data-to="6" data-speed="2000" data-fresh-interval="700">6</h3>
                    </div>
                </div>
            </a>
        </div>
       <div class="col-lg-4 col-sm-6">
            <a href="{{route('admin.mis.old-document-part','trackers')}}">
                <div class="card text-center">
                    <div class="body">
                        <h6 class="m-b-20"><i class="zmdi zmdi-book zmdi-hc-3x col-cyan"></i></h6>
                        <span>Trackers</span>
                        <h3 class="m-b-10 number count-to" data-from="0" data-to="9" data-speed="2000" data-fresh-interval="700">9</h3>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>


@stop
@section('page-script')

@stop