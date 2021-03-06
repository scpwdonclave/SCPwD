@extends('layout.master')
@section('title', 'Centers')
@section('parentPageTitle', 'Centers')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
@stop
@section('content')

<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2><strong>All</strong> Verified Centers </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Sl. No.</th>
                                    <th>Training Partner</th>
                                    <th>Training Center</th>
                                    <th>SPOC Name</th>
                                    <th>SPOC Email</th>
                                    <th>SPOC Mobile</th>
                                    <th>Overall Status</th>
                                    <th>View</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $key=>$item)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$item->partner->org_name.' ('.$item->partner->tp_id.')'}}</td>
                                    <td>{{$item->center_name.' ('.$item->tc_id.')'}}</td>
                                    <td>{{$item->spoc_name}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->mobile}}</td>
                                    <td style="color:{{($item->status && $item->partner->status)?'green':'red'}}">{{($item->status && $item->partner->status)?'Active':'Inactive'}}</td>
                                    <td><button type="button" class="badge bg-green margin-0" onclick="location.href='{{route('admin.tc.center.view',Crypt::encrypt($item->id))}}'" >View</button></td>
                                    <td><button type="button" onclick="popup('{{Crypt::encrypt($item->id).','.$item->status.','.$item->spoc_name.' ('.$item->tc_id.')'}}')" class="badge bg-{{($item->status)?'red':'green'}} margin-0">{{($item->status)?'Deactivate':'Activate'}}</button></td>
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
    function callajax(val, dataString){
        $.ajax({
            url: "{{ route('admin.tp.center.status-action') }}",
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

    function popup(v){
        var data = v.split(',');
        var confirmatonText = document.createElement("div");
        var color=''; var text=''; var displayText='';
        var _token=$('[name=_token]').val();
        var center=data[2];
        if (data[1]==1) {
                color = 'red'; text = 'Deactivate'; 
                displayText=center+'\nProvide Center Deactivation Reason ';
                confirmatonText="input"
            } else {
                color = 'green'; text = 'Activate';
                displayText = "Are you Sure ?";
                confirmatonText.innerHTML = "You are about to <span style='font-weight:bold; color:"+color+";'>"+text+"</span> <br> <span style='font-weight:bold; color:blue;'>"+center+"</span> Center";
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
            closeModal: false,
            closeOnEsc: false,
        }).then(function(val){
            if (val != null) {
                if (val === '') {
                    swal('Attention', 'Please Describe the Reason of Deactivation before Proceed', 'info');
                } else if (val === true) {
                    var dataString = {_token, data:data[0], reason:null};
                    callajax(val,dataString);
                } else {
                    var dataString = {_token, data:data[0], reason:val};
                    callajax(val,dataString);
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
@stop