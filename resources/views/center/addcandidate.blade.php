@extends('layout.master')
@section('title', 'Add Candidate')
@section('page-style')
<!-- Custom Css -->
<link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">

<link href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">
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
                    <h2><strong>Add</strong> Candidate</h2>
                   <a class="btn btn-primary btn-round waves-effect" href="{{route('center.candidates')}}">My Candidates</a>                      
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
                    <form id="form_candidate" method="POST" action="{{ route('center.submitcandidate') }}" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="0">
                        @csrf
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title"> <a role="button" href="#collapseOne" onclick="return false" aria-expanded="true" aria-controls="collapseOne"> Identity </a> </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="panel-body">
                                        
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-5">
                                                <label for="state_district">Choose State District of Candidate <span style="color:red"> <strong>*</strong></span></label>
                                                <div class="form-group form-float">
                                                    <select id="state_district" class="form-control show-tick" name="state_district" data-live-search="true" data-dropup-auto='false' required>
                                                        @foreach ($states as $state)
                                                            <option value="{{$state->id}}">{{ $state->district.' ('.$state->state.')' }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <label id="doc_label" for="doc_no">Aadhaar Number <span style="color:red"> <strong>*</strong></span></label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="Enter Candidate's Aadhaar Number" name="doc_no" required>
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
                                    <h4 class="panel-title"> <a role="button" href="#collapseTwo" onclick="return false" aria-expanded="true" aria-controls="collapseTwo">Candidate Basic Details</a> </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="panel-body">
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-3">
                                                <label for="name">Candidate Name <span style="color:red"> <strong>*</strong></span></label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="Candidate Name" value="{{ old('name') }}" name="name" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="contact">Candidate Contact <span style="color:red"> <strong>*</strong></span></label>
                                                <div class="form-group form-float">
                                                    <input type="number" class="form-control" placeholder="Candidate Contact" value="{{ old('contact') }}" name="contact" required>
                                                    <span id="contact_error" style="color:red"></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="email">Candidate Email <span style="color:red"> <strong>*</strong></span></label>
                                                <div class="form-group form-float">
                                                    <input type="email" class="form-control" placeholder="Candidate Email" value="{{ old('email') }}" name="email" required>
                                                    <span id="email_error" style="color:red"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-3">
                                                <label for="gender">Gender <span style="color:red"> <strong>*</strong></span></label>
                                                <div class="form-group form-float">
                                                    <select class="form-control selectpicker" data-live-search="true" name="gender" data-dropup-auto='false' required>
                                                        <option disabled selected value> -- select an option -- </option>
                                                        <option>Male</option>
                                                        <option>Female</option>
                                                        <option>Transgender</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="mobile">Date of Birth <span style="color:red"> <strong>*</strong></span></label>
                                                <div class="form-group form-float date_picker">
                                                    <input type="text" class="form-control" placeholder="Candidate's Date of Birth" name="dob" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="m_status">Marital Status <span style="color:red"> <strong>*</strong></span></label>
                                                <div class="form-group form-float">
                                                    <select class="form-control show-tick" data-live-search="true" name="m_status" data-dropup-auto='false' required>
                                                        <option disabled selected value> -- select an option -- </option>
                                                        <option>Married</option>
                                                        <option>Unmarried</option>
                                                        <option>Divorcee</option>
                                                        <option>Widow/Widower</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-sm-6">
                                                <label for="doc_file">Aadhaar / Voter Document <span style="color:red"> <strong>*</strong></span></label>
                                                <div class="form-group form-float">
                                                    <input type="file" id="doc_file" class="form-control" name="doc_file" required>
                                                    <span id="doc_file_error"  style="color:red;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-end">
                                            <div class="col-sm-6 d-flex justify-content-end">
                                                <button type="button" id="btnTwo" onclick="validatedata('collapseTwo,collapseThree');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-right"></span> Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingThree">
                                    <h4 class="panel-title"> <a role="button" href="#collapseThree" onclick="return false" aria-expanded="true" aria-controls="collapseThree">Candidate Other Details</a> </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="panel-body">
                                        <div class="card body field-group">
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-6">
                                                    <label for="job">Sector / Job Role / NSQF / QP Code <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <select id="job" class="form-control show-tick" data-live-search="true" name="job" onchange="updatejob()" data-dropup-auto='false' required>
                                                            @foreach ($center->center_jobroles as $centerjob)
                                                                @if ($centerjob->partnerjobrole->status)
                                                                    <option value="{{$centerjob->id}}">{{$centerjob->partnerjobrole->sector->sector .' | '. $centerjob->partnerjobrole->jobrole->job_role .' | '. $centerjob->partnerjobrole->jobrole->nsqf_level .' | '. $centerjob->partnerjobrole->jobrole->qp_code}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="d_type">Disability Type <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <select id="d_type" class="form-control show-tick" data-live-search="true" name="d_type" data-dropup-auto='false' required>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="d_cert">Upload Disability Certificate <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="file" id="d_cert" class="form-control" name="d_cert" required>
                                                        <span id="d_cert_error"  style="color:red;"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-12">
                                                    <label for="address">Address <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Candidate's Address" value="{{ old('address') }}" name="address" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4"> 
                                                    <label for="category">Category <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <select id="category" class="form-control show-tick" name="category" data-dropup-auto='false' required>
                                                            <option>SC</option>
                                                            <option>ST</option>
                                                            <option>OBC</option>
                                                            <option>General</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="service">Ex Serviceman <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <select id="service" class="form-control show-tick" name="service" data-dropup-auto='false' required>
                                                            <option>No</option>
                                                            <option>Yes</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="education">Education <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <select class="form-control show-tick form-group" id="education" name="education" data-live-search="true" required >
                                                            @foreach (Config::get('constants.qualifications') as $qualification)
                                                                <option>{{$qualification}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="g_name">Guardian Name <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Name of the Guardian" value="{{ old('g_name') }}" name="g_name" required>
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
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="repeatable-container"></div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <button id="last_prev_btn" type="button" onclick="validatedata('collapseThree,collapseTwo');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Previous</button>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group text-center">
                                                    <div class="checkbox">
                                                        <input id="terms" name="terms" type="checkbox">
                                                        <label for="terms">I Accept All the <a href="#TermsModal" data-toggle="modal" data-target="#TermsModal">Terms & Conditions </a></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 text-right">
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
@section('modal')
    <div class="modal fade" id="TermsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="title" id="TermsModalLabel">Company Terms & Conditions</h4>
                </div>
                <div class="modal-body">
                    {{Config::get('constants.declaration')}}
                </div>
            </div>
        </div>
    </div>
@stop
@section('page-script')
<script>

    /* Onload Function */
    $(() => {
        updatejob();
        filevalidate();
    });
    /* End Onload Function */



    /* Ajax Call */
        // function callapi(dataValidate,swalText,div) {
            
        // }
    /* End Ajax Call */


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
            switch (div[0]) {
                case 'collapseOne':
                    // var ajaxresponse = true;
                    var doc_no = $('[name=doc_no]').val();
                
                    $("#btnOne").prop("disabled", true);
                    $("#btnOne").html("Please Wait...");
                    var _token = $('[name=_token]').val();
                    var dataValidate = { _token, doc_no };
                    var swalText = document.createElement("div");
                    // callapi(dataValidate,swalText,div);
                    $.ajax({
                        url: "{{ route('center.addcandidate.api') }}",
                        method: "POST",
                        data: dataValidate,
                        success: function(data){
                            
                            if (!data.success) {
                                $("#btnOne").prop("disabled", false);
                                $("#btnOne").html("<span class='glyphicon glyphicon-arrow-right'></span> Next");
                                swalText.innerHTML = data.message;
                                swal({title: "Attention", content: swalText, icon: 'error', closeModal: true,timer: 4000, buttons: false});
                            } else {
                                if (data.candidate != null) {
                                    $('[name=name]').val(data.candidate.name);
                                    $('[name=contact]').val(data.candidate.contact);
                                    $('[name=email]').val(data.candidate.email);
                                    $('[name=dob]').val(data.candidate.dob);
                                    $('[name=gender]').val(data.candidate.gender);
                                    $('[name=id]').val(data.candidate.id);
                                    $('.selectpicker').selectpicker('refresh');
                                }
                                $('#'+div[0]).collapse('hide');
                                $('#'+div[0]).on('hidden.bs.collapse', function () {
                                    $('#'+div[1]).collapse('show');
                                });
                            }
                        },
                        error: function(){
                            swalText.innerHTML = 'Something went Wrong, Please Try Again';
                            swal({title: "Abort", content: swalText, icon: 'error', closeModal: true,timer: 4000, buttons: false}).then(()=>{location.reload();});
                        }
                    });
                    break;
                case 'collapseTwo':
                    // var ajaxresponse = true;
                    // var doc_no = $('[name=doc_no]').val();
                
                    var _token = $('[name=_token]').val();
                    let email = $('[name=email]').val();
                    let contact = $('[name=contact]').val();
                    var doc_no = $('[name=doc_no]').val();
                    var dataValidate = {_token, email, contact, doc_no};
                    var swalText = document.createElement("div");

                    $("#btnTwo").prop("disabled", true);
                    $("#btnTwo").html("Please Wait...");
                    $.ajax({
                        url: "{{ route('center.addcandidate.api') }}",
                        method: "POST",
                        data: dataValidate,
                        success: function(data){
                            
                            if (!data.success) {
                                swalText.innerHTML = data.message;
                                swal({title: "Attention", content: swalText, icon: 'error', closeModal: true,timer: 4000, buttons: false});
                            } else {
                                $('#'+div[0]).collapse('hide');
                                $('#'+div[0]).on('hidden.bs.collapse', function () {
                                    $('#'+div[1]).collapse('show');
                                });
                            }
                            $("#btnTwo").prop("disabled", false);
                            $("#btnTwo").html("<span class='glyphicon glyphicon-arrow-right'></span> Next");
                        },
                        error: function(){
                            swalText.innerHTML = 'Something went Wrong, Please Try Again';
                            swal({title: "Abort", content: swalText, icon: 'error', closeModal: true,timer: 4000, buttons: false}).then(()=>{location.reload();});
                        }
                    });

                    break;
                case 'collapseThree':
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

    /* Making Sure That the Terms & Condition is Accepted */
    
        $('#form_candidate').submit(function(e){
            e.preventDefault();
            if ($('#form_candidate').valid()) {
                if ($('input:checkbox', this).length == $('input:checked', this).length) {
                    
                    /* Disabling Prev & Submit Button and Proceed to Submit */
                    
                        $("#submit_form").prop("disabled", true);
                        $("#last_prev_btn").prop("disabled", true);
                        $("#submit_form").html("Please Wait...");
                        var id = $('[name=id]').val();
                        var job = $('[name=job]').val();
                        var _token = $('[name=_token]').val();
                        let swalText = document.createElement("div");
                        var dataString = {_token,id,job}
                        form = this;
                        $.ajax({
                            data:dataString,
                            method: "POST",
                            url: "{{ route('center.addcandidate.api') }}",
                            success: function (data) {
                                if (data.success) {
                                    // console.log('Submit');
                                    
                                    $(form).unbind().submit();
                                } else {
                                    swalText.innerHTML = data.message;
                                    swal({title: "Attention", content: swalText, icon: 'error', closeModal: true,timer: 5000, buttons: false});
                                    $("#submit_form").prop("disabled", false);
                                    $("#last_prev_btn").prop("disabled", false);
                                    $("#submit_form").html("<span class='glyphicon glyphicon-arrow-right'></span> Submit");
                                }
                            },
                            error: function (data) {
                                swalText.innerHTML = 'Something Went Wrong, Please Try Again';
                                swal({title: "Attention", content: swalText, icon: 'error', closeModal: true,timer: 3000, buttons: false}).then(function(){location.reload();});
                            }
                        });
                    
                    /* End Disabling Prev & Submit Button and Proceed to Submit */
                

                } else {
                    showNotification('danger','Please Accept the Terms & Conditions','top','center','wobble','zoomOut',0,250);
                }
            }
        });
        
    /* End Making Sure That the Terms & Condition is Accepted */

    /* Fetch SelectPicker Data */

        function updatejob(){
            var _token = $('[name=_token]').val();
            var jobid = $("#job :selected").val();
            if (jobid != undefined) {
                $.ajax({
                    url: "{{ route('center.addcandidate.api') }}",
                    method: "POST",
                    data: { _token, jobid },
                    success: function(data){
                        if (data.success) {
                            $('#d_type').empty();
                            data.disabilities.forEach(value => {
                                $('#d_type').append('<option value="'+value.id+'">'+value.e_expository+'</option>');
                            });
                            $('#d_type').selectpicker('refresh');
                        } else {
                            swal('Abort','Something went Wrong, Please Try Again','error').then((value) => {location.reload();} );
                        }
                        
                    } 
                });
            }            
        }

    /* End Fetch SelectPicker Data */

    /* File Type Validation */
        function filevalidate(){
            var _URL = window.URL || window.webkitURL;
            $("[type='file']").change(function(e) {
            var image, file;
            for (var i = this.files.length - 1; i >= 0; i--) {
                if ((file = this.files[i])) {
                    size = Math.round((file.size/1024/1024) * 100) / 100; // Size in MB
                    image = new Image();
                    var fileType = file["type"];
                    var ValidImageTypes = ["image/jpg", "image/jpeg", "image/png", "application/pdf"];
                    if ($.inArray(fileType, ValidImageTypes) < 0) {
                        $("#"+e.currentTarget.id).val('');
                        $("#" + e.currentTarget.id + "_error").text('File must be in jpg, jpeg, png or pdf Format');
                    } else {
                        $("#" + e.currentTarget.id + "_error").text('');
                    }
                    image.onload = function() {
                        if (size > 5) {
                            $("#"+e.currentTarget.id).val('');
                            $("#" + e.currentTarget.id + "_error").text('File Size is Exceeding the limit of 5 MB');
                        } else {
                            $("#" + e.currentTarget.id + "_error").text('');
                        }
                    };
                    image.src = _URL.createObjectURL(file);
                }
            }
            });
        }
    /* End File Type Validation */

</script>

<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/js/jquery.repeatable.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-notify/bootstrap-notify.js')}}"></script>
<script src="{{asset('assets/js/pages/common/notifications.js')}}"></script>
<script src="{{asset('assets/js/scpwd-common.js')}}"></script>

<script>

$(function () {
    
    /* Intializing Bootstrap DatePicker */
    
        $('.date_picker .form-control').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy',
            endDate: '-14y'
        });
    
    /* End Bootstrap DatePicker */
    
});

/* Custom Valiadtions */    

    jQuery("#form_candidate").validate({
        rules: {
        contact: { mobile: true },
        doc_no: { aadhaarvoter: true },
        "[type=email]": { email: true }
        }
    });

/* End Custom Valiadtions */

/* State District Checks */
    $(function(){
        $('#state_district').on('change', function(){
        val = "{{Config::get('constants.statedistricts')}}";
        
        if ($.parseJSON(val).find(v => v == $('#state_district').val()) === undefined) {
            $('#doc_label').html('Aadhaar Number <span style="color:red"> <strong>*</strong></span>');
            $('[name=doc_no]').rules('remove', 'aadhaarvoter');  
            $('[name=doc_no]').rules('add', {aadhaar: true});  
            $('[name=doc_no]').attr("placeholder", "Enter Candidate's Aadhaar Number");
        } else {
            $('#doc_label').html('Aadhaar Number or Voter Number <span style="color:red"> <strong>*</strong></span>');
            $('[name=doc_no]').rules('remove', 'aadhaar');  
            $('[name=doc_no]').rules('add', {aadhaarvoter: true});  
            $('[name=doc_no]').attr("placeholder", "Enter Candidate's Aadhaar or Voter Number");            
        }
        });
    })
/* End State District Checks */

</script>
@endsection