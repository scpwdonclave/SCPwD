@extends('layout.master')
@section('title', 'Trainer')
{{-- @section('parentPageTitle', 'Partners-verify') --}}
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/timeline.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/>
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
                                TR ID: <span style='color:blue'>{{$trainerData->trainer_id}}</span>
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
                                        <small class="text-muted">Attached TP</small>
                                        <p>{{$trainerData->partner->tp_id}}</p>
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
                                                        <th>#</th>
                                                        <th>Scheme</th>
                                                        <th>Sector</th>
                                                        <th>Job</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($trainerData->jobroles[0]->schemes as $key=>$scheme)
                                                    <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{$scheme->scheme->scheme}}</td>
                                                        <td >{{$trainerData->jobroles[0]->sector->sector}}</td>
                                                        <td>{{$trainerData->jobroles[0]->jobrole->job_role}}</td>
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
                                            <small class="text-muted">Qualification</small>
                                                <p>
                                                   
                                                    {{config('constants.qualifications.'.$trainerData->jobroles[0]->qualification)}} &nbsp;&nbsp;                                                    
                                                    <a class="btn-icon-mini" href="{{route('trainer.files.trainer-file',['id'=>$trainerData->id,'action'=>'download','filename'=>basename($trainerData->jobroles[0]->qualification_doc)])}}" download="{{basename($trainerData->jobroles[0]->qualification_doc)}}"><i class="zmdi zmdi-download"></i></a>                                                    
                                                </p>
                                          
                                            <hr>
                                        </div>
                                    
                                        <div class="col-sm-4">
                                                <small class="text-muted">SSC No</small>
                                                @if (!is_null($trainerData->jobroles[0]->ssc_doc))
                                                <p>{{$trainerData->jobroles[0]->ssc_no}}&nbsp;&nbsp; 
                                                <a class="btn-icon-mini" href="{{route('trainer.files.trainer-file',['id'=>$trainerData->id,'action'=>'download','filename'=>basename($trainerData->jobroles[0]->ssc_doc)])}}" download="{{basename($trainerData->jobroles[0]->ssc_doc)}}"><i class="zmdi zmdi-download"></i></a>                                                    
                                                </p>
                                                @else
                                                <p>No Document Provided</p>
                                                @endif

                                                <hr>
                                        </div>
                                        <div class="col-sm-4">
                                                <small class="text-muted">SSC Issued</small>
                                                <p>{{$trainerData->jobroles[0]->ssc_issued}}</p>
                                                <hr>
                                        </div>
                                        <div class="col-sm-4">
                                                <small class="text-muted">SSC Valid</small>
                                                <p>{{$trainerData->jobroles[0]->ssc_valid}}</p>
                                                <hr>
                                        </div>
                                    </div>
                                
                            </div>
                        </li>
                    </ul>
                    @auth('admin')
                        <div class="text-center" >
                            @if (Request::segment(1)==='admin')
                                @if (!$trainerData->verified )
                                    <button class="btn btn-success" onclick="location.href='{{route('admin.tr.trainer.verify',['trainer_id' => Crypt::encrypt($trainerData->id) ])}}';this.disabled = true;">Accept</button>
                                    <button class="btn btn-danger" onclick="showPromptMessage();">Reject</button>
                                @elseif ( $trainerData->verified==1)
                                    <button class="btn" onclick="location.href='{{route('admin.tr.edit.trainer',['tr_id' => Crypt::encrypt($trainerData->id) ])}}'">Edit</button>                         
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
                                        <th>#</th>
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
        function showPromptMessage() {
            swal({
                title: "Reason of Rejection",
                text: "Please Describe the Reason",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                showLoaderOnConfirm: true,
                inputPlaceholder: "Reason"
            }, function (inputValue) {
                if (inputValue === false) return false;
                if (inputValue === "") {
                    swal.showInputError("You need to write something!"); return false
                }
                var id={{$trainerData->id}};
                var note=inputValue;
                let _token = $("input[name='_token']").val();
            
                $.ajax({
                type: "POST",
                url: "{{route('admin.tr.reject.trainer')}}",
                data: {_token,id,note},
                success: function(data) {
                    // console.log(data);
                    swal({
                title: "Deleted",
                text: "Record Deleted",
                type:"success",
                //timer: 2000,
                showConfirmButton: true
            },function(isConfirm){
        
                if (isConfirm){
                
                window.location="{{route('admin.tc.pending-trainers')}}";
        
                } 
                });
            
                }
            });
                
            });
        }
    </script>
@endauth

<script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop