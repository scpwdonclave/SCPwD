@extends('layout.master')
@section('title', 'Batch')
{{-- @section('parentPageTitle', 'Partners-verify') --}}
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/timeline.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">


<link rel="stylesheet" href="{{asset('assets/css/color_skins.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                    @if (!is_null($batchData->batch_id))
                        <div class="text-center">
                            <h6>
                                Batch ID: <span style='color:blue'>{{$batchData->batch_id}}</span>
                            </h6>
                        </div>
                        <br>
                    @endif
                    <div class="container-fluid">
                        <form action="#" method="post">
                            <div class="row d-flex justify-content-around">
                                <div class="col-sm-4">
                                    <label for="batch_start">Batch Start Date *</label>
                                    <div class="form-group form-float">
                                        <input type="text" class="form-control" placeholder="Batch Start Date" value="{{ $batchData->batch_start }}" name="batch_start" required >
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="batch_end">Batch End Date *</label>
                                    <div class="form-group form-float">
                                        <input type="text" class="form-control" placeholder="Batch End Date" value="{{ $batchData->batch_end }}" name="batch_end" required >
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="assessment">Assessment Date *</label>
                                    <div class="form-group form-float date_picker">
                                        <select id="assessment" class="form-control show-tick" data-live-search="true" name="assessment" data-dropup-auto='false' required>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center" style="margin-top:30px">
                                <h6>Current Trainer for this Batch is <span style="color:blue">Shouvik Mohanta</span> (ID: <span style="color:blue">TR2019000001</span>)</h6>
                            </div>
                            <div class="row d-flex justify-content-center">
                                <div class="col-sm-6">
                                    <label for="trainer">Trainer *</label>
                                    <div class="form-group form-float">
                                        <select id="trainer" class="form-control show-tick" data-live-search="true" name="trainer" data-dropup-auto='false' required>
                                            @foreach ($trainers as $trainer)
                                            <option value="{{$trainer->id}}" {{($trainer->id == $batchData->tr_id)?'selected':null}}>{{$trainer->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
@section('page-script')

<script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop