@extends('layout.master')
@section('title', 'Centers')
@section('parentPageTitle', 'Centers')
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
                            <h2><strong>All</strong> Centers </h2>
                           
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                            <tr>
                                            <th>#</th>
                                            <th>TP ID</th>
                                            <th>TC ID</th>
                                            <th>Spoc Name</th>
                                            <th>Spoc Email</th>
                                            <th>Spoc Mobile</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @foreach ($data as $key=>$item)
                                                
                                            <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$item->partner->tp_id}}</td>
                                            <td>{{$item->tc_id}}</td>
                                            <td>{{$item->spoc_name}}</td>
                                            <td>{{$item->email}}</td>
                                            <td>{{$item->mobile}}</td>
                                            <td><a class="badge bg-green margin-0" href="{{route('admin.tc.center.view',['id'=>$item->id])}}" >View</a></td>
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
    let _token = $("input[name='_token']").val();
    var id=f;
    swal({
        title: "Are you sure?",
        text: "Partner will not be able to Access!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        cancelButtonText: "No, cancel",
        closeOnConfirm: false,
        closeOnCancel: false
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: "POST",
                url: "{{route('admin.training_partner.partner.deactive')}}",
                data:{_token,id},
                success: function(data) {
                   
                   swal({
                title: "Done",
                text: "Partner Deactivated",
                type:"success",
                
            },function(isConfirm){
        
                if (isConfirm){
               
                window.location="{{route('admin.tp.partners')}}";
        
                } 
                });
            
                }
            });
           
        } else {
            swal("Cancelled", "Your Partner is safe :)", "error");
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
<script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
@stop