@extends('layout.master')
@section('title', 'Trainers')
@section('parentPageTitle', 'Trainer')
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
                            <h2><strong>All</strong> Verified Trainer </h2>
                           
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
                                            <th>DeLink</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @foreach ($data as $key=>$item)
                                                
                                                <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$item->partner->tp_id}}</td>
                                                <td>{{$item->name}}</td>
                                                <td>{{$item->email}}</td>
                                                <td>{{$item->mobile}}</td>
                                              
                                                <td><a class="badge bg-green margin-0" href="{{route('admin.tc.trainer.view',['id'=>$item->id])}}">View</a></td>
                                                <td><button class="badge bg-blue margin-0" onclick="dlink({{$item->id}})">DeLink</button></td>
                                                @if($item->status==1 && $item->ind_status==1)
                                                <td><button class="badge bg-red margin-0" onclick="showCancelMessage({{$item->id}})">Deactivate</button></td>
                                                @elseif($item->ind_status==0)
                                                <td><button class="badge bg-grey margin-0" >Activate</button></td>
                                                @elseif($item->status==0)
                                                <td><a class="badge bg-green margin-0" href="{{route('admin.tr.trainer.active',['id'=>Crypt::encrypt($item->id)])}}" >Activate</a></td>
                                                @endif
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

<div class="container-fluid">
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
</div>
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
        url: "{{route('admin.tr.trainer.deactive')}}",
        data: {_token,id,reason},
        success: function(data) {
           // console.log(data);
           swal({
        title: "Deactive",
        text: "Trainer Record Deactivated",
        type:"success",
        
        showConfirmButton: true
    },function(isConfirm){

        if (isConfirm){
       
        window.location="{{route('admin.tc.trainers')}}";

        } 
        });
    
        }
    });
        
    });
}
//======================================

function dlinkTrainerDeactive(f) {
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
        url: "{{route('admin.tr.dlink.trainer.deactive')}}",
        data: {_token,id,reason},
        success: function(data) {
           // console.log(data);
           swal({
        title: "Deactive",
        text: "Trainer Record Deactive",
        type:"success",
        
        showConfirmButton: true
    },function(isConfirm){

        if (isConfirm){
       
        window.location="{{route('admin.tc.trainers')}}";

        } 
        });
    
        }
    });
        
    });
}

//==============================

function dlink(f) {
    swal({
        title: "DeLink!",
        text: "Write Reason for DeLink:",
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
        url: "{{route('admin.tr.trainer.dlink')}}",
        data: {_token,id,reason},
        success: function(data) {
            swal({
            title: "DeLink",
            text: "Trainer Record DeLinked",
            type:"success", 
            showConfirmButton: true
            },function(isConfirm){
                if (isConfirm){location.reload();} 
            });
        }
    });
    });
}
//==============================

// function showCancelMessage(f) {
//     let _token = $("input[name='_token']").val();
//     var id=f;
//     swal({
//         title: "Are you sure?",
//         text: "Center will not be able to Access!",
//         type: "warning",
//         showCancelButton: true,
//         confirmButtonColor: "#DD6B55",
//         confirmButtonText: "Yes",
//         cancelButtonText: "No, cancel",
//         closeOnConfirm: false,
//         closeOnCancel: false
//     }, function (isConfirm) {
//         if (isConfirm) {
//             $.ajax({
//                 type: "POST",
//                 url: "{{route('admin.tc.center.deactive')}}",
//                 data:{_token,id},
//                 success: function(data) {
                   
//                    swal({
//                 title: "Done",
//                 text: "Center Deactivated",
//                 type:"success",
                
//             },function(isConfirm){
        
//                 if (isConfirm){
               
//                 window.location="{{route('admin.tc.centers')}}";
        
//                 } 
//                 });
            
//                 }
//             });
           
//         } else {
//             swal("Cancelled", "Your Partner is safe :)", "error");
//         }
//     });
// }
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