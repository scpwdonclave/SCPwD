@extends('layout.master')
@section('title', 'Center')
{{-- @section('parentPageTitle', 'Partners-verify') --}}
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/timeline.css')}}">
{{-- <link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/> --}}
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                    @if (!is_null($centerData->tc_id))
                        <div class="text-center">
                            <h6>
                                TC ID: <span style='color:blue'>{{$centerData->tc_id}}</span> <br> <br>
                                <span style='color:{{($centerData->status)?"green":"red"}}'>{{($centerData->status)?"Active":"Inactive"}}</span>
                            </h6>
                        </div>
                        <br>
                    @endif
                    <ul class="cbp_tmtimeline">
                        
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>SPOC DETAILS</span></time>
                            <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-account"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                            <span class="d-flex justify-content-between">
                                                <small class="text-muted">SPOC Name</small>
                                                @auth('partner')
                                                {{-- @if (Gate::forUser(Auth::guard('partner')->user())->allows('partner-center-profile-active-verified', $centerData))
                                                    hi
                                                @endif --}}
                                                @if (Auth::guard('partner')->user()->can('partner-center-profile-active-verified', $centerData))
                                                    <span class="badge badge-success"onclick="update('{{$centerData->spoc_name}},name')">Change</span>
                                                @endif
                                                @endauth
                                            </span>
                                            <p>{{$centerData->spoc_name}}</p>
                                            <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                            <span class="d-flex justify-content-between">
                                                <small class="text-muted">SPOC Email</small>
                                                @auth('partner')
                                                    @if (Auth::guard('partner')->user()->can('partner-center-profile-active-verified', $centerData))
                                                        <span class="badge badge-success"onclick="update('{{$centerData->email}},email')">Change</span>
                                                    @endif
                                                @endauth
                                            </span>
                                            <p>{{$centerData->email}}</p>
                                            <hr>
                                    </div>
                                    <div class="col-sm-4">
                                            <span class="d-flex justify-content-between">
                                                <small class="text-muted">SPOC Mobile</small>
                                                @auth('partner')
                                                    @if (Auth::guard('partner')->user()->can('partner-center-profile-active-verified', $centerData))
                                                        <span class="badge badge-success"onclick="update('{{$centerData->mobile}},mobile')">Change</span>
                                                    @endif
                                                @endauth
                                            </span>
                                            <p>{{$centerData->mobile}}</p>
                                            <hr>
                                    </div>
                                  
                                </div>
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Training Center Details</span></time>
                            <div class="cbp_tmicon bg-blue"> <i class="zmdi zmdi-local-store"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Training Partner</small>
                                        <p>{{$centerData->partner->tp_id}} <span style='color:{{($centerData->partner->status)?"green":"red"}}'><strong>{{($centerData->partner->status)?"Active":"Inactive"}}</strong></span></p>
                                        <hr>
                                    </div>
                                 
                                    <div class="col-sm-4">
                                        <small class="text-muted">Training Center Name</small>
                                        <p>{{$centerData->center_name}}</p>
                                        <hr>
                                    </div>
                                 
                                    <div class="col-sm-4">
                                        <small class="text-muted">Landmark</small>
                                        <p>{{$centerData->landmark}}</p>
                                        <hr>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <small class="text-muted">Training Center Address</small>
                                        <p>{{$centerData->center_address}}</p>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                        <div class="col-sm-6">
                                                <small class="text-muted">Address Proof</small>
                                                <p>{{$centerData->addr_proof}}</p>
                                                <hr>
                                        </div>
                                    
                                        <div class="col-sm-6">
                                                <small class="text-muted">Address Proof Document</small>
                                                <p>Document &nbsp;&nbsp;
                                                    <a class="btn-icon-mini" href="{{route('center.files.center-file',['action'=>'download','filename'=>basename($centerData->addr_doc)])}}" download="{{basename($centerData->addr_doc)}}"><i class="zmdi zmdi-download"></i></a>
                                                    </p>
                                                <hr>
                                        </div>
                                    </div>
                                <div class="row">
                                        <div class="col-sm-6">
                                                <small class="text-muted">State/Union Territory - District</small>
                                                <p>{{$state_district->state}} ({{$state_district->district}})</p>
                                                <hr>
                                        </div>
                                    
                                        <div class="col-sm-6">
                                                <small class="text-muted">Parliament Constituency</small>
                                                <p>{{$state_district->constituency}}</p>
                                                <hr>
                                        </div>
                                    </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                            <small class="text-muted">City/Town/Village</small>
                                            <p>{{$centerData->city}}</p>
                                            <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                            <small class="text-muted">Tehsil/Mandal/Block</small>
                                            <p>{{$centerData->block}}</p>
                                            <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">PIN code</small>
                                        <p>{{$centerData->pin}}</p>
                                        <hr>
                                </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Center Image</span></time>
                            <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-image-alt"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-3">
                                            <small class="text-muted">Center Front View</small>
                                            @if($centerData->center_front_view !=null)
                                            <p>Center Front Image &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route('center.files.center-file',['action'=>'download','filename'=>basename($centerData->center_front_view)])}}" download="{{basename($centerData->center_front_view)}}"><i class="zmdi zmdi-download"></i></a>
                                            </p>
                                            @endif
                                            <hr>
                                    </div>
                                
                                    <div class="col-sm-3">
                                            <small class="text-muted">Center Back View</small>
                                            @if($centerData->center_back_view !=null)
                                            <p>Center Back Image &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route('center.files.center-file',['action'=>'download','filename'=>basename($centerData->center_back_view)])}}" download="{{basename($centerData->center_back_view)}}"><i class="zmdi zmdi-download"></i></a>
                                            </p>
                                            @endif    
                                            <hr>
                                    </div>
                                    <div class="col-sm-3">
                                            <small class="text-muted">Center Right View</small>
                                            @if($centerData->center_right_view !=null)
                                            <p>Center Right Image &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route('center.files.center-file',['action'=>'download','filename'=>basename($centerData->center_right_view)])}}" download="{{basename($centerData->center_right_view)}}"><i class="zmdi zmdi-download"></i></a>
                                            </p>
                                            @endif
                                            <hr>
                                    </div>
                                    <div class="col-sm-3">
                                        <small class="text-muted">Center Left View</small>
                                        @if($centerData->center_left_view !=null)
                                        <p>Center Left Image&nbsp;&nbsp;
                                            <a class="btn-icon-mini" href="{{route('center.files.center-file',['action'=>'download','filename'=>basename($centerData->center_left_view)])}}" download="{{basename($centerData->center_left_view)}}"><i class="zmdi zmdi-download"></i></a>
                                        </p>
                                        @endif    
                                        <hr>
                                </div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                            <small class="text-muted">Biometric System</small>
                                            @if($centerData->biometric !=null)
                                            <p>Biometric &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route('center.files.center-file',['action'=>'download','filename'=>basename($centerData->biometric)])}}" download="{{basename($centerData->biometric)}}"><i class="zmdi zmdi-download"></i></a>
                                            </p>
                                            @endif    
                                            <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                            <small class="text-muted">Drinking Facility</small>
                                            @if($centerData->drinking !=null)
                                            <p>Drinking &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route('center.files.center-file',['action'=>'download','filename'=>basename($centerData->drinking)])}}" download="{{basename($centerData->drinking)}}"><i class="zmdi zmdi-download"></i></a>
                                            </p>
                                            @endif    
                                            <hr>
                                    </div>
                                    <div class="col-sm-4">
                                            <small class="text-muted">Saftey</small>
                                            @if($centerData->safety !=null)
                                            <p>Saftey &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route('center.files.center-file',['action'=>'download','filename'=>basename($centerData->safety)])}}" download="{{basename($centerData->safety)}}"><i class="zmdi zmdi-download"></i></a>
                                            </p>
                                            @endif    
                                            <hr>
                                    </div>
                                    
                                </div>
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Class Room Images</span></time>
                            <div class="cbp_tmicon bg-blush"> <i class="zmdi zmdi-collection-folder-image"></i></div>
                            <div class="cbp_tmlabel">
                                    <h2><a href="javascript:void(0);">Class Room</a> <span>Images</span></h2>
                                <div class="row">
                                    @foreach ($centerData->center_docs as $docs)
                                        @if ($docs->room === 'class')
                                            <div class="col-lg-3 col-md-6 col-6"><a href="javascript:void(0);"><img src="{{route('center.files.center-file',['action'=>'view','filename'=>basename($docs->doc)])}}" alt="" class="img-fluid img-thumbnail m-t-30"></a>
                                                <a href="{{route('center.files.center-file',['action'=>'download','filename'=>basename($docs->doc)])}}" download="{{basename($docs->doc)}}">Download</a>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Lab Room Images</span></time>
                            <div class="cbp_tmicon bg-orange"> <i class="zmdi zmdi-collection-folder-image"></i></div>
                            <div class="cbp_tmlabel">
                                    <h2><a href="javascript:void(0);">Lab Room</a> <span>Images</span></h2>
                                <div class="row">
                                    @foreach ($centerData->center_docs as $docs)
                                        @if ($docs->room === 'lab')
                                            <div class="col-lg-3 col-md-6 col-6"><a href="javascript:void(0);"><img src="{{route('center.files.center-file',['action'=>'view','filename'=>basename($docs->doc)])}}" alt="" class="img-fluid img-thumbnail m-t-30"></a>
                                                <a href="{{route('center.files.center-file',['action'=>'download','filename'=>basename($docs->doc)])}}" download="{{basename($docs->doc)}}">Download</a>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Equipments Room Images</span></time>
                            <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-collection-folder-image"></i></div>
                            <div class="cbp_tmlabel">
                                    <h2><a href="javascript:void(0);">Equipments Room</a> <span>Images</span></h2>
                                <div class="row">
                                    @foreach ($centerData->center_docs as $docs)
                                        @if ($docs->room === 'equip')
                                            <div class="col-lg-3 col-md-6 col-6"><a href="javascript:void(0);"><img src="{{route('center.files.center-file',['action'=>'view','filename'=>basename($docs->doc)])}}" alt="" class="img-fluid img-thumbnail m-t-30"></a>
                                                <a href="{{route('center.files.center-file',['action'=>'download','filename'=>basename($docs->doc)])}}" download="{{basename($docs->doc)}}">Download</a>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Wash Room Images</span></time>
                            <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-collection-folder-image"></i></div>
                            <div class="cbp_tmlabel">
                                    <h2><a href="javascript:void(0);">Wash Room</a> <span>Images</span></h2>
                                <div class="row">
                                    @foreach ($centerData->center_docs as $docs)
                                        @if ($docs->room === 'wash')
                                            <div class="col-lg-3 col-md-6 col-6"><a href="javascript:void(0);"><img src="{{route('center.files.center-file',['action'=>'view','filename'=>basename($docs->doc)])}}" alt="" class="img-fluid img-thumbnail m-t-30"></a>
                                                <a href="{{route('center.files.center-file',['action'=>'download','filename'=>basename($docs->doc)])}}" download="{{basename($docs->doc)}}">Download</a>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </li>
                        
                        
                        
                        
                    </ul> 
                    @auth('admin')
                        <div class="text-center" >
                            @if ($centerData->status==0 && $centerData->verified==0)
                                <button class="btn btn-success" onclick="location.href='{{route('admin.tc.center.action',[Crypt::encrypt($centerData->id),'accept'])}}';this.disabled = true;">Accept</button>
                                <button class="btn btn-danger" onclick="popupReject('{{Crypt::encrypt($centerData->id)}}');">Reject</button>
                            @elseif ( $centerData->verified==1)
                                <button class="btn" onclick="location.href='{{route('admin.tc.edit.center',Crypt::encrypt($centerData->id))}}'">Edit</button>                         
                            @endif
                        </div>
                    @endauth 
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
                        <h2><strong>Job</strong> Target of <span style='color:blue'>{{$centerData->tc_id}}</span></h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Scheme</th>
                                        <th>Sector</th>
                                        <th>Job Role</th>
                                        <th>Target Allocated</th>
                                        <th>Student Enrolled</th>
                                        <th>Target Achieved</th>
                                        <th>Scheme Status</th>
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
                                        <td class="text-{{($target->partnerjobrole->status)?'success':'danger'}}"><strong>Scheme is {{($target->partnerjobrole->status)?'Active':'Inactive'}}</strong></td>
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
<div class="container-fluid">
    <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Candidates </strong> of <span style='color:blue'>{{$centerData->tc_id}}</span></h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Candidate Name</th>
                                        <th>Contact</th>
                                        <th>Category</th>
                                        <th>Date of Birth</th>
                                        <th>Overall Status</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($centerData->candidates as $key => $candidate)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$candidate->name}}</td>
                                        <td>{{$candidate->contact}}</td>
                                        <td>{{$candidate->category}}</td>
                                        <td>{{$candidate->dob}}</td>
                                        <td style="color:{{($candidate->jobrole->partnerjobrole->status && $candidate->center->partner->status && $candidate->center->status && $candidate->status)?'green':'red'}}">{{($candidate->jobrole->partnerjobrole->status && $candidate->center->partner->status && $candidate->center->status && $candidate->status)?'Active':'Inactive'}}</td>
                                        <td><a class="badge bg-green margin-0" href="{{route(Request::segment(1).'.tc.candidate.view', Crypt::encrypt($candidate->id))}}" >View</a></td>
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

        function popupReject(id) {

            var confirmatonText = document.createElement("div");
            var _token=$('[name=_token]').val();
            color = 'red'; text = 'Rejection'; 
            displayText='Provide Center Rejection Reason ';
            confirmatonText="input"
            
            swal({
                text: displayText,
                content: confirmatonText,
                icon: "info",
                buttons: true,
                buttons: {
                        cancel: "No, Cencel",
                        confirm: {
                            text: "Confirm Reject",
                            closeModal: false
                        }
                    },
                closeModal: false,
                closeOnEsc: false,
            }).then(function(val){
                if (val != null) {
                    if (val === '') {
                        swal('Attention', 'Please Describe the Reason of Deactivation before Proceed', 'info');
                    } else {
                        let url = "{{route('admin.tc.center.action',[':id','reject',':reason'])}}}";
                        url = url.replace(':id', id); 
                        location.href = url.replace(':reason', val);
                    }
                }
            });
        }
    </script>
