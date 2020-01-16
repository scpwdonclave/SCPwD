@extends('layout.master')
@section('title', 'Batches')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/color_skins.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
@stop
@section('parentPageTitle', 'Agency')
@section('content')
<div class="container-fluid">
    <div class="row clearfix"> 
        <div class="col-lg-8">
            <div class="card">
                <div class="header">
                    <h2><strong>Batch</strong> Section</h2>                        
                </div>
                <div class="text-center">
                    <h6><strong>Agency ID: <span style="color:blue">{{$agency->aa_id}}</span></strong></h6>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="agency_table" class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Batch ID</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Agency</th>
                                    <th>View</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($agency->agencyBatch as $agbatch) 
                                    <tr style="height:5px !important">
                                        <td>{{$agbatch->batch->batch_id}}</td>
                                        <td>{{$agbatch->batch->batch_start}}</td>
                                        <td>{{$agbatch->batch->batch_end}}</td>
                                        <td class="text-{{($agbatch->aa_verified) ?'success':'danger'}}"><strong>{{($agbatch->aa_verified)?'Approved':'Not Approved Yet'}}</strong></td>
                                        <td class="text-center"><button class="btn btn-simple btn-success btn-icon btn-icon-mini btn-round" onclick="location.href='{{route(Request::segment(1).'.bt.batch.view',Crypt::encrypt($agbatch->batch->id))}}'"><i class="zmdi zmdi-eye"></button></td>
                                        <td class="text-center"><button class="btn btn-simple btn-danger btn-icon btn-icon-mini btn-round" onclick="deleteConfirm('{{$agbatch->batch->batch_id.','.$agbatch->id}}');"><i class="zmdi zmdi-delete"></button></td>
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
                    <form id="form_scheme" action="{{route('admin.agency.batch-insert')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="sector">Sector <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" data-live-search="true" name="sector" onchange="fetchBatch(this.value)" data-dropup-auto='false' required>
                                        <option value="">--select--</option>
                                        @foreach ($agency->agencySector as $item)
                                            <option value="{{$item->sectors->id}}">{{ $item->sectors->sector }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="aa_id" value="{{$agency->id}}">
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

    function fetchBatch(sector){
        let _token = $("input[name='_token']").val();
        let aa_id = $("input[name='aa_id']").val();
        var sector=sector;
        $.ajax({
            url:"{{route('admin.aa.fetch-batch')}}", 
            data:{_token,sector,aa_id},
            method:'POST',
            success: function(data){
                $('#batch').empty();
                $.each (data.batch, function (index) {
                    var id=data.batch[index].id;
                    var batch_id=data.batch[index].batch_id;
                    if(!data.selbatch.includes(id)){
                        $('#batch').append('<option value="'+id+'">'+batch_id+'</option>');
                    }
                });
                $('#batch').selectpicker('refresh');
            }
        });
    }


function deleteConfirm(v){
    var data = v.split(',');
    var confirmatonText = document.createElement("div");
    var _token=$('[name=_token]').val();
    var id=data[1];
    var aa='{{$agency->aa_id}}';
    confirmatonText.innerHTML = "You are about to Remove <span style='font-weight:bold; color:red;'>"+data[0]+"</span> Batch from <span style='font-weight:bold; color:blue;'>"+aa+"</span> Agency";
    swal({
        text: "Are you Sure ?",
        content: confirmatonText,
        icon: "info",
        buttons: true,
        buttons: {
            cancel: "No, Cencel",
            confirm: {
                text: "Confirm Remove Batch",
                closeModal: false
            }
        },
        closeModal: false,
        closeOnEsc: false,
    }).then(function(val){
        var dataString = {_token, id:id};
        if (val) {
            $.ajax({
                url: "{{ route('admin.agency.batch-delete') }}",
                method: "POST",
                data: dataString,
                success: function(data){
                    var SuccessResponseText = document.createElement("div");
                    if(data.status=='done'){
                        SuccessResponseText.innerHTML = "Batch Record has been <span style='font-weight:bold; color:red;'>Removed</span> from <span style='font-weight:bold; color:blue;'>"+aa+"</span>";
                        setTimeout(function () {
                        swal({title: "Job Done", content: SuccessResponseText, icon: 'success', closeModal: true,timer: 4000, buttons: false}).then(function(){location.reload();});
                        }, 2000);
                    }else{
                        SuccessResponseText.innerHTML = "This Batch Record ahve already been <span style='font-weight:bold; color:blue;'>Assigned</span> to a Assessor, can not proceed further";
                        setTimeout(function () {
                            swal({title: "Already Assigned", content: SuccessResponseText, icon: 'error', closeModal: true,timer: 4000, buttons: false}).then(function(){location.reload();});
                        }, 2000);
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