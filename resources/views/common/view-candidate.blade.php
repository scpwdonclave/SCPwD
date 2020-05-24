@extends('layout.master')
@section('title', 'Candidate')
{{-- @section('parentPageTitle', 'Partners-verify') --}}
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/timeline.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">

@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                        <div class="text-center">
                            <h6>
                               CD ID: <span style="color:blue">{{$center_candidate->candidate->cd_id}}</span>&nbsp;&nbsp;&nbsp; {!!$center_candidate->cd_verified?'<i class="zmdi zmdi-shield-check" style="color:green"></i> Verified':NULL!!}
                            </h6>
                            <h6>
                                <span style='color:{{($center_candidate->candidate->status)?"green":"red"}}'>{{($center_candidate->candidate->status)?"Active":"Inactive"}}</span>
                            </h6>
                            @if ($center_candidate->dropout)
                                <h6><span style="color:blue">Dropped out</span></h6>
                            @endif
                            @switch($center_candidate->passed)
                            @case('0')
                                    <h6><span style="color:red">Failed</span></h6>
                                    @break
                            @case('1')
                                    <h6><span style="color:green">Passed</span></h6>
                                    @break
                            @case('2')
                                    <h6><span style="color:red">Absent</span></h6>
                                    @break
                            @default
                            @endswitch
                            @if (Request::segment(1)==='admin')
                                {!!$center_candidate->cd_verified?NULL:($center_candidate->candidate->doc_type?'<button type="button" id="verify_btn" onclick="request_verify()" class="badge bg-green">Verify Record</button>':NULL)!!}
                            @endif
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
                                        <p>{{$center_candidate->center->partner->tp_id}} <span style='color:{{($center_candidate->center->partner->status)?"green":"red"}}'><strong>{{($center_candidate->center->partner->status)?"Active":"Inactive"}}</strong></span></p>
                                        <hr>
                                    </div>
                                    
                                    <div class="col-sm-3">
                                        <small class="text-muted">Training Center</small>
                                        <p>{{$center_candidate->center->tc_id}} <span style='color:{{($center_candidate->center->status)?"green":"red"}}'><strong>{{($center_candidate->center->status)?"Active":"Inactive"}}</strong></span></p>
                                        <hr>
                                    </div>

                                    <div class="col-sm-3">
                                        <small class="text-muted">Aadhaar/Voter Number</small>
                                        <p>{{$center_candidate->candidate->doc_no}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-3">
                                        <small class="text-muted">Aadhaar/Voter Document</small>
                                        @if (!is_null($center_candidate->candidate->doc_file))
                                            <p>Document &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route('center.files.candidate-file',['action'=>'download','id'=>$center_candidate->candidate->id,'file'=>'doc'])}}" download="{{basename($center_candidate->candidate->doc_file)}}"><i class="zmdi zmdi-download"></i></a>
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
                                        <p>{{$center_candidate->candidate->name}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">Candidate Contact </small>
                                        <p>{{$center_candidate->candidate->contact}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Candidate Email </small>
                                        <p>{{$center_candidate->candidate->email}}</p>
                                        <hr>
                                    </div>
                                  
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Gender</small>
                                        <p>{{$center_candidate->candidate->gender}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Date of Birth</small>
                                        <p>{{$center_candidate->candidate->dob}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">Marital Status</small>
                                        <p>
                                            {{$center_candidate->m_status}}</p>
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
                                            <p>{{$center_candidate->jobrole->partnerjobrole->scheme->scheme}} |
                                                {{$center_candidate->jobrole->partnerjobrole->sector->sector}} |
                                                {{$center_candidate->jobrole->partnerjobrole->jobrole->job_role}} |
                                                {{$center_candidate->jobrole->partnerjobrole->jobrole->nsqf_level}} |
                                                {{$center_candidate->jobrole->partnerjobrole->jobrole->qp_code}}
                                            </p>
                                            <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Scheme Status </small>
                                            <p class="text-{{($center_candidate->jobrole->partnerjobrole->status)?'success':'danger'}}"><strong>Scheme is {{($center_candidate->jobrole->partnerjobrole->status)?'Active':'Inactive'}}</strong></p>
                                        <hr>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-6">
                                            <small class="text-muted">Disability Type</small>
                                            <p>{{$center_candidate->disability->e_expository}}</p>
                                            <hr>
                                    </div>
                                    <div class="col-sm-6">
                                        <small class="text-muted">Disability Certificate</small>
                                        @if (!is_null($center_candidate->d_cert))
                                            <p>Document &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route('center.files.candidate-file',['action'=>'download','id'=>$center_candidate->candidate->id,'file'=>'cert'])}}" download="{{basename($center_candidate->d_cert)}}"><i class="zmdi zmdi-download"></i></a>
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
                                                <p>{{$center_candidate->address}}</p>
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
                                                <p>{{$center_candidate->candidate->category}}</p>
                                                <hr>
                                        </div>
                                    
                                        <div class="col-sm-4">
                                                <small class="text-muted">Ex Service Employee </small>
                                                <p>{{$center_candidate->service}}</p>
                                                <hr>
                                        </div>
                                        <div class="col-sm-4">
                                                <small class="text-muted">Education</small>
                                                <p>{{$center_candidate->education}}</p>
                                                <hr>
                                        </div>
                                       
                                    </div>
                                <div class="row">
                                        <div class="col-sm-6">
                                                <small class="text-muted">Guardian Name  </small>
                                                <p>{{$center_candidate->g_name}}</p>
                                                <hr>
                                        </div>
                                    
                                        <div class="col-sm-6">
                                                <small class="text-muted">Guardian Type </small>
                                                <p>{{$center_candidate->g_type}}</p>
                                                <hr>
                                        </div>
                                       
                                       
                                    </div>
                                
                            </div>
                        </li>
                    </ul>
                  
                    @if (Request::segment(1)==='admin')
                        <div class="text-center" >
                            <button class="btn btn-primary" onclick="location.href='{{route('admin.tc.edit.candidate',['id' => Crypt::encrypt($center_candidate->id) ])}}'"><i class="zmdi zmdi-edit"></i> &nbsp;&nbsp; Edit</button>                         
                        </div>
                    @endif
                   
                </div>
            </div>
        </div>
    </div>
</div>

@stop
@section('page-script')

@auth('partner')
    @if (Auth::guard('partner')->user()->can('partner-center-profile-active-verified', $center_candidate->center))
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
                    var id='{{$center_candidate->candidate->id}}';
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
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>

@if ($center_candidate->candidate->doc_type)
<script>
    function request_verify(){
        let swalText = document.createElement("div");
        let _token = $('[name=_token]').val();
        let aadhaar = '{{$center_candidate->candidate->doc_no}}';
        let dob = '{{$center_candidate->candidate->dob}}';
        let gender = '{{$center_candidate->candidate->gender}}';
        let ccid = '{{$center_candidate->id}}';
        $('#verify_btn').prop("disabled", true).html("Verifing, Please wait ...");
        $.ajax({
            url: "{{ route('admin.docno.verification.api') }}",
            method: "POST",
            data: { _token, aadhaar, dob, gender, ccid },
            success: function(data){
                if (data.success) {
                    swalText.innerHTML = data.message;
                    swal({title: "Attention", content: swalText, icon: 'success', closeModal: true,timer: 5000, buttons: false}).then(()=>location.reload());
                } else {
                    swalText.innerHTML = data.message;
                    swal({title: "Attention", content: swalText, icon: 'error', closeModal: true,timer: 5000, buttons: false});
                    $('#verify_btn').prop("disabled", false).html("Verify record");
                }
            },
            error: function(data){
                swalText.innerHTML = 'Something Went Wrong, Please Try Again';
                swal({title: "Attention", content: swalText, icon: 'error', closeModal: true,timer: 3000, buttons: false}).then(function(){location.reload();});
            }
        })
    }
</script>    
@endif

@stop