@extends('layout.master')
@section('title', 'Payment Order')
{{-- @section('parentPageTitle', 'Partners-verify') --}}
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/timeline.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">


@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                    @if (!is_null($pay_order->agency->aa_id))
                        <div class="text-center">
                            <h6>
                                AA ID: <span style='color:blue'>{{$pay_order->agency->aa_id}}</span> <br> <br>
                                <span style='color:{{($pay_order->agency->status)?"green":"red"}}'>{{($pay_order->agency->status)?"Active":"Inactive"}}</span>
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
                                        <p>{{$pay_order->agency->name}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">SPOC Aadhaar No</small>
                                        <p>{{$pay_order->agency->aadhaar}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted"> SPOC Email</small>
                                        <p>{{$pay_order->agency->email}}</p>
                                        <hr>
                                    </div>
                                  
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">SPOC Mobile</small>
                                        <p>{{$pay_order->agency->mobile}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">SPOC Gender</small>
                                        <p>{{$pay_order->agency->gender}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">SPOC Designation</small>
                                        <p>{{$pay_order->agency->designation}}</p>
                                        <hr>
                                    </div>
                
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">SPOC Landline</small>
                                        <p>{{$pay_order->agency->landline}}</p>
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
                                            <p>{{$pay_order->agency->agency_name}}</p>
                                            <hr>
                                        </div>
                                    
                                        <div class="col-sm-4">
                                                <small class="text-muted">Organization Type</small>
                                                <p>{{$pay_order->agency->org_type}}</p>
                                                <hr>
                                        </div>
                                        <div class="col-sm-4">
                                                <small class="text-muted">Organization ID/Registration No.</small>
                                                <p>{{$pay_order->agency->org_id}}</p>
                                                <hr>
                                        </div>
                                    </div>
                                <div class="row">
                                        <div class="col-sm-4">
                                            <small class="text-muted">SLA Start Date</small>
                                            <p>{{$pay_order->agency->sla_date}}</p>
                                            <hr>
                                        </div>
                                    
                                        <div class="col-sm-4">
                                                <small class="text-muted">SLA End date</small>
                                                <p>{{$pay_order->agency->sla_end_date}}</p>
                                                <hr>
                                        </div>
                                       
                                    </div>
                                
                            </div>
                        </li>
                       
                        </ul>
                   
                        
                    {{-- <form id="form_payorder" action="{{route('agency.payorder.tc-wise')}}" method="post" >
                        @csrf
                    
                    <input type="hidden" name="center_id" value="{{$pay_order->id}}">

                    <div class="text-center" >
                        <button class="btn btn-round btn-primary" type="submit"> Submit Pay Order</button>
                    </div>
                    </form> --}}
                   
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header d-flex justify-content-between">
                        <h2><strong>All</strong> Assessed Batch</h2>
                       
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>Batch ID</th>
                                        <th>Job Role</th>
                                        <th>Assessment status</th>
                                        <th>Assessment Date</th>
                                        <th>View Candidate</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($pay_order->paymentorder as $payorder)
                                        
                                    <tr>
                                        <td>#</td>
                                        @if ($aa_batch->reass_id===null)
                                            
                                        <td>{{$aa_batch->batch->batch_id}}</td>
                                        <td>{{$aa_batch->batch->jobrole->job_role}}</td>
                                        <td>Assessment</td>
                                        <td>{{\Carbon\Carbon::parse($aa_batch->batch->assessment)->format('d-m-Y')}}</td>
                                        <td><a class="badge bg-green margin-0" href="{{route('agency.batch.bt-candidate',['id'=>Crypt::encrypt($aa_batch->bt_id)])}}" >View Candidate</a></td>

                                        @else
                                        <td>{{$aa_batch->reassessment->batch->batch_id}}</td>
                                        <td>{{$aa_batch->reassessment->batch->jobrole->job_role}}</td>
                                        <td>Re-Assessment</td>
                                        <td>{{\Carbon\Carbon::parse($aa_batch->reassessment->assessment)->format('d-m-Y')}}</td>   
                                        <td><a class="badge bg-green margin-0" href="{{route('agency.batch.reass-bt-candidate',['id'=>Crypt::encrypt($aa_batch->reass_id)])}}" >View Candidate</a></td>
                                        @endif
                                    </tr>
                                    @endforeach --}}
                                   
                                       
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


{{-- <script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script> --}}
<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{asset('assets/js/scpwd-common.js')}}"></script>
@stop