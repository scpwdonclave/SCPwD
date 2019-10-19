@extends('layout.master')
@section('title', 'Pending Batches')
@section('page-style')
<!-- Custom Css -->
<link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/>

<link rel="stylesheet" href="{{asset('assets/css/color_skins.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
@stop
@section('content')
<div class="container-fluid home">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header d-flex justify-content-between">
                    <h2><strong>All</strong> Pending Batches</h2>
                    @if (Request::segment(1) === 'partner')
                        <a class="btn btn-primary btn-round waves-effect" href="{{route('partner.addbatch')}}">Add New Batch</a>                      
                    @endif
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
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Assessment Date</th>
                                    <th>View</th>
                                    
                                </tr>
                               
                            </thead>
                            <tbody>
                                @foreach ($data as $key=>$item)
                                <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$item->batch_id}}</td>
                                <td>{{$item->partner->tp_id}}</td>
                                <td>{{$item->center->tc_id}}</td>
                                <td>{{$item->batch_start}}</td>
                                <td>{{$item->batch_end}}</td>
                                <td>{{$item->assesment}}</td>
                                <td><a class="badge bg-green margin-0" href="{{route('admin.bt.batch.view',['id'=>Crypt::encrypt($item->id)])}}">View</a></td>
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
@endsection

@section('page-script')

<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
@endsection