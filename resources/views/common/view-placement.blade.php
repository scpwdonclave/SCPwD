@extends('layout.master')
@section('title', 'View Placement')
@section('parentPageTitle', 'Placements')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/timeline.css')}}">
@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                    <div class="text-center">
                        <h6>
                            CD ID: <span style='color:blue'>{{$placement->centercandidate->candidate->cd_id}}</span> <br>
                        </h6>
                    </div>
                    <br>
                    <ul class="cbp_tmtimeline">
                        
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Basic Details</span></time>
                            <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-account"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Candidate Name</small>
                                        <p>{{$placement->centercandidate->candidate->name}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">Mobile</small>
                                        <p>{{$placement->centercandidate->candidate->contact}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Email</small>
                                        <p>{{$placement->centercandidate->candidate->email}}</p>
                                        <hr>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-6">
                                        <small class="text-muted">Training Partner</small>
                                        <p>{{'('.$placement->partner->org_name.')'.$placement->partner->tp_id}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-6">
                                        <small class="text-muted">Training Center</small>
                                        <p>{{'('.$placement->center->center_name.')'.$placement->center->tc_id}}</p>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <small class="text-muted">Organization</small>
                                        <p>{{$placement->org_name}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-6">
                                        <small class="text-muted">Employment Date</small>
                                        <p>{{$placement->employment_date}}</p>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Employer Type</small>
                                        <p>{{$placement->emp_type}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Organization Address</small>
                                        <p>{{$placement->org_address}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">State District</small>
                                        <p>{{$placement->state_district->district .' ('.$placement->state_district->state.')'}}</p>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Employer SPOC Name</small>
                                        <p>{{$placement->emp_spoc_name}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Employer SPOC Mobile</small>
                                        <p>{{$placement->emp_spoc_mobile}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Employer SPOC Email</small>
                                        <p>{{$placement->emp_spoc_email}}</p>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Offer Letter</small>
                                        @if (!is_null($placement->offer_letter))
                                            <p>
                                                Download &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route(Request::segment(1).'.placement.file',[Crypt::encrypt($placement->id),basename($placement->offer_letter)])}}"><i class="zmdi zmdi-download"></i></a>
                                            </p>
                                        @else
                                            <p>No Document Provided</p>
                                        @endif
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Appointment Letter</small>
                                        @if (!is_null($placement->appointment_letter))
                                            <p>
                                                Download &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route(Request::segment(1).'.placement.file',[Crypt::encrypt($placement->id),basename($placement->appointment_letter)])}}"><i class="zmdi zmdi-download"></i></a>
                                            </p>
                                        @else
                                            <p>No Document Provided</p>
                                        @endif
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Salary Slips</small>
                                        @if (!is_null($placement->offer_letter))
                                            <p>
                                                Download Zip &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route(Request::segment(1).'.placement.file',[Crypt::encrypt($placement->id),'zip'])}}"><i class="zmdi zmdi-download"></i></a>
                                            </p>
                                        @else
                                            <p>No Document Provided</p>
                                        @endif
                                        <hr>
                                    </div>
                                </div>

                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
@section('page-script')
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop