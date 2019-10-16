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
                                                <label for="doc_no">Aadhaar/Voter Number *</label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="Enter Candidate's Aadhaar No or Voter No" name="doc_no" required>
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
                                                <label for="name">Candidate Name *</label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="Candidate Name" value="{{ old('name') }}" name="name" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="contact">Candidate Contact *</label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="Candidate Contact" value="{{ old('contact') }}" onchange="checkduplicacy('contact')" name="contact" required>
                                                    <span id="contact_error" style="color:red"></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="email">Candidate Email *</label>
                                                <div class="form-group form-float">
                                                    <input type="email" class="form-control" placeholder="Candidate Email" value="{{ old('email') }}" onchange="checkduplicacy('email')" name="email" required>
                                                    <span id="email_error" style="color:red"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-around">
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
                                                <label for="mobile">Date of Birth *</label>
                                                <div class="form-group form-float date_picker">
                                                    <input type="text" class="form-control" placeholder="Candidate's Date of Birth" name="dob" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="m_status">Marital Status *</label>
                                                <div class="form-group form-float">
                                                    <select class="form-control show-tick" data-live-search="true" name="m_status" data-dropup-auto='false' required>
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
                                                <label for="doc_file">Aadhaar / Voter Document *</label>
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
                                                    <label for="job">Sector / Job Role / NSQF / QP Code *</label>
                                                    <div class="form-group form-float">
                                                        <select id="job" class="form-control show-tick" data-live-search="true" name="job" onchange="updatejob()" data-dropup-auto='false' required>
                                                            @foreach ($center->center_jobroles as $centerjob)
                                                                @if ($centerjob->status)
                                                                    <option value="{{$centerjob->id}}">{{$centerjob->partnerjobrole->sector->sector .' | '. $centerjob->partnerjobrole->jobrole->job_role .' | '. $centerjob->partnerjobrole->jobrole->nsqf_level .' | '. $centerjob->partnerjobrole->jobrole->qp_code}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="d_type">Disability Type *</label>
                                                    <div class="form-group form-float">
                                                        <select id="d_type" class="form-control show-tick" data-live-search="true" name="d_type" data-dropup-auto='false' required>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="d_cert">Upload Disability Certificate</label>
                                                    <div class="form-group form-float">
                                                        <input type="file" id="d_cert" class="form-control" name="d_cert">
                                                        <span id="d_cert_error"  style="color:red;"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-8">
                                                    <label for="address">Address *</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Candidate's Address" value="{{ old('address') }}" name="address" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="state_district">State District *</label>
                                                    <div class="form-group form-float">
                                                        <select id="state_district" class="form-control show-tick" name="state_district" data-live-search="true" data-dropup-auto='false' required>
                                                            @foreach ($states as $state)
                                                                <option value="{{$state->id}}" data-subtext="{{ $state->state }}">{{ $state->district }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="category">Category *</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="eg: SC / ST / OBC" value="{{ old('category') }}" name="category" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="service">Ex Service Employee *</label>
                                                    <div class="form-group form-float">
                                                        <select id="service" class="form-control show-tick" name="service" data-dropup-auto='false' required>
                                                            <option>No</option>
                                                            <option>Yes</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="education">Education *</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="eg: 10 / 12 / Diploma" value="{{ old('education') }}" name="education" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="g_name">Guardian Name *</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Name of the Guardian" value="{{ old('g_name') }}" name="g_name" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="g_type">Guardian Type *</label>
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
                    <h4 class="title" id="TermsModalLabel">Company Terms & Conditions</h4>
                </div>
                <div class="modal-body">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum nemo vero illum esse explicabo dolor quisquam id iusto enim, placeat eligendi, ipsa facere nesciunt ex temporibus repellendus assumenda atque? Officiis.
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




    /* Duplicate Email Checking */
    var dup_email_tag = true;
    var dup_mobile_tag = true;
    function checkduplicacy(val){
        var _token = $('[name=_token]').val();
        // console.log('Token :'+ _token);
         
        let value = $('[name='+val+']').val();
        let dataString = { checkredundancy : value, section: val, _token: _token};
        $.ajax({
            url: "{{ route('center.addcandidate.api') }}",
            method: "POST",
            data: dataString,
            success: function(data){
                if (data.success) {
                    $('#'+val+'_error').html('');
                    if (val == 'email') {
                        dup_email_tag = true;
                    } else {
                        dup_mobile_tag = true;
                    } 
                } else {
                    $('#'+val+'_error').html(val+' already exists');
                    if (val == 'email') {
                        dup_email_tag = false;                        
                    } else {
                        dup_mobile_tag = false;
                    } 
                }
            },
            error:function(data){
                $('#'+val+'_error').html(val+' already exists');
                dup_email_tag = false;
                dup_mobile_tag = false;
            } 
        });
    }
    /* End Duplicate Email Checking */

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

        if (tag && dup_email_tag && dup_mobile_tag) {
            switch (div[0]) {
                case 'collapseOne':
                    var ajaxresponse = true;
                    var doc_no = $('[name=doc_no]').val();
                
                    $("#btnOne").prop("disabled", true);
                    $("#btnOne").html("Please Wait...");
                    var _token = $('[name=_token]').val();
                    var dataValidate = { _token, doc_no };
                    $.ajax({
                        url: "{{ route('center.addcandidate.api') }}",
                        method: "POST",
                        data: dataValidate,
                        success: function(data){
                            if (!data.success) {
                                $("#btnOne").prop("disabled", false);
                                $("#btnOne").html("<span class='glyphicon glyphicon-arrow-right'></span> Next");
                                swal('Abort','Candidate With This Addhar/Voter No is Already Present in Our Database','error');
                                ajaxresponse = false;
                                return false;
                            }
                            ajaxresponse = true;
                            return true;
                        },
                        error: function(){
                            swal('Abort','Something went Wrong, Please Try Again','error').then((value) => {location.reload();} );
                        }
                    }).done(function(){
                        if (ajaxresponse) {
                            $('#'+div[0]).collapse('hide');
                            $('#'+div[0]).on('hidden.bs.collapse', function () {
                                $('#'+div[1]).collapse('show');
                            });
                        }

                    });
                    break;
                case 'collapseTwo':
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
                        $(this).unbind().submit();
                    
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

    /* End Fetch SelectPicker Data */

    /* File Type Validation */
        function filevalidate(){
            var _URL = window.URL || window.webkitURL;
            $("[type='file']").change(function(e) {
            var image, file;
            for (var i = this.files.length - 1; i >= 0; i--) {
            if ((file = this.files[i])) {
                    image = new Image();
                    var fileType = file["type"];
                    var ValidImageTypes = ["image/jpg", "image/jpeg", "image/png", "application/pdf"];
                    if ($.inArray(fileType, ValidImageTypes) < 0) {
                    $("#"+e.currentTarget.id).val('');
                    
                    $("#" + e.currentTarget.id + "_error").text('File must be in jpg, jpeg, png or pdf Format');
                    } else {
                    $("#" + e.currentTarget.id + "_error").text('');
                    }
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
            format: 'dd MM yyyy',
            endDate: new Date()
        });
    
    /* End Bootstrap DatePicker */
    
});

/* Custom Valiadtions */    

    jQuery("#form_candidate").validate({
        rules: {
        contact: { mobile: true },
        doc_no: { aadharvoter: true },
        "[type=email]": { email: true }
        }
    });

/* End Custom Valiadtions */
</script>
@endsection