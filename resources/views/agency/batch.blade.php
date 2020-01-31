@extends('layout.master')
@section('title', 'Batch')
@section('parentPageTitle', 'Agency')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/color_skins.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
@stop
@section('content')

<div class="container-fluid">
        <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header d-flex justify-content-between">
                            <h2><strong>My</strong> Approved Batch</h2>
                        
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Batch ID</th>
                                            <th>Partner ID</th>
                                            <th>Center ID</th>
                                            <th>Assessor</th>
                                            <th>Assessment Date</th>
                                            <th>Overall Status</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($agencyBatch as $key=>$item) 
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$item->batch->batch_id}}</td>
                                            <td>{{$item->batch->partner->tp_id}}</td>
                                            <td>{{$item->batch->center->tc_id}}</td>
                                            <td>{{is_null($item->batch->assessorbatch)?'Not Assigned Yet':$item->batch->assessorbatch->assessor->as_id}}</td>
                                            <td>{{\Carbon\Carbon::parse($item->batch->assessment)->format('d-m-Y')}}</td>
                                            @if ($item->batch->completed)
                                                <td style="color:green">Waiting for Results</td>
                                            @else
                                                <td style="color:{{($item->batch->status && $item->batch->center->status && $item->batch->partner->status && $item->batch->trainer->status && $item->batch->tpjobrole->status)?'green':'red'}}">{{($item->batch->status && $item->batch->center->status && $item->batch->partner->status && $item->batch->trainer->status && $item->batch->tpjobrole->status)?'Active':'Inactive'}}</td>
                                            @endif
                                            <td><a class="badge bg-green margin-0" href="{{route(Request::segment(1).'.bt.batch.view',Crypt::encrypt($item->batch->id))}}">View</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                                <div class="text-muted">
                                    <h6>NOTE:</h6>
                                    <i class="zmdi zmdi-circle text-danger"></i>
                                    This Instance is Currently in <span style='color:red'>Inactive State</span>
                                    <i class="zmdi zmdi-circle text-success"></i>
                                    This Instance is Currently in <span style='color:green'>Active State</span>


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