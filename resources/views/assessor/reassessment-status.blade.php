@extends('layout.master')
@section('title', 'Re-Assessment Results')
@section('parentPageTitle', 'Batches')
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
                    <h2><strong>All</strong> Re-Assessment Results</h2>
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
                                @foreach ($reassessments as $reassessment) 
                                    <td>{{$reassessment->batchreassessment->batch->batch_id}}</td>
                                    <td>{{$reassessment->agency->aa_id}}</td>
                                    <td>{{$reassessment->assessor->as_id}}</td>
                                    <td>{{$reassessment->assessment}}</td>
                                    <td style="font-weight:bold;" class="text-{{($reassessment->batchreassessment->aa_verified=='1')?'success':(($reassessment->batchreassessment->aa_verified=='2')?'danger':'muted')}}">{{($reassessment->batchreassessment->aa_verified=='1')?'Approved':(($reassessment->batchreassessment->aa_verified=='2')?'Rejected':'Pending')}}</td>
                                    <td style="font-weight:bold;" class="text-{{($reassessment->batchreassessment->admin_verified=='1')?'success':(($reassessment->batchreassessment->admin_verified=='2')?'danger':'muted')}}">{{($reassessment->batchreassessment->admin_verified=='1')?'Approved':(($reassessment->batchreassessment->admin_verified=='2')?'Rejected':'Pending')}}</td>
                                    <td style="font-weight:bold;" class="text-{{($reassessment->batchreassessment->sup_admin_verified=='1')?'success':(($reassessment->batchreassessment->sup_admin_verified=='2')?'danger':'muted')}}">{{($reassessment->batchreassessment->sup_admin_verified=='1')?'Approved':(($reassessment->batchreassessment->sup_admin_verified=='2')?'Rejected':'Pending')}}</td>
                                    <td style="font-weight:bold;" class="text-{{($reassessment->batchreassessment->supadmin_cert_rel=='1')?'success':'danger'}}">{{($reassessment->batchreassessment->supadmin_cert_rel=='1')?'Released':(($reassessment->batchreassessment->supadmin_cert_rel=='2')?'Rejected':'Not Released')}}</td>
                                    <td><a class="badge bg-green margin-0" href="{{route('assessor.reassessment.view',Crypt::encrypt($reassessment->batchreassessment->id))}}" >View</a></td>
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