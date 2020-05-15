@extends('layout.master')
@section('title', 'View Batch')
@section('parentPageTitle', 'TOT-TOA')
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
                    <h2><strong>View</strong> Batch Details</h2>
                </div>
                <div class="text-center">
                <h6><strong>Batch ID: <span style="color:blue">{{$batchData->batch_id}}</span></strong></h6>
                </div>
                <div class="body">
    
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Trainer ID</th>
                                    <th>Trainer Name</th>
                                    <th>TP Name</th>
                                    <th>Doc No</th>
                                    <th>Percentage</th>
                                    <th>Grade</th>
                                    <th>Validity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $cert_tag = false;
                                @endphp
                                @foreach ($batchData->trainers as $key=>$item)
                                    @php
                                        if (!is_null($item->percentage)) {
                                            $cert_tag = true;
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{is_null($item->bt_tot_id)?'NA':$item->bt_tot_id}}</td>
                                        <td>{{$item->trainer->name}}</td>
                                        <td>{{$item->trainer->tp_name}}</td>
                                        <td>{{$item->trainer->doc_no}}</td>
                                        <td>{{is_null($item->percentage)?'NA':$item->percentage.'%'}}</td>
                                        <td>{{is_null($item->grade)?'NA':$item->grade}}</td>
                                        <td>{{is_null($item->validity)?'NA':Carbon\Carbon::parse($item->validity)->format('d-m-Y')}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- <div class="row d-flex justify-content-center">
                        @if ($cert_tag)
                            <button class="btn btn-primary" onclick="window.open('{{route('admin.tot-toa.certificate.print',Crypt::encrypt($batchData->id.',1'))}}');"><i class="zmdi zmdi-print" formtarget="_blank"></i>  &nbsp;&nbsp;Print Certificate</button>
                        @endif
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('page-script')

<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{asset('assets/js/scpwd-common.js')}}"></script>

@stop