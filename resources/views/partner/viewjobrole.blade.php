@extends('layout.master')
@section('title', 'Job Role Details')
@section('page-style')
<!-- Custom Css -->
<link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">

<link rel="stylesheet" href="{{asset('assets/css/color_skins.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
@stop
@section('content')
<div class="container-fluid home">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header d-flex justify-content-between">
                    <h2><strong>My</strong> Job Role Details</h2>
                </div>
                <div class="row d-flex justify-content-center text-center">
                    <h6>Training Centers Under<br><span style="color:blue">{{$schemesectorjobrole}}</span><br>Job Role</h6>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>TC ID</th>
                                    <th>Name</th>
                                    <th>Center</th>
                                    <th>Target</th>
                                    <th>Enrolled</th>
                                    <th>Achieved</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($centers as $center)
                                    
                                <tr>
                                <td>{{$center->center->tc_id}}</td>
                                <td>{{$center->center->spoc_name}}</td>
                                <td>{{$center->center->center_name}}</td>
                                <td>{{$center->target}}</td>
                                <td>{{$center->enrolled}}</td>
                                <td>{{$center->enrolled}}</td>
                                <td class="text-center"> <a href="{{route('partner.tc.center.view',$center->tc_id)}}"><button class="btn btn-primary btn-sm">View</button></a></td>
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
@endsection