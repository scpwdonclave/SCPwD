@extends('layout.master')
@section('title', 'Trainer')
{{-- @section('parentPageTitle', 'Partners-verify') --}}
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/timeline.css')}}">
{{-- <link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/> --}}
@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                    @if (!is_null($trainerData->trainer_id))
                        <div class="text-center">
                            <h6>
                                TR ID: <span style='color:blue'>{{$trainerData->trainer_id}}</span> <br> <br>
                                <span style='color:{{($trainerData->status)?"green":"red"}}'>{{($trainerData->status)?"Active":"Inactive"}}</span>
                            </h6>
                        </div>
                        <br>
                    @endif
                    <ul class="cbp_tmtimeline">
                        
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Trainer Details</span></time>
                            <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-account"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Trainer Name</small>
                                        <p>{{$trainerData->name}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">Mobile</small>
                                        <p>{{$trainerData->mobile}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Email</small>
                                        <p>{{$trainerData->email}}</p>
                                        <hr>
                                    </div>
                                  
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">
                                            {{isset($delinked)?'Last ':null}}Attached TP</small>
                                        <p>{{$trainerData->partner->tp_id}} <span style='color:{{($trainerData->partner->status)?"green":"red"}}'><strong>{{($trainerData->partner->status)?"Active":"Inactive"}}</strong></span></p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Document Type</small>
                                        <p>{{$trainerData->doc_type}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">Document Number</small>
                                        @if (!is_null($trainerData->doc_file))
                                            <p>
                                                {{$trainerData->doc_no}} &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route('trainer.files.trainer-file',['id'=>$trainerData->id,'action'=>'download','filename'=>basename($trainerData->doc_file)])}}" download="{{basename($trainerData->doc_file)}}"><i class="zmdi zmdi-download"></i></a>
                                            </p>
                                        @else
                                            <p>No Document Provided</p>
                                        @endif
                                        <hr>
                                    </div>
                
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Resume</small>
                                            @if (!is_null($trainerData->resume))
                                                <p>
                                                    Resume &nbsp;&nbsp;
                                                    <a class="btn-icon-mini" href="{{route('trainer.files.trainer-file',['id'=>$trainerData->id,'action'=>'download','filename'=>basename($trainerData->resume)])}}" download="{{basename($trainerData->resume)}}"><i class="zmdi zmdi-download"></i></a>
                                                </p>
                                            @else
                                                <p>No Resume Provided</p>
                                            @endif
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">Other Document</small>
                                        @if (!is_null($trainerData->other_doc))
                                            <p>
                                                Other Document &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route('trainer.files.trainer-file',['id'=>$trainerData->id,'action'=>'download','filename'=>basename($trainerData->other_doc)])}}" download="{{basename($trainerData->other_doc)}}"><i class="zmdi zmdi-download"></i></a>
                                            </p>
                                        @else
                                            <p>No Document Provided</p>
                                        @endif
                                        <hr>
                                    </div>
                
                                </div>
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Trainer Job Role</span></time>
                            <div class="cbp_tmicon bg-pink"> <i class="zmdi zmdi-pin"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="table-responsive">
                                    <table class="table m-b-0">
                                        <thead>
                                            <tr>
                                                <th>Sl. No.</th>
                                                <th>Scheme</th>
                                                <th>Sector</th>
                                                <th>Job</th>
                                                <th>Scheme Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($trainerData->trainer_jobroles as $key=>$trainerJob)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$trainerJob->partnerjobrole->scheme->scheme}}</td>
                                                <td>{{$trainerJob->partnerjobrole->sector->sector}}</td>
                                                <td>{{$trainerJob->partnerjobrole->jobrole->job_role}}</td>
                                                <td class="text-{{($trainerJob->partnerjobrole->status)?'success':'danger'}}"><strong>Scheme is {{($trainerJob->partnerjobrole->status)?'Active':'Inactive'}}</strong></td>
                                            </tr>
                                          
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Trainer Documents</span></time>
                            <div class="cbp_tmicon bg-blue"> <i class="zmdi zmdi-local-store"></i></div>
                            <div class="cbp_tmlabel">
                                
                                <div class="row">
                                        <div class="col-sm-4">
                                            <small class="text-muted">SCPWD Certificate</small>
                                            @if (!is_null($trainerData->scpwd_doc))
                                                <p>
                                                    {{$trainerData->scpwd_no}} &nbsp;&nbsp;
                                                    <a class="btn-icon-mini" href="{{route('trainer.files.trainer-file',['id'=>$trainerData->id,'action'=>'download','filename'=>basename($trainerData->scpwd_doc)])}}" download="{{basename($trainerData->scpwd_doc)}}"><i class="zmdi zmdi-download"></i></a>                                                    
                                                </p>
                                            @else
                                                <p>No Certificate Provided</p>
                                            @endif
                                            <hr>
                                        </div>
                                    
                                        <div class="col-sm-4">
                                                <small class="text-muted">SCPWD Issued</small>
                                                <p>{{$trainerData->scpwd_issued}}</p>
                                                <hr>
                                        </div>
                                        <div class="col-sm-4">
                                                <small class="text-muted">SCPWD Valid</small>
                                                <p>{{$trainerData->scpwd_valid}}</p>
                                                <hr>
                                        </div>
                                    </div>
                                
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Trainer Education & Other Documents</span></time>
                            <div class="cbp_tmicon bg-yellow"> <i class="zmdi zmdi-local-store"></i></div>
                            <div class="cbp_tmlabel">
                                
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Relavent Qualification</small>
                                            <p>
                                                {{$trainerData->qualification}} &nbsp;&nbsp;                                                    
                                                <a class="btn-icon-mini" href="{{route('trainer.files.trainer-file',['id'=>$trainerData->id,'action'=>'download','filename'=>basename($trainerData->qualification_doc)])}}" download="{{basename($trainerData->qualification_doc)}}"><i class="zmdi zmdi-download"></i></a>                                                    
                                            </p>                                          
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Sector Experience</small>
                                        <p>{{$trainerData->sector_exp}} Years</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Teaching Experience</small>
                                        <p>{{$trainerData->teaching_exp}} Years</p>
                                        <hr>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-4">
                                            <small class="text-muted">SSC No</small>
                                            @if (!is_null($trainerData->ssc_doc))
                                            <p>{{$trainerData->ssc_no}}&nbsp;&nbsp; 
                                            <a class="btn-icon-mini" href="{{route('trainer.files.trainer-file',['id'=>$trainerData->id,'action'=>'download','filename'=>basename($trainerData->ssc_doc)])}}" download="{{basename($trainerData->ssc_doc)}}"><i class="zmdi zmdi-download"></i></a>                                                    
                                            </p>
                                            @else
                                            <p>No Document Provided</p>
                                            @endif

                                            <hr>
                                    </div>
                                    <div class="col-sm-4">
                                            <small class="text-muted">SSC Issued</small>
                                            <p>{{$trainerData->ssc_issued}}</p>
                                            <hr>
                                    </div>
                                    <div class="col-sm-4">
                                            <small class="text-muted">SSC Valid</small>
                                            <p>{{$trainerData->ssc_valid}}</p>
                                            <hr>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    @auth('admin')
                        <div class="text-center" >
                            @if (Request::segment(1)==='admin' && !auth()->guard('admin')->user()->ministry)
                                @if (is_null($trainerData->attached))
                                    @if (!$trainerData->verified)
                                        <button class="btn btn-success" onclick="location.href='{{route('admin.tp.trainer.action',Crypt::encrypt($trainerData->id.','.'1'))}}';this.disabled = true;">Accept</button>
                                        <button class="btn btn-danger" onclick="popupRejectSwal('{{Crypt::encrypt($trainerData->id.','.'0')}}');">Reject</button>
                                    @else
                                        <button class="btn btn-primary" onclick="location.href='{{route('admin.tr.edit.trainer',['tr_id' => Crypt::encrypt($trainerData->id) ])}}'"><i class="zmdi zmdi-edit"></i> &nbsp;&nbsp;Edit</button>
                                    @endif
                                @endif
                            @endif
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

