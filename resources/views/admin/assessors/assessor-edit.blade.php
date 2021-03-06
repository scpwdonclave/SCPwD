@extends('layout.master')
@section('title', 'Add Assessor')
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
                    <h2><strong>Edit</strong> Assessor</h2>
                    
                </div>
                <div class="body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif 
                <form id="form_assessor" method="POST" action="{{route('admin.as.update.assessor')}}" enctype="multipart/form-data" onsubmit="event.preventDefault();return myFunction2();">
                        @csrf
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title"> <a role="button" href="#collapseOne" onclick="return false" aria-expanded="true" aria-controls="collapseOne"> Assessor General Details </a> </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="panel-body">
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-4">
                                                <label for="name">Name of the Applicant </label>
                                                <div class="form-group form-float">
                                                <input type="text" class="form-control" placeholder="Applicant Name" name="name" value="{{$assessor->name}}" required>
                                                <input type="hidden"  value="{{$assessor->id}}" name="as_id" >  
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="birth">Date of Birth </label>
                                                <div class="form-group form-float date_picker">
                                                    <input type="text" class="form-control date_datepicker" placeholder="Date of Birth" value="{{$assessor->birth}}" id="birth" name="birth"  required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="gender">Gender </label>
                                                <div class="form-group form-float">
                                                    <select class="form-control show-tick" data-live-search="true" name="gender" data-dropup-auto='false' required>
                                                        <option value="Male" {{($assessor->gender=='Male') ? 'selected' : '' }}>Male</option>
                                                        <option value="Female" {{($assessor->gender=='Female') ? 'selected' : '' }}>Female</option>
                                                        <option value="Transgender" {{($assessor->gender=='Transgender') ? 'selected' : '' }}>Transgender</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-4">
                                                <label for="language">Language known </label>
                                                <div class="form-group form-float">
                                                    <select class="form-control show-tick" data-live-search="true" name="language[]" multiple>
                                                        @foreach ($languages as $language)
                                                            <option value="{{$language->id}}" {{ (in_array($language->id,$selLang)) ? 'selected' : '' }}>{{ $language->language }}</option>
                                                            
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                    <label for="religion">Religion </label>
                                                    <div class="form-group form-float">
                                                        <select class="form-control show-tick" data-live-search="true" name="religion" data-dropup-auto='false' >
                                                            <option value="">--Select--</option>
                                                            <option value="Hinduism" {{($assessor->religion=='Hinduism') ? 'selected' : '' }}>Hinduism</option>
                                                            <option value="Islam" {{($assessor->religion=='Islam') ? 'selected' : '' }} >Islam</option>
                                                            <option value="Christianity" {{($assessor->religion=='Christianity') ? 'selected' : '' }} >Christianity</option>
                                                            <option value="Sikhism" {{($assessor->religion=='Sikhism') ? 'selected' : '' }} >Sikhism</option>
                                                            <option value="Buddhism" {{($assessor->religion=='Buddhism') ? 'selected' : '' }} >Buddhism</option>
                                                            <option value="Jainism" {{($assessor->religion=='Jainism') ? 'selected' : '' }} >Jainism</option>
                                                            <option value="Zoroastrianism" {{($assessor->religion=='Zoroastrianism') ? 'selected' : '' }} >Zoroastrianism</option>
                                                            <option value="Other" {{($assessor->religion=='Other') ? 'selected' : '' }} >Other</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            <div class="col-sm-4">
                                                <label for="category">Category</label>
                                                <div class="form-group form-float">
                                                    <select class="form-control show-tick"  name="category" data-dropup-auto='false' >
                                                        <option value="">--Select--</option>
                                                        <option value="General" {{($assessor->category=='General') ? 'selected' : '' }} >General</option>
                                                        <option value="OBC" {{($assessor->category=='OBC') ? 'selected' : '' }} >OBC</option>
                                                        <option value="SC" {{($assessor->category=='SC') ? 'selected' : '' }} >SC</option>
                                                        <option value="ST" {{($assessor->category=='ST') ? 'selected' : '' }} >ST</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-4">
                                                <label for="disability">Disability</label>
                                                <div class="form-group form-float">
                                                    <select class="form-control show-tick"  name="disability" data-dropup-auto='false' onchange="disabilityview()" >
                                                        <option value="yes" {{($assessor->d_type != null) ? 'selected' : '' }}>Yes</option>
                                                        <option value="no" {{($assessor->d_type == null) ? 'selected' : '' }}>No</option>
                                                       
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="disabl">
                                                <label for="d_type">Disability type</label>
                                                <div class="form-group form-float">
                                                    <select class="form-control show-tick" data-live-search="true" name="d_type" required >
                                                        <option value="">--select--</option>
                                                        @foreach ($expositories as $expository)
                                                            <option value="{{$expository->id}}" {{($assessor->d_type==$expository->id) ? 'selected' : '' }} >{{ $expository->e_expository }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="disabl">
                                                <label>Disability Certificate</label>
                                                <div class="form-group form-float">
                                                    <input id="d_certificate" type="file" class="form-control" name="d_certificate" >
                                                    <span id="d_certificate_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                         </div>
                                        </div>
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-6">
                                                <label for="aadhaar">Aadhaar </label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="Enter Aadhaar No" name="aadhaar" value="{{$assessor->aadhaar}}" onchange="checkduplicacy('aadhaar')" required>
                                                    <span id="aadhaar_error" style="color:red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Aadhaar Document </label>
                                                <div class="form-group form-float">
                                                    <input id="aadhaar_doc" type="file" class="form-control" name="aadhaar_doc">
                                                    <span id="aadhaar_doc_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-4">
                                                <label for="pan">PAN No</label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="PAN No" name="pan" value="{{$assessor->pan}}" >
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label>PAN Document</label>
                                                <div class="form-group form-float">
                                                    <input id="pan_doc" type="file" class="form-control" name="pan_doc">
                                                    <span id="pan_doc_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="mobile">Mobile Number </label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="Mobile" onchange="checkduplicacy('mobile')" name="mobile" value="{{$assessor->mobile}}" required>
                                                    <span id="mobile_error" style="color:red"></span>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-4">
                                                <label for="email">Email Address </label>
                                                <div class="form-group form-float">
                                                    <input type="email" class="form-control" placeholder="Email" onchange="checkduplicacy('email')" name="email" value="{{$assessor->email}}" required>
                                                    <span id="email_error" style="color:red"></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Upload Your Photo </label>
                                                <div class="form-group form-float">
                                                    <input id="photo" type="file" class="form-control" name="photo" >
                                                    <span id="photo_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="applicant_cat">Select Applicant Category </label>
                                                <div class="form-group form-float">
                                                    <select class="form-control show-tick"  name="applicant_cat" data-dropup-auto='false' >
                                                        <option value="Assessor" {{($assessor->category=='Assessor') ? 'selected' : '' }} >Assessor</option>
                                                        <option value="Master Assessor" {{($assessor->category=='Master Assessor') ? 'selected' : '' }} >Master Assessor</option>
                                                       
                                                    </select>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            
                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingTwo">
                                    <h4 class="panel-title"> <a role="button" href="#collapseTwo" onclick="return false" aria-expanded="true" aria-controls="collapseTwo">Address Details</a> </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="address">Address Line </label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="Full Address"  name="address" value="{{$assessor->address}}" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="post_office">Post Office </label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="Post Office"  name="post_office" value="{{$assessor->post_office}}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-4">
                                                <label for="state_district">State - District </label>
                                                <div class="form-group form-float">
                                                    <select class="form-control show-tick" data-live-search="true" name="state_district" data-show-subtext="true" data-dropup-auto='false' required>
                                                        @foreach ($states as $state)
                                                            <option value="{{$state->id}}"  data-subtext="{{ $state->state }}" {{($assessor->state_district==$state->id) ? 'selected' : ''}}>{{ $state->district }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="sub_district">Sub-District </label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="Sub-District"  name="sub_district" value="{{$assessor->sub_district}}" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="parliament">Parliament Constituency </label>
                                                <div class="form-group form-float">
                                                    <select class="form-control show-tick" data-live-search="true" name="parliament" data-show-subtext="true" data-dropup-auto='false' required>
                                                        @foreach ($parliaments as $parliament)
                                                            <option value="{{$parliament->id}}"  data-subtext="{{ $parliament->state_ut }}" {{($assessor->parliament==$parliament->id) ? 'selected' : ''}}>{{ $parliament->constituency }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-6">
                                                <label for="city">City/Town/Village </label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="City/Town/Village"  name="city" value="{{$assessor->city}}" required>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-6">
                                                <label for="pin">PIN code </label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="PIN Code"  name="pin" value="{{$assessor->pin}}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingThree">
                                    <h4 class="panel-title"> <a role="button" href="#collapseThree" onclick="return false" aria-expanded="true" aria-controls="collapseThree">Education Details</a> </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="panel-body">
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-4">
                                                <label for="education">Education Attaind </label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="Full Address"  name="education" value="{{$assessor->education}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="edu_details">Details of Education</label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="Details of Education"  name="edu_details" value="{{$assessor->edu_details}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Education Certificate</label>
                                                <div class="form-group form-float">
                                                    <input id="edu_doc" type="file" class="form-control" name="edu_doc">
                                                    <span id="edu_doc_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingFour">
                                    <h4 class="panel-title"> <a role="button" href="#collapseFour" onclick="return false" aria-expanded="true" aria-controls="collapseFour">Industry Experience Details</a> </h4>
                                </div>
                                <div id="collapseFour" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingFour" data-parent="#accordion">
                                    <div class="panel-body">
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-4">
                                                <label for="relevant_sector">Relevant Sector</label>
                                                <div class="form-group form-float">
                                                    <select class="form-control show-tick" data-live-search="true" name="relevant_sector"  data-dropup-auto='false' >
                                                        @foreach ($allsector as $sector)
                                                            <option value="{{$sector->id}}" {{($assessor->relevant_sector==$sector->id) ? 'selected' : ''}}>{{ $sector->sector }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="exp_year">Experience Year</label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="Experience Year"  name="exp_year" value="{{$assessor->exp_year}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="exp_month">Experience Month</label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="Experience Month"  name="exp_month" value="{{$assessor->exp_month}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-6">
                                                <label for="exp_dtl">Details of Experience</label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="Details of Experience"  name="exp_dtl" value="{{$assessor->exp_dtl}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="industry_dtl">Details of Industries</label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="Details of Industries"  name="industry_dtl" value="{{$assessor->industry_dtl}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-4">
                                                <label>Experience Certificate</label>
                                                <div class="form-group form-float">
                                                    <input id="exp_doc" type="file" class="form-control" name="exp_doc">
                                                    <span id="exp_doc_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Upload CV/Resume</label>
                                                <div class="form-group form-float">
                                                    <input id="resume" type="file" class="form-control" name="resume">
                                                    <span id="resume_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingFive">
                                    <h4 class="panel-title"> <a role="button" href="#collapseFive" onclick="return false" aria-expanded="true" aria-controls="collapseFive">SSC Certification</a> </h4>
                                </div>
                                <div id="collapseFive" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingFive" data-parent="#accordion">
                                    <div class="panel-body">
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-3">
                                                <label>Domain Certificate</label>
                                                <div class="form-group form-float">
                                                    <input id="domain_doc" type="file" class="form-control" name="domain_doc">
                                                    <span id="domain_doc_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="domain_certi_end_date">Domain Certificate Valid Upto </label>
                                                <div class="form-group form-float date_picker">
                                                    <input type="text" class="form-control date_datepicker" placeholder="Certificate Valid Upto" name="domain_certi_end_date" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="sector">Sector </label>
                                                <div class="form-group form-float">
                                                    <select class="form-control show-tick" data-live-search="true" name="sector"  onchange="fetchJob(this.value)"  data-dropup-auto='false' required >
                                                        <option value="" >Select Sector</option>
                                                        @foreach ($sectors as $sector)
                                                            <option value="{{$sector->sectors->id}}" {{($assessor->sector_id==$sector->sectors->id) ? 'selected' : ''}} >{{ $sector->sectors->sector }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="job_role">Job Role </label>
                                                <div class="form-group form-float">
                                                    <select class="form-control show-tick" data-live-search="true" name="job_role[]" id="job_role" data-dropup-auto='false' multiple >
                                                        @foreach ($assessor->sectors->job_roles as $job)
                                                            <option value="{{$job->id}}" {{ (in_array($job->id,$selJob)) ? 'selected' : '' }} >{{$job->job_role}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row d-flex justify-content-around">
                                            <div class="col-sm-3">
                                                <label for="scpwd_certi_no">SCPwD Certificate No</label>
                                                <div class="form-group form-float">
                                                    <input type="text" class="form-control" placeholder="SCPwD Certificate No"  name="scpwd_certi_no" value="{{$assessor->scpwd_certi_no}}" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="certi_date">Date of Certification</label>
                                                <div class="form-group form-float date_picker">
                                                    <input type="text" class="form-control date_datepicker" placeholder="Date of Certification" id="certi_date"  onchange="startchangescpwd('new')" value="{{$assessor->certi_date}}" name="certi_date" required >
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Upload Certificate</label>
                                                <div class="form-group form-float">
                                                    <input id="scpwd_doc" type="file" class="form-control" name="scpwd_doc">
                                                    <span id="scpwd_doc_error" style="color:red;"></span>                                                            
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="certi_end_date">Certification valid Upto</label>
                                                <div class="form-group form-float date_picker">
                                                    <input type="text" class="form-control date_datepicker" placeholder="Certification valid Upto" id="certi_end_date" name="certi_end_date" value="{{$assessor->certi_end_date}}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                           
                                            {{-- <div class="col-sm-4">
                                                <div class="form-group text-center">
                                                    <div class="checkbox">
                                                        <input id="terms" name="terms" type="checkbox">
                                                        <label for="terms">I Accept All the <a href="#TermsModal" data-toggle="modal" data-target="#TermsModal">Terms & Conditions </a></label>
                                                    </div>
                                                </div>
                                            </div> --}}
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

    $(function(){
        disabilityview();
    });

    function disabilityview(){
       var disability= $('[name=disability]').val();
                if(disability=='no'){
                 $('.disabl').hide();
                }else{
                 $('.disabl').show();

                }
            }

    /* Fetch job role */
    function fetchJob(sector){
       // console.log(sector);
        let _token = $("input[name='_token']").val();
            var sector=sector;
            
            $.ajax({
                    url:"{{route('admin.aa.fetch-jobrole')}}", 
                    data:{_token,sector},
                    method:'POST',
                    success: function(data){
                     
                    $('#job_role').empty();

                    $.each (data.jobroles, function (index) {
                    var id=data.jobroles[index].id;
                    var job=data.jobroles[index].job_role;
                    
                    $('#job_role').append('<option value="'+id+'">'+job+'</option>');
                    });
                   
                    $('#job_role').selectpicker('refresh');

                        }
                     });
                }

   /* Check Redundancy */
        var dup_email_tag = true;
        var dup_mobile_tag = true;
        var dup_aadhaar_tag = true;
       
        function checkduplicacy(val){
           
            
           dup_email_tag = false;
           dup_mobile_tag = false;
           dup_aadhaar_tag = false;
               var _token = $('[name=_token]').val();
               
               let value = $('[name='+val+']').val();
              
               let dataString = { checkredundancy: value, section: val, _token: _token, id: '{{$assessor->id}}' };
               $.ajax({
                   url: "{{route('admin.as.assessor.api')}}",
                   method: "POST",
                   data: dataString,
                   success: function(data){
                       
                       if (data.success) {
                           $('#'+val+'_error').html('');
                           if (val == 'email') {
                               dup_email_tag = false;
                           } else  if (val == 'mobile'){
                               dup_mobile_tag = false;
                           } else{
                               dup_aadhaar_tag = false;
                           }
                       } else {
                           $('#'+val+'_error').html(data.message);
                           if (val == 'email') {
                               dup_email_tag = true;
                           } else  if (val == 'mobile'){
                               dup_mobile_tag = true;
                           } else{
                               dup_aadhaar_tag = true;
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
         if(dup_email_tag==false ||dup_mobile_tag==false || dup_aadhaar_tag ==false){
        //    console.log('my reject');
        //    console.log(dup_email_tag);
        //    console.log(dup_mobile_tag);
        //    console.log(dup_aadhaar_tag);
          
            return false;
        }
        else{
            // console.log('my accept');

            var form = document.getElementById("form_assessor");
            form.submit();
            return true;
        }
    }

    /* Validation of Each Sections */

    // function validatedata(divs){
    //         div = divs.split(',');
    //         let tag = true;
    //         var fields = document.querySelectorAll('#'+div[0]+' input[required], #'+div[0]+' select[required]');
    //         fields.forEach(function (field) {
    //         if (!$("[name='"+ field.name +"']").valid()) {
    //             tag = false;
    //             return false;
    //             }
    //         });

    //         if (true) {

    //                 $('#'+div[0]).collapse('hide');
    //                 $('#'+div[0]).on('hidden.bs.collapse', function () {
    //                     $('#'+div[1]).collapse('show');
    //                 });
    //         }
    //     }

    /* End Validation of Each Sections */
        
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
                        size = Math.round((file.size/1024/1024) * 100) / 100; // Size in MB

                        image = new Image();
                        var fileType = file["type"];
                        var ValidImageTypes = ["image/jpg", "image/jpeg", "image/png", "application/pdf"];
                        if ($.inArray(fileType, ValidImageTypes) < 0) {
                            // invalid file type code goes here.
                            $("#"+e.currentTarget.id).val('');
                            $("#" + e.currentTarget.id + "_error").text('File must be in show jpg, jpeg, png or pdf Format');
                        } else {
                            $("#" + e.currentTarget.id + "_error").text('');
                        }

                        if (size > 5) {
                            $("#"+e.currentTarget.id).val('');
                            $("#" + e.currentTarget.id + "_error").text('File Size is Exceeding the limit of 5 MB');
                        } else {
                            $("#" + e.currentTarget.id + "_error").text('');
                        }


                        image.src = _URL.createObjectURL(file);
                        }
                    }

                });
            });


</script>

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
    
        
        $('.date_picker .form-control').datepicker({ 
            autoclose: true,
            format: 'dd-mm-yyyy'
        });

        $('#certi_end_date').datepicker('setDate', '{{$assessor->certi_end_date}}');
        $('#certi_end_date').datepicker('setStartDate', '{{$assessor->certi_end_date}}');
    
    /* End Bootstrap DatePicker */

    $('#certi_date')
        .datepicker()
        .on('changeDate', function(selected){
            startDate = new Date(selected.date.valueOf());
            startDate.setDate(startDate.getDate(new Date(selected.date.valueOf()))); 
            $('#certi_end_date').datepicker('setStartDate', startDate);
        });
    
});

function startchangescpwd(){
            $('#certi_end_date').val('');
        }


/* Custom Valiadtions */
    
    
jQuery("#form_assessor").validate({
        rules: {
        pin: { pin: true },
         aadhaar: { aadhaar: true },
        "[type=email]": { email: true }
        }
    });
    
    /* End Custom Valiadtions */
</script>
@endsection