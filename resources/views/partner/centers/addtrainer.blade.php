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
                                            <div class="col-sm-6">
                                                <label for="name">Aadhar/Votar Number *</label>
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
                                        {{-- <div class="row d-flex justify-content-around">
                                            <div class="col-sm-6">
                                                <label for="addr_proof">Address Proof *</label>
                                                <div class="form-group form-float">
                                                    <select class="form-control show-tick" data-live-search="true" name="addr_proof" data-dropup-auto='false' required>
                                                        <option value="Rent/ Lease Agreement">Rent/ Lease Agreement</option>
                                                        <option value="Incorportaion Certificate">Incorportaion Certificate</option>
                                                        <option value="GST Registration Certificate">GST Registration Certificate</option>
                                                        <option value="Telephone Bill (BSNL/MTNL)">Telephone Bill (BSNL/MTNL)</option>
                                                        <option value="Electricity Bill">Electricity Bill</option>
                                                        <option value="Bank Statement">Bank Statement</option>
                                                        <option value="Incometax Certificate">Incometax Certificate</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Address Proof Document *</label>
                                                <div class="form-group form-float">
                                                    <div class="row d-flex justify-content-center">
                                                        <span id="addr_doc2" for="addr_doc" style="color:blue;"></span>
                                                    </div>
                                                    <input id="addr_doc" type="file" class="form-control" name="addr_doc" required>
                                                    <span id="addr_doc_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-5">
                                                <label for="state">State/Union Territory - District *</label>
                                                <div class="form-group form-float">
                                                    <select class="form-control show-tick" data-live-search="true" name="state_district" data-show-subtext="true" data-dropup-auto='false' required>
                                                        @foreach ($states as $state)
                                                            <option value="{{$state->id}}" data-subtext="{{ $state->state }}">{{ $state->district }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <label for="parliament">Parliament Constituency *</label>
                                                <div class="form-group form-float">
                                                    <select class="form-control show-tick" data-live-search="true" name="parliament" data-show-subtext="true" required>
                                                        @foreach ($parliaments as $parliament)
                                                            <option value="{{$parliament->id}}" data-subtext="{{ $parliament->state_ut }}">{{ $parliament->constituency }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-4">
                                                <label for="city">City/Town/Village *</label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="City/Town/Village" value="{{ old('city') }}" name="city" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="block">Tehsil/Mandal/Block *</label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="Tehsil/Mandal/Block" value="{{ old('block') }}" name="block" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="pin">PIN code *</label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="PIN Code" value="{{ old('pin') }}" name="pin" required>
                                                </div>
                                            </div>
                                        </div> --}}
                                        
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
                                                <div class="col-sm-8">
                                                    <label for="jobrole[new]">Scheme - Sectors - Job Roles *</label>
                                                    <div class="form-group form-float">
                                                        <select id="jobrole_new" class="form-control show-tick" data-live-search="true" name="jobrole[new]" data-dropup-auto='false' required>
                                                            @foreach ($partner->partner_jobroles as $job)
                                                                @if ($job->status)
                                                                    <option value="{{$job->id}}">{{$job->scheme->scheme.' | '.$job->sector->sector.' | '.$job->jobrole->job_role}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="target[new]">Target *</label>
                                                    <div class="form-group form-float">
                                                        <input type="number" id="target_new" min="0" class="form-control" placeholder="Target" name="target[new]" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="repeatable-container"></div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <button type="button" onclick="validatedata('collapseThree,collapseTwo');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Previous</button>
                                            </div>
                                            <div class="col-sm-4 text-center">
                                                <button type="button" class="btn btn-primary add" ><span class="glyphicon glyphicon-plus-sign"></span> Add More</button>
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
                                    <h4 class="panel-title"> <a role="button" href="#collapseFour" onclick="return false" aria-expanded="true" aria-controls="collapseFour">Upload Section</a> </h4>
                                </div>
                                <div id="collapseFour" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFour" data-parent="#accordion">
                                    <div class="panel-body">
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-3">
                                                <label>Center Front View</label>
                                                <div class="form-group form-float">
                                                    <input id="center_front_view" type="file" class="form-control" name="center_front_view">
                                                    <span id="center_front_view_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Center Back View</label>
                                                <div class="form-group form-float">
                                                    <input id="center_back_view" type="file" class="form-control" name="center_back_view">
                                                    <span id="center_back_view_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Center Right View</label>
                                                <div class="form-group form-float">
                                                    <input id="center_right_view" type="file" class="form-control" name="center_right_view">
                                                    <span id="center_right_view_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Center Left View</label>
                                                <div class="form-group form-float">
                                                    <input id="center_left_view" type="file" class="form-control" name="center_left_view">
                                                    <span id="center_left_view_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-6">
                                                <label>Class Room(s)</label>
                                                <div class="form-group form-float">
                                                    <input id="class" type="file" class="form-control" name="class_room[]" multiple>
                                                    <span class="d-flex justify-content-end" style="color:blue;">* You can choose multiple files</span>
                                                    <span id="class_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Lab Room(s)</label>
                                                <div class="form-group form-float">
                                                    <input id="lab" type="file" class="form-control" name="lab_room[]" multiple>
                                                    <span class="d-flex justify-content-end" style="color:blue;">* You can choose multiple files</span>
                                                    <span id="lab_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-6">
                                                <label>Equipment Room(s)</label>
                                                <div class="form-group form-float">
                                                    <input id="equipment" type="file" class="form-control" name="equipment_room[]" multiple>
                                                    <span class="d-flex justify-content-end" style="color:blue;">* You can choose multiple files</span>
                                                    <span id="equipment_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Washroom(s)</label>
                                                <div class="form-group form-float">
                                                    <input id="wash" type="file" class="form-control" name="wash_room[]" multiple>
                                                    <span class="d-flex justify-content-end" style="color:blue;">* You can choose multiple files</span>
                                                    <span id="wash_error" style="color:red;"></span>                                                          
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-3">
                                                <label>Biometric System</label>
                                                <div class="form-group form-float">
                                                    <input id="bio" type="file" class="form-control" name="bio">
                                                    <span id="bio_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Drinking Facility</label>
                                                <div class="form-group form-float">
                                                    <input id="drink" type="file" class="form-control" name="drink">
                                                    <span id="drink_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Safety</label>
                                                <div class="form-group form-float">
                                                    <input id="safety" type="file" class="form-control" name="safety">
                                                    <span id="safety_error" style="color:red;"></span>                                                            
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
              
                  default:
                      break;
              } 
            }




            
            // if (div[0] == 'collapseThree' && tag) {
            //     var array = [];
            //     var arrayValues = [];
            //     var ajaxresponse = true;
            //     $('select[id^=jobrole_]').each(function (){
            //         array.push(this.value);
            //         var temp = this.id.split('_');
            //         var last = temp[temp.length - 1];
            //         arrayValues.push($('#target_'+last).val());
            //     });
                
                
            //     if (checkIfDuplicateExists(array)) {
            //         swal('','Please Select Unique Job Roles','info');
            //         return false;
            //     } else {
            //         ajaxreqst = true;
            //         var _token = $('[name=_token]').val();
            //         var dataValidate = { _token: _token, array: array, values: arrayValues, validateArray: 1};
            //         $.ajax({
            //             url: "{{ route('partner.tc.addcenter.api') }}",
            //             method: "POST",
            //             data: dataValidate,
            //             success: function(data){
            //                 if (!data.success) {
            //                     swal('Abort', 'You can add target Upto '+data.max+' to '+data.jobrole+' job Role','error');
            //                     ajaxresponse = false;
            //                     return true;
            //                 } else {
            //                     ajaxresponse = true;
            //                     return true;
            //                 }
                            
            //             },
            //             error: function(){
            //                 swal('Abort','Something went Wrong','error');
            //                 ajaxresponse = false;
            //                 return false;
            //             }
            //         }).done(function(){
            //             if (tag && dup_email_tag && dup_mobile_tag && ajaxresponse) {
            //                 $('#'+div[0]).collapse('hide');
            //                 $('#'+div[0]).on('hidden.bs.collapse', function () {
            //                     $('#'+div[1]).collapse('show');
            //                 });
            //             }

            //         });
            //     }
            //     // console.log($('select[id^=jobrole_]')[0].value);
                
            // } 
            // else {
            //     if (tag && dup_email_tag && dup_mobile_tag) {
            //             $('#'+div[0]).collapse('hide');
            //             $('#'+div[0]).on('hidden.bs.collapse', function () {
            //                 $('#'+div[1]).collapse('show');
            //             });
            //         }
            // }

            

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



        $(function(){

            var _URL = window.URL || window.webkitURL;
                $("[type='file']").change(function(e) {

                    var image, file;

                    // var l = this.files.length;
                    // if (l>6 || l<2) {
                    // alert('You Have To select atleast 2 images ( max limit is 6)');
                    // $("#file").val('');
                    // }

                for (var i = this.files.length - 1; i >= 0; i--) {

                    if ((file = this.files[i])) {

                        size = file.size/1024/1024;
                        size = Math.round(size * 100) / 100

                        image = new Image();
                        var fileType = file["type"];
                        var ValidImageTypes = ["image/jpg", "image/jpeg", "image/png", "application/pdf"];
                        if ($.inArray(fileType, ValidImageTypes) < 0) {
                            // invalid file type code goes here.
                            $("#"+e.currentTarget.id).val('');
                            $("#" + e.currentTarget.id + "_error").text('File must be in jpg, jpeg, png or pdf Format');
                        } else {
                            $("#" + e.currentTarget.id + "_error").text('');
                        }

                        image.onload = function() {
                            if (size > 1.5) {
                                $("#"+e.currentTarget.id).val('');
                                $("#" + e.currentTarget.id + "_error").text('File Size Exceeding the limit of 1.5 MB');
                            } else {
                                $("#" + e.currentTarget.id + "_error").text('');
                            }
                        };

                        image.src = _URL.createObjectURL(file);
                        }
                    }

                });
            });

/* Job Role Changes */
    // function role_changed(v){
        // console.log(v.id);
        
        // console.log($('.jobroleclass').length);
        // for (let i = 0; i < ($('.jobrole').length/2); i++) {
        //     // const element = $('.jobrole')[i];
        //     console.log('hi');
            
            
        // }
        
    // }
/* End Job Role Changes */





/* Fetch SelectPicker Data */

    // function fetchdata(id){
        
    //     var temp = id[0].id.split('_');
    //     var last = temp[temp.length - 1];
    //     if (last === 'new0') {
    //         var $options = $("#jobrole_new > option").not('option:selected').sort().clone();
    //         $('#jobrole_'+last).append($options);
    //         $('#jobrole_'+last).selectpicker('refresh');
    //     } else {
    //         console.log(Number(last.substr(-1)) - 1);
    //         var $options = $("#jobrole_new"+(Number(last.substr(-1)) - 1)+" > option").not('option:selected').sort().clone();
    //         $('#jobrole_'+last).append($options);
    //         $('#jobrole_'+last).selectpicker('refresh');
    //         //  Number(last.substr(-1)) - 1;
    //         // fetchid = ''
    //     }


    // }

/* End Fetch SelectPicker Data */

    /* Repeatable Section for JobRole */
    $(function() {
            $("form .repeatable-container").repeatable({
            template: "#jobroleform",
            max: {{count($partner->partner_jobroles)-1}},
            afterAdd: function(id){
                // console.log(id);
                
                var temp = id[0].id.split('_');
                var last = temp[temp.length - 1];
                // console.log(id);
                $('.jobrole').selectpicker();
                /* Fetch SelectPicker Data */
                var $options = $("#jobrole_new > option").sort().clone();
                $('#jobrole_'+last).append($options);
                $('#jobrole_'+last).selectpicker('refresh');
                /* End Fetch SelectPicker Data */
            }
            });
            
        });
    /* End Repeatable Section for JobRole */

</script>


{{-- Add More FUNCTION BODY (DYNAMIC) --}}

<script type="text/template" id="jobroleform">
    <div class="card body field-group" id="form_id_{?}">
        <div class="row d-flex justify-content-around">
            <div class="col-sm-8">
                <label for="jobrole[{?}]">Scheme - Sectors - Job Roles *</label>
                <div class="form-group form-float">
                    <select id="jobrole_{?}" class="form-control show-tick jobroleclass" data-live-search="true" name="jobrole[{?}]" data-dropup-auto='false' required>
                        
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <label for="target[{?}]">Target *</label>
                <div class="form-group form-float">
                    <input id="target_{?}" type="number" min="0" class="form-control" placeholder="Target" name="target[{?}]" required>
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
    
        $('.year_picker .form-control').datepicker({
            autoclose: true,
            minViewMode: 'years',
            format: 'yyyy',
            endDate: new Date()
        });
        
        $('.date_picker .form-control').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy',
            endDate: new Date()
        });
    
    /* End Bootstrap DatePicker */
    
});


/* Custom Valiadtions */
    
    
jQuery("#form_trainer").validate({
        rules: {
        pin: { pin: true },
        mobile: { mobile: true },
        "[type=email]": { email: true }
        }
    });
    
    /* End Custom Valiadtions */
</script>
@endsection