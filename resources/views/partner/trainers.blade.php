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
                    @can('partner-has-jobrole', Auth::shouldUse('partner'))
                        <a class="btn btn-primary btn-round waves-effect" href="{{route('partner.addtrainer')}}">Add New Trainer</a>                      
                    @endcan
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Trainer ID</th>
                                    <th>Trainer Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Overall Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($partner->trainers as $key => $trainer)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{is_null($trainer->trainer_id)?Config::get('constants.nullidtext'):$trainer->trainer_id}}</td>
                                        <td>{{$trainer->name}}</td>
                                        <td>{{$trainer->email}}</td>
                                        <td>{{$trainer->mobile}}</td>
                                        @if ($trainer->verified)
                                            <td style="color:{{($trainer->partner->status && $trainer->status)?'green':'red'}}">{{($trainer->partner->status && $trainer->status)?'Active':'Inactive'}}</td>
                                        @else
                                            <td style="color:red">Not Verified</td>
                                        @endif
                                        <td><a class="badge bg-green margin-0" href="{{route('partner.trainer.view',Crypt::encrypt($trainer->id))}}">View</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> 
                    @can('partner-has-jobrole', Auth::shouldUse('partner'))
                        <div class="text-muted">
                            {!!Config::get('constants.note')!!}
                        </div>
                    @endcan
                    <div class="text-center">
                        @if (Request::segment(1)==='partner')
                            @cannot('partner-has-jobrole', Auth::shouldUse('partner'))
                                <h6>You Can Add New Trainers Once Admin Assign you Job Roles</h6>
                            @endcannot
                        @endif
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