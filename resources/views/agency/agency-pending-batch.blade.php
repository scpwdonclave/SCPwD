@extends('layout.master')
@section('title', 'Batch')
@section('parentPageTitle', 'Agency')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/color_skins.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
@stop
@section('content')

<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header d-flex justify-content-between">
                    <h2><strong>My</strong> Pending Batches for Assessment</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Batch ID</th>
                                    <th>Partner ID</th>
                                    <th>Center ID</th>
                                    <th>Disability Type</th>
                                    <th>Assessment Date</th>
                                    <th>View</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($agencyBatch as $item) 
                                    
                                    @if (is_null($item->reass_id))
                                        <tr>
                                            <td>{{$item->batch->batch_id}}</td>
                                            <td>{{$item->batch->partner->tp_id}}</td>
                                            <td>{{$item->batch->center->tc_id}}</td>
                                            <td>{{$item->batch->scheme->disability?'Multi Disability':'Single Disability'}}</td>
                                            <td>{{\Carbon\Carbon::parse($item->batch->assessment)->format('d-m-Y')}}</td>
                                            <td><a class="badge bg-green margin-0" href="{{route(Request::segment(1).'.batch.view',Crypt::encrypt($item->batch->id.',1'))}}">View</a></td>
                                            <td>
                                                <button type="button" class="badge bg-green margin-0" onclick="location.href='{{route('agency.aa.batch.action',[Crypt::encrypt($item->id),'accept'])}}'">Accept</button>
                                                <button type="button" class="badge bg-red margin-0" onclick="popupReject('{{Crypt::encrypt($item->id)}}');">Reject</button>
                                            </td>
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
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header d-flex justify-content-between">
                    <h2><strong>My</strong> Pending Batches for Re-Assessment</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Batch ID</th>
                                    <th>Partner ID</th>
                                    <th>Center ID</th>
                                    <th>Disability Type</th>
                                    <th>Assessment Date</th>
                                    <th>View</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($agencyBatch as $item) 
                                    
                                    @if (!is_null($item->reass_id))
                                        <tr>
                                            <td>{{$item->batch->batch_id}}</td>
                                            <td>{{$item->batch->partner->tp_id}}</td>
                                            <td>{{$item->batch->center->tc_id}}</td>
                                            <td>{{$item->batch->scheme->disability?'Multi Disability':'Single Disability'}}</td>
                                            <td>{{\Carbon\Carbon::parse($item->batch->assessment)->format('d-m-Y')}}</td>
                                            <td><a class="badge bg-green margin-0" href="{{route(Request::segment(1).'.batch.view',Crypt::encrypt($item->reass_id.',0'))}}">View</a></td>
                                            <td>
                                                <button type="button" class="badge bg-green margin-0" onclick="location.href='{{route('agency.aa.batch.action',[Crypt::encrypt($item->id),'accept'])}}'">Accept</button>
                                                <button type="button" class="badge bg-red margin-0" onclick="popupReject('{{Crypt::encrypt($item->id)}}');">Reject</button>
                                            </td>
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


function popupReject(id) {
    var confirmatonText = document.createElement("div");
    var _token=$('[name=_token]').val();
    color = 'red'; text = 'Rejection'; 
    displayText='Provide Batch Rejection Reason ';
    confirmatonText="input"
    
    swal({
        text: displayText,
        content: confirmatonText,
        icon: "info",
        buttons: true,
        buttons: {
                cancel: "No, Cancel",
                confirm: {
                    text: "Confirm Reject",
                    closeModal: false
                }
            },
        closeModal: false,
        closeOnEsc: false,
    }).then(function(val){
        if (val != null) {
            if (val === '') {
                swal('Attention', 'Please Describe the Reason of Rejection before Proceed', 'info');
            } else {
                let url = "{{route('agency.aa.batch.action',[':id','reject',':reason'])}}";
                url = url.replace(':id', id); 
                location.href = url.replace(':reason', val);
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