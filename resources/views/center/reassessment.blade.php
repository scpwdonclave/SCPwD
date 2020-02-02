@extends('layout.master')
@section('title', 'Setup Re-Assessment')
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
                <h2><strong>Setup</strong> Re-Assessment</h2>
            </div>
            <div class="body">
                <div class="card">
                    <h6 class="text-center">Batch ID: <span style="color:blue">{{ $batch->batch_id }}</span></h6>
                    <div class="body">
                        <form id="form_reassessment" action="{{route('center.bt.batch.reassess.submit')}}" method="post">
                            @csrf
                            <input type="hidden" name="batchid" value="{{Crypt::encrypt($batch->id)}}">
                            <table id="batchtable" data-page-length="30" class="batchtable nobtn table table-bordered table-striped table-hover display select">
                                <thead>
                                    <tr>
                                        <th><input name="select_all" value="1" type="checkbox"></th>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>Category</th>
                                        <th>Disability</th>
                                        <th>Assessment Status</th>
                                        <th>View</th>
                                        <th style="display:none;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($candidateArray as $candidate)
                                    <tr>
                                        <td>{!!$candidate->check!!}</td>
                                        <td>{{$candidate->candidate->name}}</td>
                                        <td>{{$candidate->candidate->contact}}</td>
                                        <td>{{$candidate->candidate->category}}</td>
                                        <td>{{$candidate->disability->e_expository}}</td>
                                        <td style="color:red">{{($candidate->passed=='0')?'Failed':'Absent'}}</td>
                                        <td>{!!$candidate->view!!}</td>
                                        <td style="display:none">{{$candidate->data}}</td>
                                    </tr>
                                  
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="row d-flex justify-content-center">
                                <button name="btnSubmit" type="submit" class="btn btn-primary waves-effect"><span class="glyphicon glyphicon-cloud-upload"></span> Submit</button>
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
   var rowId = data[7];

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
$('#form_reassessment').on('submit', function(e){
    var form = this;
    // Prevent actual form submission
    e.preventDefault();
    if ($('#form_reassessment').valid()) {
        $("#btnSubmit").prop("disabled", true);
        $("#btnSubmit").html("Please Wait...");
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

        var starttime = $('#batch_time').val();
        var hour = $('#batch_hour').val();
        var trainer = $('select#trainer option:selected').val();
        var _token= $('[name=_token]').val();


        var SwalText = document.createElement("div");
        SwalText.innerHTML = '<span style="color:blue">Un-Marked</span> Candidates will never get a Chance for <span style="color:red">Re-Assessment</span> Under This Batch.';
        swal({
            title: 'Confirmation!',
            content: SwalText,
            icon: "info",
            buttons: true,
            buttons: {
                    cancel: "No, Check Again",
                    confirm: {
                        text: "Confirm Proceed",
                        closeModal: false
                    }
                },
            closeModal: true,
            closeOnEsc: true,
        }).then(function (v) {
            if (v) {
                $(form).unbind().submit();
            }
        });

    }
    

});

</script>
@stop
