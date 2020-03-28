@extends('layout.master')
@section('title', 'Old Mis')
@section('parentPageTitle', 'MIS')

@section('page-style')


@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-3 col-sm-6">
            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-account-box zmdi-hc-3x col-green"></i></h6>
                    <span>Enrolled</span>
                <h3 class="m-b-10"><span class="number count-to" data-from="0" data-to="104033" data-speed="2000" data-fresh-interval="700">104033</span></h3>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-cast zmdi-hc-3x col-blue"></i></h6>
                    <span>Ongoing Training</span>
                <h3 class="m-b-10 number count-to" data-from="0" data-to="0" data-speed="2000" data-fresh-interval="700">0</h3>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-dns zmdi-hc-3x col-pink"></i></h6>
                    <span>Trained</span>
                <h3 class="m-b-10 number count-to" data-from="0" data-to="104033" data-speed="2000" data-fresh-interval="700">104033</h3>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-border-color zmdi-hc-3x col-brown"></i></h6>
                    <span>Assessed</span>
                <h3 class="m-b-10 number count-to" data-from="0" data-to="78805" data-speed="2000" data-fresh-interval="700">78805</h3>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-check-square zmdi-hc-3x col-amber"></i></h6>
                    <span>Passed</span>
                <h3 class="m-b-10 number count-to" data-from="0" data-to="61248" data-speed="2000" data-fresh-interval="700">61248</h3>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-minus-circle zmdi-hc-3x col-red"></i></h6>
                    <span>Fail</span>
                <h3 class="m-b-10 number count-to" data-from="0" data-to="17557" data-speed="2000" data-fresh-interval="700">17557</h3>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-turning-sign zmdi-hc-3x"></i></h6>
                    <span>Absent</span>
                <h3 class="m-b-10 number count-to" data-from="0" data-to="6541" data-speed="2000" data-fresh-interval="700">6541</h3>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            

            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-card-off zmdi-hc-3x col-cyan"></i></h6>
                    <span>Drop-Out</span>
                <h3 class="m-b-10 number count-to" data-from="0" data-to="0" data-speed="2000" data-fresh-interval="700">0</h3>
                    
                </div>
            </div>
           
        </div>
        <div class="col-lg-3 col-sm-6">
            <a href="{{route('admin.mis.old-document-block')}}">

            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-book zmdi-hc-3x col-cyan"></i></h6>
                    <span>Old Excel Sheet</span>
                <h3 class="">&nbsp;</h3>
                    
                </div>
            </div>
            </a>
        </div>
       
    </div>
    
    
</div>


@stop
@section('page-script')

@stop