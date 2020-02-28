@extends('layout.master')
@section('title', 'Candidate Wise Placement')
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
                    <h2><strong>Search</strong> Candidate Wise Placement</h2>                        
                </div>
                <div class="body">
                    <form id="form_scheme" action="{{route('admin.mis.candidate_wise_placement')}}" method="post">
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
                                
                                <label for="start_date">Start Date</label>
                                <div class="form-group form-float date_picker">
                                    <input type="text" class="form-control date_datepicker" placeholder="Start Date" id="start_date"  onchange="startchangescpwd('new')"  name="start_date" required >
                                </div>
                            
                        </div>
                        <div class="col-sm-4">
                            
                                <label for="end_date">End date</label>
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
                                    <th>TC ID</th>
                                    <th>TC State</th>
                                    <th>TC District</th>
                                    <th>Job Role</th>
                                    <th>Candidate ID</th>					 	
                                    <th>Candidate Name</th>
                                    <th>Type of Disability</th>
                                    <th>State</th>
                                    <th>District</th>
                                    <th>Gender</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Caste Category</th>
                                    <th>Employer Type</th>
                                    <th>Employment Date</th>
                                    <th>Organization Name</th>
                                    <th>Organization Address</th>
                                    <th>Organization State</th>
                                    <th>Organization District</th>
                                    <th>Employer Spoc Name</th>
                                    <th>Employer Spoc Mobile</th>
                                    <th>Employer Spoc Email</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($can_stack) && !empty($can_stack) )
                                    
                                @foreach ($can_stack as $key=>$item)
                                    
                                <tr>
                                    <td>{{$item[0]}}</td>
                                    <td>{{$item[1]}}</td>
                                    <td>{{$item[2]}}</td>
                                    <td>{{$item[3]}}</td>
                                    
                                    
                                    <td>{{$item[4]}}</td>
                                    <td>{{$item[5]}}</td>
                                    <td>{{$item[6]}}</td>
                                    <td>{{$item[7]}}</td>
                                    <td>{{$item[8]}}</td>
                                    <td>{{$item[9]}}</td>
                                    <td>{{$item[10]}}</td>
                                    <td>{{$item[11]}}</td>
                                    <td>{{$item[12]}}</td>
                                    <td>{{$item[13]}}</td>
                                    <td>{{$item[14]}}</td>
                                    <td>{{$item[15]}}</td>
                                    <td>{{$item[16]}}</td>
                                    <td>{{$item[17]}}</td>
                                    <td>{{$item[18]}}</td>
                                    <td>{{$item[19]}}</td>
                                    <td>{{$item[20]}}</td>
                                    <td>{{$item[21]}}</td>
                                    <td>{{$item[22]}}</td>
                                    <td>{{$item[23]}}</td>
                                    {{-- <td>{{$item[22]}}</td> --}}
                                    
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