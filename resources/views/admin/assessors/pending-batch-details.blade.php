@extends('layout.master')
@section('title', 'Pending-Batch')
@section('parentPageTitle', 'Assessor')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
@stop
@section('content')

<div class="container-fluid">
        <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>All</strong>  Details Assessor Batch </h2>
                           <div class="text-center">
                           {{-- <h6><strong>AS ID : {{$assessorBatch[0]->assessor->as_id}}</strong></h6> --}}
                            </div>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Batch ID</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Time</th>
                                            <th>View</th>
                                            <th>Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @foreach ($assessorBatch as $key=>$item) 
                                                
                                                <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$item->batch->batch_id}}</td>
                                                <td>{{$item->batch->batch_start}}</td>
                                                <td>{{$item->batch->batch_end}}</td>
                                                <td><strong>{{$item->batch->start_time}} to {{$item->batch->end_time}}</strong></td>
                                                <td><a class="badge bg-green margin-0" href="{{route(Request::segment(1).'.bt.batch.view',['id'=>Crypt::encrypt($item->batch->id)])}}">View</a></td>
                                                <td>
                                                    @if (!$item->verified)
                                                    <a class="badge bg-green margin-0" href="{{route('admin.as.accept.batch',['id'=>Crypt::encrypt($item->id)])}}" >Accept</a>
                                                    <button class="badge bg-red margin-0" onclick="showCancelMessage({{$item->id}})">Reject</button>
                                                    @else 
                                                    verified   
                                                    @endif
                                                </td>
                                                </tr>
                                          
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
@section('page-script')
<script>
    function showCancelMessage(f) {
            swal({
                title: "Reason of Rejection",
                text: "Please Describe the Reason",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                showLoaderOnConfirm: true,
                inputPlaceholder: "Reason"
            }, function (inputValue) {
                if (inputValue === false) return false;
                if (inputValue === "") {
                    swal.showInputError("You need to write something!"); return false
                }
                var id=f;
                var note=inputValue;
                let _token = $("input[name='_token']").val();
            
                $.ajax({
                type: "POST",
                url: "{{route('admin.as.reject.batch')}}",
                data: {_token,id,note},
                success: function(data) {
                    // console.log(data);
                    swal({
                title: "Deleted",
                text: "Record Deleted",
                type:"success",
                //timer: 2000,
                showConfirmButton: true
            },function(isConfirm){
        
                if (isConfirm){
                
                window.location="{{route('admin.as.pending-batch')}}";
        
                } 
                });
            
                }
            });
                
            });
        }
//======================================



//==============================


</script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
@stop