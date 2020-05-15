@extends('layout.master')
@section('title', 'Agency Registration')
@section('page-style')
<link href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/animate-css/animate.css')}}">

{{-- <link rel="stylesheet" href="../assets/plugins/bootstrap/css/bootstrap.min.css"> --}}
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}">
<!-- Custom Css -->
<link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/color_skins.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
@stop
@section('content')
<div class="container-fluid home">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header d-flex justify-content-between">
                    <h2><strong>Agency</strong> Registration</h2>
                <a class="btn btn-primary btn-round waves-effect" href="{{route('admin.agency.agencies')}}">My Agencies</a> 
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
                    <form id="form_agency" method="POST" action="{{route('admin.aa.insert-agency')}}">
                            @csrf
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab" id="headingThree">
                                            <h4 class="panel-title "> <a role="button" href="#collapseOne" onclick="return false" aria-expanded="true" aria-controls="collapseOne"><span style="color:blue">Single Point of Contact (SPOC)</span></a> </h4>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                                            <div class="panel-body">
                                                <div class="row d-flex justify-content-around">
                                                    <div class="col-sm-4">
                                                        <label for="name">SPOC Name <span style="color:red"> <strong>*</strong></span></label>
                                                        <div class="form-group form-float">
                                                            <input type="text" class="form-control" placeholder="SPOC Name"  name="name" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label for="aadhaar">SPOC Aadhaar <span style="color:red"> <strong>*</strong></span></label>
                                                        <div class="form-group form-float">
                                                            <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" onchange="checkduplicacy('aadhaar')" placeholder="Enter Aadhaar No" name="aadhaar" required>
                                                            <span id="aadhaar_error" style="color:red"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label for="spoc_email">SPOC Email Address <span style="color:red"> <strong>*</strong></span></label>
                                                        <div class="form-group form-float">
                                                            <input type="email" class="form-control" placeholder="Email" onchange="checkduplicacy('email')" name="email" required>
                                                            <span id="email_error" style="color:red"></span>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="row d-flex justify-content-around">
                                                    <div class="col-sm-3">
                                                        <label for="spoc_mobile">SPOC Mobile Number <span style="color:red"> <strong>*</strong></span></label>
                                                        <div class="form-group form-float">
                                                            <input type="text" class="form-control" placeholder="Mobile" onchange="checkduplicacy('mobile')" name="mobile" required>
                                                            <span id="mobile_error" style="color:red"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="gender">SPOC Gender <span style="color:red"> <strong>*</strong></span></label>
                                                        <div class="form-group form-float">
                                                            <select class="form-control show-tick" data-live-search="true" name="gender" data-dropup-auto='false' required>
                                                                <option>Male</option>
                                                                <option>Female</option>
                                                                <option>Transgender</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="designation">SPOC Designation <span style="color:red"> <strong>*</strong></span></label>
                                                        <div class="form-group form-float">
                                                            <input type="text" class="form-control" placeholder="Designation"  name="designation" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="landline">SPOC Landline Number</label>
                                                        <div class="form-group form-float">
                                                            <input type="text" class="form-control" placeholder="Landline No"  name="landline">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                <div class="panel panel-primary">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title"> <a role="button" href="#collapseTwo" onclick="return false" aria-expanded="true" aria-controls="collapseTwo"><span style="color:blue"> General Information </span></a> </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="panel-body">
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-3">
                                                    <label for="agency_name">Assessment Agency Name <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Name of the Agency"  name="agency_name" required>
                                                       
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="org_type">Type of Oganization</label>
                                                    <div class="form-group form-float">
                                                        <select class="form-control show-tick" data-live-search="true" name="org_type" data-show-subtext="true" data-dropup-auto='false' required>
                                                            @foreach (Config::get('constants.organizations') as $organizations)
                                                                <option>{{$organizations}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            
                                                <div class="col-sm-3">
                                                    <label for="org_id">Organization ID / Registration No <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Organization ID"  name="org_id" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="sla_date">SLA Start Date <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float date_picker">
                                                        <input type="text" class="form-control date_datepicker" placeholder="SLA Start Date" id="sla_date" name="sla_date" onchange="yearAdd()" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="sla_end_date">SLA End Date <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float ">
                                                        <input type="text" class="form-control" placeholder="SLA End Date"  id="sla_end_date" name="sla_end_date" readonly required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="sector">Sector <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <select class="form-control show-tick" data-live-search="true" name="sector[]"  data-dropup-auto='false' multiple required>
                                                            @foreach ($sectors as $sector)
                                                                <option value="{{$sector->id}}" >{{ $sector->sector }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                               
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="panel panel-primary">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title"> <a role="button" href="#collapseThree" onclick="return false" aria-expanded="true" aria-controls="collapseThree"><span style="color:blue"> CEO/Head of the Organization Details </span></a> </h4>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                                        <div class="panel-body">
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="ceo_name">CEO/Head's Name <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Name"  name="ceo_name" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="ceo_aadhaar">Aadhaar </label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="Enter Aadhaar No" name="ceo_aadhaar">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="ceo_email">CEO/Head's Email Address <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="email" class="form-control" placeholder="Email"  name="ceo_email" required>
                                                    </div>
                                                </div>
                                               
                                            </div>
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-3">
                                                    <label for="ceo_mobile">CEO/Head's Mobile Number <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Mobile"  name="ceo_mobile" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="ceo_gender">Gender <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <select class="form-control show-tick" data-live-search="true" name="ceo_gender" data-dropup-auto='false' required>
                                                            <option>Male</option>
                                                            <option>Female</option>
                                                            <option>Transgender</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="ceo_designation">Designation <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Designation"  name="ceo_designation" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="ceo_landline">Landline Number</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Landline No"  name="ceo_landline">
                                                    </div>
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div>

                                

                                <div class="panel panel-primary">
                                    <div class="panel-heading" role="tab" id="headingFour">
                                        <h4 class="panel-title"> <a role="button" href="#collapseFour" onclick="return false" aria-expanded="true" aria-controls="collapseFour"><span style="color:blue"> Address of The Organization </span></a> </h4>
                                    </div>
                                    <div id="collapseFour" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingFour" data-parent="#accordion">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="org_address">Address of the Organization <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Organization Address"  name="org_address" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="post_office">Post Office <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Post Office"  name="post_office" required>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-6">
                                                    <label for="state_district">State - District <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <select class="form-control show-tick" data-live-search="true" name="state_district" data-show-subtext="true" data-dropup-auto='false' required>
                                                            @foreach ($states as $state)
                                                                <option value="{{$state->id}}"  data-subtext="{{ $state->state }}">{{ $state->district }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="parliament">Parliament Constituency <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <select class="form-control show-tick" data-live-search="true" name="parliament" data-show-subtext="true" data-dropup-auto='false' required>
                                                            @foreach ($parliaments as $parliament)
                                                                <option value="{{$parliament->id}}"  data-subtext="{{ $parliament->state_ut }}">{{ $parliament->constituency }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="city">City/Town/Village <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="City/Town/Village"  name="city" required >
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="sub_district">Sub-District <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Sub-District"  name="sub_district" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="pin">PIN code <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="PIN Code"  name="pin" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="org_landline">Landline</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Landline No"  name="org_landline"  >
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="website">Website</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Website"  name="website" >
                                                    </div>
                                                </div>
                                               
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 text-right">
                                                    <button type="submit" id="submit_form" class="btn btn-primary"><span class="glyphicon glyphicon-cloud-upload"></span> SUBMIT</button>
                                                </div>
                                            </div>
                                            
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
<script src="{{asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('assets/js/scpwd-common.js')}}"></script>


<script type="text/javascript">
    $(function () {
    
        /* Intializing Bootstrap DatePicker */
        
            $('.date_picker .form-control').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy'
            });
        
        /* End Bootstrap DatePicker */
        
    });
/* Custom Valiadtions */    
    
    jQuery("#form_agency").validate({
            rules: {
                aadhaar: { aadhaar: true },
                website: { website: true },
                ceo_mobile: { mobile: true },
                mobile: { mobile: true },
                pin: { pin: true },
                ceo_aadhaar: { aadhaar: true },
                "[type=email]": { email: true }
            }
        });
    
    /* End Custom Valiadtions */
function yearAdd(){
    var date=$('#sla_date').val();
    if(date!=""){
    var newdate = date.split("-").reverse().join("-");
    var d = new Date(newdate);
    
    var startDate = moment(d, 'DD-MM-YYYY');
    
    var endDate = startDate.clone();
    endDate.add(1, 'years').subtract('1', 'days');
   
    $('#sla_end_date').val(endDate.format('DD-MM-YYYY'));
    
    }
}

/* Check Redundancy */
        var dup_email_tag = false;
        var dup_mobile_tag = false;
        var dup_aadhaar_tag = false;
        function checkduplicacy(val){
        dup_email_tag = true;
        dup_mobile_tag = true;
        dup_aadhaar_tag = true;
            var _token = $('[name=_token]').val();
            
            let value = $('[name='+val+']').val();
           
            let dataString = { checkredundancy : value, section: val, _token: _token};
            $.ajax({
                url: "{{route('admin.aa.agency.api')}}",
                method: "POST",
                data: dataString,
                success: function(data){
                    if (data.success) {
                        $('#'+val+'_error').html('');
                        if (val == 'email') {
                            dup_email_tag = true;
                        } else  if (val == 'mobile'){
                            dup_mobile_tag = true;
                        } else{
                            dup_aadhaar_tag = true;
                        }
                    } else {
                        if(val=='aadhaar'){
                            $('#aadhaar_error').html('Aadhaar already exists');
                            dup_aadhaar_tag = false; 
                        }else if (val=='email') {
                            $('#email_error').html('Email already exists');
                            dup_email_tag = false; 
                        }else if (val=='mobile') {
                            $('#mobile_error').html('Mobile No already exists');
                            dup_mobile_tag = false; 
                        }
                    }
                },

                error:function(data){
                    let swalText = document.createElement("div");
                    swalText.innerHTML = 'Something Went Wrong, Please Try Again'; 
                    swal({title: "Oops!", content: swalText, icon: "error", closeModal: true,timer: 3000, buttons: false}).then(()=>{location.reload()});                    
                } 
            });
        }
    /* End Check Redundancy */

    $('#form_agency').on('submit', function (e) {
        e.preventDefault();
        if ($('#form_agency').valid() && dup_email_tag && dup_mobile_tag && dup_aadhaar_tag) {
           $(this).unbind().submit();
        }
    });
    
</script>
@endsection
