@extends('layout.master')
@section('title', 'Create Invoice')
@section('parentPageTitle', 'Invoice')
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
                    <h2><strong>Search</strong> Assessment Agency Wise</h2>                        
                </div>
                <div class="body">
                    <form id="form_scheme" action="#" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="scheme">Select Scheme <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" data-live-search="true" name="scheme" onchange="fetchPartner(this.value)" data-dropup-auto='false' required>
                                        <option value="">--select--</option>
                                        @foreach ($scheme as $scheme)
                                        <option value="{{$scheme->id}}">{{$scheme->scheme}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="partner">Select Training Partner <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" data-live-search="true" name="partner" id="partner" data-dropup-auto='false' required>
                                      
                                    </select>
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
                    <h2><strong>Report</strong> Section Assessment Agency Wise</h2>                        
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
                                    <th>Assessment Agency</th>							
                                    <th>Sum of Enrolled</th>
                                    <th>Sum of Ongoing Training</th>
                                    <th>Sum of Trained</th>					 	
                                    <th>Sum of Assessed</th>
                                    <th>Sum of Passed</th>
                                    <th>Sum of Fail</th>
                                    <th>Sum of Absent</th>
                                    <th>Sum of Drop-Out</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($candidate_stack) && !empty($candidate_stack) )
                                    
                                @foreach ($candidate_stack as $key=>$item)
                                    
                                <tr>
                                    <td>{{$key}}</td>
                                    <td>{{$item[0]}}</td>
                                    <td>{{$item[1]}}</td>
                                    <td>{{$item[2]}}</td>
                                    <td>{{$item[3]}}</td>
                                    <td>{{$item[4]}}</td>
                                    <td>{{$item[5]}}</td>
                                    <td>{{$item[6]}}</td>
                                    <td>{{$item[7]}}</td>
                                   
                                    
                                    
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
 function fetchPartner(scheme){
        let _token = $("input[name='_token']").val();
       
        var scheme=scheme;
        $.ajax({
            url:"{{route('admin.invoice.fetch-partner')}}", 
            data:{_token,scheme},
            method:'POST',
            success: function(data){
                $('#partner').empty();
                $.each (data.partnerJob, function (index) {
                    var id=data.partnerJob[index].tp_id;
                    var tpid=data.partnerJob[index].tpid;
                    $('#partner').append('<option value="'+id+'">'+tpid+'</option>');
                    
                });
                $('#partner').selectpicker('refresh');
            }
        });
    }
</script>
@endsection