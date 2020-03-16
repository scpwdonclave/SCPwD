@extends('layout.master')
@if ($switch==='pending')
@section('title', 'Pending Complain')
@else
@section('title', 'Closed Complain')
@endif
@section('parentPageTitle', 'Support')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">

@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header d-flex justify-content-between">
                    @if ($switch==='pending')
                    <h2><strong>Pending</strong> Complain</h2>
                    @else
                    <h2><strong>Closed</strong> Complain</h2>
                    @endif
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Token ID</th>
                                    <th>Created By</th>
                                    <th>Date</th>
                                    <th>Subject</th>
                                    <th>Issue</th>
                                    <th>Status</th>
                                    <th>View</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                             @foreach ($complain as $key =>$item)
                                 <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$item->token_id}}</td>
                                    @if ($item->rel_with === 'agency')
                                        <td>{{$item->agency->aa_id}}</td>
                                    @elseif($item->rel_with === 'assessor')
                                        <td>{{$item->assessor->as_id}}</td>
                                    @elseif($item->rel_with === 'partner')
                                        <td>{{$item->partner->tp_id}}</td>
                                    @elseif($item->rel_with === 'center')
                                        <td>{{$item->center->tc_id}}</td>
                                    @endif
                                    <td>{{\Carbon\Carbon::parse($item->created_at)->format('d-m-Y')}}</td>
                                    <td>{{$item->subject}}</td>
                                    <td>{{$item->issue}}</td>
                                    <td>{{$item->stage}}</td>
                                    <td><a class="badge bg-green margin-0" href="{{route('admin.support.complain-view',['id'=>Crypt::encrypt($item->id)])}}" >View</a></td>
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
<script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
@stop