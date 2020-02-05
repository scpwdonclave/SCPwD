@extends('layout.master')
@section('title', 'Re Assessments')
{{-- @section('parentPageTitle', 'Assessor') --}}
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">

@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header d-flex justify-content-between">
                        <h2><strong>All</strong> Re-Assessments</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Batch ID</th>
                                        <th>Assessment Date</th>
                                        <th>Agency Approve</th>
                                        <th>Admin Approve</th>
                                        <th>Super Admin Approve</th>
                                        <th>Certificate</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reassessment as $item)                                   
                                        @if(!is_null($item->batchreassessment))
                                        <tr>
                                            <td>{{$item->batch->batch_id}}</td>
                                            <td>{{\Carbon\Carbon::parse($item->assessment)->format('d-m-Y')}}</td>
                                            @if ($item->batchreassessment->aa_verified==0)
                                                <td class="text-muted"><strong>Pending</strong></td>
                                            @elseif ($item->batchreassessment->aa_verified==1)
                                                <td class="text-success"><strong>Approved</strong></td>
                                            @else
                                                <td class="text-danger"><strong>Rejected</strong></td>
                                            @endif

                                            @if ($item->batchreassessment->admin_verified==0)
                                                <td class="text-muted"><strong>Pending</strong></td>
                                            @elseif ($item->batchreassessment->admin_verified==1)
                                                <td class="text-success"><strong>Approved</strong></td>
                                            @else
                                                <td class="text-danger"><strong>Rejected</strong></td>
                                            @endif

                                            @if ($item->batchreassessment->sup_admin_verified==0)
                                                <td class="text-muted"><strong>Pending</strong></td>
                                            @elseif ($item->batchreassessment->sup_admin_verified==1)
                                                <td class="text-success"><strong>Approved</strong></td>
                                            @else
                                                <td class="text-danger"><strong>Rejected</strong></td>
                                            @endif

                                            @if ($item->batchreassessment->admin_cert_rel==1 && $item->batchreassessment->supadmin_cert_rel==1)
                                                <td class="text-success"><strong>Released</strong></td>
                                            @else
                                                <td class="text-danger"><strong>Not Released</strong></td>
                                            @endif
                                            <td><a class="badge bg-green margin-0" href="{{route('assessor.assessment.view',['id'=>Crypt::encrypt($item->batchreassessment->id)])}}" >View</a></td>
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