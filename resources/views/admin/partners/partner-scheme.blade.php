@extends('layout.master')
@section('title', 'Partner Scheme')
@section('parentPageTitle', 'Partners')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/>
@stop
@section('content')

<div class="container-fluid">
        <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Scheme For</strong> Partner </h2>
                           
                        </div>
                        <div class="body">
                                <div class="text-center">
                                        <h4 class="margin-0">{{$partner_dtl->spoc_name}}</h4>
                                        <h6 class="m-b-20">{{$partner_dtl->tp_id}}</h6>
                                </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                            <tr>
                                            <th>#</th>
                                            <th>Scheme Name</th>
                                            <th>Year</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @foreach ($partner_scheme as $key=>$scheme)
                                                
                                            <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$scheme->scheme->scheme}}</td>
                                            <td>{{$scheme->scheme->year}}</td>
                                           
                                            @if($scheme->scheme_status==1)
                                            <td><a class="badge bg-red margin-0" href="#" onclick="showCancelMessage({{$scheme->scheme->id}},{{$partner_dtl->id}})">Deactivate</a></td>
                                           
                                            @elseif($scheme->scheme_status==0)
                                            <td><a class="badge bg-green margin-0" href="{{route('admin.tp.partner.scheme.active',['id'=>Crypt::encrypt($scheme->id),'pid'=>Crypt::encrypt($partner_dtl->id)])}}" >Activate</a></td>
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
@stop
@section('page-script')
<script>
function showCancelMessage(f,p) {
    swal({
        title: "Deactive!",
        text: "Write Reason for Deactive:",
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
        var pid=p;
        var reason=inputValue;
        let _token = $("input[name='_token']").val();
   
        $.ajax({
        type: "POST",
        url: "{{route('admin.tp.partner.scheme.deactive')}}",
        data: {_token,id,pid,reason},
        success: function(data) {
          // console.log(data.url);
           swal({
        title: "Deactive",
        text: "Scheme Record Deactive",
        type:"success",
        
        showConfirmButton: true
    },function(isConfirm){

        if (isConfirm){
       
        window.location="{{route('admin.tp.partners')}}";

        } 
        });
    
        }
    });
        
    });
}

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