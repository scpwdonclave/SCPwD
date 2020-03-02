@extends('layout.master')
@section('parentPageTitle', 'Dashboard')
@section('title', 'Logins Audit')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Logins</strong> Logouts Audit</h2>                        
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="login_audit_table" data-order="[[ 4, &quot;desc&quot; ]]" class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>User Name</th>
                                    <th>UserID</th>
                                    <th>User Type</th>
                                    <th>Event</th>
                                    <th>Date & Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logins as $login)
                                    @if ($supadmin)
                                        <tr>
                                            <td>{{$login->name}}</td>
                                            <td>{{$login->display_id}}</td>
                                            <td>{{$login->user_type}}</td>
                                            <td><span style="color:{{($login->event)?'blue':'red'}};font-weight:bold;">{{($login->event)?'Logged in':'Logged out'}}</span> from {{$login->ip_address}}</td>
                                            <td>{{\Carbon\Carbon::parse($login->created_at)->format('d-m-Y h:i:s a')}}</td>
                                        </tr>
                                    @else
                                        @if ($login->user_type !== 'admin')
                                            <tr>
                                                <td>{{$login->name}}</td>
                                                <td>{{$login->display_id}}</td>
                                                <td>{{$login->user_type}}</td>
                                                <td><span style="color:{{($login->event)?'blue':'red'}};font-weight:bold;">{{($login->event)?'Logged in':'Logged out'}}</span> from {{$login->ip_address}}</td>
                                                <td>{{\Carbon\Carbon::parse($login->created_at)->format('d-m-Y h:i:s a')}}</td>
                                            </tr>
                                        @endif
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
<script src="{{asset('assets/js/scpwd-common.js')}}"></script>
@endsection