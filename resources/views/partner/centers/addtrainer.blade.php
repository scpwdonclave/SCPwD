@extends('layout.master')
@section('title', 'Add Trainer')
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
                    <h2><strong>Add</strong> Trainer</h2>
                   <a class="btn btn-primary btn-round waves-effect" href="{{route('partner.trainers')}}">My Trainers</a>                      
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
                    <form id="form_trainer" method="POST" action="{{ route('partner.submittrainer') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="prsnt" value="0">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title"> <a role="button" href="#collapseOne" onclick="return false" aria-expanded="true" aria-controls="collapseOne"> Identity </a> </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="panel-body">
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-5">
                                                <label for="doc_no">Aadhaar/Voter Number <span style="color:red"> <strong>*</strong></span></label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="Enter Trainer's Aadhaar No or Voter No" name="doc_no" required>
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
                                    <h4 class="panel-title"> <a role="button" href="#collapseTwo" onclick="return false" aria-expanded="true" aria-controls="collapseTwo">Trainer Basic Details</a> </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="panel-body">
                                        <div class="text-center">
                                            <h6><span id="doc_message" style="color:blue"></span></h6>
                                        </div>
                                        <br>
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-3">
                                                <label for="name">Trainer Name <span style="color:red"> <strong>*</strong></span></label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="Trainer Name" value="{{ old('name') }}" name="name" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="mobile">Trainer Mobile <span style="color:red"> <strong>*</strong></span></label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="Trainer Mobile" value="{{ old('mobile') }}" name="mobile" required>
                                                    <span id="mobile_error" style="color:red"></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="email">Trainer Email <span style="color:red"> <strong>*</strong></span></label>
                                                <div class="form-group form-float">
                                                    <input type="email" class="form-control" placeholder="Trainer Email" value="{{ old('email') }}" name="email" required>
                                                    <span id="email_error" style="color:red"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="doc_file_div" class="row d-flex justify-content-center">
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
                                    <h4 class="panel-title"> <a role="button" href="#collapseThree" onclick="return false" aria-expanded="true" aria-controls="collapseThree">Job Role Section</a> </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="panel-body">
                                        <div class="text-center">
                                            <h6>Note: To View Qualification Domain Teaching Experience Requirements Please <a href="{{route('partner.requirements')}}" target="_blank"> <span style="color:blue">Click Here</span> </a> </h6>
                                        </div>
                                        <div class="card body field-group">
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="sector">Domain/Sector/SSC <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <select id="sector" class="form-control show-tick" data-live-search="true" name="sector" onchange="updatejob()" data-dropup-auto='false' required>
                                                            @foreach ($partner->partner_jobroles->unique("sector_id") as $job)
                                                                @if ($job->status)
                                                                    <option value="{{$job->sector_id}}">{{$job->sector->sector}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="jobrole">Job Roles <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <select id="jobrole" class="form-control show-tick" data-live-search="true" name="jobrole" onchange="updatequali()" data-dropup-auto='false' required>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="scheme[]">Schemes <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <select id="scheme" class="form-control show-tick" name="scheme[]" multiple data-dropup-auto='false' required>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="qualification">Relavent Qualification <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <select id="qualification" class="form-control show-tick" data-live-search="true" name="qualification" onchange="updateminvalues(this.value)" data-dropup-auto='false' required>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="sector_exp">Sector Experience in Years*</label>
                                                    <div class="form-group form-float">
                                                        <input type="number" min="0" step=".5" class="form-control" placeholder="Years" value="{{ old('sector_exp') }}" name="sector_exp" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="teaching_exp">Teaching Experience in Years*</label>
                                                    <div class="form-group form-float">
                                                        <input type="number" min="0" step=".5" class="form-control" placeholder="Years" value="{{ old('teaching_exp') }}" name="teaching_exp" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="qualification_doc">Qualification Certificate Upload <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="file" id="qualification_doc" class="form-control" name="qualification_doc" required>
                                                        <span id="qualification_doc_error"  style="color:red;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="ssc_doc_no">SSC Certificate No</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="SSC Document Number" value="{{ old('ssc_doc_no') }}" name="ssc_doc_no">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="ssc_doc">SSC Certificate Upload</label>
                                                    <div class="form-group form-float">
                                                        <input type="file" id="ssc_doc" class="form-control" name="ssc_doc">
                                                        <span id="ssc_doc_error"  style="color:red;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="ssc_start">SSC Certificate Issued On</label>
                                                    <div class="form-group form-float month_range_picker_start">
                                                        <input type="text" id="ssc_start" onchange="startchange()" class="form-control" name="ssc_start">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="ssc_end">SSC Certificate Valid Upto</label>
                                                    <div class="form-group form-float month_range_picker_end">
                                                        <input type="text" id="ssc_end" class="form-control" name="ssc_end">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 text-right">
                                                <button type="button" onclick="validatedata('collapseThree,collapseFour');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-right"></span> Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingFour">
                                    <h4 class="panel-title"> <a role="button" href="#collapseFour" onclick="return false" aria-expanded="true" aria-controls="collapseFour">SCPwD / Other Documents</a> </h4>
                                </div>
                                <div id="collapseFour" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFour" data-parent="#accordion">
                                    <div class="panel-body">
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-4">
                                                <label for="resume">Resume</label>
                                                <div class="form-group form-float">
                                                    <input type="file" id="resume" class="form-control" name="resume">
                                                    <span id="resume_error"  style="color:red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="other_doc">Other Document</label>
                                                <div class="form-group form-float">
                                                    <input type="file" id="other_doc" class="form-control" name="other_doc">
                                                    <span id="other_doc_error"  style="color:red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="scpwd_doc_no">SCPwD Certificate No</label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="SCPwD Document Number" value="{{ old('scpwd_doc_no') }}" name="scpwd_doc_no">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-4">
                                                <label for="scpwd_doc">SCPwD Certificate Upload</label>
                                                <div class="form-group form-float">
                                                    <input type="file" id="scpwd_doc" class="form-control" name="scpwd_doc">
                                                    <span id="scpwd_doc_error"  style="color:red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="scpwd_start">SCPwD Certificate Issued On</label>
                                                <div class="form-group form-float month_range_picker_start">
                                                    <input type="text" id="scpwd_start" onchange="startchangescpwd('new')" class="form-control" name="scpwd_start">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="scpwd_end">SCPwD Certificate Valid Upto</label>
                                                <div class="form-group form-float month_range_picker_end">
                                                    <input type="text" id="scpwd_end" class="form-control" name="scpwd_end">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <button id="last_prev_btn" type="button" onclick="validatedata('collapseFour,collapseThree');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Previous</button>
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


    /* Validation of Each Sections */

    function checkIfDuplicateExists(w){
        return new Set(w).size !== w.length 
    }

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
                    var ajaxresponse = true;
                    var doc_no = $('[name=doc_no]').val();
                    $("#btnOne").prop("disabled", true);
                    $("#btnOne").html("Please Wait...");
                    var _token = $('[name=_token]').val();
                    var dataValidate = { _token, doc_no };
                    $.ajax({
                        url: "{{ route('partner.addtrainer.api') }}",
                        method: "POST",
                        data: dataValidate,
                        success: function(data){
                            if (!data.success) {
                                var swalText = document.createElement("div");
                                swalText.innerHTML = 'This Aadhaar/Voter Number is Already <span style="color:blue">Present</span> in our Trainer Database'; 
                                swal({title: "Abort", content: swalText, icon: "error", closeOnEsc: true});
                                $("#btnOne").prop("disabled", false);
                                $("#btnOne").html('<span class="glyphicon glyphicon-arrow-right"></span> Next');
                                ajaxresponse = false;
                                return false;
                            } else {
                                if (data.present) {
                                    $('[name=prsnt]').val('1');
                                    if (data.trainerData.status) {
                                        $('#doc_message').text('Note: This Aadhaar/Voter Number is Registred in our Trainer Database');
                                        $('#doc_file_div').remove();
                                        $('[name=name]').val(data.trainerData.name);
                                        $('[name=email]').val(data.trainerData.email);
                                        $('[name=mobile]').val(data.trainerData.mobile);
                                        ajaxresponse = true;
                                        return true;
                                    } else {
                                        var swalText = document.createElement("div");
                                        swalText.innerHTML = 'Trainer with this Aadhaar/Voter Number is <span style="color:red">Deactivated</span> in our Record, Please Contact SCPwD';
                                        swal({title: "Abort", content: swalText, icon: "error", closeOnEsc: true});
                                        $("#btnOne").prop("disabled", false);
                                        $("#btnOne").html('<span class="glyphicon glyphicon-arrow-right"></span> Next');
                                        ajaxresponse = false;
                                        return false;
                                    }
                                } else {
                                    $('[name=prsnt]').val('0');
                                    ajaxresponse = true;
                                    return true;
                                }
                            }
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
                    var ajaxresponse = true;
                    var mobile = $('[name=mobile]').val();
                    var email = $('[name=email]').val();
                    var doc_no = $('[name=doc_no]').val();
                    $("#btnTwo").prop("disabled", true);
                    $("#btnTwo").html("Please Wait...");
                    var _token = $('[name=_token]').val();
                    var dataValidate = { _token, mobile, email, doc_no };
                    $.ajax({
                        url: "{{ route('partner.addtrainer.api') }}",
                        method: "POST",
                        data: dataValidate,
                        success: function(data){
                            
                            if (!data.success) {
                                Object.keys(data.errors).forEach(function(k){
                                    $('#'+k+'_error').html(data.errors[k][0]);
                                });
                                $("#btnTwo").prop("disabled", false);
                                $("#btnTwo").html('<span class="glyphicon glyphicon-arrow-right"></span> Next');
                                ajaxresponse = false;
                                return false;
                            } else {
                                $('#mobile_error').html('');
                                $('#email_error').html('');
                                ajaxresponse = true;
                                return true;
                            }

                        },
                        error: function(data){
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
                case 'collapseThree':
                    var array = [];
                    $('select[id^=jobrole_]').each(function (){
                        array.push(this.value);
                    });
                    if (checkIfDuplicateExists(array)) {
                        var swalText = document.createElement("div");
                        swalText.innerHTML = 'Please Select Unique <span style="color:blue">Domain/Sector/SSC</span>'; 
                        swal({title: "", content: swalText, icon: "info", closeOnEsc: true});
                        return false;
                    }
                    $('#'+div[0]).collapse('hide');
                    $('#'+div[0]).on('hidden.bs.collapse', function () {
                        $('#'+div[1]).collapse('show');
                    });
                    break;

                case 'collapseFour':
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
    
        $('#form_trainer').submit(function(e){
            e.preventDefault();
            if ($('#form_trainer').valid()) {
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


        function updatescheme() {
            var _token = $('[name=_token]').val();
            var sid = $("#sector :selected").val(); 
            var jid = $("#jobrole :selected").val();
            $.ajax({
                url: "{{ route('partner.addtrainer.api') }}",
                method: "POST",
                data: { _token, sid, jid },
                success: function(data){
                    $('#scheme').empty();
                    data.jobs.forEach(value => {
                        /* Setting partner_job_id Instead of set jobid as value of selection  */
                        $('#scheme').append('<option value='+value.id+'>'+value.scheme.scheme+'</option>');
                    });
                    $('#scheme').selectpicker('refresh');
                } 
            });
        }



    /* Fetch SelectPicker Data */

        function updatejob(){
            var _token = $('[name=_token]').val();
            var sectorid = $("#sector :selected").val();
            $.ajax({
                url: "{{ route('partner.addtrainer.api') }}",
                method: "POST",
                data: { _token, sectorid },
                success: function(data){
                    $('#jobrole').empty();
                    data.jobs.forEach(value => {
                        $('#jobrole').append('<option value='+value.jobrole_id+'>'+value.jobrole.job_role+'</option>');
                    });
                    $('#jobrole').selectpicker('refresh');
                    updatescheme();
                    updatequali();
                } 
            });
        }

    /* End Fetch SelectPicker Data */


    /* Update Min Values of Experience Depending on Selected Job Role Qualifications */
    
    function updateminvalues(v) {
        var data = localStorage.getItem(v).split(',');
        $('[name=sector_exp]').attr('min', data[0]);
        $('[name=teaching_exp]').attr('min', data[1]);
    }
    
    /* End Update Min Values of Experience Depending on Selected Job Role Qualifications */


    /* Qualification DropDown Item Section */
        function updatequali() {
            var jobroleid = ($("#jobrole :selected").val()).split(',')[0];
            var _token= $('[name=_token]').val();
            $.ajax({
                method: 'POST',
                url: "{{ route('partner.addtrainer.api') }}",
                data: {_token, jobroleid},
                success: function (response) {
                    $('#qualification').empty();
                    localStorage.clear();
                    if (response.qualifications.length == 0) {
                        $('[name=sector_exp]').attr('min', 0);
                        $('[name=teaching_exp]').attr('min', 0);
                    } else {
                        $('[name=sector_exp]').attr('min', response.qualifications[0].sector_exp);
                        $('[name=teaching_exp]').attr('min', response.qualifications[0].teaching_exp);
                    }
                    
                    response.qualifications.forEach(function(v){
                        localStorage.setItem(v.qualification, v.sector_exp+','+v.teaching_exp);
                        $('#qualification').append('<option>'+v.qualification+'</option>');
                    });

                    $('#qualification').selectpicker('refresh');
                    updatescheme();
                },
                error: function (data) {
                    setTimeout(function () {
                        swal("Sorry", "Something Went Wrong, Please Try Again", "error");
                    }, 1500);   
                }
            });
        }
    /* End Qualification DropDown Item Section */


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
    
        $('.month_range_picker_start .form-control').datepicker({
            autoclose: true,
            format: 'dd MM yyyy',
            endDate: new Date()
        });

        $('.month_range_picker_end .form-control').datepicker({
            autoclose: true,
            format: 'dd MM yyyy',
            startDate: new Date()
        });

        $('#ssc_start_new')
        .datepicker()
        .on('changeDate', function(selected){
            startDate = new Date(selected.date.valueOf());
            startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
            $('#ssc_end_new').datepicker('setStartDate', startDate);
        });

        $('#scpwd_start')
        .datepicker()
        .on('changeDate', function(selected){
            startDate = new Date(selected.date.valueOf());
            startDate.setDate(startDate.getDate(new Date(selected.date.valueOf()))); 
            $('#scpwd_end').datepicker('setStartDate', startDate);
        });
    
    /* End Bootstrap DatePicker */
    
});

    /* Date Range Picker Operations */
        function startchange(id){
            $('#ssc_end_'+id).val('');
        }
        function startchangescpwd(){
            $('#scpwd_end').val('');
        }
    /* End Date Range Picker Operations */



    /* Custom Valiadtions */    
    
        jQuery("#form_trainer").validate({
            rules: {
            mobile: { mobile: true },
            doc_no: { aadharvoter: true },
            "[type=email]": { email: true }
            }
        });
    
    /* End Custom Valiadtions */
</script>
@endsection