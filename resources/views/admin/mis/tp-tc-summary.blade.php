@extends('layout.master')
@section('title', 'TP TC Wise')
@section('parentPageTitle', 'MIS')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}">
<link href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">
{{-- <link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/> --}}

@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Search</strong> TP-TC Wise</h2>                        
                </div>
                <div class="body">
                    <form id="form_scheme" action="{{route('admin.mis.tp-tc_wise_enrolled')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="scheme">Select Scheme <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" data-live-search="true" name="scheme" data-dropup-auto='false' required>
                                        @foreach ($scheme as $scheme)
                                        <option value="{{$scheme->id}}">{{$scheme->scheme}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        
                            {{-- <div class="col-sm-6">
                                    <label for="scheme">Select Financial Year <span style="color:red"> <strong>*</strong></span></label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="zmdi zmdi-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control datetimepicker" name="financial_year" id="financial_year" placeholder="Choose Financial Year" required>
                                </div>
                            </div> --}}
                            <div class="col-sm-4">
                                
                                    <label for="start_date">Start Date <span style="color:red"> <strong>*</strong></span></label>
                                    <div class="form-group form-float date_picker">
                                        <input type="text" class="form-control date_datepicker" placeholder="Start Date" id="start_date"  onchange="startchangescpwd('new')"  name="start_date" required >
                                    </div>
                                
                            </div>
                            <div class="col-sm-4">
                                
                                    <label for="end_date">End date <span style="color:red"> <strong>*</strong></span></label>
                                    <div class="form-group form-float date_picker">
                                        <input type="text" class="form-control date_datepicker" placeholder="End date" id="end_date" name="end_date"  required>
                                    </div>
                            
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <button class="btn btn-round btn-primary" type="submit">Search</button>
                        </div>
                    </form>
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
                    <h2><strong>Report</strong> Section</h2>                        
                </div>
                <div class="text-center">
                    @if (isset($sel_scm) && isset($from) && isset($to))
                    <p><h6><strong>Selected Scheme: <span style="color:blue">{{$sel_scm}}</span></strong></h6></p>
                    <p><h6><strong>Selected DATE: <span style="color:blue">{{\Carbon\Carbon::parse($from)->format('d-m-Y')}} <span style="color:black">to</span> {{\Carbon\Carbon::parse($to)->format('d-m-Y')}}</span></strong></h6></p>
                    @endif
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="scheme_table" class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>TP</th>
                                    <th>TC</th>
                                    <th>Sum of Enrolled</th>
                                    <th>Sum of Ongoing Training</th>
                                    <th>Sum of Trained</th>					 	
                                    <th>Sum of Assessed</th>
                                    <th>Sum of Passed</th>
                                    <th>Sum of Fail</th>
                                    <th>Sum of Absent</th>
                                    <th>Sum of Drop-Out</th>
                                    <th>Sum of Certified</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($center_stack) && !empty($center_stack) )
                                    
                                @foreach ($center_stack as $key=>$item)
                                    
                                <tr>
                                    <td>{{$item[0]}}</td>
                                    <td>{{$key}}</td>
                                    <td>{{$item[1]}}</td>
                                    <td>{{$item[2]}}</td>
                                    <td>{{$item[3]}}</td>
                                    <td>{{$item[4]}}</td>
                                    <td>{{$item[5]}}</td>
                                    <td>{{$item[6]}}</td>
                                    <td>{{$item[7]}}</td>
                                    <td>{{$item[8]}}</td>
                                    <td>{{$item[9]}}</td>
                                    
                                </tr>
                                @endforeach
                                @endif
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
//     $("#financial_year").datepicker({
//         format: "yy",
//         minViewMode: 2,
//         autoclose : true
//         }).on('hide',function(date){
//          if(date.target.value) {
//              $("#financial_year").val(date.target.value + "-" + (parseInt(date.target.value) + parseInt(1)));
//             }else{
//              $("#financial_year").val('');
               
//             } 
//    });
$(function () {
    
     $('.date_picker .form-control').datepicker({ 
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
/* End Bootstrap DatePicker */

    $('#start_date')
        .datepicker()
        .on('changeDate', function(selected){
            startDate = new Date(selected.date.valueOf());
            startDate.setDate(startDate.getDate(new Date(selected.date.valueOf()))); 
            $('#end_date').datepicker('setStartDate', startDate);
        });
    
});

function startchangescpwd(){
            $('#end_date').val('');
        }
</script>
@endsection