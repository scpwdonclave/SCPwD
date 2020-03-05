@extends('layout.master')
@section('title', 'Batches')
@section('parentPageTitle', 'Assessor')
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
                    <h2><strong>My</strong> Upcoming Batches for Assessments</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Batch ID</th>
                                    <th>Disability Type</th>
                                    <th>Assessment Date</th>
                                    <th>Assessment Status</th>
                                    <th>Marks</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assessorBatch as $item)                                   
                                    @if(is_null($item->batch->batchassessment) && $item->batch->status)                                        
                                        @if (is_null($item->reass_id))
                                            <tr>
                                                <td>{{$item->batch->batch_id}}</td>
                                                <td>{{$item->batch->scheme->disability?'Multi Disability':'Single Disability'}}</td>
                                                <td>{{\Carbon\Carbon::parse($item->batch->assessment)->format('d-m-Y')}}</td>
                                                @if (\Carbon\Carbon::parse($item->batch->assessment.' 00:00') > \Carbon\Carbon::now())
                                                    <td style="color:blue">Not Started Yet</td>
                                                    <td><a class="badge bg-grey margin-0" href="javascript:void(0)" >Enter Marks</a></td>  
                                                @else
                                                    @if (\Carbon\Carbon::parse($item->batch->assessment.' 23:59') < \Carbon\Carbon::now())
                                                        <td style="color:green">Completed</td>
                                                        <td><a class="badge bg-green margin-0" href="{{route('assessor.as.batch.candidate-mark',Crypt::encrypt($item->batch->id))}}" >Enter Marks</a></td>
                                                    @else
                                                        <td style="color:blue">On Going</td>
                                                        <td><a class="badge bg-grey margin-0" href="javascript:void(0)" >Enter Marks</a></td>  
                                                    @endif
                                                @endif
                                                <td><a class="badge bg-green margin-0" href="{{route('assessor.batch.view',Crypt::encrypt($item->batch->id.',1'))}}">View</a></td>
                                            </tr>
                                        @endif
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="header d-flex justify-content-between">
                    <h2><strong>My</strong> Upcoming Batches for Re-Assessments</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Batch ID</th>
                                    <th>Re-Assessment Date</th>
                                    <th>Re-Assessment Status</th>
                                    <th>Marks</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assessorReBatch as $reassBatch)                                   
                                    @if(is_null($reassBatch->batchreassessment) && $reassBatch->batch->status)                                        
                                        <tr>
                                            <td>{{$reassBatch->batch->batch_id}}</td>
                                            <td>{{\Carbon\Carbon::parse($reassBatch->assessment)->format('d-m-Y')}}</td>
                                            @if (\Carbon\Carbon::parse($reassBatch->assessment.' 00:00') > \Carbon\Carbon::now())
                                                <td style="color:blue">Not Started Yet</td>
                                                <td><a class="badge bg-grey margin-0" href="javascript:void(0)" >Enter Marks</a></td>  
                                            @else
                                                @if (\Carbon\Carbon::parse($reassBatch->assessment.' 23:59') < \Carbon\Carbon::now())
                                                    <td style="color:green">Completed</td>
                                                    <td><a class="badge bg-green margin-0" href="{{route('assessor.as.batch.candidate-re-mark',Crypt::encrypt($reassBatch->id))}}" >Enter Marks</a></td>
                                                @else
                                                    <td style="color:blue">On Going</td>
                                                    <td><a class="badge bg-grey margin-0" href="javascript:void(0)" >Enter Marks</a></td>  
                                                @endif
                                            @endif
                                            <td><a class="badge bg-green margin-0" href="{{route('assessor.batch.view',Crypt::encrypt($reassBatch->id.',0'))}}">View</a></td>
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