@extends('layout.master')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid home">
    <div class="row clearfix">
        <div class="col-lg-4 col-sm-4">
            <div class="card">
                <div class="body">
                    <h3 class="m-b-0 number count-to" data-from="0" data-to="{{$assessment}}" data-speed="2000" data-fresh-interval="700">{{$assessment}}<i class="zmdi zmdi-trending-up float-right"></i></h3>
                    <strong><p class="text-muted"><span style="color:blue">Total no of Assessment(s)</span></p></strong>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4">
            <div class="card">
                <div class="body">
                    <h3 class="m-b-0 number count-to" data-from="0" data-to="{{$reassessment}}" data-speed="2000" data-fresh-interval="700">{{$reassessment}} <i class="zmdi zmdi-trending-up float-right"></i></h3>
                    <strong><p class="text-muted"><span style="color:blue">Total no of Re-Assessment(s)</span></p></strong>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4">
            <div class="card">
                <div class="body">
                    <h3 class="m-b-0 number count-to" data-from="0" data-to="{{$assessed}}" data-speed="2000" data-fresh-interval="700">{{$assessed}} <i class="zmdi zmdi-trending-up float-right"></i></h3>
                    <strong><p class="text-muted"><span style="color:blue">Total no of Candidate Assessed</span></p></strong>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row clearfix">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="header">
                    <h2><strong>(Re)Assessments</strong> Records</h2>
                </div>
                <div class="body">
                                          
                    <div class="progress m-b-20">
                        <div class="progress-bar progress-bar-success" style="width: {{($passed+$absent+$failed)?(100*$passed/($passed+$absent+$failed)):'0'}}%"></div>
                        <div class="progress-bar progress-bar-danger" style="width: {{($passed+$absent+$failed)?(100*$failed/($passed+$absent+$failed)):'0'}}%"></div>
                        <div class="progress-bar progress-bar-warning" style="width: {{($passed+$absent+$failed)?(100*$absent/($passed+$absent+$failed)):'0'}}%"></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover m-b-0">
                            <tbody>
                                <tr>
                                    <th><i class="zmdi zmdi-circle text-success"></i></th>
                                    <td>Passed</td>
                                    <td><span>{{$passed}} Candidate(s)</span></td>
                                    <td>{{($passed+$absent+$failed)?(round(100*$passed/($passed+$absent+$failed),2)):'0'}}%</td>
                                </tr>
                                <tr>
                                    <th><i class="zmdi zmdi-circle text-danger"></i></th>
                                    <td>Failed</td>
                                    <td><span>{{$failed}} Candidate(s)</span></td>
                                    <td>{{($passed+$absent+$failed)?(round(100*$failed/($passed+$absent+$failed),2)):'0'}}%</td>
                                </tr>
                                <tr>
                                    <th><i class="zmdi zmdi-circle text-warning"></i></th>
                                    <td>Absent</td>
                                    <td><span>{{$absent}} Candidate(s)</span></td>
                                    <td>{{($passed+$absent+$failed)?(round(100*$absent/($passed+$absent+$failed),2)):'0'}}%</td>
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
