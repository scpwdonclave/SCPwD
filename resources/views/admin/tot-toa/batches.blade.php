@extends('layout.master')
@if ($tag==='tot')
    @section('title', 'TOT Batches')
@else
    @section('title', 'TOA Batches')
@endif
@section('parentPageTitle', 'TOT-TOA')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/color_skins.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
@stop
@section('content')

<div class="container-fluid"> 
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header d-flex justify-content-between">
                    <h2><strong>{{$tag==='tot'?'TOT':'TOA'}}</strong> Batches </h2>
                    <a class="btn btn-primary btn-round waves-effect" href="javascript:void(0);" onclick="popupMenu()">Add New Batch</a>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Batch ID</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>No of {{$tag==='tot'?'Trainers':'Assessors'}}</th>
                                    <th>Marks</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records as $record)
                                    <tr>
                                        <td>{{$record->batch_id}}</td>
                                        <td>{{Carbon\Carbon::parse($record->batch_start)->format('d-m-Y')}}</td>
                                        <td>{{Carbon\Carbon::parse($record->batch_end)->format('d-m-Y')}}</td>
                                        @if ($tag==='tot')
                                            <td>{{$record->trainers->count()}}</td>
                                            @if ($record->trainers->count() && Carbon\Carbon::parse($record->batch_end) < Carbon\Carbon::now())
                                                @if (is_null($record->trainers[0]->percentage))
                                                    <td><button type="button" class="badge bg-green margin-0" onclick="location.href='{{route('admin.tot-toa.tot-batches.marks.add',Crypt::encrypt($record->id))}}'" >Enter Marks</button></td>
                                                @else
                                                    <td><button type="button" class="badge bg-grey margin-0" >Marks Taken</button></td>
                                                @endif
                                            @else
                                                <td><button type="button" class="badge bg-grey margin-0">Enter Marks</button></td>
                                            @endif
                                            @if ($record->trainers->count())
                                                <td><button type="button" class="badge bg-green margin-0" onclick="location.href='{{route('admin.tot-toa.tot-batches.view',Crypt::encrypt($record->id))}}'" >View</button></td>
                                            @else
                                                <td><button type="button" class="badge bg-grey margin-0">View</button></td>
                                            @endif
                                        @else
                                            <td>{{$record->assessors->count()}}</td>
                                            @if ($record->assessors->count() && Carbon\Carbon::parse($record->batch_end) < Carbon\Carbon::now())
                                                @if (is_null($record->assessors[0]->percentage))
                                                    <td><button type="button" class="badge bg-green margin-0" onclick="location.href='{{route('admin.tot-toa.toa-batches.marks.add',Crypt::encrypt($record->id))}}'" >Enter Marks</button></td>
                                                @else
                                                    <td><button type="button" class="badge bg-grey margin-0" >Marks Taken</button></td>
                                                @endif
                                            @else
                                                <td><button type="button" class="badge bg-grey margin-0">Enter Marks</button></td>
                                            @endif
                                            @if ($record->assessors->count())
                                                <td><button type="button" class="badge bg-green margin-0" onclick="location.href='{{route('admin.tot-toa.toa-batches.view',Crypt::encrypt($record->id))}}'" >View</button></td>
                                            @else
                                                <td><button type="button" class="badge bg-grey margin-0">View</button></td>
                                            @endif
                                            
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
@section('modal')
    <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog"> 
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="title" id="defaultModalLabel"></h4>
                </div>
                <div class="modal-body">
                    @php
                        if ($tag === 'tot') {
                            $url = 'admin.tot-toa.tot-batches.submit';
                        } else {
                            $url = 'admin.tot-toa.toa-batches.submit';
                        }
                        
                    @endphp
                    <form id="form_modal" method="POST" action="{{route($url)}}">
                        @csrf
                        {{-- <input type="hidden" name="userid" value="{{$partner->id}}"> --}}
                        <div class="row d-flex justify-content-center">
                            <div class="col-sm-6">
                                <label for="start">Batch Start Date <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group start_date">
                                    <input type="text" class="form-control" placeholder="Start Date" name="start" autoComplete="off" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="end">Batch End Date <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group end_date">
                                    <input type="text" class="form-control" placeholder="End Date" name="end" autoComplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <div class="col-sm-12">
                                <label for="new_records[]">Available newly Registered  {{$tag==='tot'?'Trainers':'Assessors'}}</label>
                                <select class="form-control show-tick form-group" id="new_records" multiple name="new_records[]" data-live-search="true" required>
                                </select>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <div class="col-sm-12">
                                <label for="renewals[]">Available {{$tag==='tot'?'Trainers':'Assessors'}} for Renewals</label>
                                <select class="form-control show-tick form-group" id="renewals" multiple name="renewals[]" data-live-search="true" required>
                                </select>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <button id="btnConfirm" class="btn btn-raised btn-primary btn-round waves-effect" type="submit" ></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')

