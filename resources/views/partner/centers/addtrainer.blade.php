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
                   <a class="btn btn-primary btn-round waves-effect" href="{{route('partner.tc.trainers')}}">My Trainers</a>                      
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
                    <form id="form_trainer" method="POST" action="{{ route('partner.tc.submittrainer') }}" enctype="multipart/form-data">
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
                                                <label for="doc_no">Aadhar/Votar Number *</label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="Enter Trainer's Aadhar No or Votar No" name="doc_no" required>
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
                                                <label for="name">Trainer Name *</label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="Trainer Name" value="{{ old('name') }}" name="name" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="mobile">Trainer Mobile *</label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="Trainer Mobile" value="{{ old('mobile') }}" onchange="checkduplicacy('mobile')" name="mobile" required>
                                                    <span id="mobile_error" style="color:red"></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="email">Trainer Email *</label>
                                                <div class="form-group form-float">
                                                    <input type="email" class="form-control" placeholder="Trainer Email" value="{{ old('email') }}" onchange="checkduplicacy('email')" name="email" required>
                                                    <span id="email_error" style="color:red"></span>
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
                                        <div class="card body field-group" id="form_id_new">
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="sector[new]">Domain/Sector/SSC *</label>
                                                    <div class="form-group form-float">
                                                        <select id="sector_new" class="form-control show-tick" data-live-search="true" name="sector[new]" onchange="updatejob('new')" data-dropup-auto='false' required>
                                                            @foreach ($partner->partner_jobroles->unique("sector_id") as $job)
                                                                @if ($job->status && $job->scheme_status)
                                                                    <option value="{{$job->sector_id}}">{{$job->scheme->scheme.' | '.$job->sector->sector}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="jobrole[new][]">Job Roles *</label>
                                                    <div class="form-group form-float">
                                                        <select id="jobrole_new" class="form-control show-tick" data-live-search="true" name="jobrole[new][]" multiple data-dropup-auto='false' required>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="ssc_doc_no[new]">SSC Document No *</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="SSC Document Number" value="{{ old('ssc_doc_no[new]') }}" name="ssc_doc_no[new]" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="ssc_doc[new]">SSC Document *</label>
                                                    <div class="form-group form-float">
                                                        <input type="file" id="ssc_doc_new" class="form-control" name="ssc_doc[new]" required>
                                                        <span id="ssc_doc_new_error"  style="color:red;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="ssc_start[new]">SSC Certificate Issued On *</label>
                                                    <div class="form-group form-float month_range_picker">
                                                        <input type="text" id="ssc_start_new" onchange="startchange('new')" class="form-control" name="ssc_start[new]" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="ssc_end[new]">SSC Certificate Valid Upto *</label>
                                                    <div class="form-group form-float month_range_picker">
                                                        <input type="text" id="ssc_end_new" class="form-control" name="ssc_end[new]" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="repeatable-container"></div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                            </div>
                                            <div class="col-sm-4 text-center">
                                                @if (count($partner->partner_jobroles->unique("sector_id"))-1 > 0)
                                                    <button type="button" class="btn btn-primary add" ><span class="glyphicon glyphicon-plus-sign"></span> Add More</button>
                                                @endif
                                            </div>
                                            <div class="col-sm-4 text-right">
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
                                                <label for="resume">Resume *</label>
                                                <div class="form-group form-float">
                                                    <input type="file" id="resume" class="form-control" name="resume" required>
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
                                                <label for="scpwd_doc_no">SCPwD Document No *</label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="SCPwD Document Number" value="{{ old('scpwd_doc_no') }}" name="scpwd_doc_no" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-4">
                                                <label for="scpwd_doc">SSC Document *</label>
                                                <div class="form-group form-float">
                                                    <input type="file" id="scpwd_doc" class="form-control" name="scpwd_doc" required>
                                                    <span id="scpwd_doc_error"  style="color:red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="scpwd_start">SCPwD Certificate Issued On *</label>
                                                <div class="form-group form-float month_range_picker">
                                                    <input type="text" id="scpwd_start" onchange="startchangescpwd('new')" class="form-control" name="scpwd_start" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="scpwd_end">SCPwD Certificate Valid Upto *</label>
                                                <div class="form-group form-float month_range_picker">
                                                    <input type="text" id="scpwd_end" class="form-control" name="scpwd_end" required>
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
        updatejob('new');
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
            url: "{{ route('partner.tc.addcenter.api') }}",
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
                dup_email_tag = false;
            } 
        });
    }
    /* End Duplicate Email Checking */

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
                        url: "{{ route('partner.tc.addtrainer.api') }}",
                        method: "POST",
                        data: dataValidate,
                        success: function(data){
                            if (!data.success) {
                                $('#doc_message').text('Note: This Aadhar/Votar Number is Registred in our Trainer Database');
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
                    var ajaxresponse = true;
                    var mobile = $('[name=mobile]').val();
                    var email = $('[name=email]').val();
                    var doc_no = $('[name=doc_no]').val();
                    $("#btnTwo").prop("disabled", true);
                    $("#btnTwo").html("Please Wait...");
                    var _token = $('[name=_token]').val();
                    var dataValidate = { _token, mobile, email, doc_no };
                    $.ajax({
                        url: "{{ route('partner.tc.addtrainer.api') }}",
                        method: "POST",
                        data: dataValidate,
                        success: function(data){
                            
                            if (!data.success) {
                                var swalText = document.createElement("div");
                                if (!data.mobile && !data.email) {
                                    swalText.innerHTML = 'This Email & Mobile Already Linked With Another Trainer'; 
                                } else if(!data.mobile) {
                                    swalText.innerHTML = 'This Mobile is Already Linked With Another Trainer'; 
                                } else if (!data.email) {
                                    swalText.innerHTML = 'This Email is Already Linked With Another Trainer'; 
                                }    
                                swal({title: "Abort", content: swalText, icon: "error", closeOnEsc: true});
                                $("#btnTwo").prop("disabled", false);
                                $("#btnTwo").html('<span class="glyphicon glyphicon-arrow-right"></span> Next');
                                ajaxresponse = false;
                                return false;
                            }
                            $("#btnTwo").prop("disabled", false);
                            $("#btnTwo").html('<span class="glyphicon glyphicon-arrow-right"></span> Next');
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
                case 'collapseThree':
                    var array = [];
                    $('select[id^=jobrole_]').each(function (){
                        array.push(this.value);
                    });
                    if (checkIfDuplicateExists(array)) {
                        var swalText = document.createElement("div");
                        swalText.innerHTML = 'Please Select Unique <span style="color:blue">Domain/Sector/SSC</span'; 
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

    /* Fetch SelectPicker Data */

        function updatejob(id){
            var _token = $('[name=_token]').val();
            var sectorid = $("#sector_"+id+" :selected").val();
            // console.log(sectorid);
            
            $.ajax({
                url: "{{ route('partner.tc.addtrainer.api') }}",
                method: "POST",
                data: { _token, sectorid },
                success: function(data){
                    // console.log(data);
                    
                    $('#jobrole_'+id).empty();
                    data.jobs.forEach(value => {
                        // console.log(value);
                        $('#jobrole_'+id).append('<option value="'+value.jobrole_id+'">'+value.jobrole.job_role+'</option>');
                    });
                    $('#jobrole_'+id).selectpicker('refresh');
                    
                } 
            });
        }

    /* End Fetch SelectPicker Data */

    /* Repeatable Section for JobRole */
    $(function() {
            $("form .repeatable-container").repeatable({
            template: "#jobroleform",
            max: {{count($partner->partner_jobroles->unique("sector_id"))-1}},
            afterAdd: function(id){
                var temp = id[0].id.split('_');
                var last = temp[temp.length - 1];
                $('.jobrole').selectpicker();
                
                /* Fetch SelectPicker Data */
                
                var $options = $("#sector_new > option").sort().clone();
                $('#sector_'+last).append($options);
                $('#sector_'+last).selectpicker('refresh');
                updatejob(last);
                $('.month_range_picker .form-control').datepicker({
                    autoclose: true,
                    format: 'dd MM yyyy',
                    endDate: new Date()
                });

                $('#ssc_start_'+last)
                .datepicker()
                .on('changeDate', function(selected){
                    startDate = new Date(selected.date.valueOf());
                    startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
                    $('#ssc_end_'+last).datepicker('setStartDate', startDate);
                });

                filevalidate();

                /* End Fetch SelectPicker Data */
                }
            });
            
        });
    /* End Repeatable Section for JobRole */

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


{{-- Add More FUNCTION BODY (DYNAMIC) --}}

<script type="text/template" id="jobroleform">
    <div class="card body field-group" id="form_id_{?}">
        <div class="row d-flex justify-content-around">
            <div class="col-sm-4">
                <label for="sector[{?}]">Domain/Sector/SSC *</label>
                <div class="form-group form-float">
                    <select id="sector_{?}" class="form-control show-tick" data-live-search="true" name="sector[{?}]" onchange="updatejob('{?}')" data-dropup-auto='false' required>
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <label for="jobrole[{?}][]">Job Roles *</label>
                <div class="form-group form-float">
                    <select id="jobrole_{?}" class="form-control show-tick jobrole" data-live-search="true" name="jobrole[{?}][]" multiple data-dropup-auto='false' required>
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <label for="ssc_doc_no[{?}]">SSC Document No *</label>
                <div class="form-group form-float">
                    <input type="text" class="form-control" placeholder="SSC Document Number" value="{{ old('ssc_doc_no[{?}]') }}" name="ssc_doc_no[{?}]" required>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-around">
            <div class="col-sm-4">
                <label for="ssc_doc[{?}]">SSC Document *</label>
                <div class="form-group form-float">
                    <input type="file" id="ssc_doc_{?}" class="form-control" name="ssc_doc[{?}]" required>
                    <span id="ssc_doc_{?}_error"  style="color:red;"></span>                        
                </div>
            </div>
            <div class="col-sm-4">
                <label for="ssc_start[{?}]">Certificate Issued On *</label>
                <div class="form-group form-float month_range_picker">
                    <input type="text" id="ssc_start_{?}" onchange="startchange('{?}')" class="form-control" name="ssc_start[{?}]" required>
                </div>
            </div>
            <div class="col-sm-4">
                <label for="ssc_end[{?}]">Certificate Valid Upto *</label>
                <div class="form-group form-float month_range_picker">
                    <input type="text" id="ssc_end_{?}" class="form-control" name="ssc_end[{?}]" required>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <button type="button" class="btn btn-danger delete"><span class="glyphicon glyphicon-minus-sign"></span> Remove</button>            
        </div>
    </div>
</script>

{{-- Add More Function Call --}}



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
    
        $('.month_range_picker .form-control').datepicker({
            autoclose: true,
            format: 'dd MM yyyy',
            endDate: new Date()
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
            "[type=email]": { email: true }
            }
        });
    
    /* End Custom Valiadtions */
</script>
@endsection