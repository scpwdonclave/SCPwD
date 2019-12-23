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
                            <h2><strong>All</strong>  Pending Assessor Batch </h2>
                           
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>AS ID</th>
                                            <th>Assessor Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>View batch</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @foreach ($pending_as_batch as $key=>$item)
                                                
                                                <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$item->assessor->as_id}}</td>
                                                <td>{{$item->assessor->name}}</td>
                                                <td>{{$item->assessor->email}}</td>
                                                <td>{{$item->assessor->mobile}}</td>
                                              
                                                <td><a class="badge bg-green margin-0" href="{{route('admin.as.assessor.view-batch',['id'=>Crypt::encrypt($item->as_id)])}}">View Batch</a></td>
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

{{-- <div class="container-fluid">
    <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>All</strong> DeLinked Trainer </h2>
                       
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>TP ID</th>
                                        <th>Trainer Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>View</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                            @php
                                              $j=1;  
                                            @endphp
                                        @foreach ($dlinkData as $key=>$item)
                                         
                                            @if (!$item->attached)
                                                <tr>
                                                    <td>{{$j}}</td>
                                                    <td>{{$item->partner->tp_id}}</td>
                                                    <td>{{$item->name}}</td>
                                                    <td>{{$item->email}}</td>
                                                    <td>{{$item->mobile}}</td>
                                                    <td><a class="badge bg-green margin-0" href="{{route('admin.tc.dlink.trainer.view',['id'=>$item->id])}}" >View</a></td>
                                                    @if($item->status)
                                                        <td><button class="badge bg-red margin-0" onclick="dlinkTrainerDeactive({{$item->id}})">Deactivate</button></td>
                                                    @elseif(!$item->status)
                                                        <td><a class="badge bg-green margin-0" href="{{route('admin.tr.dlink.trainer.active',['id'=>Crypt::encrypt($item->id)])}}" >Activate</a></td>
                                                    @endif
                                                </tr>
                                            @endif
                                        @php
                                            $j++; 
                                        @endphp
                                        @endforeach
                                       
                                    </tbody>
                            </table>
                            </div>
                    </div>
                </div>
            </div>
        </div>
</div> --}}
@stop
@section('page-script')
<script>
function showCancelMessage(f) {
    swal({
        title: "Deactivation!",
        text: "Write Reason for Deactivation:",
        type: "input",
        showCancelButton: true,
        closeOnConfirm: false,
        animation: "slide-from-top",
        showLoaderOnConfirm: true,
        inputPlaceholder: "Write reason"
    }, function (inputValue) {
        if (inputValue === false) return false;
        if (inputValue === "") {
            swal.showInputError("You need to write something!"); return false
        }
        var id=f;
        var reason=inputValue;
        let _token = $("input[name='_token']").val();
   
        $.ajax({
        type: "POST",
        url: "{{route('admin.as.assessor.deactive')}}",
        data: {_token,id,reason},
        success: function(data) {
           // console.log(data);
           swal({
        title: "Deactive",
        text: "Assessor Record Deactivated",
        type:"success",
        
        showConfirmButton: true
    },function(isConfirm){

        if (isConfirm){
       
        window.location="{{route('admin.assessor.assessors')}}";

        } 
        });
    
        }
    });
        
    });
}
//======================================



//==============================


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