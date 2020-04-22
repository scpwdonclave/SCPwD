@extends('layout.master')
@section('title', 'TOT-Trainers')
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
                    <h2><strong>All</strong> TOT Records </h2>
                    <a class="btn btn-primary btn-round waves-effect" href="{{route('admin.tot-toa.addtrainercert')}}">Add New TOT</a>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>TOT Cert ID</th>
                                    <th>Trainer Name</th>
                                    <th>Aadhaar</th>
                                    <th>Contact</th>
                                    <th>Percentage</th>
                                    <th>Grade</th>
                                    <th>Expiry</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tots as $tot)
                                    <tr>
                                        <td>{{$tot->tot_id}}</td>
                                        <td>{{$tot->name}}</td>
                                        <td>{{$tot->aadhaar}}</td>
                                        <td>{{$tot->contact}}</td>
                                        <td>{{$tot->percentage}}</td>
                                        <td>{{$tot->grade}}</td>
                                        <td>{{$tot->validity}}</td>
                                        <td><button type="button" class="badge bg-green margin-0" onclick="location.href='{{route('admin.tot-toa.trainer.view',Crypt::encrypt($tot->id))}}'" >View</button></td>
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
@stop