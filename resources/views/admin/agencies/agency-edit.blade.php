@extends('layout.master')
@section('title', 'Agency Update')
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
                    
                <form id="form2" method="POST" action="{{route('admin.aa.update.agency')}}" onsubmit="event.preventDefault();return myFunction2()">
                            @csrf
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-primary">
                                            <div class="panel-heading" role="tab" id="headingThree">
                                                <h4 class="panel-title"> <a role="button" href="#collapseThree" onclick="return false" aria-expanded="true" aria-controls="collapseThree">Single Point of Contact (SPOC)</a> </h4>
                                            </div>
                                            <div id="collapseThree" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                                                <div class="panel-body">
                                                    <div class="row d-flex justify-content-around">
                                                        <div class="col-sm-4">
                                                            <label for="name">SPOC Name <span style="color:red"> <strong>*</strong></span></label>
                                                            <div class="form-group form-float">
                                                            <input type="text" class="form-control" placeholder="SPOC Name" value="{{$agency->name}}" name="name" required>
                                                            <input type="hidden"  value="{{$agency->id}}" name="aa_id" >
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for="aadhaar">SPOC Aadhaar <span style="color:red"> <strong>*</strong></span></label>
                                                            <div class="form-group form-float">
                                                                <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" value="{{$agency->aadhaar}}" onchange="checkduplicacy('aadhaar')" placeholder="Enter Aadhaar No" name="aadhaar" required>
                                                                <span id="aadhaar_error" style="color:red"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for="spoc_email">SPOC Email Address <span style="color:red"> <strong>*</strong></span></label>
                                                            <div class="form-group form-float">
                                                                <input type="email" class="form-control" placeholder="Email" onchange="checkduplicacy('email')" value="{{$agency->email}}" name="email" required>
                                                                <span id="email_error" style="color:red"></span>
                                                            </div>
                                                        </div>
                                                       
                                                    </div>
                                                    <div class="row d-flex justify-content-around">
                                                        <div class="col-sm-3">
                                                            <label for="spoc_mobile">SPOC Mobile Number <span style="color:red"> <strong>*</strong></span></label>
                                                            <div class="form-group form-float">
                                                                <input type="text" class="form-control" placeholder="Mobile" onchange="checkduplicacy('mobile')" value="{{$agency->mobile}}" name="mobile" required>
                                                                <span id="mobile_error" style="color:red"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label for="gender">SPOC Gender <span style="color:red"> <strong>*</strong></span></label>
                                                            <div class="form-group form-float">
                                                                <select class="form-control show-tick" data-live-search="true" name="spoc_gender" data-dropup-auto='false' required>
                                                                    <option {{($agency->spoc_gender=="Male")?'selected':null}}>Male</option>
                                                                    <option {{($agency->spoc_gender=="Female")?'selected':null}}>Female</option>
                                                                    <option {{($agency->spoc_gender=="Transgender")?'selected':null}}>Transgender</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label for="designation">SPOC Designation <span style="color:red"> <strong>*</strong></span></label>
                                                            <div class="form-group form-float">
                                                                <input type="text" class="form-control" placeholder="Designation" value="{{$agency->designation}}" name="designation" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label for="landline">SPOC Landline Number</label>
                                                            <div class="form-group form-float">
                                                                <input type="text" class="form-control" placeholder="Landline No" value="{{$agency->landline}}" name="landline">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                <div class="panel panel-primary">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title"> <a role="button" href="#collapseOne" onclick="return false" aria-expanded="true" aria-controls="collapseOne"> General Information </a> </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="panel-body">
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-3">
                                                    <label for="agency_name">Assessment Agency Name <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Name of the Agency" value="{{$agency->agency_name}}" name="agency_name" required>
                                                       
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="org_type">Type of Oganization</label>
                                                    <div class="form-group form-float">
                                                        <select class="form-control show-tick" data-live-search="true" name="org_type" data-show-subtext="true" data-dropup-auto='false' required>
                                                            @foreach (Config::get('constants.organizations') as $organizations)
                                                                <option {{ ($organizations == $agency->org_type)? 'selected' : null }} >{{$organizations}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            
                                                <div class="col-sm-3">
                                                    <label for="org_id">Organization ID / Registration No <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Organization ID" value="{{$agency->org_id}}" name="org_id" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="sla_date">SLA Start Date <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float date_picker">
                                                        <input type="text" class="form-control date_datepicker" placeholder="SLA Start Date" id="sla_date" name="sla_date" value="{{$agency->sla_date}}" onchange="yearAdd()" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="sla_end_date">SLA End Date <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float ">
                                                        <input type="text" class="form-control" placeholder="SLA End Date"  id="sla_end_date" name="sla_end_date" value="{{$agency->sla_end_date}}" readonly required>
                                                    </div>
                                                </div>
                                               
                                                <div class="col-sm-4">
                                                    <label for="sector">Sector <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <select class="form-control show-tick" data-live-search="true" name="sector[]"  data-dropup-auto='false' multiple required>
                                                            @foreach ($sectors as $sector)
                                                                <option value="{{$sector->id}}"  {{ (in_array($sector->id,$selSector)) ? 'selected' : '' }} >{{ $sector->sector }}</option>
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
                                        <h4 class="panel-title"> <a role="button" href="#collapseTwo" onclick="return false" aria-expanded="true" aria-controls="collapseTwo">CEO/Head of the Organization Details</a> </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                                        <div class="panel-body">
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="ceo_name">CEO/Head's Name <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Name" value="{{$agency->ceo_name}}" name="ceo_name" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="ceo_aadhaar">Aadhaar <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="Enter Aadhaar No" value="{{$agency->ceo_aadhaar}}" name="ceo_aadhaar" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="ceo_email">CEO/Head's Email Address <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="email" class="form-control" placeholder="Email"  name="ceo_email" value="{{$agency->ceo_email}}" required>
                                                    </div>
                                                </div>
                                               
                                            </div>
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-3">
                                                    <label for="ceo_mobile">CEO/Head's Mobile Number <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Mobile"  name="ceo_mobile" value="{{$agency->ceo_mobile}}" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="ceo_gender">Gender <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <select class="form-control show-tick" data-live-search="true" name="gender" data-dropup-auto='false' required>
                                                            <option>Male</option>
                                                            <option>Female</option>
                                                            <option>Transgender</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="ceo_designation">Designation <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Designation"  name="ceo_designation" value="{{$agency->ceo_designation}}" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="ceo_landline">Landline Number</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Landline No"  name="ceo_landline" value="{{$agency->ceo_landline}}" >
                                                    </div>
                                                </div>
                                            </div>
                                           
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
                                                    <label for="org_address">Address of the Organization <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Organization Address"  name="org_address" value="{{$agency->org_address}}" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="post_office">Post Office <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Post Office"  name="post_office" value="{{$agency->post_office}}" required>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-6">
                                                    <label for="state_district">State - District <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <select class="form-control show-tick" data-live-search="true" name="state_district" data-show-subtext="true" data-dropup-auto='false' required>
                                                            @foreach ($states as $state)
                                                                <option value="{{$state->id}}"  data-subtext="{{ $state->state }}" {{($state->id==$agency->state_district) ? 'selected' : ''}}>{{ $state->district }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="parliament">Parliament Constituency <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <select class="form-control show-tick" data-live-search="true" name="parliament" data-show-subtext="true" data-dropup-auto='false' required>
                                                            @foreach ($parliaments as $parliament)
                                                                <option value="{{$parliament->id}}"  data-subtext="{{ $parliament->state_ut }}" {{($parliament->id==$agency->parliament) ? 'selected' : ''}}>{{ $parliament->constituency }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="city">City/Town/Village <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="City/Town/Village"  name="city" value="{{$agency->city}}" required >
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="sub_district">Sub-District <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Sub-District"  name="sub_district" value="{{$agency->sub_district}}" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="pin">PIN code <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="PIN Code"  name="pin" value="{{$agency->pin}}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="org_landline">Landline</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Landline No"  name="org_landline" value="{{$agency->org_landline}}" >
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="website">Website</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Website"  name="website" value="{{$agency->website}}" >
                                                    </div>
                                                </div>
                                               
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 text-right">
                                                    <button type="submit" id="submit_form" class="btn btn-primary"><span class="glyphicon glyphicon-cloud-upload"></span>UPDATE</button>
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
                format: 'dd-mm-yyyy'
            });
        
        /* End Bootstrap DatePicker */
        
    });
