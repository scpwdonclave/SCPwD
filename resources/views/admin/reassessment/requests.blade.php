@extends('layout.master')
@section('title', 'Agencies')
@section('parentPageTitle', 'Agencies')
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
                    <h2><strong>All</strong> Pending Re-Assessment Requests </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Batch ID</th>
                                    <th>TP ID</th>
                                    <th>TC ID</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reassessments as $reassessment)
                                    @if (is_null($reassessment->verified))
                                        <tr>
                                            <td>{{$reassessment->batch->batch_id}}</td>
                                            <td>{{$reassessment->batch->partner->tp_id}}</td>
                                            <td>{{$reassessment->batch->center->tc_id}}</td>
                                            <td><button type="button" class="badge bg-green margin-0" onclick="location.href='{{route('admin.reassessment.requests.view',Crypt::encrypt($reassessment->id))}}'">View</button></td>
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

<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header d-flex justify-content-between">
                    <h2><strong>All</strong> Approved/Rejected Re-Assessments </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Batch ID</th>
                                    <th>TP ID</th>
                                    <th>TC ID</th>
                                    <th>Status</th>
                                    <th>Assessment</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reassessments as $reassessment)
                                    @if (!is_null($reassessment->verified))
                                        <tr>
                                            <td>{{$reassessment->batch->batch_id}}</td>
                                            <td>{{$reassessment->batch->partner->tp_id}}</td>
                                            <td>{{$reassessment->batch->center->tc_id}}</td>
                                            <td style="color:{{($reassessment->verified)?'green':'red'}}">{{($reassessment->verified)?'Approved':'Rejected'}}</td>
                                            <td>{{($reassessment->verified)?$reassessment->assessment:'Not Applicable'}}</td>
                                            <td><button type="button" class="badge bg-green margin-0" onclick="location.href='{{route('admin.reassessment.requests.view',Crypt::encrypt($reassessment->id))}}'">View</button></td>
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