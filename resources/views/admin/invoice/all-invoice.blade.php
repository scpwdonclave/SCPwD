@extends('layout.master')
@section('title', 'Invoice')
@section('parentPageTitle', 'All')
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
                        <h2><strong>All</strong> Invoice</h2>
                       
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                        <tr>
                                        <th>Sl. No.</th>
                                        <th>Invoice ID</th>
                                        <th>Partner ID</th>
                                        <th>Scheme</th>
                                        <th>Reference No</th>
                                        <th>Invoice Date</th>
                                        <th>Status</th>
                                        <th>View</th>
                                       
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach ($all_invoice as $key=>$item)
                                        
                                    <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$item->invoice_id}}</td>
                                    <td>{{$item->partner->tp_id}}</td>
                                    <td>{{$item->scheme->scheme}}</td>
                                    <td>{{$item->ref_no}}</td>
                                    <td>{{\Carbon\Carbon::parse($item->invoice_date)->format('d-m-Y')}}</td>
                                    @if ($item->re_assessment===0)
                                    <td>Assessment</td>
                                    @else
                                    <td>Re-Assessment</td>
                                    @endif
                                    <td><a class="badge bg-green margin-0" href="{{route('admin.invoice.print.invoice',['id'=>Crypt::encrypt($item->id)])}}" >View Invoice</a></td>
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