@extends('layout.master')
@section('title', 'Candidates')
@section('page-style')
<!-- Custom Css -->
<link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/color_skins.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
@stop
@section('content')
<div class="container-fluid home">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header d-flex justify-content-between">
                    <h2><strong>My</strong> Candidates</h2>
                    @if (Request::segment(1) === 'center')
                        <a class="btn btn-primary btn-round waves-effect" href="{{route('center.addcandidate')}}">Add New Candidate</a>                      
                    @endif
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    @if (Request::segment(1) === 'admin')
                                        <th>TP</th>
                                    @endif
                                    @if (Request::segment(1) !== 'center')
                                        <th>TC</th>
                                    @endif
                                    <th>Candidate Name</th>
                                    <th>Contact</th>
                                    <th>Category</th>
                                    <th>Date of Birth</th>
                                    <th>Overall Status</th>
                                    <th>Result</th>
                                    @if (Request::segment(1) === 'admin' ||Request::segment(1) === 'center')
                                        <th>Action</th>
                                    @endif
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($candidates as $key => $candidate)
                                    
                                <tr>
                                <td>{{$key+1}}</td>
                                @if (Request::segment(1) === 'admin')
                                    <td>{{$candidate->center->partner->tp_id}}</td>
                                @endif
                                @if (Request::segment(1) !== 'center')
                                    <td>{{$candidate->center->tc_id}}</td>
                                @endif
                                <td>{{$candidate->candidate->name}}</td>
                                <td>{{$candidate->candidate->contact}}</td>
                                <td>{{$candidate->candidate->category}}</td>
                                <td>{{$candidate->candidate->dob}}</td>
                                @if ($candidate->dropout)
                                    <td style="color:blue;">Dropped out</td>
                                @else
                                    <td style="color:{{($candidate->jobrole->partnerjobrole->status && $candidate->center->partner->status && $candidate->center->status && $candidate->candidate->status)?'green':'red'}}">{{($candidate->jobrole->partnerjobrole->status && $candidate->center->partner->status && $candidate->center->status && $candidate->candidate->status)?'Active':'Inactive'}}</td>
                                @endif
                               
                               @if (is_null($candidate->passed))
                                   <td>N/A</td>
                               @elseif ($candidate->passed)
                                   <td class="text-success">Passed</td>
                               @elseif ($candidate->passed)
                                   <td class="text-danger">Failed</td>
                               @endif
                                
                                @if (Request::segment(1)==='admin')
                                    <td><button type="button" onclick="popup('{{Crypt::encrypt($candidate->candidate->id).','.$candidate->candidate->status.','.$candidate->candidate->name}}')" class="badge bg-{{($candidate->candidate->status)?'red':'green'}} margin-0">{{($candidate->candidate->status)?'Deactivate':'Activate'}}</button></td>
                                @else
                                    @if (Request::segment(1)==='center')
                                        <td><button type="button" class="badge bg-{{($candidate->dropout)?'grey':(($candidate->candidate->status)?'red':'grey')}} margin-0" {{($candidate->dropout)?'disabled':null}} onclick="popup('{{Crypt::encrypt($candidate->id).','.$candidate->candidate->status.','.$candidate->candidate->name}}')" >Dropout</button>
                                    @endif
                                @endif
                                <td>
                                    <button type="button" class="badge bg-green margin-0" onclick="location.href='{{route(Request::segment(1).(Request::segment(1) === 'center' ? null : '.tc').'.candidate.view',Crypt::encrypt($candidate->candidate->id))}}'" >View</button>
                                </td>
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
@endsection

@section('page-script')
@switch(Request::segment(1))
    @case('admin')
            
            <script>
                    function callajax(val, dataString){
                        $.ajax({
                            url: "{{ route('admin.tp.candidate.status-action') }}",
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
                        var candidate=data[2];
                            if (data[1]==1) {
                                color = 'red'; text = 'Deactivate'; 
                                displayText='Deactivate Candidate '+candidate+'\nProvide Candidate Deactivation Reason ';
                                confirmatonText="input"
                            } else {
                                color = 'green'; text = 'Activate';
                                displayText = "Are you Sure ?";
                                confirmatonText.innerHTML = "You are about to <span style='font-weight:bold; color:"+color+";'>"+text+"</span> <br>Candidate <span style='font-weight:bold; color:blue;'>"+candidate+"</span>";
                            }
                        
                        swal({
                            text: displayText,
                            content: confirmatonText,
                            icon: "info",
                            buttons: true,
                            buttons: {
                                    cancel: "No, Cencel",
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
        
        @break
    @case('center')
        
            <script>
                    function callajax(val, dataString){
                        $.ajax({
                            url: "{{ route('center.candidate.dropout') }}",
                            method: "POST",
                            data: dataString,
                            success: function(data){
                                var SuccessResponseText = document.createElement("div");
                                SuccessResponseText.innerHTML = data['message'];
                                swal({title: "Job Done", content: SuccessResponseText, icon: data['type'], closeModal: true,timer: 4000, buttons: false}).then(function(){location.reload();});
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
                        var candidate=data[2];


                        if (data[1] == 1) {
                            
                            swal({
                            text: 'Dropping out Candidate '+candidate+'\nProvide Candidate Drop Out Reason ',
                            content: "input",
                            icon: "info",
                            buttons: true,
                            buttons: {
                                    cancel: "No, Cencel",
                                    confirm: {
                                        text: "Proceed",
                                        closeModal: true
                                    }
                                },
                            closeModal: false,
                            closeOnEsc: false,
                            }).then(function(val){
                                if (val != null) {
                                    if (val === '') {
                                        swal('Attention', 'Please Describe the Reason of Drop Out before Proceed', 'info');
                                    } else {
                                        var SwalText = document.createElement("div");
                                        SwalText.innerHTML = 'Candidate <span style="color:blue">'+candidate+'</span> will be <span style="color:red;">Droped Out</span> from your <span style="color:blue">Center</span> and also from <span style="color:blue">Current Batch</span> as well (Only if the Candidate is Currently <span style="color:blue">Linked</span> with any Batch)';
                                        swal({
                                            title: 'Confirmation!',
                                            content: SwalText,
                                            icon: "info",
                                            buttons: true,
                                            buttons: {
                                                    cancel: "No, Cencel",
                                                    confirm: {
                                                        text: "Confirm Drop Out",
                                                        closeModal: false
                                                    }
                                                },
                                            closeModal: false,
                                            closeOnEsc: false,
                                        }).then(function (v) {
                                            if (v) {
                                                var dataString = {_token, data:data[0], reason:val};
                                                callajax(val,dataString);
                                            }
                                        });

                                    }
                                }
                            });

                        } else {
                            var SwalText = document.createElement("div");
                            SwalText.innerHTML = 'You cannot take <span style="color:blue;">Action</span> on those Candidates, Which are <span style="color:red;">Deactivated</span> by Admin';
                            swal({title: "Attention", content: SwalText, icon: 'info', closeModal: true,timer: 5000, buttons: false}).then(function(){location.reload();});
                        }

                    }
            
            </script>        

        @break
    @default
        
@endswitch
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@endsection