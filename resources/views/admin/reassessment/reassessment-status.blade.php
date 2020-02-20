@extends('layout.master')
@section('title', 'Results & Certificates')
@section('parentPageTitle', 'Re-Assessment')
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
                    <h2><strong>Pending</strong> Re-Assessment Result & Certificate Approvals</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Batch ID</th>
                                    <th>AA ID</th>
                                    <th>AS ID</th>
                                    <th>Re-Assessment Date</th>
                                    <th>Agency Approve</th>
                                    <th>Admin Approve</th>
                                    <th>Super Admin Approve</th> 
                                    <th>Certificate</th> 
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($batchreassessments as $batchreassessment) 
                                    <tr>
                                        @if (!$batchreassessment->superadmin_cert_rel)
                                            <td>{{$batchreassessment->batch->batch_id}}</td>
                                            <td>{{$batchreassessment->reassessment->agency->aa_id}}</td>
                                            <td>{{$batchreassessment->reassessment->assessor->as_id}}</td>
                                            <td>{{$batchreassessment->reassessment->assessment}}</td>
                                            <td style="font-weight:bold;" class="text-{{($batchreassessment->aa_verified=='1')?'success':(($batchreassessment->aa_verified=='2')?'danger':'muted')}}">{{($batchreassessment->aa_verified=='1')?'Approved':(($batchreassessment->aa_verified=='2')?'Rejected':'Pending')}}</td>
                                            <td style="font-weight:bold;" class="text-{{($batchreassessment->admin_verified=='1')?'success':(($batchreassessment->admin_verified=='2')?'danger':'muted')}}">{{($batchreassessment->admin_verified=='1')?'Approved':(($batchreassessment->admin_verified=='2')?'Rejected':'Pending')}}</td>
                                            <td style="font-weight:bold;" class="text-{{($batchreassessment->sup_admin_verified=='1')?'success':(($batchreassessment->sup_admin_verified=='2')?'danger':'muted')}}">{{($batchreassessment->sup_admin_verified=='1')?'Approved':(($batchreassessment->sup_admin_verified=='2')?'Rejected':'Pending')}}</td>
                                            <td style="font-weight:bold;" class="text-{{($batchreassessment->supadmin_cert_rel=='1')?'success':'danger'}}">{{($batchreassessment->supadmin_cert_rel=='1')?'Released':(($batchreassessment->supadmin_cert_rel=='2')?'Rejected':'Not Released')}}</td>
                                            <td><a class="badge bg-green margin-0" href="{{route('admin.reassessment.reassessment-status.view',Crypt::encrypt($batchreassessment->id))}}" >View</a></td>
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
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header d-flex justify-content-between">
                    <h2><strong>Released</strong> Re-Assessment Result & Certificates</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Batch ID</th>
                                    <th>AA ID</th>
                                    <th>AS ID</th>
                                    <th>Re-Assessment Date</th>
                                    <th>Agency Approve</th>
                                    <th>Admin Approve</th>
                                    <th>Super Admin Approve</th> 
                                    <th>Certificate</th> 
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($batchreassessments as $batchreassessment) 
                                    <tr>
                                        @if ($batchreassessment->superadmin_cert_rel)
                                            <td>{{$batchreassessment->batch->batch_id}}</td>
                                            <td>{{$batchreassessment->reassessment->agency->aa_id}}</td>
                                            <td>{{$batchreassessment->reassessment->assessor->as_id}}</td>
                                            <td>{{$batchreassessment->reassessment->assessment}}</td>
                                            <td style="font-weight:bold;" class="text-{{($batchreassessment->aa_verified=='1')?'success':(($batchreassessment->aa_verified=='2')?'danger':'muted')}}">{{($batchreassessment->aa_verified=='1')?'Approved':(($batchreassessment->aa_verified=='2')?'Rejected':'Pending')}}</td>
                                            <td style="font-weight:bold;" class="text-{{($batchreassessment->admin_verified=='1')?'success':(($batchreassessment->admin_verified=='2')?'danger':'muted')}}">{{($batchreassessment->admin_verified=='1')?'Approved':(($batchreassessment->admin_verified=='2')?'Rejected':'Pending')}}</td>
                                            <td style="font-weight:bold;" class="text-{{($batchreassessment->sup_admin_verified=='1')?'success':(($batchreassessment->sup_admin_verified=='2')?'danger':'muted')}}">{{($batchreassessment->sup_admin_verified=='1')?'Approved':(($batchreassessment->sup_admin_verified=='2')?'Rejected':'Pending')}}</td>
                                            <td style="font-weight:bold;" class="text-{{($batchreassessment->supadmin_cert_rel)?'success':'danger'}}">{{($batchreassessment->supadmin_cert_rel=='1')?'Released':(($batchreassessment->supadmin_cert_rel=='2')?'Rejected':'Not Released')}}</td>
                                            <td><a class="badge bg-green margin-0" href="{{route('admin.reassessment.reassessment-status.view',Crypt::encrypt($batchreassessment->id))}}" >View</a></td>
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


{{-- <div class="container-fluid">
    <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header d-flex justify-content-between">
                        <h2><strong>All</strong> pending Assessment for Recheck </h2>
                       
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>Batch ID</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Assessment Date</th>
                                        <th>Agency Approve</th>
                                        <th>Admin Approve</th>
                                        <th>Super Admin Approve</th>
                                        <th>View</th>
                                       
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach ($agencyBatch as $key=>$batchreassessment)
                                   
                                    @if(!is_null($batchreassessment->batch->batchassessment) && $batchreassessment->batch->batchassessment->aa_verified==2)
                                    <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$batchreassessment->batch->batch_id}}</td>
                                    <td>{{$batchreassessment->batch->batch_start}}</td>
                                    <td>{{$batchreassessment->batch->batch_end}}</td>
                                    <td>{{$batchreassessment->batch->assessment}}</td>
                                    <td class="text-{{($batchreassessment->batch->batchassessment->aa_verified)?'success':'danger'}}"><strong>{{($batchreassessment->batch->batchassessment->aa_verified)?'Approved':'Pending'}}</strong></td>
                                    <td class="text-{{($batchreassessment->batch->batchassessment->admin_verified)?'success':'danger'}}"><strong>{{($batchreassessment->batch->batchassessment->aa_verified)?'Approved':'Pending'}}</strong></td>
                                    <td class="text-{{($batchreassessment->batch->batchassessment->sup_admin_verified)?'success':'danger'}}"><strong>{{($batchreassessment->batch->batchassessment->aa_verified)?'Approved':'Pending'}}</strong></td>
                                    <td><a class="badge bg-green margin-0" href="{{route('agency.assessment.view',['id'=>Crypt::encrypt($batchreassessment->batch->batchassessment->id)])}}" >View</a></td>
                                    </tr>
                                   
                                 @endif
                                   @endforeach
                                       
                                    </tbody>
                            </table>
                            </div>
                    </div>
                </div>
            </div>
        </div>
</div> --}}
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