@extends('layout.master')
@section('title', 'Re-Assessment')
{{-- @section('parentPageTitle', 'Partners-verify') --}}
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
                            BATCH ID: <span style='color:blue'>{{$batchReAssessment->batch->batch_id}}</span>
                        </h6>
                    </div>
                    <br>
                    @if (!is_null($batchReAssessment->reject_note) && (Request::segment(1)==='admin' || Request::segment(1)==='agency' || Request::segment(1)==='assessor'))
                        <div class="alert alert-danger">
                            <i class="zmdi zmdi-email"></i>  &nbsp;<strong>{{$batchReAssessment->reject_note}}</strong>
                        </div>
                    @endif
                    <ul class="cbp_tmtimeline">
                        <li>
                        <time class="cbp_tmtime"><span>Assessment Details </span></time> 
                            <div class="cbp_tmicon bg-pink"> <i class="zmdi zmdi-collection-text"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="table-responsive">
                                    <table class="table m-b-0">
                                        <thead>
                                            <tr>
                                                <th>Sl. No.</th>
                                                <th>CD ID</th>
                                                <th>Candidate Name</th>
                                                <th>DOB</th>
                                                <th>Gender</th>
                                                <th>Attendence</th>
                                                <th>Mark</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=0;
                                            @endphp
                                            @foreach ($batchReAssessment->candidateMarks as $item) 
                                            <tr>
                                                @php
                                                    $i++;
                                                @endphp
                                                <td>{{$i}}</td>
                                                <td>{{$item->centerCandidate->candidate->cd_id}}</td>
                                                <td>{{$item->centerCandidate->candidate->name}}</td>
                                                <td>{{$item->centerCandidate->candidate->dob}}</td>
                                                <td>{{$item->centerCandidate->candidate->gender}}</td>
                                                <td>{{$item->attendence}}</td>
                                                <td>{{$item->mark}}</td>
                                                @if ($item->attendence==='present' && $item->passed)
                                                    <td class="text-success"><strong>Passed</strong></td> 
                                                @elseif ($item->attendence==='present' && !$item->passed)  
                                                    <td class="text-danger"><strong>Failed</strong></td> 
                                                @elseif ($item->attendence==='absent' && !$item->passed)  
                                                    <td class="text-danger"><strong>Absent</strong></td> 
                                                @endif
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </li>
                        @if (Request::segment(1)==='admin' || Request::segment(1)==='agency' || Request::segment(1)==='assessor')
                            <li>
                                <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Document Details</span></time>
                                <div class="cbp_tmicon bg-red"> <i class="zmdi zmdi-xbox"></i></div>
                                <div class="cbp_tmlabel">
                                    <div class="row">
                                        
                                        <div class="col-sm-6">
                                            <small class="text-muted">Attendence Document</small>
                                            @if (!is_null($batchReAssessment->attendence_sheet))
                                                <p>
                                                    Attendence Sheet &nbsp;&nbsp;
                                                    <a class="btn-icon-mini" href="{{route('agency.files.assessment-file',['id'=>$batchReAssessment->id,'action'=>'download','column'=>'attendence_sheet'])}}" ><i class="zmdi zmdi-download"></i></a>                                                    
                                                </p>
                                            @else
                                                <p>No Sheet Provided</p>
                                            @endif
                                            <hr>
                                        </div>
                                        <div class="col-sm-6">
                                            <small class="text-muted">Marksheet Document</small>
                                            @if (!is_null($batchReAssessment->mark_sheet))
                                                <p>
                                                    Marks Sheet &nbsp;&nbsp;
                                                    <a class="btn-icon-mini" href="{{route('agency.files.assessment-file',['id'=>$batchReAssessment->id,'action'=>'download','column'=>'mark_sheet'])}}" ><i class="zmdi zmdi-download"></i></a>                                                    
                                                </p>
                                            @else
                                                <p>No Marksheet Provided</p>
                                            @endif
                                            <hr>
                                        </div>
                                    
                                    </div>
                                </div>
                            </li>
                        @endif
                    </ul>
                    <div class="text-center">
                        @switch(Request::segment(1))
                            @case('assessor')
                                    @if ($batchReAssessment->aa_verified==2 || $batchReAssessment->admin_verified==2 || $batchReAssessment->sup_admin_verified==2)
                                        <button class="btn btn-primary" onclick="location.href='{{route('assessor.reassessment.edit',Crypt::encrypt($batchReAssessment->id))}}';this.disabled = true;"><i class="zmdi zmdi-edit"></i> &nbsp;&nbsp;Edit</button>
                                    @endif
                                @break
                            @case('agency')
                                    @if ($batchReAssessment->aa_verified==0 || ($batchReAssessment->aa_verified==2 && $batchReAssessment->recheck==1))
                                        <button class="btn btn-success" onclick="location.href='{{route('agency.assessment.approve.reject',[Crypt::encrypt($batchReAssessment->id.',0'),'accept'])}}';this.disabled = true;">Accept</button>
                                        <button class="btn btn-danger" onclick="showPromptMessage('agency');">Reject</button>
                                    @endif
                                @break
                            @case('admin')
                                @if (!auth()->guard('admin')->user()->ministry)
                                    @if (Auth::guard('admin')->user()->supadmin)

                                        @if ($batchReAssessment->aa_verified==1 && $batchReAssessment->admin_verified==1 && ($batchReAssessment->sup_admin_verified==0 || ($batchReAssessment->sup_admin_verified==2 && $batchReAssessment->recheck==1) ) )
                                            <button class="btn btn-success" onclick="location.href='{{route('admin.assessment.approve.reject',[Crypt::encrypt($batchReAssessment->id.',0'),'accept'])}}';this.disabled = true;">Accept</button>
                                            <button class="btn btn-danger" onclick="showPromptMessage('admin');">Reject</button>
                                        @elseif($batchReAssessment->aa_verified==1 && $batchReAssessment->admin_verified==1 && $batchReAssessment->sup_admin_verified==1 && $batchReAssessment->admin_cert_rel==1 && $batchReAssessment->supadmin_cert_rel==0)
                                            <button class="btn btn-success" onclick="location.href='{{route('admin.certificate.release.approve.reject',[Crypt::encrypt($batchReAssessment->id.',0'),'accept'])}}';this.disabled = true;">Release Certificate</button>
                                            <button class="btn btn-danger" onclick="showPromptMessage('certificate');">Reject Release</button>
                                        @endif

                                    @else

                                        @if ($batchReAssessment->aa_verified==1 && ($batchReAssessment->admin_verified==0 || ($batchReAssessment->admin_verified==2 && $batchReAssessment->recheck==1) ) )
                                            <button class="btn btn-success" onclick="location.href='{{route('admin.assessment.approve.reject',[Crypt::encrypt($batchReAssessment->id.',0'),'accept'])}}';this.disabled = true;">Accept</button>
                                            <button class="btn btn-danger" onclick="showPromptMessage('admin');">Reject</button>
                                        @elseif($batchReAssessment->aa_verified==1 && $batchReAssessment->admin_verified==1 && $batchReAssessment->sup_admin_verified==1 && (($batchReAssessment->admin_cert_rel==0 && $batchReAssessment->supadmin_cert_rel==0) ||($batchReAssessment->admin_cert_rel==1 && $batchReAssessment->supadmin_cert_rel==2)))
                                            <button class="btn btn-success" onclick="location.href='{{route('admin.certificate.release.approve.reject',[Crypt::encrypt($batchReAssessment->id.',0'),'release-request'])}}';this.disabled = true;">Request Certificate</button>
                                        @endif

                                    @endif
                                @endif
                                    {{-- To Carry Forward request from admin to partner we have removed the break Statement --}}

                            @case('partner')
                                @if ($batchReAssessment->aa_verified==1 && $batchReAssessment->admin_verified==1 && $batchReAssessment->sup_admin_verified==1 && $batchReAssessment->admin_cert_rel==1 && $batchReAssessment->supadmin_cert_rel==1)
                                    <button class="btn btn-success" onclick="window.open('{{route(Request::segment(1).'.assessment.certificate.print',Crypt::encrypt($batchReAssessment->id.',0'))}}');">Print Certificate</button>
                                @endif
                            @default
                        @endswitch
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
@section('page-script')
@if (Request::segment(1) === 'admin' || Request::segment(1) === 'agency')
<script>
    function showPromptMessage(tag) {
        var id="{{Crypt::encrypt($batchReAssessment->id.',0')}}";

        swal({
            title: "Reason of Rejection",
            text: "Please Describe the Reason",
            content: {
                element: "input",
                attributes: {
                    type: "text",
                },
            },
            icon: "info",
            buttons: true,
            buttons: {
                    cancel: "Cancel",
                    confirm: {
                        text: "Confirm",
                        closeModal: true
                    }
                },
            closeModal: true,
            closeOnEsc: false,
        }).then(function(val){
            
            if (val != '') {
                var url = '';
                switch (tag) {
                    case 'agency':
                        url = "{{ route('agency.assessment.approve.reject',[':id','reject',':reason']) }}";
                        break;
                    case 'admin':
                        url = "{{ route('admin.assessment.approve.reject',[':id','reject',':reason']) }}";
                        break;
                    case 'certificate':
                        url = "{{ route('admin.certificate.release.approve.reject',[':id','reject',':reason']) }}";
                        break;
                    default:
                        break;
                }

                url = url.replace(':id', id);
                url = url.replace(':reason', val);
                location.href = url;
                
            } else if (val!=null) {
                swal('Attention', 'You need to write something!', 'info');
            }
        });
    }
</script>
@endif

<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop