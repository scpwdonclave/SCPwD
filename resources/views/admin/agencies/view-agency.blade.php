@extends('layout.master')
@section('title', 'Agency')
{{-- @section('parentPageTitle', 'Partners-verify') --}}
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/timeline.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/color_skins.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">

@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                    @if (!is_null($agency->aa_id))
                        <div class="text-center">
                            <h6>
                                 AA ID: <span style='color:blue'>{{$agency->aa_id}}</span>
                            </h6>
                        </div>
                        <br>
                    @endif
                    <ul class="cbp_tmtimeline">
                        
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>SPOC Details</span></time>
                            <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-account"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">SPOC Name</small>
                                        <p>{{$agency->name}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">SPOC Aadhaar No</small>
                                        <p>{{$agency->aadhaar}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted"> SPOC Email</small>
                                        <p>{{$agency->email}}</p>
                                        <hr>
                                    </div>
                                  
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">SPOC Mobile</small>
                                        <p>{{$agency->mobile}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">SPOC Gender</small>
                                        <p>{{$agency->gender}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">SPOC Designation</small>
                                        <p>{{$agency->designation}}</p>
                                        <hr>
                                    </div>
                
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">SPOC Landline</small>
                                        <p>{{$agency->landline}}</p>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </li>
                        
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>General Information</span></time>
                            <div class="cbp_tmicon bg-blue"> <i class="zmdi zmdi-local-store"></i></div>
                            <div class="cbp_tmlabel">
                                
                                <div class="row">
                                        <div class="col-sm-4">
                                            <small class="text-muted">Agency name</small>
                                            <p>{{$agency->agency_name}}</p>
                                            <hr>
                                        </div>
                                    
                                        <div class="col-sm-4">
                                                <small class="text-muted">Organization Type</small>
                                                <p>{{$agency->org_type}}</p>
                                                <hr>
                                        </div>
                                        <div class="col-sm-4">
                                                <small class="text-muted">Organization ID/Registration No.</small>
                                                <p>{{$agency->org_id}}</p>
                                                <hr>
                                        </div>
                                    </div>
                                <div class="row">
                                        <div class="col-sm-4">
                                            <small class="text-muted">SLA Start Date</small>
                                            <p>{{$agency->sla_date}}</p>
                                            <hr>
                                        </div>
                                    
                                        <div class="col-sm-4">
                                                <small class="text-muted">SLA End date</small>
                                                <p>{{$agency->sla_end_date}}</p>
                                                <hr>
                                        </div>
                                       
                                    </div>
                                
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Agency Sector</span></time> 
                            <div class="cbp_tmicon bg-pink"> <i class="zmdi zmdi-pin"></i></div>
                            <div class="cbp_tmlabel">
                                    <div class="table-responsive">
                                            <table class="table m-b-0">
                                                <thead>
                                                    <tr>
                                                        <th>Sl. No.</th>
                                                        
                                                        <th>Sector</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $i=0;
                                                    @endphp
                                                    @foreach ($agency->agencySector as $item) 
                                                    <tr>
                                                      
                                                        @php
                                                            $i++;
                                                        @endphp
                                                        <td>{{$i}}</td>
                                                        <td>{{$item->sectors->sector}}</td>
                                                       
                                                       
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                               
                                
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>CEO/Head of the Organization Details
                            </span></time>
                            <div class="cbp_tmicon bg-yellow"> <i class="zmdi zmdi-local-store"></i></div>
                            <div class="cbp_tmlabel">
                                
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <small class="text-muted">CEO/Head's Name </small>
                                            <p>{{$agency->ceo_name}}</p>
                                          
                                            <hr>
                                        </div>
                                    
                                        <div class="col-sm-4">
                                                <small class="text-muted">CEO Aadhaar no</small>
                                                <p>{{$agency->ceo_aadhaar}}</p>

                                                <hr>
                                        </div>
                                        <div class="col-sm-4">
                                                <small class="text-muted">CEO/Head's Email Address </small>
                                                <p>{{$agency->ceo_email}}</p>
                                                <hr>
                                        </div>
                                       
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <small class="text-muted">CEO/Head's Mobile Number </small>
                                            <p>{{$agency->ceo_mobile}}</p>
                                          
                                            <hr>
                                        </div>
                                    
                                        <div class="col-sm-4">
                                                <small class="text-muted">Gender</small>
                                                <p>{{$agency->ceo_gender}}</p>

                                                <hr>
                                        </div>
                                        <div class="col-sm-4">
                                                <small class="text-muted">Designation </small>
                                                <p>{{$agency->ceo_designation}}</p>
                                                <hr>
                                        </div>
                                        <div class="col-sm-4">
                                                <small class="text-muted">Landline no </small>
                                                <p>{{$agency->ceo_landline}}</p>
                                                <hr>
                                        </div>
                                       
                                    </div>
                                
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Address of The Organization</span></time>
                            <div class="cbp_tmicon bg-red"> <i class="zmdi zmdi-local-store"></i></div>
                            <div class="cbp_tmlabel">
                                
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <small class="text-muted">Address of the Organization</small>
                                            <p>{{$agency->org_address}}</p>
                                          
                                            <hr>
                                        </div>
                                    
                                        <div class="col-sm-4">
                                                <small class="text-muted">Post Office</small>
                                                <p>{{$agency->post_office}}</p>

                                                <hr>
                                        </div>
                                        <div class="col-sm-4">
                                                <small class="text-muted">State - District</small> 
                                                <p>{{$agencyState->state}} ({{$agencyState->district}})</p>
                                                <hr>
                                        </div>
                                       
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <small class="text-muted">Parliament Constituency </small>
                                            <p>{{$agencyState->constituency}} ({{$agencyState->state_ut}})</p>
                                          
                                            <hr>
                                        </div>
                                    
                                        <div class="col-sm-4">
                                                <small class="text-muted">City/Town/Village</small>
                                                <p>{{$agency->city}}</p>

                                                <hr>
                                        </div>
                                        <div class="col-sm-4">
                                                <small class="text-muted">Sub-District  </small>
                                                <p>{{$agency->sub_district}}</p>
                                                <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <small class="text-muted">PIN Code </small>
                                            <p>{{$agency->pin}}</p>
                                          
                                            <hr>
                                        </div>
                                    
                                        <div class="col-sm-4">
                                                <small class="text-muted">Landline</small>
                                                <p>{{$agency->org_landline}}</p>

                                                <hr>
                                        </div>
                                        <div class="col-sm-4">
                                                <small class="text-muted">Website</small>
                                                <p>{{$agency->website}}</p>
                                                <hr>
                                        </div>
                                    </div>
                                
                            </div>
                        </li>
                    </ul>
                    
                        <div class="text-center" >
                                <button class="btn btn-primary" onclick="location.href='{{route('admin.aa.edit.agency',['aa_id' => Crypt::encrypt($agency->id) ])}}'"><i class="zmdi zmdi-edit"></i> &nbsp;&nbsp;Edit</button>                         
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
                    <h2><strong>Agency</strong> Assign Batch</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Sl. No.</th>
                                    <th>Batch ID</th>
                                    <th>Training Partner</th>
                                    <th>Training Center</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Assessment Date</th>
                                    <th>Status</th>
                                    <th>Scheme Status</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($agency->agencyBatch as $key=>$item) 
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{is_null($item->batch->batch_id)?Config::get('constants.nullidtext'):$item->batch->batch_id}}</td>
                                        <td>{{$item->batch->partner->org_name.' ('.$item->batch->partner->tp_id.')'}}</td>
                                        <td>{{$item->batch->center->center_name.' ('.$item->batch->center->tc_id.')'}}</td>
                                        <td>{{\Carbon\Carbon::parse($item->batch->batch_start)->format('d-m-Y')}}</td>
                                        <td>{{\Carbon\Carbon::parse($item->batch->batch_end)->format('d-m-Y')}}</td>
                                        <td>{{\Carbon\Carbon::parse($item->batch->assessment)->format('d-m-Y')}}</td>
                                        @if ($item->batch->verified)
                                            <td style="color:{{($item->batch->status)?'green':'red'}}">{{($item->batch->status)?'Active':'Inactive'}}</td>
                                        @else
                                            <td style="color:red">Not Verified</td>
                                        @endif
                                        <td style="color:{{($item->batch->tpjobrole->status)?'green':'red'}}">{{($item->batch->tpjobrole->status)?'Active':'Inactive'}}</td>
                                        <td><a class="badge bg-green margin-0" href="{{route(Request::segment(1).'.bt.batch.view',['id'=>Crypt::encrypt($item->batch->id)])}}">View</a></td>
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
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop