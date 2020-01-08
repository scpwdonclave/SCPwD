@extends('layout.master')
@section('title', 'Edit Candidate')
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
@stop
@section('content')
<div class="container-fluid home">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header d-flex justify-content-between">
                    <h2><strong>Edit</strong> Candidate</h2>
                                      
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
                    <div class="row d-flex justify-content-center">
                        <h6>Candidate's {{(strlen($candidate->candidate->doc_no)==12)?'Aadhaar':'Voter'}} Number <span style="color:blue;">{{$candidate->candidate->doc_no}}</span></h6>
                    </div>
                    <form id="form_candidate" method="POST" action="{{route('admin.tc.update.candidate')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{Crypt::encrypt($candidate->id)}}">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title"> <a role="button" href="#collapseOne" onclick="return false" aria-expanded="true" aria-controls="collapseOne">Candidate Basic Details</a> </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="panel-body">
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-3">
                                                <label for="name">Candidate Name <span style="color:red"> <strong>*</strong></span></label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="Candidate Name" value="{{ $candidate->candidate->name }}" name="name" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="contact">Candidate Contact <span style="color:red"> <strong>*</strong></span></label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="Candidate Contact" value="{{$candidate->candidate->contact}}"  name="contact" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="email">Candidate Email <span style="color:red"> <strong>*</strong></span></label>
                                                <div class="form-group form-float">
                                                    <input type="email" class="form-control" placeholder="Candidate Email" value="{{ $candidate->candidate->email }}"  name="email" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-3">
                                                <label for="gender">Gender <span style="color:red"> <strong>*</strong></span></label>
                                                <div class="form-group form-float">
                                                    <select class="form-control show-tick" data-live-search="true" name="gender" data-dropup-auto='false' required>
                                                        <option {{($candidate->candidate->gender=="Male")?'selected':null}}>Male</option>
                                                        <option {{($candidate->candidate->gender=="Female")?'selected':null}}>Female</option>
                                                        <option {{($candidate->candidate->gender=="Transgender")?'selected':null}}>Transgender</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="mobile">Date of Birth <span style="color:red"> <strong>*</strong></span></label>
                                                <div class="form-group form-float date_picker">
                                                    <input type="text" class="form-control" placeholder="Candidate's Date of Birth" value="{{ $candidate->candidate->dob }}" name="dob" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="m_status">Marital Status <span style="color:red"> <strong>*</strong></span></label>
                                                <div class="form-group form-float">
                                                    <select class="form-control show-tick" data-live-search="true" name="m_status" data-dropup-auto='false' required>
                                                        <option {{ ( $candidate->m_status =="Married") ? 'selected' : '' }}>Married</option>
                                                        <option {{ ( $candidate->m_status =="Unmarried") ? 'selected' : '' }}>Unmarried</option>
                                                        <option {{ ( $candidate->m_status =="Divorcee") ? 'selected' : '' }}>Divorcee</option>
                                                        <option {{ ( $candidate->m_status =="Widow/Widower") ? 'selected' : '' }}>Widow/Widower</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingTwo">
                                    <h4 class="panel-title"> <a role="button" href="#collapseTwo" onclick="return false" aria-expanded="true" aria-controls="collapseTwo">Candidate Other Details</a> </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="panel-body">
                                        <div class="card body field-group">
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-8">
                                                    <label for="address">Address <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Candidate's Address" value="{{ $candidate->address }}" name="address" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="state_district">State District <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <select id="state_district" class="form-control show-tick" name="state_district" data-live-search="true" data-dropup-auto='false' required>
                                                            @foreach ($states as $state)
                                                                <option value="{{$state->id}}" {{ ( $state->id==$candidate->state_district) ? 'selected' : '' }} data-subtext="{{ $state->state }}">{{ $state->district }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="category">Category <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="eg: SC / ST / OBC" value="{{ $candidate->candidate->category}}" name="category" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="service">Ex Service Employee <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <select id="service" class="form-control show-tick" name="service" data-dropup-auto='false' required>
                                                            <option {{ ( $candidate->service =="No") ? 'selected' : '' }}>No</option>
                                                            <option {{ ( $candidate->service =="Yes") ? 'selected' : '' }}>Yes</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="education">Education <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="eg: 10 / 12 / Diploma" value="{{ $candidate->education }}" name="education" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="g_name">Guardian Name <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Name of the Guardian" value="{{ $candidate->g_name  }}" name="g_name" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="g_type">Guardian Type <span style="color:red"> <strong>*</strong></span></label>
                                                    <div class="form-group form-float">
                                                        <select id="g_type" class="form-control show-tick" name="g_type" data-dropup-auto='false' required>
                                                            <option {{ ( $candidate->g_type =="Father") ? 'selected' : '' }}>Father</option>
                                                            <option {{ ( $candidate->g_type =="Mother") ? 'selected' : '' }}>Mother</option>
                                                            <option {{ ( $candidate->g_type =="Husband") ? 'selected' : '' }}>Husband</option>
                                                            <option {{ ( $candidate->g_type =="Wife") ? 'selected' : '' }}>Wife</option>
                                                        </select>
                                                    </div>
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
    /* Form Submission & Checking for Email Contact Duplicacy */
    
        $('#form_candidate').submit(function(e){
            e.preventDefault();
            if ($('#form_candidate').valid()) {
                        $(this).unbind().submit();
                
                // if ($('input:checkbox', this).length == $('input:checked', this).length) {
                    
                //     /* Disabling Prev & Submit Button and Proceed to Submit */
                    
                //         $("#submit_form").prop("disabled", true);
                //         $("#last_prev_btn").prop("disabled", true);
                //         $("#submit_form").html("Please Wait...");
                //         $(this).unbind().submit();
                    
                //     /* End Disabling Prev & Submit Button and Proceed to Submit */
                

                // } else {
                //     showNotification('danger','Please Accept the Terms & Conditions','top','center','wobble','zoomOut',0,250);
                // }
            }
        });
        
    /* End Form Submission & Checking for Email Contact Duplicacy */


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
        "[type=email]": { email: true }
        }
    });

/* End Custom Valiadtions */
</script>
@endsection