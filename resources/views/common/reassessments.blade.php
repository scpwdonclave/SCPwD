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
                    <h2><strong>All</strong> Pending Re-Assessment Requests</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                               
                                <tr>
                                    <th>Batch ID</th>
                                    @if (Request::segment(1)==='admin')
                                        <th>Training Partner</th>
                                        <th>Training Center</th>
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
                            @php
                                $reassessments = (Request::segment(1)==='admin')? $reassessments : $user->reassessments;
                            @endphp
                            <tbody>
                                @foreach ($reassessments as $reassessment)
                                    @if (is_null($reassessment->verified))
                                        <tr>
                                            <td>{{$reassessment->batch->batch_id}}</td>
                                            @if (Request::segment(1)==='admin')
                                                <td>{{$reassessment->batch->partner->org_name.' ('.$reassessment->batch->partner->tp_id.')'}}</td>
                                                <td>{{$reassessment->batch->center->center_name.' ('.$reassessment->batch->center->tc_id.')'}}</td>
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
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header d-flex justify-content-between">
                    <h2><strong>All</strong> Approved/Rejected Re-Assessments</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                               
                                <tr>
                                    <th>Batch ID</th>
                                    @if (Request::segment(1)==='admin')
                                        <th>Training Partner</th>
                                        <th>Training Center</th>
                                    @else
                                        @if (Request::segment(1)==='partner')
                                            <th>Center ID</th>
                                        @endif
                                    @endif
                                    <th>Re-Assessment Date</th>
                                    <th>Verified by SCPwD</th>
                                    <th>Re-Assessment Status</th>
                                    <th>View</th>
                                    @if (Request::segment(1)!='admin')
                                        <th>Result</th>
                                    @endif
                                </tr>
                               
                            </thead>
                            @php
                                $reassessments = (Request::segment(1)==='admin')? $reassessments : $user->reassessments;
                            @endphp
                            <tbody>
                                @foreach ($reassessments as $reassessment)
                                    @if (!is_null($reassessment->verified))
                                        <tr>
                                            <td>{{$reassessment->batch->batch_id}}</td>
                                            @if (Request::segment(1)==='admin')
                                                <td>{{$reassessment->batch->partner->org_name.' ('.$reassessment->batch->partner->tp_id.')'}}</td>
                                                <td>{{$reassessment->batch->center->center_name.' ('.$reassessment->batch->center->tc_id.')'}}</td>
                                            @else
                                                @if (Request::segment(1)==='partner')
                                                    <td>{{$reassessment->batch->center->tc_id}}</td>
                                                @endif
                                            @endif
                                            <td>{{(is_null($reassessment->assessment))?'Not Applicable':\Carbon\Carbon::parse($reassessment->assessment)->format('d-m-Y')}}</td>
                                            @if (!is_null($reassessment->verified))
                                                @if ($reassessment->verified)
                                                    <td style="color:green">Accepted</td>

                                                    @php
                                                    $assessment_button = false;
                                                        foreach ($reassessment->candidates as $candidate) {
                                                            if ($candidate->appear) {
                                                                $assessment_button = true;
                                                            }
                                                        }
                                                    @endphp
                                                    
                                                    @if ($assessment_button)
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
                                                        <td>Not Applicable</td>   
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
                                            @if (Request::segment(1)!='admin')
                                                @if ($reassessment->batchreassessment)
                                                    @if ($reassessment->batchreassessment->sup_admin_verified=='1')
                                                        <td><a class="badge bg-green margin-0" href="{{route(Request::segment(1).'.reassessment.marks.view',Crypt::encrypt($reassessment->batchreassessment->id))}}">View</a></td>
                                                    @else
                                                        <td><a class="badge bg-grey margin-0" href='javascript:void(0);' onclick="return false;">View</a></td>
                                                    @endif
                                                @else
                                                    <td>NA</td>
                                                @endif
                                            @endif
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