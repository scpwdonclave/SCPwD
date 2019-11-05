@extends('layout.master')
@section('title', 'Partners')
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
                        @if (!$partnerData->pending_verify)
                        <div class="text-center">
                            <h6>
                                TP ID: <span style='color:blue'>{{$partnerData->tp_id}}</span>
                            </h6>
                        </div>
                        <br>
                    @endif
                    <ul class="cbp_tmtimeline">
                       
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>SPOC MAIN</span></time>
                            <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-case"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                            <small class="text-muted">SPOC Name</small>
                                            <p>{{$partnerData->spoc_name}}</p>
                                            <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                            <small class="text-muted">SPOC Email </small>
                                            <p>{{$partnerData->email}}</p>
                                            <hr>
                                    </div>
                                    <div class="col-sm-4">
                                            <small class="text-muted">SPOC Phone</small>
                                            <p>{{$partnerData->spoc_mobile}}</p>
                                            <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Incorp. Document</small>
                                        <p>Document
                                            &nbsp;&nbsp;
                                        <a class="btn-icon-mini" href="{{route('partner.files.partner-file',['action'=>'download','filename'=>basename($partnerData->incorp_doc)])}}" download="{{basename($partnerData->incorp_doc)}}"><i class="zmdi zmdi-download"></i></a>
                                        </p>
                                        <hr>
                                </div>
                                  
                                </div>
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>General Details
                                </span></time>
                            <div class="cbp_tmicon bg-blue"> <i class="zmdi zmdi-dehaze"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                            <small class="text-muted">Oganization Name </small>
                                            <p>{{$partnerData->org_name}}</p>
                                            <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                            <small class="text-muted">Oganization Type</small>
                                            <p>{{$partnerData->org_type}}</p>
                                            <hr>
                                    </div>
                                    <div class="col-sm-4">
                                            <small class="text-muted">Establishment Year</small>
                                            <p>{{$partnerData->estab_year}}</p>
                                            <hr>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                        <div class="col-sm-4">
                                                <small class="text-muted">Landline</small>
                                                <p>{{$partnerData->landline}}</p>
                                                <hr>
                                        </div>
                                    
                                        <div class="col-sm-4">
                                                <small class="text-muted">Website</small>
                                                <p>{{$partnerData->website}}</p>
                                                <hr>
                                        </div>
                                    </div>
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>CEO/MD/Head of the Organization Details
                                </span></time>
                            <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-receipt"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                            <small class="text-muted">CEO/MD/Head's Name</small>
                                            <p>{{$partnerData->ceo_name}}&nbsp;</p>
                                            <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                            <small class="text-muted">CEO/MD/Head's Email Address</small>
                                            <p>{{$partnerData->ceo_email}}&nbsp;</p>
                                            <hr>
                                    </div>
                                    <div class="col-sm-4">
                                            <small class="text-muted">CEO/MD/Head's Mobile Number</small>
                                            <p>{{$partnerData->ceo_mobile}}&nbsp;</p>
                                            <hr>
                                    </div>
                                    
                                </div>
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Authorized Signatory Info</span></time>
                            <div class="cbp_tmicon bg-blush"> <i class="zmdi zmdi-shield-check"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                            <small class="text-muted">Authorized Signatory Name</small>
                                            <p>{{$partnerData->signatory_name}}&nbsp;</p>
                                            <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                            <small class="text-muted">Authorized Signatory Email Address</small>
                                            <p>{{$partnerData->signatory_email}}&nbsp;</p>
                                            <hr>
                                    </div>
                                    <div class="col-sm-4">
                                            <small class="text-muted">Authorized Signatory Mobile Number</small>
                                            <p>{{$partnerData->signatory_mobile}}&nbsp;</p>
                                            <hr>
                                    </div>
                                    
                                </div>
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Address of The Organization</span></time>
                            <div class="cbp_tmicon bg-cyan"> <i class="zmdi zmdi-pin"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                            <small class="text-muted">Address of the Organization</small>
                                            <p>{{$partnerData->org_address}}&nbsp;</p>
                                            <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                            <small class="text-muted">Nearby Landmark</small>
                                            <p>{{$partnerData->landmark}}&nbsp;</p>
                                            <hr>
                                    </div>
                                    <div class="col-sm-4">
                                            <small class="text-muted">Address Proof</small>
                                            <p>{{$partnerData->addr_proof}}
                                                &nbsp;&nbsp;
                                            <a class="btn-icon-mini" href="{{route('partner.files.partner-file',['action'=>'download','filename'=>basename($partnerData->addr_doc)])}}" download="{{basename($partnerData->addr_doc)}}"><i class="zmdi zmdi-download"></i></a>
                                            </p>
                                            <hr>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                        <div class="col-sm-4">
                                                <small class="text-muted">State/Union Territory - District</small>
                                                <p>{{$partnerState->state}} ({{$partnerState->district}})</p>
                                                <hr>
                                        </div>
                                    
                                        <div class="col-sm-4">
                                                <small class="text-muted">Parliament Constituency</small>
                                                <p>{{$partnerState->constituency}} ({{$partnerState->state_ut}})</p>
                                                <hr>
                                        </div>
                                        
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                            <small class="text-muted">City/Town/Village </small>
                                            <p>{{$partnerData->city}}</p>
                                            <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                            <small class="text-muted">Tehsil/Mandal/Block</small>
                                            <p>{{$partnerData->block}}</p>
                                            <hr>
                                    </div>
                                    <div class="col-sm-4">
                                            <small class="text-muted">PIN code</small>
                                            <p>{{$partnerData->pin}}</p>
                                            <hr>
                                    </div>
                                    
                            </div>
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Financial Information</span></time>
                            <div class="cbp_tmicon bg-orange"> <i class="zmdi zmdi-file"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    @if ($partnerData->ca1_year!=null)
                                    <div class="col-sm-3">
                                            <small class="text-muted">1 Pager CA Certificate of</small>
                                            <p>{{$partnerData->ca1_year}}
                                                    &nbsp;&nbsp;
                                                    <a class="btn-icon-mini" href="{{route('partner.files.partner-file',['action'=>'download','filename'=>basename($partnerData->ca1_doc)])}}" download="{{basename($partnerData->ca1_doc)}}"><i class="zmdi zmdi-download"></i></a>
                                                    
                                            </p>
                                            <hr>
                                    </div>  
                                    @endif
                                    @if ($partnerData->ca2_year!=null)
                                    <div class="col-sm-3">
                                            <small class="text-muted">1 Pager CA Certificate of</small>
                                            <p>{{$partnerData->ca2_year}}
                                                    &nbsp;&nbsp;
                                                    <a class="btn-icon-mini" href="{{route('partner.files.partner-file',['action'=>'download','filename'=>basename($partnerData->ca2_doc)])}}" download="{{basename($partnerData->ca2_doc)}}"><i class="zmdi zmdi-download"></i></a>
                                            </p>
                                            <hr>
                                    </div>  
                                    @endif
                                    @if ($partnerData->ca3_year!=null)
                                    <div class="col-sm-3">
                                            <small class="text-muted">1 Pager CA Certificate of</small>
                                            <p>{{$partnerData->ca3_year}}
                                                    &nbsp;&nbsp;
                                                    <a class="btn-icon-mini" href="{{route('partner.files.partner-file',['action'=>'download','filename'=>basename($partnerData->ca3_doc)])}}" download="{{basename($partnerData->ca3_doc)}}"><i class="zmdi zmdi-download"></i></a>
                                                    
                                            </p>
                                            <hr>
                                    </div>  
                                    @endif
                                    @if ($partnerData->ca4_year!=null)
                                    <div class="col-sm-3">
                                        <small class="text-muted">1 Pager CA Certificate of</small>
                                        <p>{{$partnerData->ca4_year}}
                                                &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route('partner.files.partner-file',['action'=>'download','filename'=>basename($partnerData->ca4_doc)])}}" download="{{basename($partnerData->ca4_doc)}}"><i class="zmdi zmdi-download"></i></a>
                                                
                                        </p>
                                        <hr>
                                    </div>  
                                    @endif
                                </div>
                                <div class="row">
                                        <div class="col-sm-4">
                                                <small class="text-muted">PAN Number</small>
                                                <p>{{$partnerData->pan}}
                                                        &nbsp;&nbsp;
                                                        <a class="btn-icon-mini" href="{{route('partner.files.partner-file',['action'=>'download','filename'=>basename($partnerData->pan_doc)])}}" download="{{basename($partnerData->pan_doc)}}"><i class="zmdi zmdi-download"></i></a>
                                                </p>
                                                <hr>
                                        </div>
                                        @if ($partnerData->gst!=null)
                                        <div class="col-sm-4">
                                            <small class="text-muted">GST Account Number</small>
                                            <p>{{$partnerData->gst}}
                                                    &nbsp;&nbsp;
                                                    <a class="btn-icon-mini" href="{{route('partner.files.partner-file',['action'=>'download','filename'=>basename($partnerData->gst_doc)])}}" download="{{basename($partnerData->gst_doc)}}"><i class="zmdi zmdi-download"></i></a>
                                                    
                                            </p>
                                            <hr>
                                        </div>  
                                        @endif
                                </div>

                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime"><span>Personal Information
                                </span></time>
                            <div class="cbp_tmicon bg-blush"> <i class="zmdi zmdi-account-o"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                            <small class="text-muted">Offer Letter </small>
                                            <p>{{$partnerData->offer}}
                                                    &nbsp;&nbsp;
                                                    <a class="btn-icon-mini" href="{{route('partner.files.partner-file',['action'=>'download','filename'=>basename($partnerData->offer_doc)])}}" download="{{basename($partnerData->offer_doc)}}"><i class="zmdi zmdi-download"></i></a>
                                            </p>
                                            <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                            <small class="text-muted">Offer LetterApproval Date </small>
                                            <p>{{$partnerData->offer_date}}</p>
                                            <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                            <small class="text-muted">Sanction Letter</small>
                                            <p>{{$partnerData->sanction}}
                                                    &nbsp;&nbsp;
                                                    <a class="btn-icon-mini" href="{{route('partner.files.partner-file',['action'=>'download','filename'=>basename($partnerData->sanction_doc)])}}" download="{{basename($partnerData->sanction_doc)}}"><i class="zmdi zmdi-download"></i></a>
                                            </p>
                                            <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                            <small class="text-muted">Sanction Letter Approval Date</small>
                                            <p>{{$partnerData->sanction_date}}</p>
                                            <hr>
                                    </div>
                                </div>
                            </div>
                        </li>
                        
                    </ul>
                    <div class="text-center" >
                        {{-- @can('partner-profile-verified', Auth::shouldUse('partner'))
                        @endcan --}}
                        @if ($partnerData->pending_verify==1)
                        <button class="btn btn-success" onclick="location.href='{{route('admin.training_partner.accept.partner',['partner_id' => Crypt::encrypt($partnerData->id) ])}}';this.disabled = true;">Accept</button>
                        <button class="btn btn-danger" onclick="showPromptMessage();">Reject</button>
                        @elseif ($partnerData->pending_verify==0 && $partnerData->status==1)
                        <button class="btn" onclick="location.href='{{route('admin.training_partner.update.partner',['partner_id' => Crypt::encrypt($partnerData->id) ])}}'">Edit</button>                         
                    
                    @endif
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- ========================= --}}
<div class="container-fluid">
        <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Schemes For</strong> Partner </h2>
                           
                        </div>
                        <div class="body">
                                <div class="text-center">
                                        <h4 class="margin-0">{{$partnerData->spoc_name}}</h4>
                                        <h6 class="m-b-20">{{$partnerData->tp_id}}</h6>
                                </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                            <tr>
                                            <th>#</th>
                                            <th>Scheme Name</th>
                                            <th>Year</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @foreach ($partner_scheme as $key=>$scheme)
                                                
                                            <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$scheme->scheme->scheme}}</td>
                                            <td>{{$scheme->scheme->year}}</td>
                                           
                                            @if($scheme->scheme_status==1)
                                            <td><a class="badge bg-red margin-0" href="#" onclick="showCancelMessage({{$scheme->scheme->id}},{{$partnerData->id}})">Deactivate</a></td>
                                           
                                            @elseif($scheme->scheme_status==0)
                                            <td><a class="badge bg-green margin-0" href="{{route('admin.tp.partner.scheme.active',['id'=>Crypt::encrypt($scheme->id),'pid'=>Crypt::encrypt($partnerData->id)])}}" >Activate</a></td>
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
{{-- =================== --}}
<div class="container-fluid">
        <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                        <h2><strong>All</strong> Centers For Partner <strong>{{$partnerData->tp_id}}</strong></h2>
                           
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                            <tr>
                                            <th>#</th>
                                            
                                            <th>TC ID</th>
                                            <th>Spoc Name</th>
                                            <th>Spoc Email</th>
                                            <th>Spoc Mobile</th>
                                            <th>Action</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @foreach ($centers as $key=>$center)
                                                
                                            <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$center->tc_id}}</td>
                                            <td>{{$center->spoc_name}}</td>
                                            <td>{{$center->email}}</td>
                                            <td>{{$center->mobile}}</td>
                                            <td><a class="badge bg-green margin-0" href="{{route('admin.tc.center.view',['id'=>$center->id])}}" >View</a></td>
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
<script>
function showPromptMessage() {
    swal({
        title: "Reject!",
        text: "Write Reason for Rejection",
        type: "input",
        showCancelButton: true,
        closeOnConfirm: false,
        confirmButtonText: 'Reject',
        animation: "slide-from-top",
        showLoaderOnConfirm: true,
        inputPlaceholder: "Write something"
    }, function (inputValue) {
        if (inputValue === false) return false;
        if (inputValue === "") {
            swal.showInputError("You need to write something!"); return false
        }
        var id={{$partnerData->id}};
        var note=inputValue;
        let _token = $("input[name='_token']").val();
    console.log(note);
        $.ajax({
        type: "POST",
        url: "{{route('admin.reject.partner')}}",
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
        window.location="{{route('admin.tp.partners')}}";

        } 
        });
    
        }
    });
        
    });
}
</script>
<script>
        function showCancelMessage(f,p) {
            swal({
                title: "Deactive!",
                text: "Write Reason for Deactivation:",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                showLoaderOnConfirm: true,
                inputPlaceholder: "Write reason"
            }, function (inputValue) {
                if (inputValue === false) return false;
                if (inputValue === "") {
                    swal.showInputError("You need to write something!"); return false
                }
                var id=f;
                var pid=p;
                var reason=inputValue;
                let _token = $("input[name='_token']").val();
           
                $.ajax({
                type: "POST",
                url: "{{route('admin.tp.partner.scheme.deactive')}}",
                data: {_token,id,pid,reason},
                success: function(data) {
                  // console.log(data.url);
                   swal({
                title: "Deactive",
                text: "Scheme Record Deactive",
                type:"success",
                
                showConfirmButton: true
            },function(isConfirm){
        
                if (isConfirm){
               
                window.location="{{route('admin.tp.partners')}}";
        
                } 
                });
            
                }
            });
                
            });
        }
        
        // function showCancelMessage(f) {
        //     let _token = $("input[name='_token']").val();
        //     var id=f;
        //     swal({
        //         title: "Are you sure?",
        //         text: "Center will not be able to Access!",
        //         type: "warning",
        //         showCancelButton: true,
        //         confirmButtonColor: "#DD6B55",
        //         confirmButtonText: "Yes",
        //         cancelButtonText: "No, cancel",
        //         closeOnConfirm: false,
        //         closeOnCancel: false
        //     }, function (isConfirm) {
        //         if (isConfirm) {
        //             $.ajax({
        //                 type: "POST",
        //                 url: "{{route('admin.tc.center.deactive')}}",
        //                 data:{_token,id},
        //                 success: function(data) {
                           
        //                    swal({
        //                 title: "Done",
        //                 text: "Center Deactivated",
        //                 type:"success",
                        
        //             },function(isConfirm){
                
        //                 if (isConfirm){
                       
        //                 window.location="{{route('admin.tc.centers')}}";
                
        //                 } 
        //                 });
                    
        //                 }
        //             });
                   
        //         } else {
        //             swal("Cancelled", "Your Partner is safe :)", "error");
        //         }
        //     });
        // }
        </script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop