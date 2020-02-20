@extends('layout.master')
@section('parentPageTitle', 'Assessor')
@section('title', 'Batches')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}">
<link href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">
@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-8">
            <div class="card">
                <div class="header">
                    <h2><strong>Batch</strong> Section</h2>                        
                </div>
                <div class="text-center">
                    @if (!is_null($assessor->as_id))
                    <h6><strong>Assessor ID: <span style="color:blue">{{$assessor->as_id}}</span></strong></h6>
                    @endif
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="scheme_table" class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Batch ID</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Assessment Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assessor->assessorBatch as $asbatch)
                                    <tr>
                                        <td>{{$asbatch->batch->batch_id}}</td>
                                        <td>{{\Carbon\Carbon::parse($asbatch->batch->batch_start)->format('d-m-Y')}}</td>
                                        <td>{{\Carbon\Carbon::parse($asbatch->batch->batch_end)->format('d-m-Y')}}</td>
                                        <td>{{\Carbon\Carbon::parse($asbatch->batch->assessment)->format('d-m-Y')}}</td>
                                        <td class="text-center"><button type="button" class="badge bg-red margin-0" onclick="removeBatch({{$asbatch->id}});">Remove</button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="header">
                    <h2><strong>Add</strong> Batch</h2>                         
                </div>
                <div class="body">
                    <form id="form_scheme" action="{{route('agency.assessor.batch-insert')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="job">Job Role <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" data-live-search="true" name="job" onchange="fetchBatch(this.value)" data-dropup-auto='false' required>
                                        <option value="">--select--</option>
                                        @foreach ($assessor->assessorJob as $item)
                                            <option value="{{$item->jobRoles->id}}">{{ $item->jobRoles->job_role }}</option>
                                        @endforeach
                                    </select>
                                  <input type="hidden" name="as_id" value="{{$assessor->id}}">
                                </div>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="batch">Batch <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" data-live-search="true" name="batch[]" id="batch" data-dropup-auto='false' multiple required>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <button class="btn btn-round btn-primary" type="submit">ADD</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('page-script')

<script>

function fetchBatch(job){
    let _token = $("input[name='_token']").val();
    let as_id = '{{$assessor->id}}';
    $.ajax({
        url:"{{route('agency.as.fetch-batch')}}", 
        data:{_token,job,as_id},
        method:'POST',
        success: function(data){
            console.log(data);
            
            $('#batch').empty();
            $.each (data.batch, function (index) {
                var id=data.batch[index].id;
                var batch_id=data.batch[index].batch_id;
                var reass_id=data.aa_batch[index].reass_id;
                 if(!data.selbatch.includes(id) || reass_id !=null){
                    $('#batch').append('<option value="'+id+','+reass_id+'">'+batch_id+'</option>');
                }
            });
            $('#batch').selectpicker('refresh');
        }
    });
}


function removeBatch(id){
    var confirmatonText = document.createElement("div");
    var _token=$('[name=_token]').val();
    confirmatonText.innerHTML = "You are about to <span style='font-weight:bold; color:red;'>Remove</span> This Assigned <span style='font-weight:bold; color:blue;'>Batch</span> from this Assessor";
    swal({
        text: "Are you Sure ?",
        content: confirmatonText,
        icon: "info",
        buttons: true,
        buttons: {
                cancel: "No, Cancel",
                confirm: {
                    text: "Confirm Remove Batch",
                    closeModal: false
                }
            },
        closeModal: false,
        closeOnEsc: false,
    }).then(function(val){
        var dataString = {_token, id:id};
        var swalResponse = document.createElement("div");
        if (val) {
            $.ajax({
                url: "{{ route('agency.as.batch-remove') }}",
                method: "POST",
                data: dataString,
                success: function(data){
                    if(data.status){
                        swalResponse.innerHTML = "Batch has been <span style='font-weight:bold; color:blue;'>De-Linked</span> from This Assessor";
                        swal({title: "Job Done", content: swalResponse, icon: 'success', closeModal: true,timer: 4000, buttons: false}).then(function(){location.reload();});
                    } else {
                        swalResponse.innerHTML = "This Batch Assessment already <span style='font-weight:bold; color:blue;'>Completed</span>, cannot Proceed";
                        swal({title: "Attention", content: swalResponse, icon: 'error', closeModal: true,timer: 3000, buttons: false}).then(function(){location.reload();});
                    }                    
                }
            });
        }
    });
}
</script>

<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{asset('assets/js/scpwd-common.js')}}"></script>

@endsection