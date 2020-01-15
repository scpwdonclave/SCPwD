@extends('layout.master')
@section('title', 'Assesors')
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
                    <h2><strong>All</strong> Assessors</h2>
                    <a class="btn btn-primary btn-round waves-effect" href="{{route('agency.add-assessor')}}">Add Assessor</a> 
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Assessor ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Overall Status</th>
                                    <th>Batch</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key=>$item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{is_null($item->as_id)?Config::get('constants.nullidtext'):$item->as_id}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->email}}</td>
                                        <td>{{$item->mobile}}</td>
                                        @if ($item->verified)
                                            <td style="color:{{($item->status && $item->agency->status)?'green':'red'}}">{{($item->status && $item->agency->status)?'Active':'Inactive'}}</td>
                                            <td><a class="badge bg-green margin-0" href="{{route('agency.as.assessor.batch',['id'=>Crypt::encrypt($item->id)])}}" >Batch</a></td>
                                        @else
                                            <td style="color:red">Not Verified</td>
                                            <td><button type="button" class="badge bg-grey margin-0">Batch</button></td>
                                        @endif
                                        <td><a class="badge bg-green margin-0" href="{{route('agency.as.assessor.view',['id'=>Crypt::encrypt($item->id)])}}">View</a></td>
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