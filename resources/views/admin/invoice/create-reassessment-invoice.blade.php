@extends('layout.master')
@section('title', 'Create Re-Assessment Invoice')
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
                    <h2><strong>Create</strong> Re Assessment Invoice</h2>                        
                </div>
                <div class="body">
                    <form id="form_scheme" action="{{route('admin.invoice.reassessment_invoice')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="scheme">Select Scheme with Department <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" data-live-search="true" name="scheme" onchange="fetchPartner(this.value)" data-dropup-auto='false' required>
                                        <option value="">--select--</option>
                                        @foreach ($scheme as $scheme)
                                        <option value="{{$scheme->id}}" data-subtext="{{$scheme->department->dept_address }}">{{$scheme->scheme}} ({{$scheme->department->dept_name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="partner">Select Training Partner <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" data-live-search="true" name="partner" id="partner" onchange="fetchCenter(this.value)" data-dropup-auto='false' required>
                                      
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="center">Select Training Center <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" data-live-search="true" name="center" id="center"  data-dropup-auto='false' required>
                                      
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
                    <h2><strong>Related</strong> Job Role & Candidate</h2>                        
                </div>
                <div class="text-center">
                    @if (isset($scheme_sel) )
                    <p><h6><strong>Selected Scheme: <span style="color:blue">{{$scheme_sel->scheme}}</span></strong></h6></p>
                    <p><h6><strong>Partner: <span style="color:blue">{{$partner->tp_id}}</span> || Center: <span style="color:blue">{{$center->tc_id}}</span></strong></h6></p>
                    {{-- <p><h6><strong>Selected DATE: <span style="color:blue">{{\Carbon\Carbon::parse($from)->format('d-m-Y')}} <span style="color:black">to</span> {{\Carbon\Carbon::parse($to)->format('d-m-Y')}}</span></strong></h6></p> --}}

                    @endif
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="scheme_table" class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>#</th>							
                                    <th>Job Role</th>							
                                    <th>Sector</th>							
                                    <th>QP Code</th>							
                                    <th>Total candidate</th>
                                    <th>Amount(&#8377;)</th>
                                   
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($stack) && !empty($stack) )
                                    
                                @foreach ($stack as $key=>$item)
                                    
                                <tr>
                                    <td>#</td>
                                    <td>{{$key}}</td>
                                    <td>{{$item[0]}}</td>
                                    <td>{{$item[1]}}</td>
                                    <td>{{$item[2]}}</td>
                                    <td>&#8377; {{$item[2]*1000}}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5" class="text-right"><strong>TOTAL AMOUNT</strong></td>
                                    <td><strong>&#8377; {{$total_candidate*1000}}</strong></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @if(!empty($stack))
                    <form id="form_invoice" action="{{route('admin.invoice.reassessment_invoice.submit')}}" method="post" >
                    @csrf
                    <div class="row d-flex justify-content-around">
                                
                        <div class="col-sm-4">
                            <label for="ref_no">Enter Ref No. <span style="color:red"> <strong>*</strong></span></label>
                            <div class="form-group form-float">
                                <input type="text" class="form-control " placeholder="Enter Ref No" id="ref_no" name="ref_no"  required>
                            <input type="hidden" name="partner" value="{{$partner->id}}">
                            <input type="hidden" name="scheme" value="{{$scheme_sel->id}}">
                            <input type="hidden" name="center" value="{{$center->id}}">
                            </div>
                        </div>
                       
                    </div>
                    <div class="text-center" >
                        <button class="btn btn-round btn-primary" type="submit" id="save-btn"> Submit Invoice</button>
                    </div>
                    </form>
                    @endif
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
                $('#partner').append('<option value="">--select--</option>');

                $.each (data.partnerJob, function (index) {
                    var id=data.partnerJob[index].tp_id;
                    var tpid=data.partnerJob[index].tpid;
                    $('#partner').append('<option value="'+id+'">'+tpid+'</option>');
                    
                });
                $('#partner').selectpicker('refresh');
            }
        });
    }

function fetchCenter(partner){
    let _token = $("input[name='_token']").val();
       
        var partner=partner;
        $.ajax({
            url:"{{route('admin.invoice.fetch-center')}}", 
            data:{_token,partner},
            method:'POST',
            success: function(data){
                console.log(data);
                
                $('#center').empty();
                $('#center').append('<option value="">--select--</option>');

                $.each (data.centers, function (index) {
                    var id=data.centers[index].id;
                    var tcid=data.centers[index].tc_id;
                    $('#center').append('<option value="'+id+'">'+tcid+'</option>');
                    
                });
                $('#center').selectpicker('refresh');
            }
        });
    
}
</script>
@endsection