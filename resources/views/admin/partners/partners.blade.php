@extends('layout.master')
@section('title', 'Approved Partners')
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
                            <h2><strong>Approved</strong> Empanelled Partners </h2>
                           
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                            <tr>
                                            <th>#</th>
                                            <th>TP ID</th>
                                            <th>Org. Name</th>
                                            <th>Spoc Name</th>
                                            <th>Spoc Email</th>
                                            <th>Spoc Mobile</th>
                                            <th>Target</th>
                                            <th>Scheme</th>
                                            <th>View</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @foreach ($data as $key=>$item)
                                                
                                            <tr>
                                           
                                          
                                            <td>{{$key+1}}</td>
                                          
                                            <td>{{$item->tp_id}}</td>
                                            <td>{{$item->org_name}}</td>
                                            <td>{{$item->spoc_name}}</td>
                                                <td>{{$item->email}}</td>
                                                <td>{{$item->spoc_mobile}}</td>
                                                {{-- <td class="text-center">
                                                    <a class="" href="#largeModal{{$item->id}}" data-toggle="modal" data-target="#largeModal{{$item->id}}"><i class="zmdi zmdi-eye"></i></a>
                                                </td> --}}
                                             @if($item->status==1)
                                            <td ><a class="badge bg-green margin-0" href="{{route('admin.training_partner.partner.target',['id'=>Crypt::encrypt($item->id)])}}" >Target</a></td>
                                            <td ><a class="badge bg-green margin-0" href="{{route('admin.training_partner.partner.scheme',['id'=>Crypt::encrypt($item->id)])}}" >Scheme</a></td>
                                            @else
                                            <td ><a class="badge bg-grey margin-0" href="javascript:void(0);" >Target</a></td>
                                            <td ><a class="badge bg-grey margin-0" href="javascript:void(0);" >Scheme</a></td>
                                            @endif
                                            <td ><a class="badge bg-green margin-0" href="{{route('admin.training_partner.partner.verify',['id'=>$item->id])}}" >View</a></td>
                                            @if($item->status==1)
                                            <td><a class="badge bg-red margin-0" href="#" onclick="showCancelMessage({{$item->id}})">Deactivate</a></td>
                                            @else
                                            <td><a class="badge bg-green margin-0" href="{{route('admin.training_partner.partner.active',['id'=>$item->id])}}" >Activate</a></td>
                                            @endif
                                        </tr>
                                            {{-- <div class="modal fade" id="largeModal{{$item->id}}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            
                                                            <div class="modal-body embed-responsive embed-responsive-16by9">
                                                                    <iframe class="embed-responsive-item" src="{{route('partner.files.partner-file',['action'=>'view','filename'=>basename($item->incorp_doc)])}}" allowfullscreen runat="server">
                                                                </iframe>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a href="{{route('partner.files.partner-file',['action'=>'download','filename'=>basename($item->incorp_doc)])}}" download="{{substr($item->incorp_doc,8)}}" class="btn btn-default btn-round waves-effect">Download</a>
                                                                <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> --}}
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
        var reason=inputValue;
        let _token = $("input[name='_token']").val();
   
        $.ajax({
        type: "POST",
        url: "{{route('admin.training_partner.partner.deactive')}}",
        data: {_token,id,reason},
        success: function(data) {
           // console.log(data);
           swal({
        title: "Deactive",
        text: "Record Deactive",
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
//         text: "Partner will not be able to Access!",
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
//                 url: "{{route('admin.training_partner.partner.deactive')}}",
//                 data:{_token,id},
//                 success: function(data) {
                   
//                    swal({
//                 title: "Done",
//                 text: "Partner Deactivated",
//                 type:"success",
                
//             },function(isConfirm){
        
//                 if (isConfirm){
               
//                 window.location="{{route('admin.tp.partners')}}";
        
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