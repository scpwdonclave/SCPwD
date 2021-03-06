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
                    <h2><strong>My</strong> Approved Batches for Assessment</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Batch ID</th>
                                    <th>Partner ID</th>
                                    <th>Center ID</th>
                                    <th>Assessor</th>
                                    <th>Disability Type</th>
                                    <th>Assessment Date</th>
                                    <th>Assessment Status</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($agency->agencyBatch as $batch) 
                                    @if (is_null($batch->reass_id) && $batch->aa_verified)
                                        <tr>
                                            <td>{{$batch->batch->batch_id}}</td>
                                            <td>{{$batch->batch->partner->tp_id}}</td>
                                            <td>{{$batch->batch->center->tc_id}}</td>
                                            <td>{!!is_null($batch->batch->assessorbatch)?'<span style="color:blue">Not Assigned Yet</span>':$batch->batch->assessorbatch->assessor->as_id!!}</td>
                                            <td>{{$batch->batch->scheme->disability?'Multi Disability':'Single Disability'}}</td>
                                            <td>{{\Carbon\Carbon::parse($batch->batch->assessment)->format('d-m-Y')}}</td>
                                            @if (\Carbon\Carbon::parse($batch->batch->assessment.' 00:00') > \Carbon\Carbon::now())
                                                <td style="color:blue">Not Started Yet</td>
                                            @else
                                                @if (\Carbon\Carbon::parse($batch->batch->assessment.' 23:59') < \Carbon\Carbon::now())
                                                    <td style="color:green">Completed</td>
                                                @else
                                                    <td style="color:blue">On Going</td>
                                                @endif
                                            @endif
                                            <td><a class="badge bg-green margin-0" href="{{route('agency.batch.view',Crypt::encrypt($batch->batch->id.',1'))}}">View</a></td>
                                            {{-- <td><a class="badge bg-green margin-0" href="{{route(Request::segment(1).'.bt.batch.view-dtl',Crypt::encrypt($batch->batch->id))}}">View</a></td> --}}
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
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header d-flex justify-content-between">
                    <h2><strong>My</strong> Approved Batches for Re-Assessment</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Batch ID</th>
                                    <th>Partner ID</th>
                                    <th>Center ID</th>
                                    <th>Disability Type</th>
                                    <th>Assessor</th>
                                    <th>Re-Assessment Date</th>
                                    <th>Re-Assessment Status</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($agency->agencyBatch as $batch) 
                                    @if (!is_null($batch->reass_id) && $batch->aa_verified)
                                        <tr>
                                            <td>{{$batch->batch->batch_id}}</td>
                                            <td>{{$batch->batch->partner->tp_id}}</td>
                                            <td>{{$batch->batch->center->tc_id}}</td>
                                            <td>{!!is_null($batch->reassessment->as_id)?'<span style="color:blue">Not Assigned Yet</span>':$batch->reassessment->assessor->as_id!!}</td>
                                            <td>{{$batch->batch->scheme->disability?'Multi Disability':'Single Disability'}}</td>
                                            <td>{{\Carbon\Carbon::parse($batch->reassessment->assessment)->format('d-m-Y')}}</td>
                                            @if (\Carbon\Carbon::parse($batch->reassessment->assessment.' 00:00') > \Carbon\Carbon::now())
                                                <td style="color:blue">Not Started Yet</td>
                                            @else
                                                @if (\Carbon\Carbon::parse($batch->reassessment->assessment.' 23:59') < \Carbon\Carbon::now())
                                                    <td style="color:green">Completed</td>
                                                @else
                                                    <td style="color:blue">On Going</td>
                                                @endif
                                            @endif
                                            <td><a class="badge bg-green margin-0" href="{{route('agency.batch.view',Crypt::encrypt($batch->reass_id.',0'))}}">View</a></td>

                                            {{-- <td><a class="badge bg-green margin-0" href="{{route(Request::segment(1).'.bt.batch.view-dtl',Crypt::encrypt($batch->batch->id))}}">View</a></td> --}}
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
@stop