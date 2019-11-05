@extends('layout.master')
@section('title', 'Add Batch')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatables-checkboxes/css/dataTables.checkboxes.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-timepicker-wvega/jquery.timepicker.css')}}">
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
        <div class="card">
            <div class="header d-flex justify-content-between">
                <h2><strong>Add</strong> Batch</h2>
                <a class="btn btn-primary btn-round waves-effect" href="{{route('partner.batches')}}">My Batches</a>                      
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
            <div class="body">
                <div class="card">

                    <div class="body">
                        <form id="form_addbatch" action="{{route('partner.submitbatch')}}" method="post">
                            @csrf
                            <div class="row d-flex justify-content-around">
                                <div class="col-sm-3">
                                    <label for="scheme">Scheme *</label>
                                    <div class="form-group form-float">
                                        <select id="scheme" class="form-control show-tick" data-live-search="true" name="scheme" onchange="update('job')" data-dropup-auto='false' required>
                                            @foreach ($partner->partner_jobroles->unique("scheme_id") as $scheme)
                                                @if ($scheme->status && $scheme->scheme_status)
                                                    <option value="{{$scheme->scheme->id}}">{{$scheme->scheme->scheme}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label for="jobrole">Job Role *</label>
                                    <div class="form-group form-float">
                                        <select id="jobrole" class="form-control show-tick" data-live-search="true" name="jobrole" onchange="update('center')" data-dropup-auto='false' required>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="center">Training Center *</label>
                                    <div class="form-group form-float">
                                        <select id="center" class="form-control show-tick" data-live-search="true" name="center" onchange="update('table')" data-dropup-auto='false' required>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row d-flex justify-content-around">
                                <div class="col-sm-6">
                                    <label for="trainer">Trainer *</label>
                                    <div class="form-group form-float">
                                        <select id="trainer" class="form-control show-tick" data-live-search="true" name="trainer" data-dropup-auto='false' required>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label for="batch_time">Batch Start Time *</label>
                                    <div class="form-group form-float">
                                        <input type="text" id="batch_time" class="form-control time_picker" name="batch_time" onchange="calculate_enddate()" required>                                        
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label for="batch_hour">Hours Per Day *</label>
                                    <div class="form-group form-float">
                                        <select id="batch_hour" class="form-control show-tick" data-live-search="true" onchange="calculate_enddate()" name="batch_hour" data-dropup-auto='false' required>
                                            @foreach (config('constants.hours') as $item)
                                                <option value="{{$item['val']}}">{{$item['text']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="batch_start">Batch Start Date *</label>
                                    <div class="form-group form-float batch_start_datepicker">
                                        <input type="text" id="batch_start" class="form-control" onchange="calculate_enddate()" name="batch_start" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="batch_end">Batch End Date *</label>
                                    <div class="form-group form-float">
                                        <input type="text" id="batch_end" class="form-control" name="batch_end" readonly required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="assesment">Assesment Date *</label>
                                    <div class="form-group form-float date_picker">
                                        <select id="assesment" class="form-control show-tick" data-live-search="true" name="assesment" data-dropup-auto='false' required>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <table id="batchtable" data-page-length="30" class="batchtable table table-bordered table-striped table-hover display select">
                                <thead>
                                    <tr>
                                        <th><input name="select_all" value="1" type="checkbox"></th>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>Category</th>
                                        <th>Disability</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                            </table>

                            <div class="row d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary waves-effect">Submit</button>
                            </div>
                        </form>
    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('page-script')
<script>

    $(()=>{
        update('job');


        $('.batch_start_datepicker .form-control').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy',
            startDate: new Date(),
            daysOfWeekDisabled: [0,6],
            datesDisabled: JSON.parse('<?php echo json_encode($holidays)?>'),
        });


        $('input.time_picker').timepicker({
            timeFormat: 'h:mm p',
            interval: 15,
            minTime: '6:00am',
            maxTime: '10:00pm',
            defaultTime: '8',
            startTime: '6:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });



        $('#batch_start')
        .datepicker()
        .on('changeDate', function(selected){
            $('#batch_end').val('');
            $('#assesment').empty();
            $('#assesment').selectpicker('refresh');
            startDate = new Date(selected.date.valueOf());
            startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
        });
    });


    function clearDropdown(id,msg) {
        $('#'+id).empty();
        $('#'+id).prepend("<option value='' selected>Select "+msg+"</option>");
        $('#'+id).selectpicker('refresh');
    }





    function update(v){
        var _token = $('[name=_token]').val();
        switch (v) {
            case 'job':
                    var schemeid = $("#scheme :selected").val();
                    $.ajax({
                        url: "{{ route('partner.addbatch.api') }}",
                        method: "POST",
                        data: { _token, schemeid },
                        success: function(data){
                            console.log(data);
                            
                            clearDropdown('jobrole','Job Role');
                            data.jobrole.forEach(value => {
                                $('#jobrole').append('<option value="'+value.id+'">'+value.jobrole.job_role+'</option>');
                            });
                            $('#jobrole').selectpicker('refresh');
                            clearDropdown('center','Center');
                            clearDropdown('trainer','Trainer');
                        } 
                    });
                break;
            
            case 'center':
                    var jobid = $('#jobrole :selected').val();
                    // $('#batch_start').val('');
                    // $('#batch_end').val('');
                    // $('#assesment').val('');
                    if (jobid!='') {
                        $.ajax({
                            url: "{{ route('partner.addbatch.api') }}",
                            method: "POST",
                            data: { _token, jobid },
                            success: function(data){
                                $('#center').empty();
                                $("#center").prepend("<option value='' selected='selected'>Select Center</option>");
                                $('#trainer').empty();
                                $("#trainer").prepend("<option value='' selected='selected'>Select Trainer</option>");
                                data.centers.forEach(value => {
                                    $('#center').append('<option value="'+value.id+'">'+ value.tc_id +' '+ value.spoc_name+'</option>');
                                });
                                data.trainers.forEach(value => {
                                    $('#trainer').append('<option value="'+value.id+'">'+value.name+'</option>');
                                });
                                $('#center').selectpicker('refresh');
                                $('#trainer').selectpicker('refresh');
                                calculate_enddate();
                            }
                        });
                    }
                break;
            case 'table':
                    var centerid = $('#center :selected').val();
                    $.ajax({
                        url: "{{ route('partner.addbatch.api') }}",
                        method: "POST",
                        data: { _token, centerid },
                        success: function(data){
                            // $('#center').empty();
                            // $("#center").prepend("<option value='' selected='selected'>Select Center</option>");
                            var datatable = $('.batchtable').DataTable();
                            datatable.clear().draw();
                            data.candidates.forEach(value => {
                                // console.log(value);
                                datatable.rows.add([value]); // Add new data
                                
                                // $('#center').append('<option value="'+value.id+'">'+ value.tc_id +' '+ value.spoc_name+'</option>');
                            });

                            datatable.columns.adjust().draw();
                                // $('#center').selectpicker('refresh');
                            },
                        error: function(){
                                swal('UnAuthorized','Something Went Wrong, Try Again', 'error').then(function(){ location.reload(); });
                            }
                        });
                break;
            default:
                break;
        }
        
    }
</script>

<script>

function calculate_enddate() {
    var startdate = $('#batch_start').val();
    var starttime = $('#batch_time').val();
    var hour = $('#batch_hour').val();
    var jobrole = $('select#jobrole option:selected').val();
    var _token= $('[name=_token]').val();
    // console.log(starttime);
    
    if (jobrole==='') {
        $('#batch_start').val('');
    }
    if (startdate!='' && jobrole!='' && starttime!='' && hour!='') {
        $.ajax({
            method: 'post',
            url: '{{route("partner.addbatch.api")}}',
            data: {startdate,_token,jobrole,starttime,hour},
            success: function (data) {
                if (data.success) {
                    $('#batch_end').val(data.enddate);
                    $('#assesment').empty();
                    $("#assesment").prepend("<option value='' selected='selected'>Select Assesment Date</option>");
                    data.assesment_dates.forEach(value => {
                        $('#assesment').append('<option value="'+value+'">'+value+'</option>');
                    });
                    $('#assesment').selectpicker('refresh');
                } else {
                    swal('Abort',data.message, 'info');
                    $('#batch_start').val('');
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



//
// Updates "Select all" control in a data table
//
function updateDataTableSelectAllCtrl(table){
   var $table             = table.table().node();
   var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
   var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
   var chkbox_select_all  = $('thead input[name="select_all"]', $table).get(0);

   // If none of the checkboxes are checked
   if($chkbox_checked.length === 0){
      chkbox_select_all.checked = false;
      if('indeterminate' in chkbox_select_all){
         chkbox_select_all.indeterminate = false;
      }

   // If all of the checkboxes are checked
   } else if ($chkbox_checked.length === $chkbox_all.length){
      chkbox_select_all.checked = true;
      if('indeterminate' in chkbox_select_all){
         chkbox_select_all.indeterminate = false;
      }

   // If some of the checkboxes are checked
   } else {
      chkbox_select_all.checked = true;
      if('indeterminate' in chkbox_select_all){
         chkbox_select_all.indeterminate = true;
      }
   }
}

function viewcandidate(id) {
    let url = "{{route(Request::segment(1).(Request::segment(1) === 'center' ? null : '.tc').'.candidate.view',':id')}}";
    location.href = url.replace(':id', id);    
}


</script>

<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatables-checkboxes/js/dataTables.checkboxes.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-timepicker-wvega/jquery.timepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{asset('assets/js/scpwd-common.js')}}"></script>


<script>

var table = $('.batchtable').DataTable({
    dom: 'Bfrtip',
    buttons: []
});

var rows_selected = [];
// Handle click on checkbox
$('.batchtable tbody').on('click', 'input[type="checkbox"]', function(e){

    
   var $row = $(this).closest('tr');
   
   // Get row data
   var data = table.row($row).data();
   
   // Get row ID
   var rowId = data[6];

   // Determine whether row ID is in the list of selected row IDs 
   var index = $.inArray(rowId, rows_selected);
  
   // If checkbox is checked and row ID is not in list of selected row IDs
   if(this.checked && index === -1){
      rows_selected.push(rowId);

   // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
   } else if (!this.checked && index !== -1){
      rows_selected.splice(index, 1);
   }

   if(this.checked){
      $row.addClass('selected');
   } else {
      $row.removeClass('selected');
   }

   // Update state of "Select all" control
   updateDataTableSelectAllCtrl(table);

   // Prevent click event from propagating to parent
   e.stopPropagation();
});

// Handle click on table cells with checkboxes
$('.batchtable').on('click', 'tbody td, thead th:first-child', function(e){    
   $(this).parent().find('input[type="checkbox"]').trigger('click');
});

// Handle click on "Select all" control
$('thead input[name="select_all"]', table.table().container()).on('click', function(e){
   if(this.checked){
      $('.batchtable tbody input[type="checkbox"]:not(:checked)').trigger('click');
   } else {
      $('.batchtable tbody input[type="checkbox"]:checked').trigger('click');
   }

   // Prevent click event from propagating to parent
   e.stopPropagation();
});

// Handle table draw event
table.on('draw', function(){
   // Update state of "Select all" control
   updateDataTableSelectAllCtrl(table);
});

// Handle form submission event 
$('#form_addbatch').on('submit', function(e){
    var form = this;
    // Prevent actual form submission
    e.preventDefault();
    if ($('#form_addbatch').valid()) {
       // Iterate over all selected checkboxes
        $.each(rows_selected, function(index, rowId){
            
            // Create a hidden element 
            $(form).append(
                $('<input>')
                    .attr('type', 'hidden')
                    .attr('name', 'id['+index+']')
                    .val(rowId)
            );
        });


        var count = $('input[name^="id"]', form).length;
        // if (count < 10) {
        //    swal('Attention','You need to choose atleast 10 Candidates', 'info');
        // } else if (count > 30) {
        //     swal('Attention','You can choose atmost 30 Candidates', 'info');
        // } else {

            var starttime = $('#batch_time').val();
            var hour = $('#batch_hour').val();
            var trainer = $('select#trainer option:selected').val();
            var _token= $('[name=_token]').val();

            $.ajax({
                method: 'post',
                url: '{{route("partner.addbatch.api")}}',
                data: {_token,trainer,starttime,hour},
                success: function (data) {
                    if (data.success) {
                        $('#form_addbatch').unbind().submit();
                        // Remove added elements
                        $('input[name^="id"]', form).remove();
                    } else {
                        swal('Attention','The Selected Trainer is Pre-Occupied on This Time, Please Switch to another Trainer or Change Batch Time', 'info');
                    }
                },
                error: function (data) {
                    setTimeout(function () {
                        swal("Sorry", "Something Went Wrong, Please Try Again", "error");
                    }, 2000);
                }
            });

        // }

    }
    

});

    /* Custom Valiadtions */    
    
    jQuery("#form_addbatch").validate({
            rules: {
                batch_time: { time: true },
            }
        });
    
    /* End Custom Valiadtions */

</script>
@stop