/* Custom Valiadtions */    
    
    jQuery("#form2").validate({
            rules: {
                aadhaar: { aadhaar: true },
                website: { website: true },
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
        var dup_email_tag = true;
        var dup_mobile_tag = true;
        var dup_aadhaar_tag = true;
        function checkduplicacy(val){
       
            var _token = $('[name=_token]').val();
            
            let value = $('[name='+val+']').val();
            let aa_id = $('[name=aa_id]').val();
           
            let dataString = { checkredundancy : value, section: val,aa_id:aa_id, _token: _token};
            $.ajax({
                url: "{{route('admin.aa.agency.api')}}",
                method: "POST",
                data: dataString,
                success: function(data){
                       // console.log(data);
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

                        $('#'+val+'_error').html('Aadhaar already exists');
                        }else{

                        $('#'+val+'_error').html(val+' already exists');
                        }
                        if (val == 'email') {
                            dup_email_tag = false;
                        } else  if (val == 'mobile'){
                            dup_mobile_tag = false; 
                        }else{
                            dup_aadhaar_tag = false; 
                        } 
                    }
                },

                error:function(data){
                   // console.log(data);
                    
                    swal('Oops!','Something Went Wrong','error');
                    
                } 
            });
        }
    /* End Check Redundancy */

    function myFunction2(){
         if(dup_email_tag==false ||dup_mobile_tag==false || dup_aadhaar_tag ==false){
           
            return false;
        }
        else{
            var form = document.getElementById("form2");
            form.submit();
            return true;
        }
    }
    
    
</script>
@endsection
