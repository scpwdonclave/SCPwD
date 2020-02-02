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
                    @if (Request::segment(1)==='admin')
                        @if ($reassessment->verified)
                        <div class="row d-flex justify-content-center">
                            <h6>Re-Assessment Date: <span style='color:blue'>{{$reassessment->assessment}}</span></h6>
                        </div>
                        @else
                            <form id="reassess_form" action="{{route('admin.reassessment.requests.submit')}}" method="post">
                                @csrf
                                <input type="hidden" name="reassid" value="{{$reassessment->bt_id}}">
                                <input type="hidden" name="action" value="1">
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
                                    <button type="button" class="btn btn-danger" onclick="showPromptMessage();">Reject</button>
                                </div>
                            </form>
                        @endif
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

        function showPromptMessage() {
            var id='{{$reassessment->id}}';
            let _token = $("[name='_token']").val();
        
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
                        text: "Confirm Reject",
                        closeModal: false
                    }
                },
            closeModal: true,
            closeOnEsc: true,
        }).then(function(val){
            
            var dataString = {_token:_token, id:id,note:val};
            if (val) {
                $('[name=action]').val('0');
                var form = $('#reassess_form');
                form.append("<input type='hidden' name='reason' value='"+val+"'>");
                $(form).unbind().submit();
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
        // daysOfWeekDisabled: [0],
    });

</script>
@stop