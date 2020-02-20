@extends('layout.master')
@section('title', 'Batches')
@section('parentPageTitle', 'Assessment')
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
                        <h2><strong>All</strong> Assessment</h2>
                       
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>Batch ID</th>
                                        <th>AA ID</th>
                                        <th>AS ID</th>
                                        {{-- <th>Start Date</th>
                                        <th>End Date</th> --}}
                                        <th>Assessment Date</th>
                                        <th>Agency Approve</th>
                                        <th>Admin Approve</th>
                                        <th>Super Admin Approve</th>
                                        <th>Certificate</th>
                                        <th>View</th>
                                       
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach ($agencyBatch as $key=>$item) 
                                   
                                    @if(!is_null($item->batch->batchassessment) && is_null($item->reass_id))
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$item->batch->batch_id}}</td>
                                            <td>{{$item->agency->aa_id}}</td>
                                            <td>{{$item->batch->assessorbatch->assessor->as_id}}</td>
                                            {{-- <td>{{$item->batch->batch_start}}</td>
                                            <td>{{$item->batch->batch_end}}</td> --}}
                                            <td>{{\Carbon\Carbon::parse($item->batch->assessment)->format('d-m-Y')}}</td>

                                            @if ($item->batch->batchassessment->aa_verified==0)
                                            <td class="text-muted"><strong>Pending</strong></td>
                                            @elseif ($item->batch->batchassessment->aa_verified==1)
                                            <td class="text-success"><strong>Approved</strong></td>
                                            @else
                                            <td class="text-danger"><strong>Rejected</strong></td>
                                            @endif

                                            @if ($item->batch->batchassessment->admin_verified==0)
                                            <td class="text-muted"><strong>Pending</strong></td>
                                            @elseif ($item->batch->batchassessment->admin_verified==1)
                                            <td class="text-success"><strong>Approved</strong></td>
                                            @else
                                            <td class="text-danger"><strong>Rejected</strong></td>
                                            @endif

                                            @if ($item->batch->batchassessment->sup_admin_verified==0)
                                            <td class="text-muted"><strong>Pending</strong></td>
                                            @elseif ($item->batch->batchassessment->sup_admin_verified==1)
                                            <td class="text-success"><strong>Approved</strong></td>
                                            @else
                                            <td class="text-danger"><strong>Rejected</strong></td>
                                            @endif

                                            @if ($item->batch->batchassessment->admin_cert_rel==1 && $item->batch->batchassessment->supadmin_cert_rel==1)
                                            <td class="text-success"><strong>Released</strong></td>
                                            @elseif($item->batch->batchassessment->supadmin_cert_rel==2)
                                            <td class="text-danger"><strong>Rejected</strong></td>
                                            @else
                                            <td class="text-danger"><strong>Not Released</strong></td>
                                            @endif

                                            <td><a class="badge bg-green margin-0" href="{{route('admin.assessment.view',['id'=>Crypt::encrypt($item->batch->batchassessment->id)])}}" >View</a></td>
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
                                    @foreach ($agencyBatch as $key=>$item)
                                   
                                    @if(!is_null($item->batch->batchassessment) && $item->batch->batchassessment->aa_verified==2)
                                    <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$item->batch->batch_id}}</td>
                                    <td>{{$item->batch->batch_start}}</td>
                                    <td>{{$item->batch->batch_end}}</td>
                                    <td>{{$item->batch->assessment}}</td>
                                    <td class="text-{{($item->batch->batchassessment->aa_verified)?'success':'danger'}}"><strong>{{($item->batch->batchassessment->aa_verified)?'Approved':'Pending'}}</strong></td>
                                    <td class="text-{{($item->batch->batchassessment->admin_verified)?'success':'danger'}}"><strong>{{($item->batch->batchassessment->aa_verified)?'Approved':'Pending'}}</strong></td>
                                    <td class="text-{{($item->batch->batchassessment->sup_admin_verified)?'success':'danger'}}"><strong>{{($item->batch->batchassessment->aa_verified)?'Approved':'Pending'}}</strong></td>
                                    <td><a class="badge bg-green margin-0" href="{{route('agency.assessment.view',['id'=>Crypt::encrypt($item->batch->batchassessment->id)])}}" >View</a></td>
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