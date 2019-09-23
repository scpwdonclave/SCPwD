@extends('layout.master')
@section('title', 'Centers')
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
                    <h2><strong>My</strong> Centers</h2>
                    @can('partner-has-jobrole', Auth::shouldUse('partner'))
                        <a class="btn btn-primary btn-round waves-effect" href="{{route('partner.tc.addcenter')}}">Add New Training Center</a>                      
                    @endcan
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>SPOC Name</th>
                                    <th>SPOC Email</th>
                                    <th>SPOC Mobile</th>
                                    <th>Verified</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($centers as $center)
                                    
                                <tr>
                                <td><i class="zmdi zmdi-circle text-{{$center->status?'success':'danger'}}"></td>
                                <td>{{$center->spoc_name}}</td>
                                <td>{{$center->email}}</td>
                                <td>{{$center->mobile}}</td>
                                <td class="text-{{$center->verified?'primary':'danger'}}">{{$center->verified?'Verified':'Not Verified'}}</td>
                                <td><button class="btn btn-primary btn-round waves-effect">Button</button></td>
                                </tr>
                                @endforeach
                               
                            </tbody>
                        </table>
                    </div> 
                    <div class="text-center">
                        @cannot('partner-has-jobrole', Auth::shouldUse('partner'))
                            <h6>You Can Add New Training Centers Once Admin Assign you Job Roles</h6>
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