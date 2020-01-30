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
                    <h2><strong>My</strong> Batches</h2>
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
                                    <th>Overall Status</th>
                                    <th>Marks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assessorBatch as $key=>$item)                                   
                                    @if(is_null($item->batch->batchassessment))
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$item->batch->batch_id}}</td>
                                            <td>{{\Carbon\Carbon::parse($item->batch->batch_start)->format('d-m-Y')}}</td>
                                            <td>{{\Carbon\Carbon::parse($item->batch->batch_end)->format('d-m-Y')}}</td>
                                            <td>{{\Carbon\Carbon::parse($item->batch->assessment)->format('d-m-Y')}}</td>
                                            @if (\Carbon\Carbon::now()>\Carbon\Carbon::parse($item->batch->assessment))
                                                <td style="color:green"><strong>Processing Marks</strong></td>
                                                <td><a class="badge bg-green margin-0" href="{{route('assessor.as.batch.candidate-mark',['id'=>Crypt::encrypt($item->batch->id)])}}" >Enter Marks</a></td>
                                            @else
                                                <td style="color:{{($item->batch->tpjobrole->status)?'green':'red'}}"><strong>{{($item->batch->tpjobrole->status)?'Active':'Inactive'}}</strong></td>
                                                <td><a class="badge bg-grey margin-0" href="javascript:void(0)" >Enter Marks</a></td>  
                                            @endif
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