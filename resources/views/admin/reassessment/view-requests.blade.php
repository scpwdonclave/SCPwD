@extends('layout.master')
@section('title', 'Assessment')
{{-- @section('parentPageTitle', 'Partners-verify') --}}
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}">

<link rel="stylesheet" href="{{asset('assets/css/timeline.css')}}">
<style>
table.dataTable.select tbody tr,
table.dataTable thead th:first-child {
  cursor: pointer;
}

.datepicker table tr td.disabled,
.datepicker table tr td.disabled:hover {
  background: none;
  color: red;
  cursor: not-allowed;
}
.datepicker-inline {
    width: 100%;
}
.datepicker table {
    width: 100%;
}
</style>
@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                    <div class="text-center">
                        <h6>
                            BATCH ID: <span style='color:blue'>{{$reassessment->batch->batch_id}}</span>
                        </h6>
                    </div>
                    <ul class="cbp_tmtimeline">
                        <li>
                            <time class="cbp_tmtime"><span>Re-Assessment Details</span></time>
                            <div class="cbp_tmicon bg-red"> <i class="zmdi zmdi-file-text"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">TP ID</small>
                                        <p>{{$reassessment->batch->partner->tp_id}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">TC ID</small>
                                        <p>{{$reassessment->batch->center->tc_id}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Trainer ID</small>
                                        <p>{{$reassessment->batch->trainer->trainer_id}}</p>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Batch Start Date</small>
                                        <p>{{$reassessment->batch->batch_start}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">Batch End Date</small>
                                        <p>{{$reassessment->batch->batch_end}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Initial Assessment Date</small>
                                        <p>{{$reassessment->batch->assessment}}</p>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime"><span>Candidates List </span></time> 
                            <div class="cbp_tmicon bg-pink"> <i class="zmdi zmdi-collection-text"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="table-responsive">
                                    <table class="table m-b-0">
                                        <thead>
                                            <tr>
                                                <th>Candidate Name</th>
                                                <th>DOB</th>
                                                <th>Gender</th>
                                                <th>Assessment Status</th>
                                                <th>Appear in Re-Assessment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($reassessment->candidates as $candidate) 
                                                <tr>
                                                    <td>{{$candidate->centercandidate->candidate->name}}</td>
                                                    <td>{{$candidate->centercandidate->candidate->dob}}</td>
                                                    <td>{{$candidate->centercandidate->candidate->gender}}</td>
                                                    <td style="color:{{($candidate->assessment_status)?'blue':'red'}}">{{($candidate->assessment_status)?'Absent':'Failed'}}</td>
                                                    <td style="color:{{($candidate->appear)?'blue':'red'}}">{{($candidate->appear)?'Will Appear in Re-Assessment':'Won\'t Appear in Re-Assessment'}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <br>
                    @if (Request::segment(1)==='admin' && !$reassessment->verified)
                        <form id="reassess_form" action="{{route('admin.reassessment.requests.submit')}}" method="post">
                            @csrf
                            <div class="row d-flex justify-content-center">
                                <div class="col-sm-4">
                                    <label for="assessment"><strong>Re-Assessment Date <span style="color:red"> *</strong></span></label>
                                    <div class="form-group form-float">
                                        <input type="text" class="form-control reassess_date" placeholder="New Assessment Date" value="{{ old('assessment') }}" name="assessment" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center">
                                <button type="submit" class="btn btn-success">Accept</button>
                                <button class="btn btn-danger" onclick="showPromptMessage('admin');">Reject</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@stop
@section('page-script')
{{-- @auth('admin') --}}
    <script>

        function showPromptMessage(f,t = 0) {
            var id={{$reassessment->id}};
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
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{asset('assets/js/scpwd-common.js')}}"></script>

<script>
    $('#reassess_form').validate();

    $('.reassess_date').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
        startDate: new Date(),
        daysOfWeekDisabled: [0],
    });

</script>
@stop