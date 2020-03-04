@extends('layout.master')
@section('title', 'Notifications')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2><strong>All</strong> Notifications</h2>                        
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="notification_table" data-order="[[ 0, &quot;desc&quot; ]]" class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Created At</th>
                                    <th>Title</th>
                                    <th>Message</th>
                                    @if (Request::segment(1)==='admin')
                                        <th>Read By</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notifications as $notification)
                                    <tr>
                                        <td>
                                            <span style="display:none;">{{ \Carbon\Carbon::parse($notification->created_at)->getTimestamp()}}</span>
                                            {{\Carbon\Carbon::parse($notification->created_at)->format('d-m-Y h:i:s a')}}
                                        </td>
                                        <td>{{$notification->title}}</td>
                                        <td>{!!$notification->message!!}</td>
                                        @if (Request::segment(1)==='admin')
                                            @if (is_null($notification->read_by))
                                                <td style="color:blue;">Haven't Viewed Yet</td>
                                            @else
                                                <td>{{$notification->read_by}}</td>
                                            @endif
                                        @endif
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

@endsection