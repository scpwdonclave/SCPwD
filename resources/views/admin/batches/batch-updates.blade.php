@extends('layout.master')
@section('title', 'Batch Updates')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
@stop
@section('content')

<div class="row clearfix">
    <div class="col-md-12 col-lg-8">
        <div class="card">
            <div class="header">
                <h2><strong>Batch Updates</strong> Record </h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                        <thead>
                            <tr>
                                <th>Sl. No.</th>
                                <th>Batch ID</th>
                                <th>Trainer ID</th>
                                <th>Status</th>
                                <th>View</th>
                                <th>Batch</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($batchupdates as $key=>$item)                              
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$item->batch->batch_id}}</td>
                                <td>{{$item->trainer->trainer_id}}</td>
                                <td class="text-{{($item->approved)?'success':'danger'}}">{{($item->approved)?'Approved':'Rejected'}}</td>
                                <td><button class="badge margin-0" style="align:right;" onclick="location.href='#viewModal{{$item->id}}'" data-toggle="modal" data-target="#viewModal{{$item->id}}" >show</button></td>
                                <td><a class="badge bg-green margin-0" href="{{route('admin.bt.batch.view',['id'=>Crypt::encrypt($item->batch->id)])}}" >View</a></td>
                            </tr>
                                
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @section('modal')
                    @foreach ($batchupdates as $key=>$item)
                        <div class="modal fade" id="viewModal{{$item->id}}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <table class="nobtn table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Sl. No.</th>
                                                        <th>Old Data</th>
                                                        <th>New data</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="font-weight:bold">Trainer</td>
                                                        <td style="color:{{$item->tr_id==$item->new_tr_id? null: 'firebrick'}}">{{$item->trainer->trainer_id}}</td>
                                                        <td style="color:{{$item->tr_id==$item->new_tr_id? null: 'green'}}">{{$item->new_trainer->trainer_id}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold">End Date</td>
                                                        <td style="color:{{$item->end_date==$item->batch->batch_end? null: 'firebrick'}}">{{\Carbon\Carbon::parse($item->batch->batch_end)->format('d-m-Y')}}</td>
                                                        <td style="color:{{$item->end_date==$item->batch->batch_end? null: 'green'}}">{{\Carbon\Carbon::parse($item->end_date)->format('d-m-Y')}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold">Assessment</td>
                                                        <td style="color:{{$item->assessment==$item->batch->assessment? null: 'firebrick'}}">{{\Carbon\Carbon::parse($item->batch->assessment)->format('d-m-Y')}}</td>
                                                        <td style="color:{{$item->assessment==$item->batch->assessment? null: 'green'}}">{{\Carbon\Carbon::parse($item->assessment)->format('d-m-Y')}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        @if (!is_null($item->new_tr_start))
                                            <div class="row d-flex justify-content-center">
                                                <p>New Trainer Start Date:  <span style="color:blue;font-weight:bold">{{$item->new_tr_start}}</span></p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endsection
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-4">
        <div class="card activities">
            <div class="header">
                <h2><strong>Batch Update</strong> Request</h2>
            </div>
            <div class="body">
                @if(count($updaterequests) > 0)
                    <ul class="list-unstyled activity">
                    @foreach ($updaterequests as $item)
                        <li>
                            <a href="javascript:void(0);">
                                <i class="zmdi zmdi-tag bg-blush"></i>
                                <div class="info">
                                    <h4>{{$item->batch->batch_id}}</h4>                    
                                    <small><strong>Trainer: </strong>{{$item->new_trainer->trainer_id}}</small> <br>
                                    <small><strong>End Date: </strong>{{\Carbon\Carbon::parse($item->end_date)->format('d-m-Y')}}</small><br>
                                    <small><strong>Assessment: </strong>{{\Carbon\Carbon::parse($item->assessment)->format('d-m-Y')}}</small><br>
                                    
                                    <button  class="btn btn-sm" style="align:right;" onclick="location.href='#smallModal{{$item->id}}'" data-toggle="modal" data-target="#smallModal{{$item->id}}" >show</button>
                                    @if (!auth()->guard('admin')->user()->ministry)
                                        <button  class="btn btn-success btn-sm" style="align:right;" onclick="location.href='{{route('admin.batch.bu.submit',['id' =>Crypt::encrypt($item->id),'action'=>'accept'])}}'" >Accept</button>    
                                        <button  class="btn btn-danger btn-sm" style="align:right;"  onclick="showPromptMessage('{{Crypt::encrypt($item->id)}}')" >Reject</button>    
                                    @endif
                                </div>
                            </a>
                        </li>
                        <div class="modal fade" id="smallModal{{$item->id}}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <table class="nobtn table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Sl. No.</th>
                                                        <th>Old Data</th>
                                                        <th>New data</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="font-weight:bold">Trainer</td>
                                                        <td style="color:{{$item->tr_id==$item->new_tr_id? null: 'firebrick'}}">{{$item->trainer->trainer_id}}</td>
                                                        <td style="color:{{$item->tr_id==$item->new_tr_id? null: 'green'}}">{{$item->new_trainer->trainer_id}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold">End Date</td>
                                                        <td style="color:{{$item->end_date==$item->batch->batch_end? null: 'firebrick'}}">{{\Carbon\Carbon::parse($item->batch->batch_end)->format('d-m-Y')}}</td>
                                                        <td style="color:{{$item->end_date==$item->batch->batch_end? null: 'green'}}">{{\Carbon\Carbon::parse($item->end_date)->format('d-m-Y')}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold">Assessment</td>
                                                        <td style="color:{{$item->assessment==$item->batch->assessment? null: 'firebrick'}}">{{\Carbon\Carbon::parse($item->batch->assessment)->format('d-m-Y')}}</td>
                                                        <td style="color:{{$item->assessment==$item->batch->assessment? null: 'green'}}">{{\Carbon\Carbon::parse($item->assessment)->format('d-m-Y')}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        @if (!is_null($item->new_tr_start))
                                            <div class="row d-flex justify-content-center">
                                                <p>New Trainer Start Date:  <span style="color:blue;font-weight:bold">{{$item->new_tr_start}}</span></p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </ul>
                @else 
                    <div class="body text-center">
                        <div class="not_found">
                            <i class="zmdi zmdi-mood zmdi-hc-4x"></i>
                            <h4 class="m-b-0">No Pending Requests Found.</h4>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


@stop
@section('page-script')
<script>

    // Handling Rejecting A Update Request
    function showPromptMessage(id) {
        swal({
            text: "Please Provide the Reason for Rejection",
            content: {
                element: "input",
                attributes: {
                    type: "text",
                },
            },
            icon: "info",
            buttons: true,
            buttons: {
                cancel: {
                    text: "Cancel",
                    visible: true,
                    value: null,
                    closeModal: true,
                },
                confirm: {
                    text: "Confirm Reject",
                    value: true,
                    closeModal: true
                }
                },
            closeModal: false,
            closeOnEsc: false,
        }).then(function(note){
            if (note!='' && note!=null) {
                let route = '{{route("admin.batch.bu.submit", [":id", "reject", ":reason"])}}';
                route = route.replace(':id',id);
                route = route.replace(':reason',note);
                location.href=route;
            } else if(note != null) {
                swal('Attention', 'Write Something Before you Submit','info');
            }
        });
    }
    // End Handling Rejecting A Update Request

</script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop