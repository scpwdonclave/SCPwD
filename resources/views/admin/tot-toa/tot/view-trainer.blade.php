@extends('layout.master')
@section('parentPageTitle', 'TOT-TOA')
@section('title', 'View TOT Trainer')
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
                    <ul class="cbp_tmtimeline">
                        <li>
                            <time class="cbp_tmtime"><span>Identity</span></time>
                            <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-account"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Document No</small>
                                        <p>{{$tot->doc_no}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Trainer Type</small>
                                        <p>{{$tot->trainer_category?'Master':null}} Trainer</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">State District</small>
                                        <p>{{$tot->statedistrict->district.' ('.$tot->statedistrict->state.')'}}</p>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </li>
                        
                        <li>
                            <time class="cbp_tmtime"><span>Trainer Basic Details</span></time>
                            <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-account"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <small class="text-muted">Trainer Name</small>
                                        <p>{{$tot->salutation.' '.$tot->name}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-6">
                                        <small class="text-muted">SIP Trainer ID</small>
                                        <p>{{$tot->sip_tr_id}}</p>
                                        <hr>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <small class="text-muted">Trainer Mobile</small>
                                        <p>{{$tot->contact}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-6">
                                        <small class="text-muted">Trainer Email</small>
                                        <p>{{$tot->email}}</p>
                                        <hr>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <small class="text-muted">Date of Birth</small>
                                        <p>{{$tot->dob}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-6">
                                        <small class="text-muted">Disability</small>
                                        <p>{{$tot->d_type}}</p>
                                        <hr>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">TOT Payment UTR No</small>
                                        <p>{{$tot->utr_no}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Date of Payment</small>
                                        <p>{{$tot->dop}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Gender</small>
                                        <p>{{$tot->gender}}</p>
                                        <hr>
                                    </div>
                                </div>

                                <h6 class="d-flex justify-content-center" style="color:blue; text-decoration: underline">CONTACT PERSON WITH ADDRESS</h6> <br>
                                
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Guardian Name</small>
                                        <p>{{$tot->g_name}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Guardian Type</small>
                                        <p>{{$tot->g_type}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Village/Town/City</small>
                                        <p>{{$tot->city}}</p>
                                        <hr>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Pin</small>
                                        <p>{{$tot->pin}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-8">
                                        <small class="text-muted">Trainer Address</small>
                                        <p>{{$tot->address}}</p>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li>
                            <time class="cbp_tmtime"><span>Domain, Certification, Qualification Section</span></time>
                            <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-account"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">TP Name</small>
                                        <p>{{$tot->tp_name}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">TC Name</small>
                                        <p>{{$tot->tc_name}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Scheme</small>
                                        <p>{{$tot->scheme}}</p>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">SIP TC ID</small>
                                        <p>{{$tot->sip_tc_id}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-8">
                                        <small class="text-muted">TC Location</small>
                                        <p>{{$tot->tc_address}}</p>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Certified from Domain SSC</small>
                                        <p>{{$tot->has_ssc?'Yes':'No'}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Domain Certification no</small>
                                        <p>{{$tot->ssc_certno}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Details Provided during Center Physical Inspection</small>
                                        <p>{{$tot->details_on_inspc?'Yes':'No'}}</p>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Highest Qualification</small>
                                        <p>{{$tot->high_quali}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Industry Experience</small>
                                        <p>{{$tot->industry_exp}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Training Experience</small>
                                        <p>{{$tot->training_exp}}</p>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <small class="text-muted">Domain Job Role</small>
                                        <p>{{$tot->domain_job}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-6">
                                        <small class="text-muted">Domain Job Role Code</small>
                                        <p>{{$tot->domain_job_code}}</p>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Trainer ID</th>
                                    <th>Category</th>
                                    <th>Percentage</th>
                                    <th>Grade</th>
                                    <th>Validity</th>
                                    <th>Certificate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tot_records as $tot_item)
                                    @foreach ($tot_item->batches as $totbatchmap)
                                        <tr>
                                            <td>{{is_null($totbatchmap->bt_tot_id)?'NA':$totbatchmap->bt_tot_id}}</td>
                                            <td>{{($totbatchmap->trainer->trainer_category)?'Master Trainer':'Trainer'}}</td>
                                            <td>{{is_null($totbatchmap->percentage)?'NA':$totbatchmap->percentage.'%'}}</td>
                                            <td>{{is_null($totbatchmap->percentage)?'NA':(is_null($totbatchmap->grade)?'Failed':$totbatchmap->grade)}}</td>
                                            <td>{{is_null($totbatchmap->validity)?'NA':Carbon\Carbon::parse($totbatchmap->validity)->format('d-m-Y')}}</td>
                                            @if (!is_null($totbatchmap->digital_key))
                                                <td><button type="button" class="badge bg-green margin-0" onclick="window.open('{{route('admin.tot-toa.certificate.print',Crypt::encrypt($totbatchmap->id.',0,1'))}}');" formtarget="_blank">Print</button></td>
                                            @else
                                                <td>NA</td>
                                            @endif
                                        </tr>
                                    @endforeach
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
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop