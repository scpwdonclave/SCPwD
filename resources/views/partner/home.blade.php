@extends('layout.master')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid home">
    <div class="row clearfix">
        <div class="col-lg-4 col-sm-4">
            <div class="card">
                <div class="body">
                    <h3 class="m-b-0 number count-to" data-from="0" data-to="{{count($partner->centers)}}" data-speed="2000" data-fresh-interval="700">{{count($partner->centers)}}<i class="zmdi zmdi-trending-up float-right"></i></h3>
                    <strong><p class="text-muted"><span style="color:blue">Total no of Centers<span></p></strong>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4">
            <div class="card">
                <div class="body">
                    <h3 class="m-b-0 number count-to" data-from="0" data-to="{{$candidate}}" data-speed="2000" data-fresh-interval="700">{{$candidate}}<i class="zmdi zmdi-trending-up float-right"></i></h3>
                    <strong><p class="text-muted"><span style="color:blue">Total no of Candidates<span></p></strong>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4">
            <div class="card">
                <div class="body">
                    <h3 class="m-b-0 number count-to" data-from="0" data-to="{{count($partner->trainers)}}" data-speed="2000" data-fresh-interval="700">{{count($partner->trainers)}} <i class="zmdi zmdi-trending-up float-right"></i></h3>
                    <strong><p class="text-muted"><span style="color:blue">Total no of Trainers<span></p></strong>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-4 col-sm-4">
            <div class="card">
                <div class="body">
                    <h3 class="m-b-0 number count-to" data-from="0" data-to="{{count($partner->batches)}}" data-speed="2000" data-fresh-interval="700">{{count($partner->batches)}} <i class="zmdi zmdi-trending-up float-right"></i></h3>
                    <strong><p class="text-muted"><span style="color:blue">Total no of Batches<span></p></strong>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4">
            <div class="card">
                <div class="body">
                    <h3 class="m-b-0 number count-to" data-from="0" data-to="{{$placed}}" data-speed="2000" data-fresh-interval="700">{{count($partner->centers)}}<i class="zmdi zmdi-trending-up float-right"></i></h3>
                    <strong><p class="text-muted"><span style="color:blue">Total no of Placements<span></p></strong>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4">
            <div class="card">
                <div class="body">
                    <h3 class="m-b-0 number count-to" data-from="0" data-to="{{$assessment}}" data-speed="2000" data-fresh-interval="700">{{$assessment}} <i class="zmdi zmdi-trending-up float-right"></i></h3>
                    <strong><p class="text-muted"><span style="color:blue">Total no of (Re)Assessmets Taken<span></p></strong>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Candidate</strong> Records</h2>
                </div>
                <div class="body">
                                          
                    <div class="progress m-b-20">
                        <div class="progress-bar progress-bar-success" style="width: {{100*$passed/$candidate}}%"></div>
                        <div class="progress-bar progress-bar-danger" style="width: {{100*$failed/$candidate}}%"></div>
                        <div class="progress-bar progress-bar-warning" style="width: {{100*$absent/$candidate}}%"></div>
                        <div class="progress-bar progress-bar-info" style="width: {{100*$dropped/$candidate}}%"></div>
                        <div class="progress-bar l-slategray" style="width: {{100*$registered/$candidate}}%"></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover m-b-0">
                            <tbody>
                                <tr>
                                    <th><i class="zmdi zmdi-circle text-success"></i></th>
                                    <td>Passed</td>
                                    <td><span>{{$passed}} Candidate(s)</span></td>
                                    <td>{{round(100*$passed/$candidate,2)}}%</td>
                                </tr>
                                <tr>
                                    <th><i class="zmdi zmdi-circle text-danger"></i></th>
                                    <td>Failed</td>
                                    <td><span>{{$failed}} Candidate(s)</span></td>
                                    <td>{{round(100*$failed/$candidate,2)}}%</td>
                                </tr>
                                <tr>
                                    <th><i class="zmdi zmdi-circle text-warning"></i></th>
                                    <td>Absent</td>
                                    <td><span>{{$absent}} Candidate(s)</span></td>
                                    <td>{{round(100*$absent/$candidate,2)}}%</td>
                                </tr>
                                <tr>
                                    <th><i class="zmdi zmdi-circle text-info"></i></th>
                                    <td>Dropped out</td>
                                    <td><span>{{$dropped}} Candidate(s)</span></td>
                                    <td>{{round(100*$dropped/$candidate,2)}}%</td>
                                </tr>
                                <tr>
                                    <th><i class="zmdi zmdi-circle text-l-slategray"></i></th>
                                    <td>Newly Registered</td>
                                    <td><span>{{$registered}} Candidate(s)</span></td>
                                    <td>{{round(100*$registered/$candidate,2)}}%</td>
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