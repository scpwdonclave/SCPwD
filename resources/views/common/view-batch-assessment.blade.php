@extends('layout.master')
@section('title', 'Batch')
{{-- @section('parentPageTitle', 'Partners-verify') --}}
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/timeline.css')}}">
{{-- <link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/> --}}

<link rel="stylesheet" href="{{asset('assets/css/color_skins.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
@stop
@section('content')

<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Batch Candidates</strong> for {{$assessment_tag}}</h2>
                </div>
                <div class="body">
                    <div class="text-center">
                        <h6>
                            Batch ID: <span style='color:blue'>{{$batchData->batch_id}}</span> <br> <br>
                        </h6>
                    </div>
                    <ul class="cbp_tmtimeline">
                        <li>
                            <time class="cbp_tmtime"><span>Batch Details</span></time>
                            <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-account"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Sector</small>
                                        <p>{{$batchData->jobrole->sector->sector}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">Job Role</small>
                                        <p>{{$batchData->jobrole->job_role}}</p>
                                        <hr>
                                    </div>

                                    <div class="col-sm-4">
                                        <small class="text-muted">{{$assessment_tag}} Date</small>
                                        <p>{{\Carbon\Carbon::parse($assessment_date)->format('d-m-Y')}}</p>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-sm-6">
                                        <small class="text-muted">Assessor</small>
                                        <p>{!!is_null($assessor)?'<span style="color:blue">Not Assigned Yet</span>':$assessor!!}</p>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Candidate Name</th>
                                    @if (Request::segment(1)==='agency' || Request::segment(1)==='assessor')
                                        <th>Category</th>
                                        <th>Education</th>
                                        <th>DOB</th>
                                        <th>Aadhaar/Voter</th>
                                    @else
                                        <th>Contact</th>
                                        <th>Email</th>
                                        <th>Aadhaar/Voter</th>
                                    @endif
                                    <th>Result</th>
                                    @if(Request::segment(1) !='agency' && Request::segment(1) !='assessor')
                                        <th>View</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($center_candidates as $center_candidate)
                            
                                <tr>
                                    <td>{{$center_candidate->candidate->name}}</td>
                                    @if (Request::segment(1)==='agency' || Request::segment(1)==='assessor')
                                        <td>{{$center_candidate->candidate->category}}</td>
                                        <td>{{$center_candidate->education}}</td>
                                        <td>{{$center_candidate->candidate->dob}}</td>
                                        <td>{{substr($center_candidate->candidate->doc_no, 0, 0).str_repeat('*', strlen($center_candidate->candidate->doc_no) - 4).substr($center_candidate->candidate->doc_no, strlen($center_candidate->candidate->doc_no) - 4, 4)}}</td>
                                    @else
                                        <td>{{$center_candidate->candidate->contact}}</td>
                                        <td>{{$center_candidate->candidate->email}}</td>
                                        <td>{{$center_candidate->candidate->doc_no}}</td>
                                    @endif
                                    @if ($center_candidate->dropout)
                                        <td style="color:blue">Dropped out</td>
                                    @else
                                        @switch($center_candidate->quilified)
                                            @case('0')
                                                <td style="color:red">Failed</td>
                                                @break
                                            @case('1')
                                                <td style="color:green">Passed</td>
                                                @break
                                            @case('2')
                                                <td style="color:red">Absent</td>
                                                @break
                                            @default
                                                <td>Not Applicable</td>
                                        @endswitch
                                    @endif
                                        {{-- <td style="color:{{($center_candidate->jobrole->partnerjobrole->status && $center_candidate->center->partner->status && $center_candidate->center->status && $center_candidate->candidate->status)?'green':'red'}}">{{($center_candidate->jobrole->partnerjobrole->status && $center_candidate->center->partner->status && $center_candidate->center->status && $center_candidate->candidate->status)?'Active':'Inactive'}}</td> --}}
                                    @if (Request::segment(1)==='center')
                                        <td><a class="badge bg-green margin-0" href="{{route('center.candidate.view',Crypt::encrypt($center_candidate->candidate->id))}}" >View</a></<td>                                                                                
                                    @elseif(Request::segment(1) !='agency' && Request::segment(1) !='assessor')
                                        <td><a class="badge bg-green margin-0" href="{{route(Request::segment(1).'.tc.candidate.view',Crypt::encrypt($center_candidate->candidate->id))}}" >View</a></<td>
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
@auth('admin')
    <script>

    function showPromptMessage(id) {
        swal({
            text: "Please Provide the Reason for Rejection",
            content: {
                element: "input",
                attributes: {
                    type: "text",
                },
            },
            icon: "info",
            buttons: true,
            buttons: {
                cancel: {
                    text: "Cancel",
                    visible: true,
                    value: null,
                    closeModal: true,
                },
                confirm: {
                    text: "Confirm Reject",
                    value: true,
                    closeModal: false
                }
                },
            closeModal: false,
            closeOnEsc: false,
        }).then(function(note){
            if (note!='' && note!=null) {
                let route = '{{route("admin.batch.action", [":id", "reject", ":reason"])}}';
                route = route.replace(':id',id);
                route = route.replace(':reason',note);
                location.href=route;
            } else if(note != null) {
                swal('Attention', 'Write Something Before you Submit','info');
            }
        });
    }
    </script>
@endauth

{{-- <script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script> --}}
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop