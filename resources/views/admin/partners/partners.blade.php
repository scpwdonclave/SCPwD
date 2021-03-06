@extends('layout.master')
@section('title', 'Approved Partners')
@section('parentPageTitle', 'Partners')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
{{-- <link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/> --}}
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
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
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Sl. No.</th>
                                    <th>TP ID</th>
                                    <th>Org. Name</th>
                                    <th>SPOC Name</th>
                                    <th>SPOC Email</th>
                                    <th>SPOC Mobile</th>
                                    <th>Target</th>
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
                                        <td><button type="button" class="badge bg-green margin-0" onclick="location.href='{{route('admin.tp.target.view',Crypt::encrypt($item->id))}}'" >Target</button></td>
                                        <td><button type="button" class="badge bg-green margin-0" onclick="location.href='{{route('admin.tp.partner.view',Crypt::encrypt($item->id))}}'" >View</button></td>
                                        <td><button type="button" onclick="popup('{{Crypt::encrypt($item->id).','.$item->status.','.$item->spoc_name.' ('.$item->tp_id.')'}}')" class="badge bg-{{($item->status)?'red':'green'}} margin-0">{{($item->status)?'Deactivate':'Activate'}}</button></td>
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

    function proceed(val, dataString, status, confirm){
        if (status=='1') {
            if (confirm=='1') {
                dataString.blacklist = 1;
                $.ajax({
                    url: "{{ route('admin.tp.partner.status-action') }}",
                    method: "POST",
                    data: dataString,
                    success: function(data){
                        var SuccessResponseText = document.createElement("div");
                        SuccessResponseText.innerHTML = data['message'];
                        swal({title: "Job Done", content: SuccessResponseText, icon: data['type'], closeModal: true,timer: 3000, buttons: false}).then(function(){location.reload();});
                    },
                    error:function(data){
                        swal("Sorry", "Something Went Wrong, Please Try Again", "error").then(function(){location.reload();});
                    }
                });
            } else {
                dataString.blacklist = 0;
                $.ajax({
                    url: "{{ route('admin.tp.partner.status-action') }}",
                    method: "POST",
                    data: dataString,
                    success: function(data){
                        var SuccessResponseText = document.createElement("div");
                        SuccessResponseText.innerHTML = data['message'];
                        swal({title: "Job Done", content: SuccessResponseText, icon: data['type'], closeModal: true,timer: 3000, buttons: false}).then(function(){location.reload();});
                    },
                    error:function(data){
                        swal("Sorry", "Something Went Wrong, Please Try Again", "error").then(function(){location.reload();});
                    }
                });
            }    
        } else {
            $.ajax({
                url: "{{ route('admin.tp.partner.status-action') }}",
                method: "POST",
                data: dataString,
                success: function(data){
                    var SuccessResponseText = document.createElement("div");
                    SuccessResponseText.innerHTML = data['message'];
                    swal({title: "Job Done", content: SuccessResponseText, icon: data['type'], closeModal: true,timer: 3000, buttons: false}).then(function(){location.reload();});
                },
                error:function(data){
                    swal("Sorry", "Something Went Wrong, Please Try Again", "error").then(function(){location.reload();});
                }
            });
        }
    }

    function callajax(val, dataString, status){

        if (status == '1') {
            var SwalText = document.createElement("div");
            SwalText.innerHTML = 'Kindly choose to <span style="color:blue">Deactive</span> or <span style="color:red;">Blacklist</span> this TP';
            swal({
                title: 'Confirmation!',
                content: SwalText,
                icon: "info",
                buttons: true,
                buttons: {
                        cancel: "No, Cancel",
                        confirm: {
                            text: "Just Deactive",
                            closeModal: false,
                            value: "catch",
                        },
                        defeat: {
                            text: "Blacklist",
                            closeModal: false
                        },
                    },
                closeModal: false,
                closeOnEsc: false,
            }).then(function (v) {
                switch (v) {
                    case "defeat":
                        proceed(val,dataString,status,1);
                        break;

                    case "catch":
                        proceed(val,dataString,status,0);
                        break;

                    default:
                }
                
            });   
        } else {
            proceed(val,dataString,status,null);
        }
    }

    function popup(v){
        var data = v.split(',');
        var confirmatonText = document.createElement("div");
        var color=''; var text=''; var displayText='';
        var _token=$('[name=_token]').val();
        var partner=data[2];
        if (data[1]==1) {
                color = 'red'; text = 'Deactivate'; 
                displayText=partner+'\nProvide Partner Deactivation Reason ';
                confirmatonText="input"
            } else {
                color = 'green'; text = 'Activate';
                displayText = "Are you Sure ?";
                confirmatonText.innerHTML = "You are about to <span style='font-weight:bold; color:"+color+";'>"+text+"</span> <br> <span style='font-weight:bold; color:blue;'>"+partner+"</span> Partner";
            }
        
        swal({
            text: displayText,
            content: confirmatonText,
            icon: "info",
            buttons: true,
            buttons: {
                    cancel: "No, Cancel",
                    confirm: {
                        text: "Confirm Update Status",
                        closeModal: false
                    }
                },
            closeModal: true,
            closeOnEsc: true,
        }).then(function(val){
            if (val != null) {
                if (val === '') {
                    swal('Attention', 'Please Describe the Reason of Deactivation before Proceed', 'info');
                } else if (val === true) {
                    var dataString = {_token, data:data[0], reason:null};
                    callajax(val,dataString,0);
                } else {
                    var dataString = {_token, data:data[0], reason:val};
                    callajax(val,dataString,1);
                }
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