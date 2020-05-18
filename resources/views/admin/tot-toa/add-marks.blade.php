@extends('layout.master')
@section('title', 'Add Marks')
@section('parentPageTitle', 'TOT-TOA')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">

@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header d-flex justify-content-between">
                    <h2><strong>Add</strong> {{$tag == 'tot'?'Trainer':'Assessor'}} Marks </h2>
                </div>
                @php
                    $url = $tag=='tot'? route('admin.tot-toa.tot-batches.marks.submit'):route('admin.tot-toa.toa-batches.marks.submit');
                @endphp
                <div class="text-center">
                <h6><strong>Batch ID: <span style="color:blue">{{$batchData->batch_id}}</span></strong></h6>
                </div>
                <div class="body">
                <form id="form_batch_mark" method="POST" action="{{$url}}">
                    @csrf
                    <input type="hidden" name="bt_id" value="{{$batchData->id}}">

                    <div class="table-responsive">
                        <table class="table nobtn table-bordered ">
                            <thead>
                                <tr>
                                    <th>Sl. No.</th>
                                    @if ($tag == 'tot')
                                        <th>Trainer Name</th>
                                        <th>Trainer Type</th>
                                        <th>TP Name</th>
                                    @else
                                        <th>Assessor Name</th>
                                        <th>Agency Name</th>
                                    @endif
                                    <th>Doc No</th>
                                    <th>Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i=0;    
                                @endphp
                                @if ($tag == 'tot')
                                    @foreach ($batchData->trainers as $key=>$item)
                                        @php
                                        $i++;    
                                        @endphp
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>
                                                {{$item->trainer->name}}
                                                <input type="hidden" name="item_id[]" value="{{$item->tr_id}}"> 
                                            </td>
                                            <td>{{$item->trainer->trainer_category?'Master ': null}}Trainer</td>
                                            <td>{{$item->trainer->tp_name}}</td>
                                            <td>{{$item->trainer->doc_no}}</td>
                                            <td><input class="text-center" type="number" min="0" max="100" style="height:30px;border:none;width:40px !important;" name="mark[{{$item->tr_id}}][]" required /></td>
                                        </tr>
                                    @endforeach
                                @else
                                    @foreach ($batchData->assessors as $key=>$item)
                                        @php
                                        $i++;    
                                        @endphp
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>
                                                {{$item->assessor->name}}
                                                <input type="hidden" name="item_id[]" value="{{$item->as_id}}"> 
                                            </td>
                                            <td>{{$item->assessor->agency->agency_name}}</td>
                                            <td>{{$item->assessor->doc_no}}</td>
                                            <td><input class="text-center" type="number" min="0" max="100" style="height:30px;border:none;width:40px !important;" name="mark[{{$item->as_id}}][]" required /></td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <br><br>
                    </div>
                    <div class="row d-flex justify-content-center">
                        <button type="submit" id="submit_form" class="btn btn-primary">SUBMIT</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('page-script')

<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{asset('assets/js/scpwd-common.js')}}"></script>

@stop