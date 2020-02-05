@extends('layout.master')
@section('title', 'Candidate Wise')
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
                    <h2><strong>Search</strong> Candidate Wise</h2>                        
                </div>
                <div class="body">
                    <form id="form_scheme" action="{{route('admin.mis.candidate_wise_enrolled')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="scheme">Select Scheme <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" data-live-search="true" name="scheme" data-dropup-auto='false' required>
                                        @foreach ($scheme as $scheme)
                                        <option value="{{$scheme->id}}">{{$scheme->scheme}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        
                            <div class="col-sm-6">
                                    <label for="scheme">Select Financial Year <span style="color:red"> <strong>*</strong></span></label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="zmdi zmdi-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control datetimepicker" name="financial_year" id="financial_year" placeholder="Choose Financial Year" required>
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
                    @if (isset($sel_scm) && isset($sel_yr))
                    <p><h6><strong>Selected Scheme: <span style="color:blue">{{$sel_scm}}</span></strong></h6></p>
                    <p><h6><strong>Selected FY: <span style="color:blue">{{$sel_yr}}</span></strong></h6></p>
                    @endif
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="scheme_table" class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                 								 				 								

                                    <th>TP</th>
                                    <th>TC</th>
                                    <th>Job Role</th>
                                    <th>Batch</th>
                                    <th>Candidate ID</th>					 	
                                    <th>Candidate Name</th>
                                    <th>State</th>
                                    <th>District</th>
                                    <th>Gender</th>
                                    <th>Education</th>
                                    <th>Mobile</th>
                                    <th>Type of Disability</th>
                                    <th>Batch Start Date</th>
                                    <th>Batch End Date</th>
                                    <th>Result</th>
                                    <th>Caste Category</th>
                                    <th>Centre Address</th>
                                    <th>Sector</th>
                                    <th>TC State</th>
                                    <th>TC District</th>
                                    <th>TC SPOC Email</th>
                                    <th>TC SPOC Mobile</th>
                                    <th>TC SPOC Name</th>
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
                                    <td>{{$item[22]}}</td>
                                    
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
    $("#financial_year").datepicker({
        format: "yy",
        minViewMode: 2,
        autoclose : true
        }).on('hide',function(date){
         if(date.target.value) {
             $("#financial_year").val(date.target.value + "-" + (parseInt(date.target.value) + parseInt(1)));
            }else{
             $("#financial_year").val('');
               
            } 
   });
</script>
@endsection