@extends('layout.master')
@section('title', 'Center')
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
                    <ul class="cbp_tmtimeline">
                        
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>SPOC DETAILS</span></time>
                            <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-case"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                            <small class="text-muted">SPOC Name</small>
                                            <p>{{$centerData->spoc_name}}</p>
                                            <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                            <small class="text-muted">SPOC Email </small>
                                            <p>{{$centerData->email}}</p>
                                            <hr>
                                    </div>
                                    <div class="col-sm-4">
                                            <small class="text-muted">SPOC Phone</small>
                                            <p>{{$centerData->mobile}}</p>
                                            <hr>
                                    </div>
                                    {{-- <div class="col-sm-4">
                                        <small class="text-muted">Incorp. Document</small>
                                        <p>Document
                                            &nbsp;&nbsp;
                                        <a class="btn-icon-mini" href="{{route('partner.files.partner-file',['action'=>'download','filename'=>basename($centerData->incorp_doc)])}}" download="{{basename($centerData->incorp_doc)}}"><i class="zmdi zmdi-download"></i></a>
                                        </p>
                                        <hr>
                                </div> --}}
                                  
                                </div>
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Training Center Details</span></time>
                            <div class="cbp_tmicon bg-blue"> <i class="zmdi zmdi-case"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                            <small class="text-muted">Training Center Name</small>
                                            <p>{{$centerData->center_name}}</p>
                                            <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                            <small class="text-muted">Training Center Address</small>
                                            <p>{{$centerData->center_address}}</p>
                                            <hr>
                                    </div>
                                    <div class="col-sm-4">
                                            <small class="text-muted">Landmark</small>
                                            <p>{{$centerData->landmark}}</p>
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
                                                <p> &nbsp;&nbsp;
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
                            <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-case"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-3">
                                            <small class="text-muted">Center Front View</small>
                                            <p>Center Front Image &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route('center.files.center-file',['action'=>'download','filename'=>basename($centerData->center_front_view)])}}" download="{{basename($centerData->center_front_view)}}"><i class="zmdi zmdi-download"></i></a>
                                                </p>
                                            <hr>
                                    </div>
                                
                                    <div class="col-sm-3">
                                            <small class="text-muted">Center Back View</small>
                                            <p>Center Back Image &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route('center.files.center-file',['action'=>'download','filename'=>basename($centerData->center_back_view)])}}" download="{{basename($centerData->center_back_view)}}"><i class="zmdi zmdi-download"></i></a>
                                                </p>
                                            <hr>
                                    </div>
                                    <div class="col-sm-3">
                                            <small class="text-muted">Center Right View</small>
                                            <p>Center Right Image &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route('center.files.center-file',['action'=>'download','filename'=>basename($centerData->center_right_view)])}}" download="{{basename($centerData->center_right_view)}}"><i class="zmdi zmdi-download"></i></a>
                                                </p>
                                            <hr>
                                    </div>
                                    <div class="col-sm-3">
                                        <small class="text-muted">Center Left View</small>
                                        <p>Center Left Image&nbsp;&nbsp;
                                            <a class="btn-icon-mini" href="{{route('center.files.center-file',['action'=>'download','filename'=>basename($centerData->center_left_view)])}}" download="{{basename($centerData->center_left_view)}}"><i class="zmdi zmdi-download"></i></a>
                                            </p>
                                        <hr>
                                </div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                            <small class="text-muted">Biometric System</small>
                                            <p>Biometric &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route('center.files.center-file',['action'=>'download','filename'=>basename($centerData->biometric)])}}" download="{{basename($centerData->biometric)}}"><i class="zmdi zmdi-download"></i></a>
                                                </p>
                                            <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                            <small class="text-muted">Drinking Facility</small>
                                            <p>Drinking &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route('center.files.center-file',['action'=>'download','filename'=>basename($centerData->drinking)])}}" download="{{basename($centerData->drinking)}}"><i class="zmdi zmdi-download"></i></a>
                                                </p>
                                            <hr>
                                    </div>
                                    <div class="col-sm-4">
                                            <small class="text-muted">Saftey</small>
                                            <p>Saftey &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route('center.files.center-file',['action'=>'download','filename'=>basename($centerData->safety)])}}" download="{{basename($centerData->safety)}}"><i class="zmdi zmdi-download"></i></a>
                                                </p>
                                            <hr>
                                    </div>
                                    
                                </div>
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Class Room Images</span></time>
                            <div class="cbp_tmicon bg-blush"> <i class="zmdi zmdi-case"></i></div>
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
                            <div class="cbp_tmicon bg-orange"> <i class="zmdi zmdi-case"></i></div>
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
                            <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-case"></i></div>
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
                            <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-case"></i></div>
                            <div class="cbp_tmlabel">
                                    <h2><a href="javascript:void(0);">Wash Room</a> <span>Images</span></h2>
                                <div class="row">
                                    @foreach ($centerData->center_docs as $docs)
                                        @if ($docs->room === 'wash')
                                            <div class="col-lg-3 col-md-6 col-6"><a href="javascript:void(0);"><img src="{{route('center.files.center-file',['action'=>'view','filename'=>basename($wash->doc)])}}" alt="" class="img-fluid img-thumbnail m-t-30"></a>
                                                <a href="{{route('center.files.center-file',['action'=>'download','filename'=>basename($wash->doc)])}}" download="{{basename($wash->doc)}}">Download</a>
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
                                <button class="btn btn-success" onclick="location.href='{{route('admin.tc.center.verify',['center_id' => Crypt::encrypt($centerData->id) ])}}'">Accept</button>
                                <button class="btn btn-danger" onclick="showPromptMessage();">Reject</button>
                            @elseif ( $centerData->verified==1)
                                <button class="btn" onclick="location.href='{{route('admin.tc.edit.center',['center_id' => Crypt::encrypt($centerData->id) ])}}'">Edit</button>                         
                            @endif
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

{{-- =================== --}}
<div class="container-fluid">
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
</div>
{{-- =================== --}}
@stop
@section('page-script')
@auth('admin')
    <script>
        function showPromptMessage() {
            swal({
                title: "An input!",
                text: "Write something interesting:",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                showLoaderOnConfirm: true,
                inputPlaceholder: "Write something"
            }, function (inputValue) {
                if (inputValue === false) return false;
                if (inputValue === "") {
                    swal.showInputError("You need to write something!"); return false
                }
                var id={{$centerData->id}};
                var note=inputValue;
                let _token = $("input[name='_token']").val();
            console.log(note);
            console.log(id);
                $.ajax({
                type: "POST",
                url: "{{route('admin.tc.reject.center')}}",
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
                //swal("Shortlisted!", "Candidates are successfully shortlisted!", "success");
                window.location="{{route('admin.tc.centers')}}";
        
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