{{-- =================== --}}
{{-- <div class="container-fluid">
    <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Center</strong> Job Target</h2>
                       
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                        <tr>
                                        <th>Sl. No.</th>
                                        <th>Scheme</th>
                                        <th>Sector</th>
                                        <th>Job Role</th>
                                        <th>Target Allocated</th>
                                        <th>Student Enroll</th>
                                        <th>Target Achieve</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                        @foreach ($tc_target as $key=>$target)
                                            
                                        <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$target->partnerjobrole->scheme->scheme}}</td>
                                        <td>{{$target->partnerjobrole->sector->sector}}</td>
                                        <td>{{$target->partnerjobrole->jobrole->job_role}}</td>
                                        <td>{{$target->target}}</td>
                                        <td>{{$target->enrolled}}</td>
                                       <td>0</td>
                                        </tr>
                                      
                                        @endforeach
                                       
                                    </tbody>
                            </table>
                            </div>
                    </div>
                </div>
            </div>
        </div>
</div> --}}
{{-- =================== --}}
@stop
@section('page-script')
@auth('admin')
    <script>
        function popupRejectSwal(id) {
            swal({
                text: 'Please Provide the Reason of Rejection',
                content: "input",
                icon: "info",
                buttons: true,
                buttons: {
                        cancel: "No, Cancel",
                        confirm: {
                            text: "Confirm Reject",
                            closeModal: false
                        }
                    },
                closeModal: false,
                closeOnEsc: false,
            }).then(function(reason){
                if (reason != null) {
                    if (reason === '') {
                        swal('Attention', 'Please Describe the Reason of Rejection before Proceed', 'info');
                    } else {
                        var url = '{{ route("admin.tp.trainer.action",[":id",":reason"]) }}';
                        url = url.replace(':id', id);
                        url = url.replace(':reason', reason);
                        location.href = url;
                    }
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