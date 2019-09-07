@extends('layout.master')
@section('title', 'Finish Registration')
@section('page-style')
<link href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/animate-css/animate.css')}}">

{{-- <link rel="stylesheet" href="{{asset('assets/css/monthpicker.css')}}"> --}}
{{-- <link rel="stylesheet" href="{{asset('assets/css/spinner.css')}}"> --}}
{{-- <link rel="stylesheet" href="{{asset('assets/css/slider_button.css')}}"> --}}
{{-- <link href="{{asset('vendor/bootstrap-datetimepicker.css')}}" rel="stylesheet"> --}}
{{-- <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.css')}}"> --}}
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-steps/jquery.steps.css')}}">


{{-- <link rel="stylesheet" href="../assets/plugins/bootstrap/css/bootstrap.min.css"> --}}
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}">
<!-- Custom Css -->
<link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/color_skins.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">



<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}"/>
@stop
@section('content')
<div class="container-fluid home">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Complete</strong> Registration</h2>
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
                    <div class="row d-flex justify-content-around">
                        <div class="col-sm-3">
                            <p>SPOC Name : <h6>{{ $partner->spoc_name }}</h6></p>
                        </div>
                        <div class="col-sm-3">
                            <p>SPOC Email : <h6>{{ $partner->email }}</h6></p>
                        </div>
                        <div class="col-sm-3">
                            <p>SPOC Phone : <h6>{{ $partner->spoc_mobile }}</h6></p>
                        </div>

                    </div>
                    <form id="form_complete_registration" method="POST" action="{{ route('partner.comp-register') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-primary">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title"> <a role="button" href="#collapseOne" onclick="return false" aria-expanded="true" aria-controls="collapseOne"> General Details </a> </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="panel-body">
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-3">
                                                    <label for="org_name">Oganization Name *</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Name of the Organization" value="{{ old('org_name') }}" name="org_name" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="org_type">Oganization Type</label>
                                                    <div class="form-group form-float">
                                                        <select class="form-control show-tick" data-live-search="true" name="org_type" data-show-subtext="true" data-dropup-auto='false' required>
                                                            <option>Type 1</option>
                                                            <option>Type 2</option>
                                                            <option>Type 3</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            
                                                <div class="col-sm-3">
                                                    <label for="estab_year">Establishment Year *</label>
                                                    <div class="form-group form-float year_picker">
                                                         <input type="text" class="form-control" placeholder="Year of Establishment" value="{{ old('estab_year') }}" name="estab_year" required>
                                                    </div>
                                                </div>
                                                
                                                
                                            </div>

                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="landline">Landline</label>
                                                    <div class="form-group form-float">
                                                        <input type="number" min="0" class="form-control" placeholder="Landline Number" value="{{ old('landline') }}" name="landline">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="website">Website</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Website" value="{{ old('website') }}" name="website">
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
                                        <h4 class="panel-title"> <a role="button" href="#collapseTwo" onclick="return false" aria-expanded="true" aria-controls="collapseTwo">CEO/MD/Head of the Organization Details</a> </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                                        <div class="panel-body">
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="ceo_name">CEO/MD/Head's Name</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Name" value="{{ old('ceo_name') }}" name="ceo_name">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="ceo_email">CEO/MD/Head's Email Address</label>
                                                    <div class="form-group form-float">
                                                        <input type="email" class="form-control" placeholder="Email" value="{{ old('ceo_email') }}" name="ceo_email">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="ceo_mobile">CEO/MD/Head's Mobile Number</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Mobile" value="{{ old('ceo_mobile') }}" name="ceo_mobile">
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

                                <div class="panel panel-primary">
                                    <div class="panel-heading" role="tab" id="headingThree">
                                        <h4 class="panel-title"> <a role="button" href="#collapseThree" onclick="return false" aria-expanded="true" aria-controls="collapseThree">Authorized Signatory Info</a> </h4>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label for="signatory_name">Authorized Signatory Name (as per Ministry)</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Name" value="{{ old('signatory_name') }}" name="signatory_name">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="signatory_email">Authorized Signatory Email Address (as per Ministry)</label>
                                                    <div class="form-group form-float">
                                                        <input type="email" class="form-control" placeholder="Email" value="{{ old('signatory_email') }}" name="signatory_email">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="signatory_mobile">Authorized Signatory Mobile Number (as per Ministry)</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Mobile" value="{{ old('signatory_mobile') }}" name="signatory_mobile">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <button type="button" onclick="validatedata('collapseThree,collapseTwo');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Previous</button>
                                                </div>
                                                <div class="col-sm-6 text-right">
                                                    <button type="button" onclick="validatedata('collapseThree,collapseFour');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-right"></span> Next</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-primary">
                                    <div class="panel-heading" role="tab" id="headingFour">
                                        <h4 class="panel-title"> <a role="button" href="#collapseFour" onclick="return false" aria-expanded="true" aria-controls="collapseFour">Address of The Organization</a> </h4>
                                    </div>
                                    <div id="collapseFour" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingFour" data-parent="#accordion">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="org_address">Address of the Organization *</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Organization Address" value="{{ old('org_address') }}" name="org_address" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
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
                                                        <select class="form-control show-tick" data-live-search="true" name="addr_proof" onchange="checkaddress();" data-show-subtext="true" data-dropup-auto='false' required>
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
                                                    <button type="button" onclick="validatedata('collapseFour,collapseThree');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Previous</button>
                                                </div>
                                                <div class="col-sm-6 text-right">
                                                    <button type="button" onclick="validatedata('collapseFour,collapseFive');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-right"></span> Next</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-primary">
                                    <div class="panel-heading" role="tab" id="headingFive">
                                        <h4 class="panel-title"> <a role="button" href="#collapseFive" onclick="return false" aria-expanded="true" aria-controls="collapseFive">Financial Information</a> </h4>
                                    </div>
                                    <div id="collapseFive" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFive" data-parent="#accordion">
                                        <div class="panel-body">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col-sm-5">
                                                    <label for="ca1_doc">1 Pager CA Certificate of <span id="ca1"></span></label>
                                                    <div class="form-group form-float">
                                                        <input id="ca1_doc" type="file" class="form-control" name="ca1_doc">
                                                        <span id="ca1_doc_error"  style="color:red;"></span>                                                            
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <label for="ca2_doc">1 Pager CA Certificate of <span id="ca2"></span></label>
                                                    <div class="form-group form-float">
                                                        <input id="ca2_doc" type="file" class="form-control" name="ca2_doc">
                                                        <span id="ca2_doc_error"  style="color:red;"></span>                                                            
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex justify-content-center">
                                                <div class="col-sm-5">
                                                    <label for="ca3_doc">1 Pager CA Certificate of <span id="ca3"></span></label>
                                                    <div class="form-group form-float">
                                                        <input id="ca3_doc" type="file" class="form-control" name="ca3_doc">
                                                        <span id="ca3_doc_error"  style="color:red;"></span>                                                            
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <label for="ca4_doc">1 Pager CA Certificate of <span id="ca4"></span></label>
                                                    <div class="form-group form-float">
                                                        <input id="ca4_doc" type="file" class="form-control" name="ca4_doc">
                                                        <span id="ca4_doc_error"  style="color:red;"></span>                                                            
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex justify-content-center">
                                                <div class="col-sm-3">
                                                    <label for="pan">PAN Number *</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="PAN Number" value="{{ old('pan') }}" name="pan" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="pan_doc">PAN Document *</label>
                                                    <div class="form-group form-float">
                                                        <input id="pan_doc" type="file" class="form-control" name="pan_doc" required>
                                                        <span id="pan_doc_error"  style="color:red;"></span>                                                            
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="gst">GST Account Number</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="GST Number" onkeyup="this.value = this.value.toUpperCase();" value="{{ old('gst') }}" name="gst">
                                                    </div>
                                                </div>
                                                <div id="gst_doc_id" class="col-sm-3">
                                                    <label for="gst_doc">GST Registration Certificate</label>
                                                    <div class="form-group form-float">
                                                        <input id="gst_doc" type="file" class="form-control" name="gst_doc">
                                                        <span id="gst_doc_error"  style="color:red;"></span>                                                            
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <button type="button" onclick="validatedata('collapseFive,collapseFour');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Previous</button>
                                                </div>
                                                <div class="col-sm-6 text-right">
                                                    <button type="button" onclick="validatedata('collapseFive,collapseSix');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-right"></span> Next</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-primary">
                                    <div class="panel-heading" role="tab" id="headingSix">
                                        <h4 class="panel-title"> <a role="button" href="#collapseSix" onclick="return false" aria-expanded="true" aria-controls="collapseSix">Personal Information</a> </h4>
                                    </div>
                                    <div id="collapseSix" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingSix" data-parent="#accordion">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label for="offer">Offer Letter *</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Offer Letter Number" value="{{ old('offer') }}" name="offer" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="offer_date">Offer Letter Approval Date *</label>
                                                    <div class="form-group form-float date_picker">
                                                        <input type="text" class="form-control date_datepicker" placeholder="Approval Date" value="{{ old('offer_date') }}" name="offer_date" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="offer_doc">Offer Letter File *</label>
                                                    <div class="form-group form-float">
                                                        <input id="offer_doc" type="file" class="form-control" name="offer_doc" required>
                                                        <span id="offer_doc_error"  style="color:red;"></span>                                                            
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label for="sanction">Sanction Letter *</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Sanction Letter Number" value="{{ old('sanction') }}" name="sanction" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="sanction_date">Sanction Letter Approval Date *</label>
                                                    <div class="form-group form-float date_picker">
                                                        <input type="text" class="form-control date_datepicker" placeholder="Approval Date" value="{{ old('sanction_date') }}" name="sanction_date" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="sanction_doc">Sanction Letter File *</label>
                                                    <div class="form-group form-float">
                                                        <input id="sanction_doc" type="file" class="form-control" name="sanction_doc" required>
                                                        <span id="sanction_doc_error"  style="color:red;"></span>                                                            
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <button id="last_prev_btn" type="button" onclick="validatedata('collapseSix,collapseFive');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Previous</button>
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
@stop
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
    $(function(){
        /* Start File Type Validation for jpg,jpeg,png,pdf */         
        
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
        
        /* End File Type Validation for jpg,jpeg,png,pdf */


        /* Finantial Year Calculator for CA Certificate Section */
        
            var now = new Date();
            var initial_year = (now.getMonth() > 2) ? now.getFullYear() : (now.getFullYear()-1);

            for (let i = 1; i <= 4; i++) { 
                var text = initial_year + '-' + (initial_year+1);
                $('#ca'+i).html(text);
                initial_year--;
            }

        /* End Finantial Year Calculator for CA Certificate Section */
    });



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
        
        $('#form_complete_registration').submit(function(e){
            e.preventDefault();
            if ($('#form_complete_registration').valid()) {
                if ($('input:checkbox', this).length == $('input:checked', this).length) {
                    
                    /* Disabling Prev & Submit Button and Proceed to Submit */
                    
                        $("#submit_form").prop("disabled", true);
                        $("#last_prev_btn").prop("disabled", true);
                        $("#submit_form").html("Please Wait...");
                        $(this).unbind().submit();
                    
                    /* End Disabling Prev & Submit Button and Proceed to Submit */
                

                } else {
                    showNotification('danger','Please Accept the Terms & Conditions','top','center','wobble','zoomOut',0,250);
                    console.log('Not Checked');
                }
            }
        });
        
    /* End Making Sure That the Terms & Condition is Accepted */


    /* Checking Address Proof Type */
        
        function checkaddress(){
            if ($('select[name=addr_proof]').val() === 'Incorportaion Certificate') {
                $('#addr_doc_error').slideUp('slow');
                $('#addr_doc').slideUp('slow', function(){
                    $('#addr_doc-error').text('');
                    $('#addr_doc2').hide().html('We Have Your Incorporation Certificate').fadeIn('slow');
                });

            } else {
                $('#addr_doc2').fadeOut('slow').html('');
                $('#addr_doc').slideDown('slow');
                $('#addr_doc_error').slideDown('slow');
                $('#addr_doc_error').html(''); 
            }

            if ($('select[name=addr_proof]').val() === 'GST Registration Certificate') {
                $('#gst_doc_id').hide();
            } else {
                $('#gst_doc_id').show();
            }
        }

    /* End Checking Address Proof Type */

</script>



<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/partner/jquery.repeatable.js')}}"></script>
{{-- <script src="{{asset('assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js')}}"></script> --}}
<script src="{{asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>

<script src="{{asset('assets/plugins/jquery-steps/jquery.steps.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-notify/bootstrap-notify.js')}}"></script>

<script src="{{asset('assets/js/pages/forms/form-wizard.js')}}"></script>
<script src="{{asset('assets/js/pages/common/notifications.js')}}"></script>
<script src="{{asset('assets/js/scpwd-common.js')}}"></script>



<script type="text/javascript">
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
    
    
    jQuery("#form_complete_registration").validate({
        rules: {
        pan: { pan: true },
        gst: { gst: true },
        website: { website: true },
        pin: { pin: true },
        ceo_mobile: { mobile: true },
        signatory_mobile: { mobile: true },
        "[type=email]": { email: true }
        }
    });
    
    /* End Custom Valiadtions */
    
</script>
@endsection
