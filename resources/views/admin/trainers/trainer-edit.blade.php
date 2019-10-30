@extends('layout.master')
@section('title', 'Edit Trainer')
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
                    <h2><strong>Update</strong> Trainer</h2>
                  
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
                <form id="form_trainer" method="POST" action="{{route('admin.tr.update.trainer')}}" enctype="multipart/form-data" onsubmit="event.preventDefault();return myFunction2()">
                        @csrf
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title"> <a role="button" href="#collapseOne" onclick="return false" aria-expanded="true" aria-controls="collapseOne"> Identity </a> </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="panel-body">
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-6">
                                                <label for="name">Aadhaar/ Votar Number </label>
                                                <div class="form-group form-float">
                                                <input type="text" class="form-control" value="{{$trainer->doc_no}}" name="doc_no" readonly>
                                                <input type="hidden"  value="{{$trainer->id}}" name="trid">
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            
                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingTwo">
                                    <h4 class="panel-title"> <a role="button" href="#collapseTwo" onclick="return false" aria-expanded="true" aria-controls="collapseTwo">Trainer Basic Details</a> </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="panel-body">
                                        <div class="text-center">
                                            <h6><span id="doc_message" style="color:blue"></span></h6>
                                        </div>
                                        <br>
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-3">
                                                <label for="name">Trainer Name *</label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="Trainer Name" value="{{$trainer->name}}" name="name" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="mobile">Trainer Mobile *</label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="Trainer Mobile" value="{{$trainer->mobile}}" onchange="checkduplicacy('mobile')"  name="mobile" required>
                                                    <span id="mobile_error" style="color:red"></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="email">Trainer Email *</label>
                                                <div class="form-group form-float">
                                                    <input type="email" class="form-control" placeholder="Trainer Email" value="{{$trainer->email}}" onchange="checkduplicacy('email')" name="email" required>
                                                    <span id="email_error" style="color:red"></span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </div>

                            

                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingFour">
                                    <h4 class="panel-title"> <a role="button" href="#collapseFour" onclick="return false" aria-expanded="true" aria-controls="collapseFour">SCPwD / Other Documents</a> </h4>
                                </div>
                                <div id="collapseFour" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingFour" data-parent="#accordion">
                                    <div class="panel-body">
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-4">
                                                <label for="resume">Resume </label>
                                                <div class="form-group form-float">
                                                    <input type="file" id="resume" class="form-control" name="resume" >
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
                                                <label for="scpwd_doc_no">SCPwD Document No </label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="SCPwD Document Number" value="{{$trainer->scpwd_no}}" name="scpwd_doc_no" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-4">
                                                <label for="scpwd_doc">SCPwD Document </label>
                                                <div class="form-group form-float">
                                                    <input type="file" id="scpwd_doc" class="form-control" name="scpwd_doc" >
                                                    <span id="scpwd_doc_error"  style="color:red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="scpwd_start">SCPwD Certificate Issued On </label>
                                                <div class="form-group form-float month_range_picker">
                                                    <input type="text" id="scpwd_start" onchange="startchangescpwd('new')" class="form-control" value="{{$trainer->scpwd_issued}}" name="scpwd_start" >
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="scpwd_end">SCPwD Certificate Valid Upto </label>
                                                <div class="form-group form-float month_range_picker">
                                                    <input type="text" id="scpwd_end" class="form-control" value="{{$trainer->scpwd_valid}}" name="scpwd_end" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-4">
                                                    <label for="qualification">Qualification</label>
                                                    <div class="form-group form-float">
                                                        <select class="form-control show-tick" data-live-search="true" name="qualification" data-show-subtext="true" data-dropup-auto='false'>
                                                            @foreach (config('constants.qualifications') as $key=>$qualification)
                                                                <option value="{{$key}}" {{ ( $key ==$trainer->jobroles[0]->qualification) ? 'selected' : '' }}>{{ $qualification }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            <div class="col-sm-4">
                                                <label for="scpwd_doc">Qualification Certificate </label>
                                                <div class="form-group form-float">
                                                    <input type="file" id="qualification_doc" class="form-control" name="qualification_doc" >
                                                    <span id="qualification_doc_error"  style="color:red;"></span>
                                                </div>
                                            </div>
                                          </div>
                                        
                                        <div class="row">
                                            <div class="col-sm-12 text-right">
                                                <button type="submit" id="submit_form" class="btn btn-primary"><span class="glyphicon glyphicon-cloud-upload"></span> UPDATE</button>
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
  /* Check Redundancy */
        var dup_email_tag = true;
        var dup_mobile_tag = true;
        function checkduplicacy(val){
            var _token = $('[name=_token]').val();
            let value = $('[name='+val+']').val();
            let id = '{{$trainer->id}}';
            let dataString = { checkredundancy : value, section: val, _token: _token, id:id};
            $.ajax({
                url: "{{route('admin.tr.trainer.api')}}",
                method: "POST",
                data: dataString,
                success: function(data){
                       // console.log(data);
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
                    swal('Oops!','Something Went Wrong','error');
                    
                } 
            });
        }
    /* End Check Redundancy */
    function myFunction2(){
        
            if(dup_email_tag==false ||dup_mobile_tag==false){
               
                return false;
            }
            else{
                var form = document.getElementById("form_trainer");
                form.submit();
                return true;
            }
        }
</script>
<script>

    /* Onload Function */
    $(() => {
        var ajaxresponse = true;
        filevalidate();
    });
    /* End Onload Function */

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
    
        $('.month_range_picker .form-control').datepicker({
            autoclose: true,
            format: 'dd MM yyyy',
            endDate: new Date()
        });

        // $('#ssc_start_new')
        // .datepicker()
        // .on('changeDate', function(selected){
        //     startDate = new Date(selected.date.valueOf());
        //     startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
        //     $('#ssc_end_new').datepicker('setStartDate', startDate);
        // });

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
            $('#scpwd_end').val($('#scpwd_end').val());
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