@endauth

@auth('partner')
    @if (Auth::guard('partner')->user()->can('partner-center-profile-active-verified', $centerData))
        <script>
            function update(v){
                dataValues = v.split(',');
                
                swal({
                    text: "Update TC SPOC Details",
                    content: {
                        element: "input",
                        attributes: {
                            value: dataValues[0],
                            type: "text",
                        },
                    },
                    icon: "info",
                    buttons: true,
                    buttons: {
                            cancel: "No, Cencel",
                            confirm: {
                                text: "Confirm UPDATE",
                                closeModal: false
                            }
                        },
                    closeModal: false,
                    closeOnEsc: false,
                }).then(function(value){
                    if (value != null) {
                        if (value === '') {
                            swal('Attention', 'Please Describe the Reason of Deactivation before Proceed', 'info');
                        } else {
                            var id='{{$centerData->id}}';
                            let _token = $("[name='_token']").val();
                            var name = dataValues[1]
                            $.ajax({
                                type: "POST",
                                url: "{{ route('partner.tc.center.update') }}",
                                data: {_token,id,name,value},
                                success: function(data) {
                                    var ResponseText = document.createElement("div");
                                    ResponseText.innerHTML=data['message'];
                                    swal({title: data['title'], content: ResponseText, icon: data['type'], closeModal: true,timer: 3000, buttons: false}).then(function(){location.reload();});
                                },
                                error:function(){
                                    swal('Oops', 'Something Went Wrong, Try Again Later', 'error').then(function () {
                                        location.reload();
                                    });
                                }
                            });
                        }
                    }
                });
            }
        </script>
    @endif
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