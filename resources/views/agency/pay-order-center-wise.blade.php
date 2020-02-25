@extends('layout.master')
@section('title', 'Pay Order')
@section('parentPageTitle', 'TC Wise')
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
                                        <th>Center ID</th>
                                        <th>SPOC Name</th>
                                        <th>SPOC Email</th>
                                        <th>SPOC Mobile</th>
                                        <th>Center Name</th>
                                        <th>Center Address</th>
                                        
                                        <th>View</th>
                                       
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach ($center as $key=>$item)
                                        
                                    <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$item->tc_id}}</td>
                                    <td>{{$item->spoc_name}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->mobile}}</td>
                                    <td>{{$item->center_name}}</td>
                                    <td style="white-space:pre-wrap; word-wrap:break-word">{{$item->center_address}}</td>
                                    <td><a class="badge bg-green margin-0" href="{{route('agency.tc.payorder',['id'=>Crypt::encrypt($item->id)])}}" >View Pay Order</a></td>
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