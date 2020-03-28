@extends('layout.master')
@section('title', 'View Placement')
@section('parentPageTitle', 'Placements')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/timeline.css')}}">
@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                    <div class="text-center">
                        <h6>
                            CD ID: <span style='color:blue'>{{$placement->centercandidate->candidate->cd_id}}</span> <br>
                        </h6>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <br>
                    <ul class="cbp_tmtimeline">
                        <li>
                            <time class="cbp_tmtime"><span>Candidate Details</span></time>
                            <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-account"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Candidate Name</small>
                                        <p>{{$placement->centercandidate->candidate->name}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">Mobile</small>
                                        <p>{{$placement->centercandidate->candidate->contact}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Email</small>
                                        <p>{{$placement->centercandidate->candidate->email}}</p>
                                        <hr>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-6">
                                        <small class="text-muted">Training Partner</small>
                                        <p>{{$placement->partner->org_name.' ('.$placement->partner->tp_id.')'}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-6">
                                        <small class="text-muted">Training Center</small>
                                        <p>{{$placement->center->center_name.' ('.$placement->center->tc_id.')'}}</p>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </li>
                        
                        <li>
                            <time class="cbp_tmtime"><span>Organization & Employment Details</span></time>
                            <div class="cbp_tmicon bg-blue"> <i class="zmdi zmdi-city-alt"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <small class="text-muted">Organization</small>
                                        <p>{{$placement->org_name}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-6">
                                        <small class="text-muted">Employment Date</small>
                                        <p>{{$placement->employment_date}}</p>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Employer Type</small>
                                        <p>{{$placement->emp_type}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Organization Address</small>
                                        <p>{{$placement->org_address}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">State District</small>
                                        <p>{{$placement->state_district->district .' ('.$placement->state_district->state.')'}}</p>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Employer SPOC Name</small>
                                        <p>{{$placement->emp_spoc_name}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Employer SPOC Mobile</small>
                                        <p>{{$placement->emp_spoc_mobile}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Employer SPOC Email</small>
                                        <p>{{$placement->emp_spoc_email}}</p>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li>
                            <time class="cbp_tmtime"><span>Placement Documents</span></time>
                            <div class="cbp_tmicon bg-pink"> <i class="zmdi zmdi-file-text"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <small class="text-muted">Offer Letter</small>
                                        @if (!is_null($placement->offer_letter))
                                            <p>
                                                Download &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route(Request::segment(1).'.placement.file',[Crypt::encrypt($placement->id),basename($placement->offer_letter)])}}"><i class="zmdi zmdi-download"></i></a>
                                            </p>
                                        @else
                                            <p>No Document Provided</p>
                                        @endif
                                        <hr>
                                    </div>
                                    <div class="col-sm-6">
                                        <small class="text-muted">Appointment Letter</small>
                                        @if (!is_null($placement->appointment_letter))
                                            <p>
                                                Download &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route(Request::segment(1).'.placement.file',[Crypt::encrypt($placement->id),basename($placement->appointment_letter)])}}"><i class="zmdi zmdi-download"></i></a>
                                            </p>
                                        @else
                                            <p>No Document Provided</p>
                                        @endif
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">First Month's Salary Slip</small>
                                        @if (!is_null($placement->payslip1))
                                            <p>
                                                Download &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route(Request::segment(1).'.placement.file',[Crypt::encrypt($placement->id),basename($placement->payslip1)])}}"><i class="zmdi zmdi-download"></i></a>
                                            </p>
                                        @else
                                            <p>Not provided yet</p>
                                        @endif
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Second Month's Salary Slip</small>
                                        @if (!is_null($placement->payslip2))
                                            <p>
                                                Download &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route(Request::segment(1).'.placement.file',[Crypt::encrypt($placement->id),basename($placement->payslip2)])}}"><i class="zmdi zmdi-download"></i></a>
                                            </p>
                                        @else
                                            <p>Not provided yet</p>
                                        @endif
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Third Month's Salary Slip</small>
                                        @if (!is_null($placement->payslip3))
                                            <p>
                                                Download &nbsp;&nbsp;
                                                <a class="btn-icon-mini" href="{{route(Request::segment(1).'.placement.file',[Crypt::encrypt($placement->id),basename($placement->payslip3)])}}"><i class="zmdi zmdi-download"></i></a>
                                            </p>
                                        @else
                                            <p>Not provided yet</p>
                                        @endif
                                        <hr>
                                    </div>
                                </div>
                                @php
                                    $sum_tag = (is_null($placement->payslip1)?1:0)+(is_null($placement->payslip2)?1:0)+(is_null($placement->payslip3)?1:0);
                                @endphp
                                @if ($sum_tag && Request::segment(1)==='center')
                                    <div class="row d-flex justify-content-center">
                                        <button type="button" data-toggle="modal" data-target="#defaultModal" class="btn btn-primary">Upload Salary Slip(s)</button>
                                    </div>
                                @endif
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
@section('modal')
@if ($sum_tag && Request::segment(1)==='center')
    <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog"> 
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="title" id="defaultModalLabel">Upload Salary Slips</h4>
                </div>
                @php
                    switch ($sum_tag) {
                        case '1':
                            $col=8;
                        break;
                        case '2':
                            $col=5;
                        break;
                        case '3':
                            $col=4;
                        break;
                        default:
                    }
                @endphp
                <div class="modal-body">
                    <form id="form_modal" method="POST" action="{{route('center.placement.update')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="pid" value="{{Crypt::encrypt($placement->id)}}">
                        <div class="row d-flex justify-content-center">
                            @if (is_null($placement->payslip1))
                                <div class="col-sm-{{$col}}">
                                    <label for="payslip1">First Month's Salary Slip</label>    
                                    <div class="form-group form-float">
                                        <input type="file" class="form-control" name="payslip1" id="payslip1">
                                    </div>
                                </div>
                            @endif
                            @if (is_null($placement->payslip2))
                                <div class="col-sm-{{$col}}">
                                    <label for="payslip2">Second Month's Salary Slip</label>    
                                    <div class="form-group form-float">
                                        <input type="file" class="form-control" name="payslip2" id="payslip2">
                                    </div>
                                </div>
                            @endif
                            @if (is_null($placement->payslip3))
                                <div class="col-sm-{{$col}}">
                                    <label for="payslip3">Third Month's Salary Slip</label>    
                                    <div class="form-group form-float">
                                        <input type="file" class="form-control" name="payslip3" id="payslip3">
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="row d-flex justify-content-center">
                            <button class="btn btn-raised btn-primary btn-round waves-effect" type="submit">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
@section('page-script')
<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop