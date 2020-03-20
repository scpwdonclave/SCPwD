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
                <h3 class="m-b-10"><span class="number count-to" data-from="0" data-to="49" data-speed="2000" data-fresh-interval="700">49</span></h3>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-cast zmdi-hc-3x col-blue"></i></h6>
                    <span>Ongoing Training</span>
                <h3 class="m-b-10 number count-to" data-from="0" data-to="102" data-speed="2000" data-fresh-interval="700">102</h3>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-dns zmdi-hc-3x col-pink"></i></h6>
                    <span>Trained</span>
                <h3 class="m-b-10 number count-to" data-from="0" data-to="95" data-speed="2000" data-fresh-interval="700">95</h3>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-border-color zmdi-hc-3x col-brown"></i></h6>
                    <span>Assessed</span>
                <h3 class="m-b-10 number count-to" data-from="0" data-to="200" data-speed="2000" data-fresh-interval="700">200</h3>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-check-square zmdi-hc-3x col-amber"></i></h6>
                    <span>Passed</span>
                <h3 class="m-b-10 number count-to" data-from="0" data-to="165" data-speed="2000" data-fresh-interval="700">165</h3>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-minus-circle zmdi-hc-3x col-red"></i></h6>
                    <span>Fail</span>
                <h3 class="m-b-10 number count-to" data-from="0" data-to="220" data-speed="2000" data-fresh-interval="700">220</h3>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-turning-sign zmdi-hc-3x"></i></h6>
                    <span>Absent</span>
                <h3 class="m-b-10 number count-to" data-from="0" data-to="339" data-speed="2000" data-fresh-interval="700">339</h3>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            

            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-card-off zmdi-hc-3x col-cyan"></i></h6>
                    <span>Drop-Out</span>
                <h3 class="m-b-10 number count-to" data-from="0" data-to="260" data-speed="2000" data-fresh-interval="700">260</h3>
                    
                </div>
            </div>
           
        </div>
        <div class="col-lg-3 col-sm-6">
            <a href="{{route('admin.mis.old-document-block')}}">

            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-book zmdi-hc-3x col-cyan"></i></h6>
                    <span>Old Excel Sheet</span>
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