@extends('layout.master')
@section('title', 'Re-Assessment')
{{-- @section('parentPageTitle', 'Partners-verify') --}}
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">

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
                                        <small class="text-muted">Assessment Date</small>
                                        <p>{{$reassessment->assessment}}</p>
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
                                                <th>Candidate ID</th>
                                                <th>Candidate Name</th>
                                                <th>DOB</th>
                                                <th>Gender</th>
                                                <th>Last Assessment Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($reassessment->candidates as $candidate) 
                                                <tr>
                                                    <td>{{$candidate->centercandidate->candidate->cd_id}}</td>
                                                    <td>{{$candidate->centercandidate->candidate->name}}</td>
                                                    <td>{{$candidate->centercandidate->candidate->dob}}</td>
                                                    <td>{{$candidate->centercandidate->candidate->gender}}</td>
                                                    <td style="color:{{($candidate->assessment_status)?'blue':'red'}}">{{($candidate->assessment_status)?'Absent':'Failed'}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <br>
                    @if (Request::segment(1)==='agency')
                        @if ($reassessment->verified)
                            @if (is_null($reassessment->as_id))
                                <form id="reassess_form" action="{{route('agency.reassessment.batch.submit')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="reassid" value="{{$reassessment->id}}">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-sm-4">
                                            <label for="assessment"><strong>Choose Assessor <span style="color:red"> *</strong></span></label>
                                            <div class="form-group form-float">
                                                <select class="form-control show-tick" data-live-search="true" name="assessor" data-dropup-auto='false' required>
                                                    @foreach ($assessors as $assessor)
                                                        <option value="{{$assessor->id}}">{{ $assessor->as_id .' ('.$assessor->name.')' }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center">
                                        <button type="submit" class="btn btn-success">Add Assessor</button>
                                    </div>
                                </form>
                            @else
                                <div class="row d-flex justify-content-center">
                                    <h6>Assessor : <span style="color:blue">{{ $reassessment->assessor->as_id .' ('.$reassessment->assessor->name.')' }}</span></h6>
                                </div>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@stop
@section('page-script')

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