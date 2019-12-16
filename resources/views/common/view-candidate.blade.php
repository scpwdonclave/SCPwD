@extends('layout.master')
@section('title', 'Candidate')
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
                        <div class="text-center">
                            <h6>
                                This Candidate is <span style='color:{{($candidate->status)?"green":"red"}}'>{{($candidate->status)?"Active":"Inactive"}}</span>
                            </h6>
                        </div>
                        <br>
                    <ul class="cbp_tmtimeline">
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Identity</span></time>
                            <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-case"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <small class="text-muted">Training Partner</small>
                                        <p>{{$candidate->center->partner->tp_id}} <span style='color:{{($candidate->center->partner->status)?"green":"red"}}'><strong>{{($candidate->center->partner->status)?"Active":"Inactive"}}</strong></span></p>
                                        <hr>
                                    </div>
                                    
                                    <div class="col-sm-3">
                                        <small class="text-muted">Training Center</small>
                                        <p>{{$candidate->center->tc_id}} <span style='color:{{($candidate->center->status)?"green":"red"}}'><strong>{{($candidate->center->status)?"Active":"Inactive"}}</strong></span></p>
                                        <hr>
                                    </div>

                                    <div class="col-sm-3">
                                        <small class="text-muted">Aadhaar/Voter Number</small>
                                        <p>{{$candidate->doc_no}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-3">
                                        <small class="text-muted">Aadhaar/Voter Document</small>
                                        @if (!is_null($candidate->doc_file))
                                            <p>Document &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route('center.files.candidate-file',['action'=>'download','id'=>$candidate->id,'file'=>'doc'])}}" download="{{basename($candidate->doc_file)}}"><i class="zmdi zmdi-download"></i></a>
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
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Candidate Basic Details</span></time>
                            <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-account"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Candidate Name </small>
                                        <p>{{$candidate->name}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">Candidate Contact </small>
                                        <p>{{$candidate->contact}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Candidate Email </small>
                                        <p>{{$candidate->email}}</p>
                                        <hr>
                                    </div>
                                  
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Gender</small>
                                        <p>{{$candidate->gender}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Date of Birth</small>
                                        <p>{{$candidate->dob}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">Marital Status</small>
                                        <p>
                                            {{$candidate->m_status}}</p>
                                        <hr>
                                    </div>
                
                                </div>
                                
                            </div>
                        </li>
                        
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Candidate Other Details
                            </span></time>
                            <div class="cbp_tmicon bg-blue"> <i class="zmdi zmdi-local-store"></i></div>
                            <div class="cbp_tmlabel">
                                
                                <div class="row">
                                    <div class="col-sm-8">
                                            <small class="text-muted">Scheme/Sector/Job Role/NSQF/QP Code</small>
                                            <p>{{$candidate->jobrole->partnerjobrole->scheme->scheme}} |
                                                {{$candidate->jobrole->partnerjobrole->sector->sector}} |
                                                {{$candidate->jobrole->partnerjobrole->jobrole->job_role}} |
                                                {{$candidate->jobrole->partnerjobrole->jobrole->nsqf_level}} |
                                                {{$candidate->jobrole->partnerjobrole->jobrole->qp_code}}
                                            </p>
                                            <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Scheme Status </small>
                                            <p class="text-{{($candidate->jobrole->partnerjobrole->status)?'success':'danger'}}"><strong>Scheme is {{($candidate->jobrole->partnerjobrole->status)?'Active':'Inactive'}}</strong></p>
                                        <hr>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-6">
                                            <small class="text-muted">Disability Type</small>
                                            <p>{{$candidate->disability->e_expository}}</p>
                                            <hr>
                                    </div>
                                    <div class="col-sm-6">
                                        <small class="text-muted">Disability Certificate</small>
                                        @if (!is_null($candidate->d_cert))
                                            <p>Document &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route('center.files.candidate-file',['action'=>'download','id'=>$candidate->id,'file'=>'cert'])}}" download="{{basename($candidate->d_cert)}}"><i class="zmdi zmdi-download"></i></a>
                                            </p>
                                        @else
                                            <p>No Document Provided</p>                                                 
                                        @endif
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                        <div class="col-sm-6">
                                                <small class="text-muted">Address</small>
                                                <p>{{$candidate->address}}</p>
                                                <hr>
                                        </div>
                                    
                                        <div class="col-sm-6">
                                                <small class="text-muted">State District</small>
                                                <p>{{$state_dist->district}} ({{$state_dist->state}})</p>
                                                <hr>
                                        </div>
                                       
                                    </div>
                                <div class="row">
                                        <div class="col-sm-4">
                                                <small class="text-muted">Category </small>
                                                <p>{{$candidate->category}}</p>
                                                <hr>
                                        </div>
                                    
                                        <div class="col-sm-4">
                                                <small class="text-muted">Ex Service Employee </small>
                                                <p>{{$candidate->service}}</p>
                                                <hr>
                                        </div>
                                        <div class="col-sm-4">
                                                <small class="text-muted">Education</small>
                                                <p>{{$candidate->education}}</p>
                                                <hr>
                                        </div>
                                       
                                    </div>
                                <div class="row">
                                        <div class="col-sm-6">
                                                <small class="text-muted">Guardian Name  </small>
                                                <p>{{$candidate->g_name}}</p>
                                                <hr>
                                        </div>
                                    
                                        <div class="col-sm-6">
                                                <small class="text-muted">Guardian Type </small>
                                                <p>{{$candidate->g_type}}</p>
                                                <hr>
                                        </div>
                                       
                                       
                                    </div>
                                
                            </div>
                        </li>
                    </ul>
                  
                    @if (Request::segment(1)==='admin')
                        <div class="text-center" >
                            <button class="btn btn-primary" onclick="location.href='{{route('admin.tc.edit.candidate',['id' => Crypt::encrypt($candidate->id) ])}}'"><i class="zmdi zmdi-edit"></i> &nbsp;&nbsp; Edit</button>                         
                        </div>
                    @endif
                   
                </div>
            </div>
        </div>
    </div>
</div>

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
                var id={{$candidate->id}};
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

@auth('partner')
    @if (Auth::guard('partner')->user()->can('partner-center-profile-active-verified', $candidate))
        <script>
            function update(v){
                dataValues = v.split(',');
                swal({
                    title: "Update TC SPOC Details",
                    text: "Please Provide The Updated Value",
                    type: "input",
                    confirmButtonText: 'UPDATE',
                    cancelButtonText: 'NOT NOW',
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                    inputValue: dataValues[0]
                }, function (value) {
                    if (value === false) return false;
                    if (value === "") {
                        swal.showInputError("You need to write something!"); return false
                    }
                    var id='{{$candidate->id}}';
                    let _token = $("input[name='_token']").val();
                    var name = dataValues[1]
                    $.ajax({
                    type: "POST",
                    url: "{{ route('partner.tc.center.update') }}",
                    data: {_token,id,name,value},
                    success: function(data) {
                        swal({
                            title: data['title'],
                            text: data['message'],
                            type: data['type'],
                            html: true,
                            showConfirmButton: true
                        },function(isConfirm){
                            if (isConfirm){
                                    setTimeout(function(){location.reload()},150);
                            } 
                        });
                    },
                    error:function(){
                        setTimeout(function () {
                            swal("Sorry", "Something Went Wrong, Please Try Again", "error");
                        }, 2000);
                    }
                    }); 
                });
            }
        </script>
    @endif
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