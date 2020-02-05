@extends('layout.master')
@section('title', 'All Re-Assessments')
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
                    <h2><strong>All</strong> Re-Assessments</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                               
                                <tr>
                                    <th>Batch ID</th>
                                    @if (Request::segment(1)==='admin')
                                        <th>Partner ID</th>
                                        <th>Center ID</th>
                                    @else
                                        @if (Request::segment(1)==='partner')
                                            <th>Center ID</th>
                                        @endif
                                    @endif
                                    <th>Re-Assessment Date</th>
                                    <th>Verified by SCPwD</th>
                                    <th>Re-Assessment Status</th>
                                    <th>View</th>
                                </tr>
                               
                            </thead> 
                            <tbody>
                                @foreach ($user->reassessments as $reassessment)
                                    <tr>
                                        <td>{{$reassessment->batch->batch_id}}</td>
                                        @if (Request::segment(1)==='admin')
                                            <td>{{$reassessment->batch->partner->tp_id}}</td>
                                            <td>{{$reassessment->batch->center->tc_id}}</td>
                                        @else
                                            @if (Request::segment(1)==='partner')
                                                <td>{{$reassessment->batch->center->tc_id}}</td>
                                            @endif
                                        @endif
                                        <td>{{(is_null($reassessment->assessment))?'Not Applicable':\Carbon\Carbon::parse($reassessment->assessment)->format('d-m-Y')}}</td>
                                        @if (!is_null($reassessment->verified))
                                            @if ($reassessment->verified)
                                                <td style="color:green">Verified</td>

                                                @if ($reassessment->batch->status)
                                                    @if (\Carbon\Carbon::parse($reassessment->assessment.' 00:00') > \Carbon\Carbon::now())
                                                        <td style="color:blue">Not Started Yet</td>
                                                    @else
                                                        @if (\Carbon\Carbon::parse($reassessment->assessment.' 23:59') < \Carbon\Carbon::now())
                                                            <td style="color:green">Completed</td>
                                                        @else
                                                            <td style="color:blue">On Going</td>
                                                        @endif
                                                    @endif
                                                @else
                                                    <td style="color:red">Cancelled</td>
                                                @endif
                                            @else 
                                                <td style="color:red">Request Rejected</td>
                                                <td>Not Applicable</td>   
                                            @endif
                                        @else
                                            <td style="color:red">Not Verified yet</td>   
                                            <td>Not Applicable</td>   
                                        @endif
                                        <td><a class="badge bg-green margin-0" href="{{route(Request::segment(1).'.reassessment.view',Crypt::encrypt($reassessment->id))}}">View</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @can('partner-has-jobrole', Auth::shouldUse('partner'))
                            <div class="text-muted">
                                {!!Config::get('constants.note')!!}
                            </div>
                        @endcan
                        <div class="text-center">
                            @if (Request::segment(1)==='partner')
                                @cannot('partner-has-jobrole', Auth::shouldUse('partner'))
                                    <h6>You Can Add New Batches Once Admin Assign you Job Roles</h6>
                                @endcannot
                            @endif
                        </div>
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