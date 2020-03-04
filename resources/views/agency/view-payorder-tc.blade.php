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
                    @if (!is_null($center->tc_id))
                        <div class="text-center">
                            <h6>
                                TC ID: <span style='color:blue'>{{$center->tc_id}}</span> <br> <br>
                                <span style='color:{{($center->status)?"green":"red"}}'>{{($center->status)?"Active":"Inactive"}}</span>
                            </h6>
                        </div>
                        <br>
                    @endif
                   
                    <ul class="cbp_tmtimeline">
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>SPOC DETAILS</span></time>
                            <div class="cbp_tmicon bg-blue"> <i class="zmdi zmdi-local-store"></i></div>
                            <div class="cbp_tmlabel">
                                
                                <div class="row">
                                        <div class="col-sm-4">
                                            <small class="text-muted">SPOC Name</small>
                                            <p>{{$center->spoc_name}}</p>
                                            <hr>
                                        </div>
                                    
                                        <div class="col-sm-4">
                                                <small class="text-muted">SPOC Email</small>
                                                <p>{{$center->email}}</p>
                                                <hr>
                                        </div>
                                        <div class="col-sm-4">
                                                <small class="text-muted">SPOC Mobile</small>
                                                <p>{{$center->mobile}}</p>
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
                                    <div class="col-sm-6">
                                        <small class="text-muted">Training Center Name</small>
                                        <p>{{$center->center_name}}</p>
                                        <hr>
                                    </div>
                                 <div class="col-sm-6">
                                        <small class="text-muted">Landmark</small>
                                        <p>{{$center->landmark}}</p>
                                        <hr>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <small class="text-muted">Training Center Address</small>
                                        <p>{{$center->center_address}}</p>
                                        <hr>
                                    </div>
                                </div>
                                
                                {{-- <div class="row">
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
                                </div> --}}

                                <div class="row">
                                    <div class="col-sm-4">
                                            <small class="text-muted">City/Town/Village</small>
                                            <p>{{$center->city}}</p>
                                            <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                            <small class="text-muted">Tehsil/Mandal/Block</small>
                                            <p>{{$center->block}}</p>
                                            <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">PIN code</small>
                                        <p>{{$center->pin}}</p>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </li>
                       
                        </ul>
                   
                        
                    <form id="form_payorder" action="{{route('agency.payorder.tc-wise')}}" method="post" >
                        @csrf
                    
                    <input type="hidden" name="center_id" value="{{$center->id}}">
                    <div class="row d-flex justify-content-around">
                                
                        <div class="col-sm-4">
                            <label for="ref_no">Enter Ref No. <span style="color:red"> <strong>*</strong></span></label>
                            <div class="form-group form-float">
                                <input type="text" class="form-control " placeholder="Enter Ref No" id="ref_no" name="ref_no"  required>
                            </div>
                        </div>
                       
                    </div>
                    <div class="text-center" >
                        <button class="btn btn-round btn-primary" type="submit"> Submit Pay Order</button>
                    </div>
                    </form>
                   
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
                                        <th>Total Candidate</th>
                                        <th>Amount</th>
                                        <th>View Candidate</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach ($aa_batch as $aa_batch)
                                        
                                    <tr>
                                        <td>#</td>
                                        @if ($aa_batch->reass_id===null && !is_null($aa_batch->batch->batchassessment))
                                            
                                        <td>{{$aa_batch->batch->batch_id}}</td>
                                        <td>{{$aa_batch->batch->jobrole->job_role}}</td>
                                        <td>Assessment</td>
                                        <td>{{\Carbon\Carbon::parse($aa_batch->batch->assessment)->format('d-m-Y')}}</td>
                                        @if (!is_null($aa_batch->batch->batchassessment))
                                        <td>{{$aa_batch->batch->batchassessment->candidateMarks->count()}}</td>
                                        <td>{{$aa_batch->batch->batchassessment->candidateMarks->count()*500}}</td>
                                        @else
                                          <td>0</td>  
                                          <td>0</td>  
                                        @endif
                                        <td><a class="badge bg-green margin-0" href="{{route('agency.batch.bt-candidate',['id'=>Crypt::encrypt($aa_batch->bt_id)])}}" >View Candidate</a></td>

                                        @elseif(!is_null($aa_batch->reassessment))
                                        <td>{{$aa_batch->reassessment->batch->batch_id}}</td>
                                        <td>{{$aa_batch->reassessment->batch->jobrole->job_role}}</td>
                                        <td>Re-Assessment</td>
                                        <td>{{\Carbon\Carbon::parse($aa_batch->reassessment->assessment)->format('d-m-Y')}}</td>
                                        @if (!is_null($aa_batch->reassessment))
                                            
                                        <td>{{$aa_batch->reassessment->candidates->count()}}</td>
                                        <td>{{$aa_batch->reassessment->candidates->count()*500}}</td>
                                        @else
                                          <td>0</td>  
                                          <td>0</td>  
                                        @endif   
                                        <td><a class="badge bg-green margin-0" href="{{route('agency.batch.reass-bt-candidate',['id'=>Crypt::encrypt($aa_batch->reass_id)])}}" >View Candidate</a></td>
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