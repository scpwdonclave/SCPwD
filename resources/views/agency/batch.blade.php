@extends('layout.master')
@section('title', 'Batch')
@section('parentPageTitle', 'Agency')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/>
@stop
@section('content')

<div class="container-fluid">
        <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header d-flex justify-content-between">
                            <h2><strong>My</strong> Approved Batch</h2>
                        
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                            <tr>
                                            <th>#</th>
                                            <th>Batch ID</th>
                                            <th>Partner ID</th>
                                            <th>Center ID</th>
                                            <th>Assessor</th>
                                            {{-- <th>Start Date</th>
                                            <th>End Date</th> --}}
                                            <th>Assessment Date</th>
                                            <th>Status</th>
                                            <th>Scheme Status</th>
                                            <th>View</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @foreach ($agencyBatch as $key=>$item) 
                                             
                                            <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{is_null($item->batch->batch_id)?Config::get('constants.nullidtext'):$item->batch->batch_id}}</td>
                                            <td>{{$item->batch->partner->tp_id}}</td>
                                            <td>{{$item->batch->center->tc_id}}</td>
                                            @if (is_null($item->batch->assessorbatch))
                                            <td>{{Config::get('constants.nullidtext')}}</td>
                                            @else
                                            <td>{{$item->batch->assessorbatch->assessor->as_id}}</td>
                                            @endif
                                            {{-- <td>{{$item->batch->batch_start}}</td>
                                            <td>{{$item->batch->batch_end}}</td> --}}
                                            <td>{{$item->batch->assessment}}</td>
                                            @if ($item->batch->verified)
                                            <td style="color:{{($item->batch->status)?'green':'red'}}">{{($item->batch->status)?'Active':'Inactive'}}</td>
                                            @else
                                                <td style="color:red">Not Verified</td>
                                            @endif
                                                <td style="color:{{($item->batch->tpjobrole->status)?'green':'red'}}">{{($item->batch->tpjobrole->status)?'Active':'Inactive'}}</td>
                                           
                                                <td><a class="badge bg-green margin-0" href="{{route(Request::segment(1).'.bt.batch.view',['id'=>Crypt::encrypt($item->batch->id)])}}">View</a></td>
                                                                                                               
                                            </tr>
                                           
                                            @endforeach
                                           
                                        </tbody>
                                </table>
                                </div>
                                <div class="text-muted">
                                    <h6>NOTE:</h6>
                                    <i class="zmdi zmdi-circle text-danger"></i>
                                    This Instance is Currently in <span style='color:red'>Inactive State</span>
                                    <i class="zmdi zmdi-circle text-success"></i>
                                    This Instance is Currently in <span style='color:green'>Active State</span>


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