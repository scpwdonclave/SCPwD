@extends('layout.master')
@section('parentPageTitle', 'TOT-TOA')
@section('title', 'View TOA Assessors')
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
                                    <div class="col-sm-6">
                                        <small class="text-muted">Document No</small>
                                        <p>{{$toa->doc_no}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-6">
                                        <small class="text-muted">State District</small>
                                        <p>{{$toa->statedistrict->district.' ('.$toa->statedistrict->state.')'}}</p>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </li>
                        
                        <li>
                            <time class="cbp_tmtime"><span>Assessor Basic Details</span></time>
                            <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-account"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <small class="text-muted">Assessor Name</small>
                                        <p>{{$toa->salutation.' '.$toa->name}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-6">
                                        <small class="text-muted">Gender</small>
                                        <p>{{$toa->gender}}</p>
                                        <hr>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Assessor Mobile</small>
                                        <p>{{$toa->contact}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Landline</small>
                                        <p>{{$toa->landline}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Assessor Email</small>
                                        <p>{{$toa->email}}</p>
                                        <hr>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <small class="text-muted">Date of Birth</small>
                                        <p>{{$toa->dob}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-6">
                                        <small class="text-muted">Disability</small>
                                        <p>{{$toa->d_type}}</p>
                                        <hr>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <small class="text-muted">Domain Certificate No</small>
                                        <p>{{$toa->domain_cert_no}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-6">
                                        <small class="text-muted">Domain SSC Certificate</small>
                                        @if (is_null($toa->domain_ssc_doc))
                                            <p>No File Provided</p>
                                        @else
                                            <p>Document
                                            &nbsp;&nbsp;
                                            <a class="btn-icon-mini" href="{{route('admin.files.toa-file',['filename'=>basename($toa->domain_ssc_doc)])}}" download="{{basename($toa->domain_ssc_doc)}}"><i class="zmdi zmdi-download"></i></a>
                                            </p>
                                        @endif
                                        <hr>
                                    </div>
                                </div>

                                <h6 class="d-flex justify-content-center" style="color:blue; text-decoration: underline">CONTACT PERSON WITH ADDRESS</h6> <br>
                                
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Guardian Name</small>
                                        <p>{{$toa->g_name}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Guardian Type</small>
                                        <p>{{$toa->g_type}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Village/Town/City</small>
                                        <p>{{$toa->city}}</p>
                                        <hr>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Pin</small>
                                        <p>{{$toa->pin}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-8">
                                        <small class="text-muted">Assessor Address</small>
                                        <p>{{$toa->address}}</p>
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
                                    <div class="col-sm-6">
                                        <small class="text-muted">Current Assessment Agency</small>
                                        <p>{{$toa->agency->agency_name}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-6">
                                        <small class="text-muted">Appointment date as an Assessor</small>
                                        <p>{{Carbon\Carbon::parse($toa->doa_curr_aa)->format('d-m-Y')}}</p>
                                        <hr>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <small class="text-muted">Job Type</small>
                                        <p>{{$toa->job_type}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-6">
                                        <small class="text-muted">State - Location of Employment</small>
                                        <p>{{$toa->statedistrict->district.' ('.$toa->statedistrict->state.')'}}</p>
                                        <hr>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Qualification</small>
                                        <p>{{$toa->qualification}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Industry Experience</small>
                                        <p>{{$toa->industry_exp}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Assessing Experience</small>
                                        <p>{{$toa->assessing_exp}}</p>
                                        <hr>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Sector</small>
                                        <p>{{$toa->sector}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Sub Sector</small>
                                        <p>{{$toa->sub_sector}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Domain Job Role</small>
                                        <p>{{$toa->domain_job}}</p>
                                        <hr>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Domain Job Role Code</small>
                                        <p>{{$toa->domain_job_code}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Domain job role NSQF level</small>
                                        <p>{{$toa->nsqf}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">No. of Batches Assessed on the Domain job Role</small>
                                        <p>{{$toa->no_batch_assessed}}</p>
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
                                    <th>Assessor ID</th>
                                    <th>Percentage</th>
                                    <th>Grade</th>
                                    <th>Validity</th>
                                    <th>Certificate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($toa_records as $toa_item)
                                    @foreach ($toa_item->batches as $toabatchmap)
                                        <tr>
                                            <td>{{is_null($toabatchmap->bt_toa_id)?'NA':$toabatchmap->bt_toa_id}}</td>
                                            <td>{{is_null($toabatchmap->percentage)?'NA':$toabatchmap->percentage.'%'}}</td>
                                            <td>{{is_null($toabatchmap->percentage)?'NA':(is_null($toabatchmap->grade)?'Failed':$toabatchmap->grade)}}</td>
                                            <td>{{is_null($toabatchmap->validity)?'NA':Carbon\Carbon::parse($toabatchmap->validity)->format('d-m-Y')}}</td>
                                            @if (!is_null($toabatchmap->digital_key))
                                                <td><button type="button" class="badge bg-green margin-0" onclick="window.open('{{route('admin.tot-toa.certificate.print',Crypt::encrypt($toabatchmap->id.',0,0'))}}');" formtarget="_blank">Print</button></td>
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