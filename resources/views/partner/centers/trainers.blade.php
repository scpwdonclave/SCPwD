@extends('layout.master')
@section('title', 'Trainers')
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
                    <h2><strong>My</strong> Trainers</h2>
                    @can('partner-profile-verified', Auth::shouldUse('partner'))
                        <a class="btn btn-primary btn-round waves-effect" href="{{route('partner.tc.addcenter')}}">Add New Trainer</a>                      
                    @endcan
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trainers as $trainer)
                                    
                                <tr>
                                {{-- <td><i class="zmdi zmdi-circle text-{{$trainer->status?'success':'danger'}}"></td>
                                <td>{{$trainer->spoc_name}}</td>
                                <td>{{$trainer->email}}</td>
                                <td>{{$trainer->spoc_mobile}}</td>
                                <td>{{$trainer->verified?'Verified':'Not Verified'}}</td>
                                <td>hi</td> --}}
                                </tr>
                                @endforeach
                               
                            </tbody>
                        </table>
                    </div> 
                    <div class="text-center">
                        @cannot('partner-profile-verified', Auth::shouldUse('partner'))
                            <h6>You Can Add New Trainers Once Your Account get Verified</h6>
                        @endcannot
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