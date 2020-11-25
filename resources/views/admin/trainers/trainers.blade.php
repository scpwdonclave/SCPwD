@extends('layout.master')
@section('title', 'Trainers')
@section('parentPageTitle', 'Trainer')
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
                    <h2><strong>All</strong> Verified Trainer </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>TP ID</th>
                                    <th>Trainer ID</th>
                                    <th>Trainer Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Overall Status</th>
                                    <th>View</th>
                                    @if (!auth()->guard('admin')->user()->ministry)
                                        <th>DeLink</th>
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key=>$item)
                                    <tr>
                                        <td>{{$item->partner->tp_id}}</td>
                                        <td>{{$item->trainer_id}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->email}}</td>
                                        <td>{{$item->mobile}}</td>
                                        <td style="color:{{$item->verified?($item->partner->status && $item->status?'green':'red'):'red'}}">{{$item->verified?($item->partner->status && $item->status?'Active':'Inactive'):"Not Verified"}}</td>
                                        <td><a class="badge bg-green margin-0" href="{{route('admin.tc.trainer.view',Crypt::encrypt($item->id))}}">View</a></td>
                                        @if (!auth()->guard('admin')->user()->ministry)
                                            <td><button type="button" onclick="popup('{{Crypt::encrypt($item->id).','.$item->status.','.$item->name.' ('.$item->trainer_id.'),'.'1,0'}}')" class="badge bg-blue margin-0">DeLink</button></td>
                                            <td><button type="button" onclick="popup('{{Crypt::encrypt($item->id).','.$item->status.','.$item->name.' ('.$item->trainer_id.'),'.'1,1'}}')" class="badge bg-{{($item->status)?'red':'green'}} margin-0">{{($item->status)?'Deactivate':'Activate'}}</button></td>
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
                                    <th>Last Attached TP ID</th>
                                    <th>Trainer Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>View</th>
                                    @if (!auth()->guard('admin')->user()->ministry)
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dlinkData as $key=>$item)
                                    @if (!$item->attached)
                                        <tr>
                                            <td>{{$item->partner->tp_id}}</td>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->email}}</td>
                                            <td>{{$item->mobile}}</td>
                                            <td><a class="badge bg-green margin-0" href="{{route('admin.tc.dlink.trainer.view',Crypt::encrypt($item->id))}}" >View</a></td>
                                            @if (!auth()->guard('admin')->user()->ministry)
                                                <td><button type="button" onclick="popup('{{Crypt::encrypt($item->id).','.$item->status.','.$item->name.' ('.$item->trainer_id.'),'.'0,1'}}')" class="badge bg-{{($item->status)?'red':'green'}} margin-0">{{($item->status)?'Deactivate':'Activate'}}</button></td>
                                            @endif
                                        </tr>
                                    @endif
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
            url: "{{ route('admin.trainer.status-action') }}",
            method: "POST",
            data: dataString,
            success: function(data){
                var SuccessResponseText = document.createElement("div");
                SuccessResponseText.innerHTML = data['message'];
                swal({title: data['title'], content: SuccessResponseText, icon: data['type'], closeModal: true,timer: 5000, buttons: false}).then(function(){location.reload();});
            },
            error:function(data){
                swal("Sorry", "Something Went Wrong, Please Try Again", "error").then(function(){location.reload();});
            }
        });
    }

    function popup(v){
        var data = v.split(',');
        // data[4] = '1: Request for Deactvation or Activation of Linked Trainer 0: Request for Delinking a Linked Active Trainer'
        // data[3] = '1: Request from Trainers Table 0: Request from Delinked Trainer Table'
        // data[1] = '1: Trainer is Active 0: Trainer is Inactive'
        
        var confirmatonText = document.createElement("div");
        var color=''; var text=''; var displayText='';
        var _token=$('[name=_token]').val();
        var trainer=data[2];
        var confirmBtn = "Confirm Update Status";
        var dataSend = ''; 
        
        
        if (data[3] == 1) {
            if (data[4]==1) {
                if (data[1]==1) {
                    color = 'red'; text = 'Deactivate'; 
                    displayText=trainer+'\nProvide Trainer Deactivation Reason ';
                    confirmatonText="input";
                } else {
                    color = 'green'; text = 'Activate';
                    displayText = "Are you Sure ?";
                    confirmatonText.innerHTML = "You are about to <span style='font-weight:bold; color:"+color+";'>"+text+"</span> <br> <span style='font-weight:bold; color:blue;'>"+trainer+"</span> Trainer";
                }
                // dataSend = data[0]+',1,1';
            } else {
                color = 'red'; text = 'Trainer DeLinking'; 
                displayText=trainer+'\nProvide Trainer DeLinking Reason ';
                confirmatonText="input";
                confirmBtn = "Confirm DeLink";
                // dataSend = data[0]+',0,1';
            }
        } else {
            if (data[1]==1) {
                    color = 'red'; text = 'Deactivate'; 
                    displayText=trainer+'\nProvide Trainer Deactivation Reason ';
                    confirmatonText="input";
                } else {
                    color = 'green'; text = 'Activate';
                    displayText = "Are you Sure ?";
                    confirmatonText.innerHTML = "You are about to <span style='font-weight:bold; color:"+color+";'>"+text+"</span> <br> <span style='font-weight:bold; color:blue;'>"+trainer+"</span> Trainer";
                }
                // dataSend = data[0]+',1,0';
        }
        dataSend = data[0]+','+data[4]+','+data[3];
        swal({
            text: displayText,
            content: confirmatonText,
            icon: "info",
            buttons: true,
            buttons: {
                    cancel: "No, Cancel",
                    confirm: {
                        text: confirmBtn,
                        closeModal: false
                    }
                },
            closeModal: false,
            closeOnEsc: false,
        }).then(function(val){
            if (val != null) {
                if (val === '') {
                    swal('Attention', 'Please Describe the Reason before Proceed', 'info');
                } else if (val === true) {
                    var dataString = {_token, data:dataSend, reason:null};
                    callajax(val,dataString);
                } else {
                    var dataString = {_token, data:dataSend, reason:val};
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