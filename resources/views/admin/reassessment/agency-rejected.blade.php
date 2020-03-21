@extends('layout.master')
@section('title', 'Re-Assign Agency Re-Assessment')
@section('parentPageTitle', 'Re-Assessment')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}">
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
                <div class="header d-flex justify-content-between">
                    <h2><strong>Pending</strong> Re-Assessments Agency Re-Assign</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Batch ID</th>
                                    <th>TP ID</th>
                                    <th>TC ID</th>
                                    <th>View</th>
                                    <th>Action</th> 
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reassessments as $key => $reassessment)
                                    @if (!$reassessment->agencybatch && $tag[$key])
                                        <tr>
                                            <td>{{$reassessment->batch->batch_id}}</td>
                                            <td>{{$reassessment->partner->tp_id}}</td>
                                            <td>{{$reassessment->center->tc_id}}</td>
                                            <td><a class="badge bg-green margin-0" href="{{route('admin.reassessment.view',Crypt::encrypt($reassessment->id))}}">View</a></td>
                                            <td> <button type="button" class="badge bg-green margin-0" onclick="popup('{{Crypt::encrypt($reassessment->id)}}')">Assign to Agency</button> </td>
                                        </tr>
                                    @endif
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
@section('modal')
    <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h6 class="title" id="defaultModalLabel">Re-Assign this Re-Assessment Batch to an Assessment Agency</h6>
                </div>
                <div class="modal-body d-flex justify-content-center">
                    <div id="modalForm">
                        <form id="form_modal" method="POST" action="{{route('admin.reassessment.reassign.submit')}}">
                            @csrf
                            <input type="hidden" name="id" id="reassid">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="agency">Assessment Agency <span style="color:red"> <strong>*</strong></span></label>    
                                    <select class="form-control show-tick form-group" id="agency" name="agency" data-live-search="true" required >
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="assessment">Re-Assessment Date <span style="color:red"> <strong>*</strong></span></label>    
                                    <div class="form-group form-float datepicker">
                                        <input type="text" id="assessment" class="form-control" placeholder="New Re-Assessment Date" autocomplete="false" name="assessment" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center">
                                <button id="btnConfirm" class="btn btn-raised btn-primary btn-round waves-effect" type="submit" >Assign to Agency</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
<script src="{{asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
<script>

    function popup(id){
        $("#defaultModal").modal('show');
        $('#form_modal').validate();
        var _token=$('[name=_token]').val();
        $.ajax({
            url: "{{route('admin.reassessment.fetch.agency')}}",
            method: 'POST',
            data: {_token, id},
            success: function(data){
                $('#agency').empty();
                $('#agency').append('<option disabled selected value="">Choose an Agency</option>');
                data.agencies.forEach(element => {
                    $('#agency').append('<option value="'+element.id+'">'+element.agency_name+' ('+element.aa_id+')</option>');
                    $('#assessment').val(data.assessment);
                    $('#reassid').val(data.reassid);
                });
                $('#agency').selectpicker('refresh');
            },
            error: function(data){
                let swalText = document.createElement("div");
                swalText.innerHTML = 'Something Went Wrong, Please Try Again';
                swal({title: "Attention", content: swalText, icon: 'error', closeModal: true,timer: 3000, buttons: false}).then(function(){location.reload();});
            }
        })
    }


    $('.datepicker .form-control').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
        daysOfWeekDisabled: [0],
    });

</script>


@stop