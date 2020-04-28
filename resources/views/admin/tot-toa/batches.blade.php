@extends('layout.master')
@if ($tag==='tot')
    @section('title', 'TOT Batches')
@else
    @section('title', 'TOA Batches')
@endif
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
                    <h2><strong>{{$tag==='tot'?'TOT':'TOA'}}</strong> Batches </h2>
                    <a class="btn btn-primary btn-round waves-effect" href="javascript:void(0);" data-toggle="modal" data-target="#defaultModal">Add New Batch</a>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Batch ID</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>No of {{$tag==='tot'?'Trainers':'Assessors'}}</th>
                                    <th>view</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($records as $record)
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
                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('modal')
    <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog"> 
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="title" id="defaultModalLabel"></h4>
                </div>
                <div class="modal-body">
                    <form id="form_modal" method="POST" action="#">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="scheme">Select Scheme</label>    
                                <select class="form-control show-tick form-group" id="scheme" name="scheme" data-live-search="true" required >
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="sector">Select Sector</label>
                                <select class="form-control show-tick form-group" id="sector" name="sector" data-live-search="true" required >
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="jobrole">Select Job Role</label>
                                <select class="form-control show-tick form-group" id="jobrole" name="jobrole" data-live-search="true" required >
                                </select>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <div class="col-sm-6">
                                <label for="target">Enter Target Value</label>    
                                <div class="form-group form-float">
                                    <input type="number" class="form-control" placeholder="Enter Target Value" name="target" id="target" required>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <button id="btnConfirm" class="btn btn-raised btn-primary btn-round waves-effect" type="submit" ></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop