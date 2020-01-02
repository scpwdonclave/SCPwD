@extends('layout.master')
@section('title', 'Agencies')
@section('parentPageTitle', 'Agencies')
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
                            <h2><strong>All</strong> Active Agencies </h2>
                            <a class="btn btn-primary btn-round waves-effect" href="{{route('admin.aa.add-agency')}}">Add Agency</a> 
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                            <tr>
                                            <th>#</th>
                                            <th>Agency ID</th>
                                            <th>SPOC Name</th>
                                            <th>SPOC Email</th>
                                            <th>SPOC Mobile</th>
                                            <th>View</th>
                                            <th>Batch</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @foreach ($data as $key=>$item)
                                                
                                            <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$item->aa_id}}</td>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->email}}</td>
                                            <td>{{$item->mobile}}</td>
                                            <td><a class="badge bg-green margin-0" href="{{route('admin.aa.agency.view',['id'=>Crypt::encrypt($item->id)])}}" >View</a></td>
                                            <td><a class="badge bg-green margin-0" href="{{route('admin.aa.agency.batch',['id'=>Crypt::encrypt($item->id)])}}" >Batch</a></td>
                                            @if($item->status==1)
                                            <td><a class="badge bg-red margin-0" href="javascript:showCancelMessage({{$item->id}})">Deactivate</a></td>
                                            {{-- @elseif($item->status==0)
                                            <td><a class="badge bg-green margin-0" href="{{route('admin.aa.agency.active',['id'=>Crypt::encrypt($item->id)])}}" >Activate</a></td> --}}
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
                    <div class="header d-flex justify-content-between">
                        <h2><strong>All</strong> Deactive Agencies </h2>
                       
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>Agency ID</th>
                                        <th>SPOC Name</th>
                                        <th>SPOC Email</th>
                                        <th>SPOC Mobile</th>
                                        <th>View</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        @foreach ($deactiveData as $key=>$item)
                                            
                                        <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$item->aa_id}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->email}}</td>
                                        <td>{{$item->mobile}}</td>
                                        <td><a class="badge bg-green margin-0" href="{{route('admin.aa.agency.view',['id'=>Crypt::encrypt($item->id)])}}" >View</a></td>
                                        {{-- @if($item->status==1)
                                        <td><a class="badge bg-red margin-0" href="#" onclick="showCancelMessage({{$item->id}})">Deactivate</a></td> --}}
                                        @if($item->status==0)
                                        <td><a class="badge bg-green margin-0" href="{{route('admin.aa.agency.active',['id'=>Crypt::encrypt($item->id)])}}" >Activate</a></td>
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
// function showCancelMessage(f) {
//     swal({
//         title: "Deactive!",
//         text: "Write Reason for Deactive:",
//         type: "input",
//         showCancelButton: true,
//         closeOnConfirm: false,
//         animation: "slide-from-top",
//         showLoaderOnConfirm: true,
//         inputPlaceholder: "Write reason"
//     }, function (inputValue) {
//         if (inputValue === false) return false;
//         if (inputValue === "") {
//             swal.showInputError("You need to write something!"); return false
//         }
//         var id=f;
//         var reason=inputValue;
//         let _token = $("input[name='_token']").val();
   
//         $.ajax({
//         type: "POST",
//         url: "{{route('admin.aa.agency.deactive')}}",
//         data: {_token,id,reason},
//         success: function(data) {
//            // console.log(data);
//            swal({
//         title: "Deactive",
//         text: "Agency Record Deactive",
//         type:"success",
        
//         showConfirmButton: true
//     },function(isConfirm){

//         if (isConfirm){
       
//         window.location="{{route('admin.agency.agencies')}}";

//         } 
//         });
    
//         }
//     });
        
//     });
// }

function showCancelMessage(f) { 
        var id=f;
       let _token = $("input[name='_token']").val();
        swal({
            title: "Deactive!",
            text: "Write Reason for Deactive:",
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
            var dataString = {_token:_token, id:id,reason:val};
            if (val) {
                $.ajax({
                    url: "{{ route('admin.aa.agency.deactive') }}",
                    method: "POST",
                    data: dataString,
                    success: function(data){
                        var SuccessResponseText = document.createElement("div");
                        SuccessResponseText.innerHTML ="Agency Record <span style='font-weight:bold; color:red'>Deactive</span>";
                        swal({title: "Deactive", content: SuccessResponseText, icon:"success", closeModal: true,timer: 3000, buttons: false}).then(function(){location.reload();});
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