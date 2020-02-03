@extends('layout.master')
@section('title', 'Re-Assessment')
{{-- @section('parentPageTitle', 'Partners-verify') --}}
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/timeline.css')}}">
{{-- <link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/> --}}
@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                    @if (!is_null($batchReAssessment->batch->batch_id))
                        <div class="text-center">
                            <h6>
                                BATCH ID: <span style='color:blue'>{{$batchReAssessment->batch->batch_id}}</span>
                            </h6>
                        </div>
                        <br>
                    @endif
                    @if (!is_null($batchReAssessment->reject_note))
                    <div class="alert alert-danger">
                        <i class="zmdi zmdi-email"></i>  &nbsp;<strong>{{$batchReAssessment->reject_note}}</strong>
                    </div>
                    @endif
                    <ul class="cbp_tmtimeline">
                            <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Assessment Details </span></time> 
                                    <div class="cbp_tmicon bg-pink"> <i class="zmdi zmdi-collection-text"></i></div>
                                    <div class="cbp_tmlabel">
                                            <div class="table-responsive">
                                                    <table class="table m-b-0">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
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

                                                                {{-- <td class="text-{{($item->passed)?'success':'danger'}}"><strong>{{($item->passed)?'Passed':'Failed'}}</strong></td> --}}

                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                        </div>
                                </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Document Details</span></time>
                            <div class="cbp_tmicon bg-red"> <i class="zmdi zmdi-xbox"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    {{-- <div class="col-sm-4">
                                        <small class="text-muted">Education Attaind</small>
                                        <p>{{$batchReAssessment->education}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">Details of Education</small>
                                        <p>{{$batchReAssessment->edu_details}}</p>
                                        <hr>
                                    </div> --}}
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
                    </ul>
                    @auth('assessor')
                        <div class="text-center" >
                            @if (Request::segment(1)==='assessor')
                               
                                    @if ($batchReAssessment->aa_verified==2 || $batchReAssessment->admin_verified==2 || $batchReAssessment->sup_admin_verified==2)
                                        <button class="btn btn-primary" onclick="location.href='{{route('assessor.assessment.edit',['id' => Crypt::encrypt($batchReAssessment->id) ])}}';this.disabled = true;"><i class="zmdi zmdi-edit"></i> &nbsp;&nbsp;Edit</button>
                                        {{-- <button class="btn btn-danger" onclick="showPromptMessage();">Reject</button> --}}
                                    {{-- @elseif ( $batchReAssessment->verified==1)
                                        <button class="btn" onclick="location.href='{{route('admin.as.edit.assessor',['as_id' => Crypt::encrypt($batchReAssessment->id) ])}}'">Edit</button>                          --}}
                                    @endif
                                
                            @endif
                        </div>
                    @endauth
                    @auth('agency')
                        <div class="text-center" >
                            @if (Request::segment(1)==='agency')
                               
                                    @if ($batchReAssessment->aa_verified==0 || ($batchReAssessment->aa_verified==2 && $batchReAssessment->recheck==1))
                                        <button class="btn btn-success" onclick="location.href='{{route('agency.assessment.verify',['id' => Crypt::encrypt($batchReAssessment->id) ])}}';this.disabled = true;">Accept</button>
                                        <button class="btn btn-danger" onclick="showPromptMessage('agency');">Reject</button>
                                    {{-- @elseif ( $batchReAssessment->verified==1)
                                        <button class="btn" onclick="location.href='{{route('admin.as.edit.assessor',['as_id' => Crypt::encrypt($batchReAssessment->id) ])}}'">Edit</button>                          --}}
                                    @endif
                                
                            @endif
                        </div>
                    @endauth
                    @auth('admin')
                        <div class="text-center" >
                            @if (Request::segment(1)==='admin')
                                @if (!Auth::guard('admin')->user()->supadmin)
                                    @if ($batchReAssessment->aa_verified==1 && ($batchReAssessment->admin_verified==0 || ($batchReAssessment->admin_verified==2 && $batchReAssessment->recheck==1) ) )
                                    <button class="btn btn-success" onclick="location.href='{{route('admin.assessment.verify',['id' => Crypt::encrypt($batchReAssessment->id) ])}}';this.disabled = true;">Accept</button>
                                    <button class="btn btn-danger" onclick="showPromptMessage('admin');">Reject</button>
                                    @endif
                                    @if ($batchReAssessment->aa_verified==1 && $batchReAssessment->admin_verified==1 && $batchReAssessment->sup_admin_verified==1 && (($batchReAssessment->admin_cert_rel==0 && $batchReAssessment->supadmin_cert_rel==0) ||($batchReAssessment->admin_cert_rel==1 && $batchReAssessment->supadmin_cert_rel==2)))
                                    <button class="btn btn-success" onclick="location.href='{{route('admin.assessment.certificate.release',['id' => Crypt::encrypt($batchReAssessment->id) ])}}';this.disabled = true;">Request Certificate</button>
                                    {{-- <button class="btn btn-danger" onclick="showPromptMessage('admin');">Reject Release</button> --}}
 
                                    @endif
                                @elseif(Auth::guard('admin')->user()->supadmin)
                                    @if ($batchReAssessment->aa_verified==1 && $batchReAssessment->admin_verified==1 && ($batchReAssessment->sup_admin_verified==0 || ($batchReAssessment->sup_admin_verified==2 && $batchReAssessment->recheck==1) ) )
                                    <button class="btn btn-success" onclick="location.href='{{route('admin.assessment.verify',['id' => Crypt::encrypt($batchReAssessment->id) ])}}';this.disabled = true;">Accept</button>
                                    <button class="btn btn-danger" onclick="showPromptMessage('admin');">Reject</button>
                                    @endif

                                    @if ($batchReAssessment->aa_verified==1 && $batchReAssessment->admin_verified==1 && $batchReAssessment->sup_admin_verified==1 && $batchReAssessment->admin_cert_rel==1 && $batchReAssessment->supadmin_cert_rel==0)
                                    <button class="btn btn-success" onclick="location.href='{{route('admin.assessment.certificate.release',['id' => Crypt::encrypt($batchReAssessment->id) ])}}';this.disabled = true;">Release Certificate</button>
                                    <button class="btn btn-danger" onclick="showPromptMessage('admin',1);">Reject Release</button>
 
                                    @endif
                                @endif

                                @if ($batchReAssessment->aa_verified==1 && $batchReAssessment->admin_verified==1 && $batchReAssessment->sup_admin_verified==1 && $batchReAssessment->admin_cert_rel==1 && $batchReAssessment->supadmin_cert_rel==1)
                                <button class="btn btn-success" onclick="location.href='{{route('admin.assessment.certificate.print',['id' => Crypt::encrypt($batchReAssessment->id) ])}}';this.disabled = true;">Print Certificate</button>
                                    
                                @endif

                            @endif
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

{{-- =================== --}} 




{{-- =================== --}}
@stop
@section('page-script')
{{-- @auth('admin') --}}
    <script>

        function showPromptMessage(f,t = 0) {
            var id={{$batchReAssessment->id}};
            let _token = $("input[name='_token']").val();
                
                 if(t==0){
                if(f=='agency'){
                    var urlLink="{{route('agency.assessment.reject')}}";
                }else if(f=='admin'){
                    var urlLink="{{route('admin.assessment.reject')}}";
                }

                }else{
                    var urlLink="{{route('admin.assessment.release.reject')}}";

                }
        
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
                        closeModal: false
                    }
                },
            closeModal: false,
            closeOnEsc: false,
        }).then(function(val){
            
            var dataString = {_token:_token, id:id,note:val};
            if (val) {
                $.ajax({
                    url: urlLink,
                    method: "POST",
                    data: dataString,
                    success: function(data){
                        var SuccessResponseText = document.createElement("div");
                        SuccessResponseText.innerHTML ="Assessment Submit for <span style='font-weight:bold; color:red'>Recheck</span>";
                       
                        swal({title: "Rejected", content: SuccessResponseText, icon:"success", closeModal: true,timer: 3000, buttons: false})
                        .then(function(){
                            if(f=='agency'){
                            location="{{route('agency.assessment.pending-assessment')}}";
                            }else if(f=='admin'){
                            location="{{route('admin.assessment.all-assessment')}}";

                            }
                           // location="{{route('admin.tc.pending-trainers')}}";
                            });
                    },
                    error:function(data){
                        var errors = JSON.parse(data.responseText);
                        setTimeout(function () {
                            swal("Sorry", "Something Went Wrong, Please Try Again", "error");
                        }, 2000);
                    }
                });
            } else if (val!=null) {
                swal('Attention', 'You need to write something!', 'info');
            }
        });
}
    </script>
{{-- @endauth --}}

{{-- <script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script> --}}
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop