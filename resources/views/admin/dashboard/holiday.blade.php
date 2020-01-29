@extends('layout.master')
@section('title', 'Holidays')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}">
<link href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">
{{-- <link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/> --}}
<style>
.table td {
    padding: .10rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
    text-align: center;
}
</style>
@stop
@section('parentPageTitle', 'Dashboard')
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-8">
            <div class="card">
                <div class="header">
                    <h2><strong>Holiday</strong> Section</h2>                        
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="scheme_table" class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Holiday Name</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($holidays as $key=>$holiday)
                                <tr style="height:5px !important">
                                <td>{{$key+1}}</td>
                                <td>{{$holiday->holiday_name}}</td>
                                <td>{{$holiday->holiday_date}}</td>
                                <td class="text-center"><button class="btn btn-simple btn-danger btn-icon btn-icon-mini btn-round" onclick="deleteConfirm({{$holiday->id}});"><i class="zmdi zmdi-delete"></button></td>
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
                    <h2><strong>Add</strong> Holiday</h2>                        
                </div>
                <div class="body">
                    <form id="form_scheme" action="{{route('admin.dashboard.holiday-insert')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="scheme">Holiday Name <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group form-float">
                                    <input type="text" class="form-control" placeholder="Holiday Name"  name="holiday_name" required>
                                    @if ($errors->has('scheme'))
                                        <span style="color:red">{{$errors->first('scheme')}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-sm-12">
                                    <label for="scheme">Date <span style="color:red"> <strong>*</strong></span></label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="zmdi zmdi-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control datetimepicker" name="holiday_date" id="holiday_date" placeholder="Date of Holiday" required>
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
//  function deleteConfirm(id){
//     swal({
//         title: "Are you sure?",
//         text: "Your Holiday Data will be deleted",
//         type: "warning",
//         showCancelButton: true,
//         confirmButtonColor: "#DD6B55",
//         confirmButtonText: "Yes, delete it!",
//         cancelButtonText: "No, cancel!",
//         closeOnConfirm: false,
//         closeOnCancel: false
//     }, function (isConfirm) {
//         if (isConfirm) {
//             let _token = $("input[name='_token']").val();
//             $.ajax({
//                 type: "POST",
//                 url: "{{route('admin.dashboard.holiday-delete')}}",
//                 data: {_token,id},
//                 success: function(data) {
//                    swal({
//                         title: "Deleted",
//                         text: "Holiday Record Deleted",
//                         type:"success",
//                         showConfirmButton: true
//                     },function(isConfirm){
//                         if (isConfirm){
//                             window.location="{{route('admin.dashboard.holiday')}}";
//                         }
//                     });
//                 }
//             });
//         } else {
//             swal("Cancelled", "Your Cancel this process", "error");
//         }
//     });

//  }

function deleteConfirm(id){
    //var data = v.split(',');
        var confirmatonText = document.createElement("div");
        //var color=''; var text='';
        var _token=$('[name=_token]').val();
        //if (data[1]==1) {color = 'red'; text = 'Deactivate';} else {color = 'green'; text = 'Activate';}
        //var scheme=data[2];
        confirmatonText.innerHTML = "You are about to <span style='font-weight:bold; color:red;'>Delete</span> This <span style='font-weight:bold; color:blue;'>Holiday</span>";
        swal({
            text: "Are you Sure ?",
            content: confirmatonText,
            icon: "info",
            buttons: true,
            buttons: {
                    cancel: "No, Cancel",
                    confirm: {
                        text: "Confirm Delete Holiday",
                        closeModal: false
                    }
                },
            closeModal: false,
            closeOnEsc: false,
        }).then(function(val){
            var dataString = {_token, id:id};
            if (val) {
                $.ajax({
                    url: "{{ route('admin.dashboard.holiday-delete') }}",
                    method: "POST",
                    data: dataString,
                    success: function(data){
                        var SuccessResponseText = document.createElement("div");
                        SuccessResponseText.innerHTML = "Holiday Record <span style='font-weight:bold; color:red;'>Deleted</span>";
                        setTimeout(function () {
                            swal({title: "Job Done", content: SuccessResponseText, icon: 'success', closeModal: true,timer: 3000, buttons: false}).then(function(){location.reload();});
                        }, 2000);
                    },
                    error:function(data){
                        var errors = JSON.parse(data.responseText);
                        setTimeout(function () {
                            swal("Sorry", "Something Went Wrong, Please Try Again", "error");
                        }, 2000);
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
{{-- <script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script> --}}


<script>
     $("#holiday_date").datepicker({
        format: 'dd-mm-yyyy',
        time: false,
        autoclose:true
    });
</script>
@endsection