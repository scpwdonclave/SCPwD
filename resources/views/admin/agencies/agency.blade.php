@extends('layout.master')
@section('title', 'Agency Registration')
@section('page-style')
<link href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/animate-css/animate.css')}}">

{{-- <link rel="stylesheet" href="{{asset('assets/css/monthpicker.css')}}"> --}}
{{-- <link rel="stylesheet" href="{{asset('assets/css/spinner.css')}}"> --}}
{{-- <link rel="stylesheet" href="{{asset('assets/css/slider_button.css')}}"> --}}
{{-- <link href="{{asset('vendor/bootstrap-datetimepicker.css')}}" rel="stylesheet"> --}}
{{-- <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.css')}}"> --}}
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-steps/jquery.steps.css')}}">


{{-- <link rel="stylesheet" href="../assets/plugins/bootstrap/css/bootstrap.min.css"> --}}
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}">
<!-- Custom Css -->
<link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/color_skins.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">



<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}"/>
@stop
@section('content')
<div class="container-fluid home">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Agency</strong> Registration</h2>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="body">
                    {{-- <div class="row d-flex justify-content-around">
                        <div class="col-sm-3">
                            <p>SPOC Name : <h6>{{ $partner->spoc_name }}</h6></p>
                        </div>
                        <div class="col-sm-3">
                            <p>SPOC Email : <h6>{{ $partner->email }}</h6></p>
                        </div>
                        <div class="col-sm-3">
                            <p>SPOC Phone : <h6>{{ $partner->spoc_mobile }}</h6></p>
                        </div>

                    </div> --}}
                <form id="form2" method="POST" action="{{route('admin.aa.add-agency')}}" >
                            @csrf
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-primary">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title"> <a role="button" href="#collapseOne" onclick="return false" aria-expanded="true" aria-controls="collapseOne"> General Information </a> </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="panel-body">
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-3">
                                                    <label for="org_name">Assesment Agency Name * </label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Name of the Agency"  name="agency_name" required>
                                                       
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="org_type">Type of Oganization</label>
                                                    <div class="form-group form-float">
                                                        <select class="form-control show-tick" data-live-search="true" name="org_type" data-show-subtext="true" data-dropup-auto='false'>
                                                            <option >NGO</option>
                                                            <option >Private Limited</option>
                                                            <option >Partnership Firm</option>
                                                            <option >Proprietorship</option>
                                                            <option >Limited Company</option>
                                                            <option >One Person Company</option>
                                                            <option >LLP</option>
                                                            <option >LLC</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            
                                                <div class="col-sm-3">
                                                    <label for="org_name">Organization ID / Registration No *</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Organization ID"  name="org_id">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="offer_date">SLA Start Date</label>
                                                    <div class="form-group form-float date_picker">
                                                        <input type="text" class="form-control date_datepicker" placeholder="SLA Start Date"  name="sla_date">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4"></div>
                                               
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="panel panel-primary">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title"> <a role="button" href="#collapseTwo" onclick="return false" aria-expanded="true" aria-controls="collapseTwo">CEO/Head of the Organization Details</a> </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                                        <div class="panel-body">
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="ceo_name">CEO/Head's Name</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Name"  name="ceo_name">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="aadhaar_no">Aadhaar *</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="Enter Aadhaar No" name="aadhaar_no" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="ceo_email">CEO/Head's Email Address</label>
                                                    <div class="form-group form-float">
                                                        <input type="email" class="form-control" placeholder="Email"  name="ceo_email">
                                                    </div>
                                                </div>
                                               
                                            </div>
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-3">
                                                    <label for="ceo_mobile">CEO/Head's Mobile Number</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Mobile"  name="ceo_mobile">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="gender">Gender *</label>
                                                    <div class="form-group form-float">
                                                        <select class="form-control show-tick" data-live-search="true" name="gender" data-dropup-auto='false' required>
                                                            <option value="male">Male</option>
                                                            <option value="female">Female</option>
                                                            <option value="other">Other</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="ceo_name">Designation</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Designation"  name="ceo_designation">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="ceo_mobile">Landline Number</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Landline"  name="ceo_landline">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            {{-- <div class="row">
                                                <div class="col-sm-6">
                                                    <button type="button" onclick="validatedata('collapseTwo,collapseOne');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Previous</button>
                                                </div>
                                                <div class="col-sm-6 text-right">
                                                    <button type="button" onclick="validatedata('collapseTwo,collapseThree');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-right"></span> Next</button>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab" id="headingThree">
                                            <h4 class="panel-title"> <a role="button" href="#collapseThree" onclick="return false" aria-expanded="true" aria-controls="collapseThree">Single Point of Contact (SPOC)</a> </h4>
                                        </div>
                                        <div id="collapseThree" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                                            <div class="panel-body">
                                                <div class="row d-flex justify-content-around">
                                                    <div class="col-sm-4">
                                                        <label for="ceo_name">SPOC Name</label>
                                                        <div class="form-group form-float">
                                                            <input type="text" class="form-control" placeholder="SPOC Name"  name="spoc_name">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label for="aadhaar_no">SPOC Aadhaar *</label>
                                                        <div class="form-group form-float">
                                                            <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="Enter Aadhaar No" name="spoc_aadhaar_no" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label for="ceo_email">SPOC Email Address</label>
                                                        <div class="form-group form-float">
                                                            <input type="email" class="form-control" placeholder="Email"  name="spoc_email">
                                                        </div>
                                                    </div>
                                                   
                                                </div>
                                                <div class="row d-flex justify-content-around">
                                                    <div class="col-sm-3">
                                                        <label for="ceo_mobile">SPOC Mobile Number</label>
                                                        <div class="form-group form-float">
                                                            <input type="text" class="form-control" placeholder="Mobile"  name="spoc_mobile">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="gender">SPOC Gender *</label>
                                                        <div class="form-group form-float">
                                                            <select class="form-control show-tick" data-live-search="true" name="spoc_gender" data-dropup-auto='false' required>
                                                                <option value="male">Male</option>
                                                                <option value="female">Female</option>
                                                                <option value="other">Other</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="ceo_name">SPOC Designation</label>
                                                        <div class="form-group form-float">
                                                            <input type="text" class="form-control" placeholder="SPOC Designation"  name="spoc_designation">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="ceo_mobile">SPOC Landline Number</label>
                                                        <div class="form-group form-float">
                                                            <input type="text" class="form-control" placeholder="SPOC Landline"  name="spoc_landline">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                {{-- <div class="row">
                                                    <div class="col-sm-6">
                                                        <button type="button" onclick="validatedata('collapseTwo,collapseOne');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Previous</button>
                                                    </div>
                                                    <div class="col-sm-6 text-right">
                                                        <button type="button" onclick="validatedata('collapseTwo,collapseThree');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-right"></span> Next</button>
                                                    </div>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>

                                <div class="panel panel-primary">
                                    <div class="panel-heading" role="tab" id="headingFour">
                                        <h4 class="panel-title"> <a role="button" href="#collapseFour" onclick="return false" aria-expanded="true" aria-controls="collapseFour">Address of The Organization</a> </h4>
                                    </div>
                                    <div id="collapseFour" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingFour" data-parent="#accordion">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="org_address">Address of the Organization</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Organization Address"  name="org_address" >
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="landmark">Post Office *</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Post Office"  name="post_office">
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-6">
                                                    <label for="state">State - District</label>
                                                    <div class="form-group form-float">
                                                        <select class="form-control show-tick" data-live-search="true" name="state_district" data-show-subtext="true" data-dropup-auto='false'>
                                                            {{-- @foreach ($states as $state)
                                                                <option value="{{$state->id}}"  data-subtext="{{ $state->state }}">{{ $state->district }}</option>
                                                            @endforeach --}}
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="parliament">Parliament Constituency</label>
                                                    <div class="form-group form-float">
                                                        <select class="form-control show-tick" data-live-search="true" name="parliament" data-show-subtext="true">
                                                            {{-- @foreach ($parliaments as $parliament)
                                                                <option value="{{$parliament->id}}"  data-subtext="{{ $parliament->state_ut }}">{{ $parliament->constituency }}</option>
                                                            @endforeach --}}
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="city">City/Town/Village</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="City/Town/Village"  name="city" >
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="block">Sub-District</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Sub-District"  name="sub_district" >
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="pin">PIN code </label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="PIN Code"  name="pin" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 text-right">
                                                    <button type="submit" id="submit_form" class="btn btn-primary"><span class="glyphicon glyphicon-cloud-upload"></span> SUBMIT</button>
                                                </div>
                                            </div>
                                            
                                            {{-- <div class="row">
                                                <div class="col-sm-6">
                                                    <button type="button" onclick="validatedata('collapseFour,collapseThree');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Previous</button>
                                                </div>
                                                <div class="col-sm-6 text-right">
                                                    <button type="button" onclick="validatedata('collapseFour,collapseFive');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-right"></span> Next</button>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('page-script')





<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/partner/jquery.repeatable.js')}}"></script>
{{-- <script src="{{asset('assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js')}}"></script> --}}
<script src="{{asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>

<script src="{{asset('assets/plugins/jquery-steps/jquery.steps.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-notify/bootstrap-notify.js')}}"></script>

<script src="{{asset('assets/js/pages/forms/form-wizard.js')}}"></script>
<script src="{{asset('assets/js/pages/common/notifications.js')}}"></script>
<script src="{{asset('assets/js/scpwd-common.js')}}"></script>



<script type="text/javascript">
    $(function () {
    
        /* Intializing Bootstrap DatePicker */
        
            
            $('.date_picker .form-control').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy',
                endDate: new Date()
            });
        
        /* End Bootstrap DatePicker */
        
    });
/* Custom Valiadtions */    
    
    jQuery("#form2").validate({
            rules: {
            mobile: { mobile: true },
            "[type=email]": { email: true }
            }
        });
    
    /* End Custom Valiadtions */

    
    
</script>
@endsection
