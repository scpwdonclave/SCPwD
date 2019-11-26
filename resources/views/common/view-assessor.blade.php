@extends('layout.master')
@section('title', 'Assessor')
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
                    @if (!is_null($assessorData->as_id))
                        <div class="text-center">
                            <h6>
                                AS ID: <span style='color:blue'>{{$assessorData->as_id}}</span>
                            </h6>
                        </div>
                        <br>
                    @endif
                    <ul class="cbp_tmtimeline">
                        
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Assessor General Details</span></time>
                            <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-account"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Assessor Name</small>
                                        <p>{{$assessorData->name}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">Mobile</small>
                                        <p>{{$assessorData->mobile}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Email</small>
                                        <p>{{$assessorData->email}}</p>
                                        <hr>
                                    </div>
                                  
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Date of Birth</small>
                                        <p>{{$assessorData->birth}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Gender</small>
                                        <p>{{$assessorData->gender}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">Language</small>
                                       <p>
                                        @foreach ($language as $item)
                                           {{$item->language}},
                                       @endforeach
                                       </p>
                                        <hr>
                                    </div>
                
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Religion</small>
                                        <p>{{$assessorData->religion}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">Category</small>
                                        <p>{{$assessorData->category}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Disability Type</small>
                                        @if (!is_null($assessorData->d_type))
                                        <p>{{$assessorData->disability->e_expository}}</p>
                                        @endif
                                        <hr>
                                    </div>
                
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Disability Certificate</small>
                                        @if (!is_null($assessorData->d_certificate))
                                            <p>
                                                Certificate &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route('agency.files.assessor-file',['id'=>$assessorData->id,'action'=>'download','column'=>'d_certificate'])}}"><i class="zmdi zmdi-download"></i></a>                                                    
                                            </p>
                                        @else
                                            <p>No Certificate Provided</p>
                                        @endif
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">Aadhaar</small>
                                        <p>{{$assessorData->aadhaar}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Aadhaar Document</small>
                                        @if (!is_null($assessorData->aadhaar_doc))
                                            <p>
                                                {{$assessorData->aadhaar}} &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route('agency.files.assessor-file',['id'=>$assessorData->id,'action'=>'download','column'=>'aadhaar_doc'])}}" ><i class="zmdi zmdi-download"></i></a>                                                    
                                            </p>
                                        @else
                                            <p>No Certificate Provided</p>
                                        @endif
                                        <hr>
                                    </div>
                
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">PAN No</small>
                                        <p>{{$assessorData->pan}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Pan Document</small>
                                        @if (!is_null($assessorData->pan_doc))
                                            <p>
                                                {{$assessorData->pan}} &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route('agency.files.assessor-file',['id'=>$assessorData->id,'action'=>'download','column'=>'pan_doc'])}}" ><i class="zmdi zmdi-download"></i></a>                                                    
                                            </p>
                                        @else
                                            <p>No Certificate Provided</p>
                                        @endif
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">Applicant Category</small>
                                        <p>{{$assessorData->applicant_cat}}</p>
                                        <hr>
                                    </div>
                
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Photo</small>
                                        @if (!is_null($assessorData->photo))
                                            <p>
                                                Photo &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route('agency.files.assessor-file',['id'=>$assessorData->id,'action'=>'download','column'=>'photo'])}}"><i class="zmdi zmdi-download"></i></a>                                                    
                                            </p>
                                        @else
                                            <p>No Certificate Provided</p>
                                        @endif
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Address Details</span></time>
                            <div class="cbp_tmicon bg-blue"> <i class="zmdi zmdi-pin"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Address</small>
                                        <p>{{$assessorData->address}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">Post Office</small>
                                        <p>{{$assessorData->post_office}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">State - District</small>
                                        <p>{{$assessorState->state}} ({{$assessorState->district}})</p>
                                        <hr>
                                    </div>
                                  
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Sub-District</small>
                                        <p>{{$assessorData->sub_district}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Parliament Constituency</small>
                                        <p>{{$assessorState->constituency}} ({{$assessorState->state_ut}})</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">City/Town/Village</small>
                                        <p>{{$assessorData->city}}</p>
                                        <hr>
                                    </div>
                
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">PIN code</small>
                                        <p>{{$assessorData->pin}}</p>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Education Details</span></time>
                            <div class="cbp_tmicon bg-red"> <i class="zmdi zmdi-xbox"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Education Attaind</small>
                                        <p>{{$assessorData->education}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">Details of Education</small>
                                        <p>{{$assessorData->edu_details}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Education Certificate</small>
                                        @if (!is_null($assessorData->edu_doc))
                                            <p>
                                                Certificate &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route('agency.files.assessor-file',['id'=>$assessorData->id,'action'=>'download','column'=>'edu_doc'])}}" ><i class="zmdi zmdi-download"></i></a>                                                    
                                            </p>
                                        @else
                                            <p>No Certificate Provided</p>
                                        @endif
                                        <hr>
                                    </div>
                                  
                                </div>
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Industry Experience Details</span></time>
                            <div class="cbp_tmicon bg-brown"> <i class="zmdi zmdi-vimeo"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Relevant Sector</small>
                                        <p>{{$assessorData->relevantSectors->sector}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">Experience Year</small>
                                        <p>{{$assessorData->exp_year}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Experience Month</small>
                                        <p>{{$assessorData->exp_month}}</p>
                                        <hr>
                                    </div>
                                  
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <small class="text-muted">Details of Experience</small>
                                        <p>{{$assessorData->exp_dtl}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-6">
                                        <small class="text-muted">Details of Industries</small>
                                        <p>{{$assessorData->industry_dtl}} year</p>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Experience Certificate</small>
                                        @if (!is_null($assessorData->exp_doc))
                                        <p>
                                            Certificate &nbsp;&nbsp;
                                            <a class="btn-icon-mini" href="{{route('agency.files.assessor-file',['id'=>$assessorData->id,'action'=>'download','column'=>'exp_doc'])}}"><i class="zmdi zmdi-download"></i></a>                                                    
                                        </p>
                                    @else
                                        <p>No Certificate Provided</p>
                                    @endif
                                    <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                            <small class="text-muted">Resume / CV</small>
                                            @if (!is_null($assessorData->resume))
                                            <p>
                                                Document &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route('agency.files.assessor-file',['id'=>$assessorData->id,'action'=>'download','column'=>'resume'])}}" ><i class="zmdi zmdi-download"></i></a>                                                    
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
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>SSC Certification</span></time>
                            <div class="cbp_tmicon bg-violet"> <i class="zmdi zmdi-8tracks"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Domain Certificate</small>
                                        @if (!is_null($assessorData->domain_doc))
                                            <p>
                                                Certificate &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route('agency.files.assessor-file',['id'=>$assessorData->id,'action'=>'download','column'=>'domain_doc'])}}" ><i class="zmdi zmdi-download"></i></a>                                                    
                                            </p>
                                        @else
                                            <p>No Certificate Provided</p>
                                        @endif
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">Sector</small>
                                        <p>{{$assessorData->sectors->sector}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">SCPwD Certificate No</small>
                                        <p>{{$assessorData->scpwd_certi_no}}</p>
                                        <hr>
                                    </div>
                                  
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">SCPwD Certificate</small>
                                        @if (!is_null($assessorData->scpwd_doc))
                                            <p>
                                                {{$assessorData->scpwd_certi_no}}&nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route('agency.files.assessor-file',['id'=>$assessorData->id,'action'=>'download','column'=>'scpwd_doc'])}}"><i class="zmdi zmdi-download"></i></a>                                                    
                                            </p>
                                        @else
                                            <p>No Certificate Provided</p>
                                        @endif
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">Date of Certification</small>
                                        <p>{{$assessorData->certi_date}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Certification valid Upto</small>
                                        <p>{{$assessorData->certi_end_date}}</p>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </li>
                        
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Assessor Job Roles</span></time> 
                            <div class="cbp_tmicon bg-pink"> <i class="zmdi zmdi-collection-text"></i></div>
                            <div class="cbp_tmlabel">
                                    <div class="table-responsive">
                                            <table class="table m-b-0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Job Role</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $i=0;
                                                    @endphp
                                                    @foreach ($assessorData->assessorJob as $item) 
                                                    <tr>
                                                       @php
                                                            $i++;
                                                        @endphp
                                                        <td>{{$i}}</td>
                                                        <td>{{$item->jobRoles->job_role}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                </div>
                        </li>
                        
                        
                    </ul>
                    @auth('admin')
                        <div class="text-center" >
                            @if (Request::segment(1)==='admin')
                                @if (is_null($assessorData->attached))
                                    @if (!$assessorData->verified )
                                        <button class="btn btn-success" onclick="location.href='{{route('admin.as.assessor.verify',['trainer_id' => Crypt::encrypt($assessorData->id) ])}}';this.disabled = true;">Accept</button>
                                        <button class="btn btn-danger" onclick="showPromptMessage();">Reject</button>
                                    @elseif ( $assessorData->verified==1)
                                        <button class="btn" onclick="location.href='{{route('admin.as.edit.assessor',['as_id' => Crypt::encrypt($assessorData->id) ])}}'">Edit</button>                         
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
                var id={{$assessorData->id}};
                var note=inputValue;
                let _token = $("input[name='_token']").val();
            
                $.ajax({
                type: "POST",
                url: "{{route('admin.as.reject.assessor')}}",
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
                
                window.location="{{route('admin.as.pending-assessors')}}";
        
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