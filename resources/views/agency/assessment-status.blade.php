@extends('layout.master')
@section('title', 'Assessment Results')
{{-- @section('parentPageTitle', 'Assessment') --}}
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">

@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header d-flex justify-content-between">
                    <h2><strong>Pending</strong> Assessment Result Approvals</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Batch ID</th>
                                    <th>AA ID</th>
                                    <th>AS ID</th>
                                    <th>Assessment Date</th>
                                    <th>Agency Approve</th>
                                    <th>Admin Approve</th>
                                    <th>Super Admin Approve</th> 
                                    <th>Certificate</th> 
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($agencyBatches as $assessment)
                                    @if ($assessment->batch->batchassessment)
                                        @if (!$assessment->batch->batchassessment->aa_verified)
                                            <td>{{$assessment->batch->batch_id}}</td>
                                            <td>{{$assessment->agency->aa_id}}</td>
                                            <td>{{$assessment->batch->assessorbatch->assessor->as_id}}</td>
                                            <td>{{$assessment->batch->assessment}}</td>
                                            <td style="font-weight:bold;" class="text-{{($assessment->batch->batchassessment->aa_verified=='1')?'success':(($assessment->batch->batchassessment->aa_verified=='2')?'danger':'muted')}}">{{($assessment->batch->batchassessment->aa_verified=='1')?'Approved':(($assessment->batch->batchassessment->aa_verified=='2')?'Rejected':'Pending')}}</td>
                                            <td style="font-weight:bold;" class="text-{{($assessment->batch->batchassessment->admin_verified=='1')?'success':(($assessment->batch->batchassessment->admin_verified=='2')?'danger':'muted')}}">{{($assessment->batch->batchassessment->admin_verified=='1')?'Approved':(($assessment->batch->batchassessment->admin_verified=='2')?'Rejected':'Pending')}}</td>
                                            <td style="font-weight:bold;" class="text-{{($assessment->batch->batchassessment->sup_admin_verified=='1')?'success':(($assessment->batch->batchassessment->sup_admin_verified=='2')?'danger':'muted')}}">{{($assessment->batch->batchassessment->sup_admin_verified=='1')?'Approved':(($assessment->batch->batchassessment->sup_admin_verified=='2')?'Rejected':'Pending')}}</td>
                                            <td style="font-weight:bold;" class="text-{{($assessment->batch->batchassessment->supadmin_cert_rel)?'success':'danger'}}">{{($assessment->batch->batchassessment->supadmin_cert_rel)?'Released':'Not Released'}}</td>
                                            <td><a class="badge bg-green margin-0" href="{{route('agency.assessment.view',Crypt::encrypt($assessment->batch->batchassessment->id))}}" >View</a></td>
                                        @endif
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header d-flex justify-content-between">
                    <h2><strong>Confirmed</strong> Assessment Results</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Batch ID</th>
                                    <th>AA ID</th>
                                    <th>AS ID</th>
                                    <th>Assessment Date</th>
                                    <th>Agency Approve</th>
                                    <th>Admin Approve</th>
                                    <th>Super Admin Approve</th> 
                                    <th>Certificate</th> 
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($agencyBatches as $assessment)
                                    @if ($assessment->batch->batchassessment && ($assessment->batch->agencybatch->aa_id == Auth::guard('agency')->user()->id))
                                        @if ($assessment->batch->batchassessment->aa_verified)
                                            <td>{{$assessment->batch->batch_id}}</td>
                                            <td>{{$assessment->agency->aa_id}}</td>
                                            <td>{{$assessment->batch->assessorbatch->assessor->as_id}}</td>
                                            <td>{{$assessment->batch->assessment}}</td>
                                            <td style="font-weight:bold;" class="text-{{($assessment->batch->batchassessment->aa_verified=='1')?'success':(($assessment->batch->batchassessment->aa_verified=='2')?'danger':'muted')}}">{{($assessment->batch->batchassessment->aa_verified=='1')?'Approved':(($assessment->batch->batchassessment->aa_verified=='2')?'Rejected':'Pending')}}</td>
                                            <td style="font-weight:bold;" class="text-{{($assessment->batch->batchassessment->admin_verified=='1')?'success':(($assessment->batch->batchassessment->admin_verified=='2')?'danger':'muted')}}">{{($assessment->batch->batchassessment->admin_verified=='1')?'Approved':(($assessment->batch->batchassessment->admin_verified=='2')?'Rejected':'Pending')}}</td>
                                            <td style="font-weight:bold;" class="text-{{($assessment->batch->batchassessment->sup_admin_verified=='1')?'success':(($assessment->batch->batchassessment->sup_admin_verified=='2')?'danger':'muted')}}">{{($assessment->batch->batchassessment->sup_admin_verified=='1')?'Approved':(($assessment->batch->batchassessment->sup_admin_verified=='2')?'Rejected':'Pending')}}</td>
                                            <td style="font-weight:bold;" class="text-{{($assessment->batch->batchassessment->supadmin_cert_rel)?'success':'danger'}}">{{($assessment->batch->batchassessment->supadmin_cert_rel)?'Released':'Not Released'}}</td>
                                            <td><a class="badge bg-green margin-0" href="{{route('agency.assessment.view',Crypt::encrypt($assessment->batch->batchassessment->id))}}" >View</a></td>
                                        @endif
                                    @endif
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
<script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
@stop