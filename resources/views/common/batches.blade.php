@extends('layout.master')
@section('title', 'Batches')
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
                    <h2><strong>All</strong> Batches</h2>
                    @if (Request::segment(1) === 'partner')
                        @can('partner-has-jobrole', Auth::shouldUse('partner'))
                            <a class="btn btn-primary btn-round waves-effect" href="{{route('partner.addbatch')}}">Add New Batch</a>                      
                        @endcan
                    @endif
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
                                    <th>Disability Type</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Assessment Date</th>
                                    <th>Training Status</th>
                                    <th>Certificate</th>
                                    <th>View</th>
                                </tr>
                               
                            </thead> 
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{is_null($item->batch_id)?Config::get('constants.nullidtext'):$item->batch_id}}</td>
                                        @if (Request::segment(1)==='admin')
                                            <td>{{ $item->partner->org_name.' ('.$item->partner->tp_id.')'}}</td>
                                            <td>{{ $item->center->center_name.' ('.$item->center->tc_id.')'}}</td>
                                        @else
                                            @if (Request::segment(1)==='partner')
                                                <td>{{$item->center->tc_id}}</td>
                                            @endif
                                        @endif
                                        <td>{{$item->scheme->disability?'Multi Disabilty':'Single DIsability'}}</td>
                                        <td>{{\Carbon\Carbon::parse($item->batch_start)->format('d-m-Y')}}</td>
                                        <td>{{\Carbon\Carbon::parse($item->batch_end)->format('d-m-Y')}}</td>
                                        <td>{{\Carbon\Carbon::parse($item->assessment)->format('d-m-Y')}}</td>
                                        @if ($item->verified)
                                            @if ($item->status)
                                                @if (\Carbon\Carbon::parse($item->batch_start.' 00:00') > \Carbon\Carbon::now())
                                                    <td style="color:blue">Not Started Yet</td>
                                                @else
                                                    @if (\Carbon\Carbon::parse($item->batch_end.' 23:59') < \Carbon\Carbon::now())
                                                        <td style="color:green">Completed</td>
                                                    @else
                                                        <td style="color:blue">On Going</td>
                                                    @endif
                                                @endif
                                            @else
                                                <td style="color:red">Cancelled</td>
                                            @endif
                                        @else
                                            <td style="color:red">Not Verified Yet</td>
                                        @endif
                                        @if (!is_null($item->batchassessment) && $item->batchassessment->supadmin_cert_rel)
                                            <td style="color:green">Released</td>   
                                        @else
                                            <td style="color:red">Not Released</td>   
                                        @endif
                                        <td><a class="badge bg-green margin-0" href="{{route(Request::segment(1).'.bt.batch.view',Crypt::encrypt($item->id))}}">View</a></td>
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