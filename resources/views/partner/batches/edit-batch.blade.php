@extends('layout.master')
@section('title', 'Batch')
{{-- @section('parentPageTitle', 'Partners-verify') --}}
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/timeline.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/color_skins.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
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
</style>
@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="body">
                    @if (!is_null($batchData->batch_id))
                        <div class="text-center">
                            <h6>
                                Batch ID: <span style='color:blue'>{{$batchData->batch_id}}</span>
                            </h6>
                        </div>
                        <br>
                    @endif
                    <div class="container" style="margin-bottom: 20px">
                        <div class="row d-flex justify-content-around">
                            <h6>Start Date: <span style='color:blue'>{{$batchData->batch_start}}</span></h6>
                            <h6>Batch time : <span style='color:blue'>{{$batchData->start_time}}</span> to <span style="color:blue">{{$batchData->end_time}}</span></h6>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <form id="form_updatebatch" action="{{route('partner.bt.batch.submitedit')}}" method="post">
                            @csrf
                            <input type="hidden" name="batchid" value="{{$batchData->id}}">
                            <div class="row d-flex justify-content-around">
                                <div class="col-sm-4">
                                    <label for="trainer">Trainer <span style="color:red"> <strong>*</strong></span></label>
                                    <div class="form-group form-float">
                                        <select id="trainer" class="form-control show-tick" data-live-search="true" name="trainer" data-dropup-auto='false' onchange="changetrainer()" required>
                                            @foreach ($trainers as $trainer)
                                                <option value="{{$trainer->id}}" {{($trainer->id == $batchData->tr_id)?'selected':null}}>{{$trainer->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="batch_end">Batch End Date <span style="color:red"> <strong>*</strong></span></label>
                                    <div class="form-group form-float batch_end_datepicker">
                                        <input type="text" id="batch_end" class="form-control" placeholder="Batch End Date" onchange="calculate_assessment()" value="{{\Carbon\Carbon::parse( $batchData->batch_end)->format('d-m-Y') }}" name="batch_end" required >
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="assessment">Assessment Date <span style="color:red"> <strong>*</strong></span></label>
                                    <div class="form-group form-float date_picker">
                                        <select id="assessment" class="form-control show-tick" data-live-search="true" name="assessment" data-dropup-auto='false' required>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center">
                                <div class="col-sm-4" id="trainer_start_div">
                                    <label for="trainer_start">New Trainer Start Date <span style="color:red"> <strong>*</strong></span></label>
                                    <div class="form-group form-float trainer_start_datepicker">
                                        <input type="text" id="trainer_start" class="form-control" placeholder="Trainer Start Date" onchange="calculate_assessment()" name="trainer_start">
                                    </div>
                                </div>
                            </div>
                            @if (Auth::guard('partner')->user()->can('partner-batch-update', $batchData->id))
                                <div class="row d-flex justify-content-center" style="margin-top:20px">
                                    @if (Carbon\Carbon::parse($batchData->batch_end.' 23:59:00')->gte(Carbon\Carbon::now()))
                                        <button type="submit" class="btn btn-primary waves-effect">REQUEST FOR AN UPDATE</button>
                                    @else
                                        <h6>You can only update batches which are not finished yet</h6>
                                    @endif
                                </div>
                            @else
                                <div class="row d-flex justify-content-center" style="margin-top:20px">
                                    <h6>You Can only request for an update after your pending update request gets cleared</h6>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
@section('page-script')

{{-- <script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script> --}}
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>


<script>
$(()=>{
    $('.batch_end_datepicker .form-control').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
        startDate: '<?php echo $batchData->batch_end?>',
        daysOfWeekDisabled: [0,6],
        datesDisabled: JSON.parse('<?php echo json_encode($holidays)?>'),
    });

    $('.trainer_start_datepicker .form-control').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
        startDate: '<?php echo $batchData->batch_start?>',
        endDate: '<?php echo $batchData->batch_end?>',
        daysOfWeekDisabled: [0,6],
        datesDisabled: JSON.parse('<?php echo json_encode($holidays)?>'),
    });


    $('#form_updatebatch').on('submit', function(e){
        e.preventDefault();
        initial = '<?php echo $batchData->tr_id.','.$batchData->batch_end.','.$batchData->assessment?>';
        if ($('#form_updatebatch').valid()) {
            if (initial === $('#trainer').val()+','+$('#batch_end').val()+','+$('#assessment').val()) {
                swal('','You have not changed anything yet', 'info');
            } else {
                $('#form_updatebatch').unbind().submit();
            }
        }    
    });

    $('#trainer_start_div').hide();
});


function calculate_assessment() {
    var batchend = $('#batch_end').val();
    var batchid = '<?php echo $batchData->id?>';
    var _token= $('[name=_token]').val();
    // console.log(starttime);
    
    if (batchend==='') {
        $('#assessment').empty();
        $('#assessment').selectpicker('refresh');
    }
    if (batchend!='' && batchid!='') {
        $.ajax({
            method: 'post',
            url: '{{route("partner.addbatch.api")}}',
            data: {batchend,_token,batchid},
            success: function (data) {
                if (data.success) {
                    $('#assessment').empty();
                    $("#assessment").prepend("<option value='' selected='selected'>Select Assessment Date</option>");
                    var selected = null;
                    data.assessment_dates.forEach(value => {
                        date = value.split(' ');
                        selected = (date[0] == '<?php echo $batchData->assessment?>')?'selected':null;
                        $('#assessment').append('<option '+selected+' value="'+date[0]+'">'+value+'</option>');
                    });
                    $('#assessment').selectpicker('refresh');
                }
            },
            error: function (data) {
                setTimeout(function () {
                    swal("Sorry", "Something Went Wrong, Please Try Again", "error");
                }, 2000);
            }
        });
    }
}

function changetrainer(){

    old_tr = '<?php echo $batchData->tr_id?>';
    if ($('#trainer').val() == old_tr) {
        $('#trainer_start_div').slideUp();
        $('#trainer_start').prop('required', false);
    } else {
        $('#trainer_start_div').slideDown();
        $('#trainer_start').prop('required', true);
    }
    
}

</script>

@stop