@extends('layout.master')
@section('title', 'Add Assessor for Certification')
@section('parentPageTitle', 'TOT-TOA')
@section('page-style')
<!-- Custom Css -->
<link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/animate-css/animate.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}">

<link rel="stylesheet" href="{{asset('assets/css/color_skins.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
<style>
.datepicker-inline {
    width: 100%;
}
.datepicker table {
    width: 100%;
}

</style>
@stop
@section('content')
<div class="container-fluid home">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header d-flex justify-content-between">
                    <h2><strong>Add</strong> Assessor</h2>
                   <a class="btn btn-primary btn-round waves-effect" href="{{route('admin.tot-toa.assessors')}}">Registered Assessors</a>
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
                    <form id="form_assessor" method="POST" action="{{ route('admin.tot-toa.addassessorcert.submit') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title"> <a role="button" href="#collapseOne" onclick="return false" aria-expanded="true" aria-controls="collapseOne"> Identity </a> </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="panel-body">
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-4">
                                                <label for="state_district">State District of Assessor <span style="color:red"> <strong>*</strong></span></label>
                                                <div class="form-group form-float">
                                                    <select id="state_district" class="form-control show-tick" name="state_district" data-live-search="true" data-dropup-auto='false' required>
                                                        @foreach ($states as $state)
                                                            <option value="{{$state->id}}">{{ $state->district.' ('.$state->state.')' }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4" id="doc_type_div" style="display: none;">
                                                <label for="doc_type">Document Type <span style="color:red"> <strong>*</strong></span></label>
                                                <div class="form-group form-float">
                                                    <select class="form-control show-tick" name="doc_type" data-dropup-auto='false' required>
                                                        <option value="1">Aadhaar</option>
                                                        <option value="0">Voter</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label id="doc_label" for="doc_no">Aadhaar No <span style="color:red"> <strong>*</strong></span></label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="Enter Assessor's Aadhaar Number" name="doc_no" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 text-right">
                                                <button type="button" id="btnOne" onclick="validatedata('collapseOne,collapseTwo');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-right"></span> Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingTwo">
                                    <h4 class="panel-title"> <a role="button" href="#collapseTwo" onclick="return false" aria-expanded="true" aria-controls="collapseTwo">Assessor Basic Details</a> </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="panel-body">
                                        <div class="card body field-group">
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="salutation">Salutation <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <select id="salutation" class="form-control show-tick" name="salutation" data-dropup-auto='false' required>
                                                            <option value="Mr.">Mr</option>
                                                            <option value="Miss.">Miss</option>
                                                            <option value="Mrs.">Mrs</option>
                                                            <option value="Dr.">Dr</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="name">Assessor Name <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Assessor Name" value="{{ old('name') }}" name="name" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="gender">Gender <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <select id="gender" class="form-control show-tick" name="gender" data-dropup-auto='false' required>
                                                            <option>Male</option>
                                                            <option>Female</option>
                                                            <option>Transgender</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" row d-flex ustifycontent-center">
                                                <div class="col-sm-4">
                                                    <label for="mobile">Assessor Mobile <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Assessor Mobile" value="{{ old('mobile') }}" name="mobile" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="landline">Landline <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Landline" value="{{ old('landline') }}" name="landline" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="email">Assessor Email <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="email" class="form-control" placeholder="Assessor Email" value="{{ old('email') }}" name="email" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="dob">Date of Birth<span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float datepicker">
                                                        <input type="text" class="form-control" placeholder="Date of Birth" value="{{ old('dob') }}" name="dob" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="is_pwd">Is Assessor PWD <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <select id="is_pwd" class="form-control show-tick" name="is_pwd" onchange="toggleThis('disability')" data-dropup-auto='false' required>
                                                            <option value="1">Yes</option>
                                                            <option value="0">No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4" id="disability">
                                                    <label for="disability">Type of Disability <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <select class="form-control show-tick" name="disability" data-dropup-auto='false' required>
                                                            @foreach ($disabilities as $disability)
                                                                <option>{{$disability->expository}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex justify-content-center">
                                                <div class="col-sm-6">
                                                    <label for="domain_cert_no">Domain Certificate No (if Present)</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Domain Certificate No" value="{{ old('domain_cert_no') }}" name="domain_cert_no">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="domain_ssc_doc">Upload Domain SSC Certificate (if Present)</label>
                                                    <div class="form-group form-float">
                                                        <input type="file" class="form-control" name="domain_ssc_doc">
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <h6 class="d-flex justify-content-center" style="color:blue">CONTACT PERSON WITH ADDRESS</h6> <br>
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="g_name">Guardian Name<span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Guardian Name" value="{{ old('g_name') }}" name="g_name" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="g_type">Guardian Type <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <select id="g_type" class="form-control show-tick" name="g_type" data-dropup-auto='false' required>
                                                            <option>Father</option>
                                                            <option>Mother</option>
                                                            <option>Husband</option>
                                                            <option>Wife</option>
                                                            <option>Uncle/Aunt</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="city">Village/Town/City <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Name of Village/Town/City" value="{{ old('city') }}" name="city" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="pin">Pin<span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Pin" value="{{ old('pin') }}" name="pin" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-8">
                                                    <label for="address">Assessor Address <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Full Address" value="{{ old('address') }}" name="address" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <button type="button" onclick="validatedata('collapseTwo,collapseOne');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Previous</button>
                                            </div>
                                            <div class="col-sm-6 text-right">
                                                <button type="button" id="btnTwo" onclick="validatedata('collapseTwo,collapseThree');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-right"></span> Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingThree">
                                    <h4 class="panel-title"> <a role="button" href="#collapseThree" onclick="return false" aria-expanded="true" aria-controls="collapseThree">Domain, Certification, Qualification Section</a> </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="panel-body">
                                        <div class="card body field-group">
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-6">
                                                    <label for="aa_name">Current Agency<span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <select class="form-control show-tick" name="aa_name" data-dropup-auto='false' required>
                                                            <option value="">None</option>
                                                            @foreach ($agencies as $agency)
                                                                <option value="{{$agency->id}}">{{$agency->agency_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="doa_curr_aa">Appointment date as an Assessor (with the Present Employer)<span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control date_picker" placeholder="Appointment Date" value="{{ old('doa_curr_aa') }}" name="doa_curr_aa" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row d-flex justify_content_center">
                                                <div class="col-sm-6">
                                                    <label for="job_type">Job Type <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <select class="form-control show-tick" name="job_type" data-dropup-auto='false' required>
                                                            <option>Fulltime</option>
                                                            <option>Freelancer</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="state_loc_employment">State - Location of Employment<span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <select class="form-control show-tick" name="state_loc_employment" data-dropup-auto='false' required>
                                                            @foreach ($states as $state)
                                                                <option value="{{$state->id}}">{{ $state->district.' ('.$state->state.')' }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                         
                                            <div class="row d-flex justify-content-around">     
                                                <div class="col-sm-4">
                                                    <label for="qualification">Qualification <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <select class="form-control show-tick form-group" id="qualification" name="qualification" data-live-search="true" required >
                                                            @foreach (Config::get('constants.qualifications') as $qualification)
                                                                <option>{{$qualification}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="industry_exp">Industry Experience<span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Industry Experience" value="{{ old('industry_exp') }}" name="industry_exp" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="assessing_exp">Assessing Experience<span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Assessing Experience" value="{{ old('assessing_exp') }}" name="assessing_exp" required>
                                                    </div>
                                                </div>
                                            </div>
                                                
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="sector">Sector<span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Sector" value="{{ old('sector') }}" name="sector" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="sub_sector">Sub Sector<span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Sub Sector" value="{{ old('sub_sector') }}" name="sub_sector" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="domain_job">Domain Job Role<span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Domain Job Role" value="{{ old('domain_job') }}" name="domain_job" required>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="domain_job_code">Domain Job Role Code<span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Domain Job Role Code" value="{{ old('domain_job_code') }}" name="domain_job_code" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="nsqf">Domain job role NSQF level<span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="NSQF Level" value="{{ old('nsqf') }}" name="nsqf" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="no_batch_assessed">No. of Batches Assessed on the Domain job Role<span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Domain Job Role Code" value="{{ old('no_batch_assessed') }}" name="no_batch_assessed" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <button id="last_prev_btn" type="button" onclick="validatedata('collapseThree,collapseTwo');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Previous</button>
                                            </div>
                                            <div class="col-sm-6 text-right">
                                                <button type="submit" id="submit_form" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-right"></span> SUBMIT</button>
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
@endsection
@section('page-script')
<script>
    /* Validation of Each Sections */

    function validatedata(divs){
        div = divs.split(',');
        let tag = true;
        var fields = document.querySelectorAll('#'+div[0]+' input[required], #'+div[0]+' select[required]');
        fields.forEach(function (field) {
        if (!$("[name='"+ field.name +"']").valid()) {
                tag = false;
                return false;
            }
        });

        if (tag) {
            var swalText = document.createElement("div");
            switch (div[0]) {
                case 'collapseOne':
                    var ajaxresponse = true;
                    var doc_no = $('[name=doc_no]').val();
                    $("#btnOne").prop("disabled", true);
                    $("#btnOne").html("Please Wait...");
                    var _token = $('[name=_token]').val();
                    let tag = 0;
                    var dataValidate = { _token, doc_no, tag };
                    $.ajax({
                        url: "{{ route('admin.tot-toa.redundant.api') }}",
                        method: "POST",
                        data: dataValidate,
                        success: function(data){
                            
                            if (data.success) {
                                $('#'+div[0]).collapse('hide');
                                $('#'+div[0]).on('hidden.bs.collapse', function () {
                                    $('#'+div[1]).collapse('show');
                                });
                            } else {
                                swalText.innerHTML = data.message;
                                // swalText.innerHTML = 'This Aadhaar/Voter Number is Already <span style="color:blue">Registered</span> with Someone Else'; 
                                swal({title: "Abort", content: swalText, icon: "error", closeModal: true,timer: 4000, buttons: false});

                                $("#btnOne").prop("disabled", false);
                                $("#btnOne").html('<span class="glyphicon glyphicon-arrow-right"></span> Next');
                            }
                        },
                        error: function(){
                            swalText.innerHTML = 'Something went Wrong, Please Try Again';
                            swal({title: "Abort", content: swalText, icon: "error", closeModal: true,timer: 3000, buttons: false}).then(()=>location.reload());
                        }
                    });
                    break;
                case 'collapseTwo':
                    var ajaxresponse = true;
                    var mobile = $('[name=mobile]').val();
                    var email = $('[name=email]').val();
                    $("#btnTwo").prop("disabled", true);
                    $("#btnTwo").html("Please Wait...");
                    var _token = $('[name=_token]').val();
                    var dataValidate = { _token, mobile, email };
                    var SwalResponse = document.createElement("div");
                    $.ajax({
                        url: "{{ route('admin.tot-toa.redundant.api') }}",
                        method: "POST",
                        data: dataValidate,
                        success: function(data){
                            if (data.success) {
                                $('#'+div[0]).collapse('hide');
                                $('#'+div[0]).on('hidden.bs.collapse', function () {
                                    $('#'+div[1]).collapse('show');
                                });
                            } else {
                                swalText.innerHTML = data.message; 
                                swal({title: "Abort", content: swalText, icon: "error", closeModal: true,timer: 4000, buttons: false});

                                $("#btnTwo").prop("disabled", false);
                                $("#btnTwo").html('<span class="glyphicon glyphicon-arrow-right"></span> Next');
                            }
                        },
                        error: function(){
                            swalText.innerHTML = 'Something went Wrong, Please Try Again';
                            swal({title: "Abort", content: swalText, icon: "error", closeModal: true,timer: 3000, buttons: false}).then(()=>location.reload());
                        }
                    });
                    break;

                    $('#'+div[0]).collapse('hide');
                    $('#'+div[0]).on('hidden.bs.collapse', function () {
                        $('#'+div[1]).collapse('show');
                    });
                    break;
            
                default:
                    break;
                }
        }
    }

    /* End Validation of Each Sections */

    /* Form Submit Function */
    
        $('#form_assessor').submit(function(e){
            e.preventDefault();
            if ($('#form_assessor').valid()) {    
                /* Disabling Prev & Submit Button and Proceed to Submit */
                
                    $("#submit_form").prop("disabled", true);
                    $("#last_prev_btn").prop("disabled", true);
                    $("#submit_form").html("Please Wait...");
                    $(this).unbind().submit();
                
                /* End Disabling Prev & Submit Button and Proceed to Submit */
            }
        });
        
    /* End Form Submit Function */

</script>


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

    /* Custom Valiadtions */    
    
        jQuery("#form_assessor").validate({
            rules: {
            mobile: { mobile: true },
            doc_no: { aadhaar: true },
            pin: { pin: true },
            "[type=email]": { email: true }
            }
        });
    
    /* End Custom Valiadtions */

    /* On Load Functions */
    $(function(){

        $('.datepicker .form-control').datepicker({
            autoclose: true,
            format: 'dd MM yyyy',
        });
        $('.date_picker').datepicker({
            autoclose: true,
            format: 'dd MM yyyy',
        });


        $('#state_district').on('change', function(){
        val = "{{Config::get('constants.statedistricts')}}";
        
        if ($.parseJSON(val).find(v => v == $('#state_district').val()) === undefined) {
            $('#doc_label').html('Aadhaar No <span style="color:red"> <strong>*</strong></span>');
            $('[name=doc_no]').rules('add', {aadhaar: true});  
            $('[name=doc_no]').attr("placeholder", "Enter Assessor's Aadhaar Number");
            $('#doc_type_div').hide();
        } else {
            $('#doc_label').html('Aadhaar or Voter No <span style="color:red"> <strong>*</strong></span>');
            $('[name=doc_no]').rules('remove', 'aadhaar');
            $('[name=doc_no]').attr("placeholder", "Enter Assessor's Aadhaar or Voter Number");            
            $('#doc_type_div').show();
        }
        });
    });
/* End On Load Functions */

    function toggleThis(t){
        $('#'+t).toggle('slide');
    }

</script>
@endsection