@extends('layout.master')
@section('title', 'Add Training Center')
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
                    <h2><strong>Add</strong> New Training Center</h2>
                   <a class="btn btn-primary btn-round waves-effect" href="{{route('partner.tc.centers')}}">My Training Centers</a>                      
                </div>
                <div class="body">
                    <form id="form_center" method="POST" action="{{ route('partner.tc.addcenter') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title"> <a role="button" href="#collapseOne" onclick="return false" aria-expanded="true" aria-controls="collapseOne"> SPOC Details </a> </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="panel-body">
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-3">
                                                <label for="spoc_name">SPOC Name *</label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="SPOC Name" value="{{ old('spoc_name') }}" name="spoc_name" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="spoc_mobile">SPOC Mobile *</label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="SPOC Mobile" value="{{ old('spoc_mobile') }}" name="spoc_mobile" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="email">SPOC Email *</label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="SPOC Email" value="{{ old('email') }}" onchange="checkmail('email')" name="email" required>
                                                    <span id="email_error" style="color:red"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 text-right">
                                                <button type="button" onclick="validatedata('collapseOne,collapseTwo');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-right"></span> Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingTwo">
                                    <h4 class="panel-title"> <a role="button" href="#collapseTwo" onclick="return false" aria-expanded="true" aria-controls="collapseTwo">Training Center Details</a> </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label for="center_name">Name of the Training Center</label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="Training Center Name" value="{{ old('center_name') }}" name="center_name">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="center_address">Address of the Training Center *</label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="Training Center Address" value="{{ old('center_address') }}" name="center_address" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="landmark">Nearby Landmark *</label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="Landmark" value="{{ old('landmark') }}" name="landmark" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-around">
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
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <button type="button" onclick="validatedata('collapseTwo,collapseOne');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Previous</button>
                                            </div>
                                            <div class="col-sm-6 text-right">
                                                <button type="button" onclick="validatedata('collapseTwo,collapseThree');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-right"></span> Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingThree">
                                    <h4 class="panel-title"> <a role="button" href="#collapseThree" onclick="return false" aria-expanded="true" aria-controls="collapseThree">Job Role Section</a> </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="panel-body">
                                        
                                        <div class="repeatable-container"></div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <button type="button" onclick="validatedata('collapseThree,collapseTwo');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Previous</button>
                                            </div>
                                            <div class="col-sm-4 text-center">
                                                <button type="button" class="btn btn-primary add" ><span class="glyphicon glyphicon-plus-sign"></span> Add Experience</button>
                                            </div>
                                            <div class="col-sm-4 text-right">
                                                <button type="button" onclick="validatedata('collapseThree,collapseFour');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-right"></span> Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingThree">
                                    <h4 class="panel-title"> <a role="button" href="#collapseThree" onclick="return false" aria-expanded="true" aria-controls="collapseThree">Upload Section</a> </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="panel-body">
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-3">
                                                <label>Center Front View</label>
                                                <div class="form-group form-float">
                                                    <input type="file" class="form-control" name="center_front_view">
                                                    <span id="center_front_view_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Center Back View</label>
                                                <div class="form-group form-float">
                                                    <input type="file" class="form-control" name="center_back_view">
                                                    <span id="center_back_view_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Center Right View</label>
                                                <div class="form-group form-float">
                                                    <input type="file" class="form-control" name="center_right_view">
                                                    <span id="center_right_view_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Center Left View</label>
                                                <div class="form-group form-float">
                                                    <input type="file" class="form-control" name="center_left_view">
                                                    <span id="center_left_view_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-3">
                                                <label>Class Room(s)</label>
                                                <div class="form-group form-float">
                                                    <input type="file" class="form-control" name="class_room[]" multiple>
                                                    <span id="class_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Lab Room(s)</label>
                                                <div class="form-group form-float">
                                                    <input type="file" class="form-control" name="lab_room[]" multiple>
                                                    <span id="lab_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Equipment Room(s)</label>
                                                <div class="form-group form-float">
                                                    <input type="file" class="form-control" name="equipment_room[]" multiple>
                                                    <span id="equipment_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Washroom(s)</label>
                                                <div class="form-group form-float">
                                                    <input type="file" class="form-control" name="wash_room[]" multiple>
                                                    <span id="wash_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-3">
                                                <label>Biometric System</label>
                                                <div class="form-group form-float">
                                                    <input type="file" class="form-control" name="bio_room">
                                                    <span id="class_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Drinking Facility</label>
                                                <div class="form-group form-float">
                                                    <input type="file" class="form-control" name="drink_room">
                                                    <span id="lab_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Saftey</label>
                                                <div class="form-group form-float">
                                                    <input type="file" class="form-control" name="saftey">
                                                    <span id="equipment_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                        </div>
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

    /* Duplicate Email Checking */
    var dup_email_tag = true;
    function checkmail(val){
        let value = $('[name='+val+']').val();
        let dataString = { checkredundancy : value, section: val};
        $.ajax({
            url: "{{ route('partner.tc.addcenter') }}",
            method: "POST",
            data: dataString,
            success: function(data){
                if (data.success) {
                    $('#'+val+'_error').html('');
                    dup_email_tag = true;                        
                } else {
                    $('#'+val+'_error').html(val+' already exists');
                    dup_email_tag = false;                        
                }
            },
            error:function(data){
                $('#'+val+'_error').html(val+' already exists');
                dup_email_tag = false;
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

            if (true) {

                    $('#'+div[0]).collapse('hide');
                    $('#'+div[0]).on('hidden.bs.collapse', function () {
                        $('#'+div[1]).collapse('show');
                    });
            }
        }

    /* End Validation of Each Sections */

    /* Making Sure That the Terms & Condition is Accepted */
    
        $('#form_center').submit(function(e){
            e.preventDefault();
            if ($('#form_center').valid()) {
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






    /* Repeatable Section for JobRole */
    // $(function() {
    //         $("form .repeatable-container").repeatable({
    //         template: "#jobroleform",
    //         max: 5,
    //         afterAdd: function(id){
    //             var temp = id[0].id.split('_');
    //             var last = temp[temp.length - 1];
    //             console.log(id);
    //             $('.jobrole').selectpicker();
    //             // filevalidate();
    //         }
    //         });
            
    //     });
    /* End Repeatable Section for JobRole */

</script>


{{-- ADD EMPLOYEE EXPERIENCE FUNCTION BODY (DYNAMIC) --}}

{{-- <script type="text/template" id="jobroleform">
    <div class="card body field-group" id="form_id_{?}">
        <div class="row d-flex justify-content-around">
            <div class="col-sm-5">
                <label for="jobrole[{?}]">Job Roles - Sectors *</label>
                <div class="form-group form-float">
                    <select class="form-control show-tick jobrole" data-live-search="true" name="jobrole[{?}]" data-dropup-auto='false' required>
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
            <div class="col-sm-5">
                <label for="target[{?}]">Target *</label>
                <div class="form-group form-float">
                    <input type="text" class="form-control" placeholder="Target" name="target[{?}]" required>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <button type="button" class="btn btn-danger delete"><span class="glyphicon glyphicon-minus-sign"></span> Remove</button>            
        </div>
    </div>
</script> --}}

{{-- ADD Employee Experience Function Call --}}


<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
{{-- <script src="{{asset('assets/js/jquery.repeatable.js')}}"></script> --}}
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
    
    
jQuery("#form_center").validate({
        rules: {
        pin: { pin: true },
        spoc_mobile: { mobile: true },
        "[type=email]": { email: true }
        }
    });
    
    /* End Custom Valiadtions */
</script>
@endsection