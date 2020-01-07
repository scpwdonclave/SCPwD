@extends('layout.master')
@section('title', 'Batch')
@section('parentPageTitle', 'Agency')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
{{-- <link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/> --}}
@stop
@section('content')

<div class="container-fluid">
        <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header d-flex justify-content-between">
                            <h2><strong>My</strong> Pending Batch</h2>
                        
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                            <tr>
                                            <th>#</th>
                                            <th>Batch ID</th>
                                            <th>Partner ID</th>
                                            <th>Center ID</th>
                                            {{-- <th>Assessor</th> --}}
                                            {{-- <th>Start Date</th>
                                            <th>End Date</th> --}}
                                            <th>Assessment Date</th>
                                            <th>Status</th>
                                            <th>Scheme Status</th>
                                            <th>View</th>
                                            <th>Action</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @foreach ($agencyBatch as $key=>$item) 
                                             
                                            <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{is_null($item->batch->batch_id)?Config::get('constants.nullidtext'):$item->batch->batch_id}}</td>
                                            <td>{{$item->batch->partner->tp_id}}</td>
                                            <td>{{$item->batch->center->tc_id}}</td>
                                            {{-- @if (is_null($item->batch->assessorbatch))
                                            <td>NULL</td>
                                            @else
                                            <td>{{$item->batch->assessorbatch->assessor->as_id}}</td>
                                            @endif --}}
                                            {{-- <td>{{$item->batch->batch_start}}</td>
                                            <td>{{$item->batch->batch_end}}</td> --}}
                                            <td>{{$item->batch->assessment}}</td>
                                            @if ($item->batch->verified)
                                            <td style="color:{{($item->batch->status)?'green':'red'}}">{{($item->batch->status)?'Active':'Inactive'}}</td>
                                            @else
                                                <td style="color:red">Not Verified</td>
                                            @endif
                                                <td style="color:{{($item->batch->tpjobrole->status)?'green':'red'}}">{{($item->batch->tpjobrole->status)?'Active':'Inactive'}}</td>
                                           
                                                <td><a class="badge bg-green margin-0" href="{{route(Request::segment(1).'.bt.batch.view',['id'=>Crypt::encrypt($item->batch->id)])}}">View</a></td>
                                                 <td>
                                                    <a class="badge bg-green margin-0" href="{{route('agency.aa.accept.batch',['id'=>Crypt::encrypt($item->id)])}}" >Accept</a>
                                                    <button class="badge bg-red margin-0" onclick="showCancelMessage({{$item->id}})">Reject</button>   
                                                </td>                                                              
                                            </tr>
                                           
                                            @endforeach
                                           
                                        </tbody>
                                </table>
                                </div>
                                <div class="text-muted">
                                    <h6>NOTE:</h6>
                                    <i class="zmdi zmdi-circle text-danger"></i>
                                    This Instance is Currently in <span style='color:red'>Inactive State</span>
                                    <i class="zmdi zmdi-circle text-success"></i>
                                    This Instance is Currently in <span style='color:green'>Active State</span>


                                </div>
                        </div>
                    </div>
                </div>
            </div>
</div>


@stop
@section('page-script')
<script>
    // function showCancelMessage(f) {
    //         swal({
    //             title: "Reason of Rejection",
    //             text: "Please Describe the Reason",
    //             type: "input",
    //             showCancelButton: true,
    //             closeOnConfirm: false,
    //             animation: "slide-from-top",
    //             showLoaderOnConfirm: true,
    //             inputPlaceholder: "Reason"
    //         }, function (inputValue) {
    //             if (inputValue === false) return false;
    //             if (inputValue === "") {
    //                 swal.showInputError("You need to write something!"); return false
    //             }
    //             var id=f;
    //             var note=inputValue;
    //             let _token = $("input[name='_token']").val();
            
    //             $.ajax({
    //             type: "POST",
    //             url: "{{route('agency.aa.reject.batch')}}",
    //             data: {_token,id,note},
    //             success: function(data) {
    //                 // console.log(data);
    //                 swal({
    //             title: "Deleted",
    //             text: "Record Deleted",
    //             type:"success",
    //             //timer: 2000,
    //             showConfirmButton: true
    //         },function(isConfirm){
        
    //             if (isConfirm){
                
    //             window.location="{{route('agency.pending-batch')}}";
        
    //             } 
    //             });
            
    //             }
    //         });
                
    //         });
    //     }

    function showCancelMessage(f) { 
        var id=f;
       let _token = $("input[name='_token']").val();
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
                    cancel: "Cencel",
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
                    url: "{{ route('agency.aa.reject.batch') }}",
                    method: "POST",
                    data: dataString,
                    success: function(data){
                        var SuccessResponseText = document.createElement("div");
                        SuccessResponseText.innerHTML ="This Batch Record <span style='font-weight:bold; color:red'>Rejected</span>";
                        swal({title: "Deleted", content: SuccessResponseText, icon:"success", closeModal: true,timer: 3000, buttons: false}).then(function(){location.reload();});
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

<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
{{-- <script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script> --}}
@stop