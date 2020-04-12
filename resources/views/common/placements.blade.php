@extends('layout.master')
@section('title', 'Placements')
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
                    <h2><strong>All</strong> Placements</h2>
                    @if (Request::segment(1)==='center')
                        <a class="btn btn-primary btn-round waves-effect" href="{{route('center.placement.add')}}">New Placement</a>
                    @endif
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Training Partner</th>
                                    <th>Training Center</th>
                                    <th>Candidate Name</th>
                                    <th>Job Role</th>
                                    <th>Organization</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($placements as $placement)
                                    <tr>
                                        <td>{{$placement->centercandidate->center->partner->org_name.' ('.$placement->centercandidate->center->partner->tp_id.')'}}</td>
                                        <td>{{$placement->centercandidate->center->center_name.' ('.$placement->centercandidate->center->tc_id.')'}}</td>
                                        <td>{{$placement->centercandidate->candidate->name.' ('.$placement->centercandidate->candidate->cd_id.')'</td>
                                        <td>{{$placement->centercandidate->jobrole->partnerjobrole->jobrole->job_role}}</td>
                                        <td>{{$placement->org_name}}</td>
                                        <td><button type="button" class="badge bg-green margin-0" onclick="location.href='{{route(Request::segment(1).'.placement.view',Crypt::encrypt($placement->id))}}'" >View</button></td>
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