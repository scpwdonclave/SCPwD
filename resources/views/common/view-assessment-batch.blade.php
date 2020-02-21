@extends('layout.master')
@section('title', 'Batch')
{{-- @section('parentPageTitle', 'Partners-verify') --}}
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/timeline.css')}}">
{{-- <link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/> --}}

<link rel="stylesheet" href="{{asset('assets/css/color_skins.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                    @if (!is_null($batchData->batch_id))
                        <div class="text-center">
                            <h6>
                                Batch ID: <span style='color:blue'>{{$batchData->batch_id}}</span> <br> <br>
                                <span style='color:{{($batchData->status)?"green":"red"}}'>{{($batchData->status)?"Active":"Cencelled"}}</span>
                            </h6>
                        </div>
                        <br>
                    @endif
                    <ul class="cbp_tmtimeline">
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Batch Details</span></time>
                            <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-account"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Training Partner ID</small>
                                        <p>{{$batchData->partner->tp_id}} <span style='color:{{($batchData->partner->status)?"green":"red"}}'><strong>{{($batchData->partner->status)?"Active":"Inactive"}}</strong></span></p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">Training Center ID</small>
                                        <p>{{$batchData->center->tc_id}} <span style='color:{{($batchData->center->status)?"green":"red"}}'><strong>{{($batchData->center->status)?"Active":"Inactive"}}</strong></span></p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Trainer ID</small>
                                        <p>{{$batchData->trainer->trainer_id}} <span style='color:{{($batchData->trainer->status)?"green":"red"}}'><strong>{{($batchData->trainer->status)?"Active":"Inactive"}}</strong></span></p>
                                        <hr>
                                    </div>
                                  
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Scheme</small>
                                        <p>{{$batchData->scheme->scheme}} <span style='color:{{($batchData->tpjobrole->status)?"green":"red"}}'><strong>{{($batchData->tpjobrole->status)?"Active":"Inactive"}}</strong></span></p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Sector</small>
                                        <p>{{$batchData->jobrole->sector->sector}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Job Role</small>
                                        <p>{{$batchData->jobrole->job_role}}</p>
                                        <hr>
                                    </div>                
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <small class="text-muted">Batch Time</small>
                                        <p>{{$batchData->start_time.' - '.$batchData->end_time}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-3">
                                        <small class="text-muted">Batch Start Date</small>
                                        <p>{{\Carbon\Carbon::parse($batchData->batch_start)->format('d-m-Y')}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-3">
                                        <small class="text-muted">Batch End Date</small>
                                        <p>{{\Carbon\Carbon::parse($batchData->batch_end)->format('d-m-Y')}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-3">
                                        <small class="text-muted">Assessment Date</small>
                                        <p>{{\Carbon\Carbon::parse($batchData->assessment)->format('d-m-Y')}}</p>
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

<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Batch</strong> Candidates</h2>
                    
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Candidate Name</th>
                                    <th>Category</th>
                                    <th>Education</th>
                                    <th>DOB</th> 
                                    <th>Aadhaar/Voter</th>
                                    <th>Final Result</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($batchData->candidatesmap as $key=>$item)
                            
                                <tr>
                                    <td>{{$item->centercandidate->candidate->name}}</td>
                                    <td>{{$item->centercandidate->candidate->category}}</td>
                                    <td>{{$item->centercandidate->education}}</td>
                                    <td>{{$item->centercandidate->candidate->dob}}</td>
                                    @if (Request::segment(1)==='agency')
                                        <td>{{substr($item->centercandidate->candidate->doc_no, 0, 0).str_repeat('*', strlen($item->centercandidate->candidate->doc_no) - 4).substr($item->centercandidate->candidate->doc_no, strlen($item->centercandidate->candidate->doc_no) - 4, 4)}}</td>
                                        @else
                                        <td>{{$item->centercandidate->candidate->doc_no}}</td>
                                    @endif
                                   
                                        @if (!is_null($item->centercandidate->candidateMark) && !$item->centercandidate->dropout)
                                            
                                            @if ($item->centercandidate->candidateMark->passed===1 && $item->centercandidate->candidateMark->attendence==='present')
                                            <td style="color:green">Passed</td>
                                            @elseif($item->centercandidate->candidateMark->passed===0 && $item->centercandidate->candidateMark->attendence==='present')
                                            <td style="color:red">Failed</td>  
                                            @elseif($item->centercandidate->candidateMark->attendence==='absent')
                                            <td style="color:red">Absent</td>  
                                            @endif
                                            {{-- @switch($item->candidateMark->passed)
                                                @case('0')
                                                    <td style="color:red">Failed</td>
                                                    @break
                                                @case('1')
                                                    <td style="color:green">Passed</td>
                                                    @break
                                                @case('2')
                                                    <td style="color:red">Absent</td>
                                                    @break
                                                @default
                                                    <td>Not Applicable</td>
                                            @endswitch --}}
                                        @else
                                        <td>Not Applicable</td>
                                        @endif
                                    
                                        
                                    
                                </tr>
                                @endforeach     
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('page-script')


{{-- <script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script> --}}
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop