@extends('layout.master')
@section('title', 'Job Roles')
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
                    <h2><strong>My</strong> Job Roles</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Scheme | Sector | Job Role</th>
                                    <th>Target</th>
                                    <th>{{(Request::segment(1) === 'partner')?'Assigned':'Enrolled'}}</th>
                                    <th>Scheme Status</th>
                                    @if (Request::segment(1) === 'partner')
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @auth('partner')
                                    @if (Request::segment(1) === 'partner')
                                        @foreach ($jobroles as $jobrole)
                                            <tr>
                                                <td>{{$jobrole->scheme->scheme.' | '.$jobrole->sector->sector.' | '.$jobrole->jobrole->job_role}}</td>
                                                <td>{{$jobrole->target}}</td>
                                                <td>{{$jobrole->assigned}}</td>
                                                <td class="text-{{($jobrole->status)?'success':'danger'}}">Scheme is {{($jobrole->status)?'Active':'Inactive'}}</td>
                                                <td><a class="badge bg-green margin-0" href="{{route('partner.dashboard.jobroles.view',Crypt::encrypt($jobrole->id))}}" >View</a></td>
                                            </tr>
                                            @endforeach
                                            @endif
                                            @endauth
                                            @auth('center')
                                            @if (Request::segment(1) === 'center')
                                            @foreach ($jobroles as $jobrole)
                                            <tr>
                                                <td>{{$jobrole->partnerjobrole->scheme->scheme.' | '.$jobrole->partnerjobrole->sector->sector.' | '.$jobrole->partnerjobrole->jobrole->job_role}}</td>
                                                <td>{{$jobrole->target}}</td>
                                                <td>{{$jobrole->enrolled}}</td>
                                                <td class="text-{{($jobrole->partnerjobrole->status)?'success':'danger'}}">Scheme is {{($jobrole->partnerjobrole->status)?'Active':'Inactive'}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endauth
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