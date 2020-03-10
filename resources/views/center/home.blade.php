@extends('layout.master')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid home">
    <div class="row clearfix">
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="body">
                    <h3 class="m-b-0 number count-to" data-from="0" data-to="{{count($center->candidatesmap)}}" data-speed="2000" data-fresh-interval="700">{{count($center->candidatesmap)}}<i class="zmdi zmdi-trending-up float-right"></i></h3>
                    <strong><p class="text-muted"><span style="color:blue">Total No of Candidate Registration</span></p></strong>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="body">
                    <h3 class="m-b-0 number count-to" data-from="0" data-to="{{count($center->batches)}}" data-speed="2000" data-fresh-interval="700">{{count($center->batches)}} <i class="zmdi zmdi-trending-up float-right"></i></h3>
                    <strong><p class="text-muted"><span style="color:blue">Total No of Batches</span></p></strong>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="body">
                    <h3 class="m-b-0 number count-to" data-from="0" data-to="{{$placed}}" data-speed="2000" data-fresh-interval="700">{{$placed}} <i class="zmdi zmdi-trending-up float-right"></i></h3>
                    <strong><p class="text-muted"><span style="color:blue">Total No of Placements</span></p></strong>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="body">
                    <h3 class="m-b-0 number count-to" data-from="0" data-to="{{$assessment}}" data-speed="2000" data-fresh-interval="700">{{$assessment}} <i class="zmdi zmdi-trending-up float-right"></i></h3>
                    <strong><p class="text-muted"><span style="color:blue">Total No of (Re)Assessmets Taken</span></p></strong>
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Data</strong> Managed</h2>
                </div>
                <div class="body">
                                          
                    <div class="progress m-b-20">
                        <div class="progress-bar progress-bar-success" style="width: {{100*$passed/count($center->candidatesmap)}}%"></div>
                        <div class="progress-bar progress-bar-danger" style="width: {{100*$failed/count($center->candidatesmap)}}%"></div>
                        <div class="progress-bar progress-bar-warning" style="width: {{100*$absent/count($center->candidatesmap)}}%"></div>
                        <div class="progress-bar progress-bar-info" style="width: {{100*$dropped/count($center->candidatesmap)}}%"></div>
                        <div class="progress-bar l-slategray" style="width: {{100*$registered/count($center->candidatesmap)}}%"></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover m-b-0">
                            <tbody>
                                <tr>
                                    <th><i class="zmdi zmdi-circle text-success"></i></th>
                                    <td>Passed</td>
                                    <td><span>{{$passed}} Candidate(s)</span></td>
                                    <td>{{round(100*$passed/count($center->candidatesmap),2)}}%</td>
                                </tr>
                                <tr>
                                    <th><i class="zmdi zmdi-circle text-danger"></i></th>
                                    <td>Failed</td>
                                    <td><span>{{$failed}} Candidate(s)</span></td>
                                    <td>{{round(100*$failed/count($center->candidatesmap),2)}}%</td>
                                </tr>
                                <tr>
                                    <th><i class="zmdi zmdi-circle text-warning"></i></th>
                                    <td>Absent</td>
                                    <td><span>{{$absent}} Candidate(s)</span></td>
                                    <td>{{round(100*$absent/count($center->candidatesmap),2)}}%</td>
                                </tr>
                                <tr>
                                    <th><i class="zmdi zmdi-circle text-info"></i></th>
                                    <td>Dropped out</td>
                                    <td><span>{{$dropped}} Candidate(s)</span></td>
                                    <td>{{round(100*$dropped/count($center->candidatesmap),2)}}%</td>
                                </tr>
                                <tr>
                                    <th><i class="zmdi zmdi-circle text-l-slategray"></i></th>
                                    <td>Newly Registered</td>
                                    <td><span>{{$registered}} Candidate(s)</span></td>
                                    <td>{{round(100*$registered/count($center->candidatesmap),2)}}%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>          
    </div>
</div>
@stop