<script>
    // Call Modal of Adding or Display Table

    function popupMenu(id){
    let tag = '{{$tag}}';
    let url = '';
    if (tag === 'tot') {
        url = "{{route('admin.tot.batch.api')}}";
    } else {
        url = "{{route('admin.toa.batch.api')}}";
    }
    let _token = $("[name=_token]").val();
    
    if (id === undefined) {
        data = null;
        $('#defaultModalLabel').html('Create New Batch');
        $('#btnConfirm').html('Add Batch');
    } else if(id != '') {
        if (tag === 'tot') {
            $('#defaultModalLabel').html('Trainers Under This Batch');
        } else {
            $('#defaultModalLabel').html('Assessors Under This Batch');
        }
        $('#btnConfirm').html('Update JobRole');
        $('[name=jobid]').val(id);
        data = id;
    }
    
        $.ajax({
            url:url, 
            data:{_token,data},
            method:'POST',
            success: function(data){
                
                $('#new_records').empty();
                $('#renewals').empty();
                
                $.each (data.new_records, function (index) {
                    let record_id=data.new_records[index].id;
                    let new_records = '';
                    
                    if (tag === 'tot') {
                        new_records=data.new_records[index].name+' | '+data.new_records[index].doc_no+' ('+data.new_records[index].tp_name+')';
                    } else {
                        new_records=data.new_records[index].name+' | '+data.new_records[index].doc_no+' ('+data.new_records[index].agency_name+')';
                    }
                    $('#new_records').append('<option value="'+record_id+'">'+new_records+'</option>');
                });
                $.each (data.renewals, function (index) {
                    let record_id=data.renewals[index].id;
                    let renewals = '';
                    
                    if (tag === 'tot') {
                        renewals=data.renewals[index].name+' | '+data.renewals[index].doc_no+' ('+data.renewals[index].tp_name+')';
                    } else {
                        renewals=data.renewals[index].name+' | '+data.renewals[index].doc_no+' ('+data.renewals[index].agency_name+')';
                    }
                    $('#renewals').append('<option value="'+record_id+'">'+renewals+'</option>');
                });
                
                if(id != '' && id !== undefined) {
                    
                    if (user==='admin') {
                        $("[name=scheme]").val(data.data.scheme_id);
                        $("[name=sector]").val(data.data.sector_id);
                        $("[name=target]").val(data.data.target);
                        if (data.data.assigned == 0) {
                            $("[name=target]").attr("min", 1);
                        } else {
                            $("[name=target]").attr("min", data.data.assigned);
                        }
                    }
                }

                $('#new_records').selectpicker('refresh');
                $('#renewals').selectpicker('refresh');
            },
            error: function(){
                swal('Attention', 'Something went Wrong, Try Again', 'error').then(function(){location.reload()});
            }
            });
         $("#defaultModal").modal('show');
    }

    // End Call Modal of Adding or Display Table
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

<script>
    $(()=>{
        $('#form_modal').validate();
        $('.end_date .form-control').datepicker({
            autoclose: true,
            format: 'dd MM yyyy',
        });
        $('.start_date .form-control').datepicker({
            autoclose: true,
            format: 'dd MM yyyy',
        }).on('changeDate', function(selected){
            $('[name=end]').val('');
            var minDate = new Date(selected.date.valueOf());
            $('.end_date .form-control').datepicker('setStartDate', minDate);            
        });

        $('#renewals').on('change', function(){
            if ($('#renewals > option:selected').length > 0) {
                $('#new_records').prop('required', false);
            } else {
                $('#new_records').prop('required', true);
            }
        });
        $('#new_records').on('change', function(){
            if ($('#new_records > option:selected').length > 0) {
                $('#renewals').prop('required', false);
            } else {
                $('#renewals').prop('required', true);
            }
        });
    });
</script>
@stop