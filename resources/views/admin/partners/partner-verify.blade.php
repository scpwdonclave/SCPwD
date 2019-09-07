@extends('layout.master')
@section('title', 'Partners')
{{-- @section('parentPageTitle', 'Partners-verify') --}}
@section('page-style')
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
                        {{-- <li>
                            <time class="cbp_tmtime" datetime="2017-11-04T18:30"><span class="hidden">25/12/2017</span> <span class="large">Now</span></time>
                            <div class="cbp_tmicon"><i class="zmdi zmdi-account"></i></div>
                            <div class="cbp_tmlabel empty"> <span>No Activity</span> </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-04T03:45"><span>03:45 AM</span> <span>Today</span></time>
                            <div class="cbp_tmicon bg-info"><i class="zmdi zmdi-label"></i></div>
                            <div class="cbp_tmlabel">
                                <h2><a href="javascript:void(0);">Art Ramadani</a> <span>posted a status update</span></h2>
                                <p>Tolerably earnestly middleton extremely distrusts she boy now not. Add and offered prepare how cordial two promise. Greatly who affixed suppose but enquire compact prepare all put. Added forth chief trees but rooms think may.</p>
                            </div>
                        </li> --}}
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
                                  
                                </div>
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>General Details
                                </span></time>
                            <div class="cbp_tmicon bg-blue"> <i class="zmdi zmdi-case"></i></div>
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
                            <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-case"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                            <small class="text-muted">CEO/MD/Head's Name</small>
                                            <p>{{$partnerData->ceo_name}}</p>
                                            <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                            <small class="text-muted">CEO/MD/Head's Email Address</small>
                                            <p>{{$partnerData->ceo_email}}</p>
                                            <hr>
                                    </div>
                                    <div class="col-sm-4">
                                            <small class="text-muted">CEO/MD/Head's Mobile Number</small>
                                            <p>{{$partnerData->ceo_mobile}}</p>
                                            <hr>
                                    </div>
                                    
                                </div>
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Authorized Signatory Info</span></time>
                            <div class="cbp_tmicon bg-blush"> <i class="zmdi zmdi-case"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                            <small class="text-muted">Authorized Signatory Name</small>
                                            <p>{{$partnerData->signatory_name}}</p>
                                            <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                            <small class="text-muted">Authorized Signatory Email Address</small>
                                            <p>{{$partnerData->signatory_email}}</p>
                                            <hr>
                                    </div>
                                    <div class="col-sm-4">
                                            <small class="text-muted">Authorized Signatory Mobile Number</small>
                                            <p>{{$partnerData->signatory_mobile}}</p>
                                            <hr>
                                    </div>
                                    
                                </div>
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Address of The Organization</span></time>
                            <div class="cbp_tmicon bg-cyan"> <i class="zmdi zmdi-case"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                            <small class="text-muted">Address of the Organization</small>
                                            <p>{{$partnerData->org_address}}</p>
                                            <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                            <small class="text-muted">Nearby Landmark</small>
                                            <p>{{$partnerData->landmark}}</p>
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
                                                <small class="text-muted">State/Union Territory</small>
                                                <p>{{$partnerData->state}}</p>
                                                <hr>
                                        </div>
                                    
                                        <div class="col-sm-4">
                                                <small class="text-muted">District</small>
                                                <p>{{$partnerData->district}}</p>
                                                <hr>
                                        </div>
                                        <div class="col-sm-4">
                                                <small class="text-muted">Parliament Constituency</small>
                                                <p>{{$partnerData->parliament}}</p>
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
                            <div class="cbp_tmicon bg-orange"> <i class="zmdi zmdi-case"></i></div>
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
                            <div class="cbp_tmicon bg-blush"> <i class="zmdi zmdi-case"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                            <small class="text-muted">Offer Latter </small>
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
                    @if ($partnerData->pending_verify==1)
                    <div class="text-center" >
                    <button class="btn btn-success" onclick="location.href='{{route('admin.accept.partner',['partner_id' => Crypt::encrypt($partnerData->id) ])}}'">Accept</button>
                    <button class="btn btn-danger" onclick="showPromptMessage();">Reject</button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('page-script')
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
        window.location="{{route('admin.partners')}}";

        } 
        });
    
        }
    });
        
    });
}
</script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
@stop