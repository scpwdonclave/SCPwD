@extends('layout.master')
@section('title', 'Batches')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}">
<link href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/>
<style>
.table td {
    padding: .10rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
    text-align: center;
}
</style>
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
                    @if (!is_null($agency[0]->aa_id))
                    <h6><strong>Agency ID: {{$agency[0]->aa_id}}</strong></h6>
                    @endif
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="scheme_table" class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                   
                                    <th>Batch ID</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>View</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($agency[0]->agencyBatch as $agbatch)
                                <tr style="height:5px !important">
                                
                                <td>{{$agbatch->batch->batch_id}}</td>
                                <td>{{$agbatch->batch->batch_start}}</td>
                                <td>{{$agbatch->batch->batch_end}}</td>
                                <td class="text-{{($agbatch->aa_verified) ?'success':'danger'}}"><strong>{{($agbatch->aa_verified)?'Verified':'Not Verified'}}</strong></td>
                                {{-- <td><a class="badge bg-green margin-0" href="{{route(Request::segment(1).'.bt.batch.view',['id'=>Crypt::encrypt($item->batch->id)])}}">View</a></td> --}}
                                <td class="text-center"><button class="btn btn-simple btn-success btn-icon btn-icon-mini btn-round" onclick="location.href='{{route(Request::segment(1).'.bt.batch.view',['id'=>Crypt::encrypt($agbatch->batch->id)])}}'"><i class="zmdi zmdi-eye"></button></td>
                                <td class="text-center"><button class="btn btn-simple btn-danger btn-icon btn-icon-mini btn-round" onclick="deleteConfirm({{$agbatch->id}});"><i class="zmdi zmdi-delete"></button></td>
                                {{-- <button class="btn" onclick="location.href='{{route('admin.tc.edit.center',['center_id' => Crypt::encrypt($centerData->id) ])}}'">Edit</button>                          --}}
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
                                        @foreach ($agency[0]->agencySector as $item)
                                       
                                        <option value="{{$item->sectors->id}}">{{ $item->sectors->sector }}</option>
                                       
                                        @endforeach
                                    </select>
                                <input type="hidden" name="aa_id" value="{{$agency[0]->id}}">
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
                        //console.table(data.batch);
                        
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

 function deleteConfirm(id){
    swal({
        title: "Are you sure?",
        text: "Your Batch Data will be deleted",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        closeOnConfirm: false,
        closeOnCancel: false
    }, function (isConfirm) {
        if (isConfirm) {
            let _token = $("input[name='_token']").val();
            $.ajax({
                type: "POST",
                url: "{{route('admin.agency.batch-delete')}}",
                data: {_token,id},
                success: function(data) {
                    if(data.status=='done'){
                   swal({
                        title: "Deleted",
                        text: "Batch Record Deleted",
                        type:"success",
                        showConfirmButton: true
                    },function(isConfirm){
                        if (isConfirm){
                            window.location="{{route('admin.agency.agencies')}}";
                        }
                    });

                    }else{
                        swal({
                        title: "Failed",
                        text: "This Batch already been assigned to a Assessor",
                        type:"error",
                        showConfirmButton: true
                    },function(isConfirm){
                        if (isConfirm){
                            window.location="{{route('admin.agency.agencies')}}";
                        }
                    });
                    }
                }
            });
        } else {
             swal("Cancelled", "Your Cancel the process", "error");
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
<script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>


{{-- <script>
     $("#holiday_date").datepicker({
        format: 'dd-mm-yyyy',
        time: false,
        autoclose:true
    });
</script> --}}
@endsection