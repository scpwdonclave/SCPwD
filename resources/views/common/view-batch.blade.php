@extends('layout.master')
@section('title', 'Batch')
{{-- @section('parentPageTitle', 'Partners-verify') --}}
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/timeline.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/>

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
                                <span style='color:{{($batchData->status)?"green":"red"}}'>{{($batchData->status)?"Active":"Inactive"}}</span>
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
                                        <p>{{$batchData->partner->tp_id}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">Training Center ID</small>
                                        <p>{{$batchData->center->tc_id}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Trainer ID</small>
                                        <p>{{$batchData->trainer->trainer_id}}</p>
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
                                        <p>{{$batchData->batch_start}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-3">
                                        <small class="text-muted">Batch End Date</small>
                                        <p>{{$batchData->batch_end}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-3">
                                        <small class="text-muted">Assessment Date</small>
                                        <p>{{$batchData->assessment}}</p>
                                        <hr>
                                    </div>
                
                                </div>
                            </div>
                        </li>
                        
                    </ul>
                    <div class="text-center" >
                        @if (Request::segment(1)==='admin')
                            @if (!$batchData->verified)
                                <button class="btn btn-success" onclick="location.href='{{route('admin.batch.action',['id' => Crypt::encrypt($batchData->id),'action'=>'accept' ])}}';this.disabled = true;">Accept</button>
                                <button class="btn btn-danger" onclick="showPromptMessage('{{Crypt::encrypt($batchData->id)}}');">Reject</button>
                            {{-- @else
                                @if (!Auth::guard('admin')->user()->supadmin)
                                    <button class="btn btn-danger" onclick="location.href='{{route('admin.bt.batch.verify',['batch_id' => Crypt::encrypt($batchData->id) ])}}';this.disabled = true;">Request for DELETE</button>                                
                                @endif --}}
                            @endif
                        @else
                            @if (Request::segment(1) ==='partner')
                                @if ($batchData->verified)
                                    <button class="btn btn-primary" onclick="location.href='{{route('partner.bt.batch.edit',['batch_id' => Crypt::encrypt($batchData->id) ])}}'"><i class="zmdi zmdi-edit"></i> &nbsp;&nbsp;Edit</button>
                                @else
                                    <h6>Only Verified Batches are Editable</h6>
                                @endif
                            @endif
                        @endif
                    </div>
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
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                    <th>Aadhaar/Voter</th>
                                    <th>Status</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($batchData->candidatesmap as $key=>$item)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$item->candidate->name}}</td>
                                    <td>{{$item->candidate->contact}}</td>
                                    <td>{{$item->candidate->email}}</td>
                                    <td>{{$item->candidate->doc_no}}</td>
                                    <td style="color:{{($item->candidate->status)?'green':'red'}}">{{($item->candidate->status)?'Active':'Inactive'}}</td>
                                    @if (Request::segment(1)==='center')
                                        <td><a class="badge bg-green margin-0" href="{{route('center.candidate.view',Crypt::encrypt($item->candidate->id))}}" >View</a></<td>                                                                                
                                    @else
                                        <td><a class="badge bg-green margin-0" href="{{route(Request::segment(1).'.tc.candidate.view',Crypt::encrypt($item->candidate->id))}}" >View</a></<td>
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
@auth('admin')
    <script>

    function showPromptMessage(id) {
        swal({
            text: "Please Provide the Reason for Rejection",
            content: {
                element: "input",
                attributes: {
                    type: "text",
                },
            },
            icon: "info",
            buttons: true,
            buttons: {
                cancel: {
                    text: "Cancel",
                    visible: true,
                    value: null,
                    closeModal: true,
                },
                confirm: {
                    text: "Confirm Reject",
                    value: true,
                    closeModal: false
                }
                },
            closeModal: false,
            closeOnEsc: false,
        }).then(function(note){
            if (note!='' && note!=null) {
                let route = '{{route("admin.batch.action", [":id", "reject", ":reason"])}}';
                route = route.replace(':id',id);
                route = route.replace(':reason',note);
                location.href=route;
            } else if(note != null) {
                swal('Attention', 'Write Something Before you Submit','info');
            }
        });
    }
    </script>
@endauth

{{-- <script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script> --}}
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop