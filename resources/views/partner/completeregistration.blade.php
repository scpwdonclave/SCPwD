@extends('partner.layouts.app')
@section('title', 'Finish Registration')
@section('page-style')
<link href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/animate-css/animate.css')}}">

{{-- <link rel="stylesheet" href="{{asset('assets/css/monthpicker.css')}}"> --}}
{{-- <link rel="stylesheet" href="{{asset('assets/css/spinner.css')}}"> --}}
{{-- <link rel="stylesheet" href="{{asset('assets/css/slider_button.css')}}"> --}}
{{-- <link href="{{asset('vendor/bootstrap-datetimepicker.css')}}" rel="stylesheet"> --}}
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-steps/jquery.steps.css')}}">


{{-- <link rel="stylesheet" href="../assets/plugins/bootstrap/css/bootstrap.min.css"> --}}
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}">
<!-- Custom Css -->
<link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/color_skins.css')}}">



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
                    <form id="form_complete_registration" method="POST" action="{{ route('partner.register') }}">
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
                                                    <label for="organization">Oganization Name *</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Name of the Organization" value="{{ old('organization') }}" name="organization" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="organization_type">Oganization Type</label>
                                                    <div class="form-group form-float">
                                                        <select class="form-control show-tick" data-live-search="true" name="organization_type" data-show-subtext="true" data-dropup-auto='false' required>
                                                            <option>Type 1</option>
                                                            <option>Type 2</option>
                                                            <option>Type 3</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            
                                                <div class="col-sm-3">
                                                    <label for="establishment">Establishment Year *</label>
                                                    <div class="form-group form-float year_picker">
                                                         <input type="text" class="form-control" placeholder="Year of Establishment" value="{{ old('establishment') }}" name="establishment" required>
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
                                                        <input type="number" min="0" minlength="10" maxlength="10" class="form-control" placeholder="Mobile" value="{{ old('ceo_mobile') }}" name="ceo_mobile">
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
                                                    <label for="sinatory_email">Authorized Signatory Email Address (as per Ministry)</label>
                                                    <div class="form-group form-float">
                                                        <input type="email" class="form-control" placeholder="Email" value="{{ old('sinatory_email') }}" name="sinatory_email">
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
                                        <h4 class="panel-title"> <a role="button" href="#collapseFour" onclick="return false" aria-expanded="true" aria-controls="collapseFour">SPOC Info</a> </h4>
                                    </div>
                                    <div id="collapseFour" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFour" data-parent="#accordion">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label for="spoc_name">SPOC Name</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Name" value="{{ old('spoc_name') }}" name="spoc_name">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="spoc_email">SPOC Email Address</label>
                                                    <div class="form-group form-float">
                                                        <input type="email" class="form-control" placeholder="Email" value="{{ old('spoc_email') }}" name="spoc_email">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="spoc_mobile">SPOC Mobile Number</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Mobile" value="{{ old('spoc_mobile') }}" name="spoc_mobile">
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
                                        <h4 class="panel-title"> <a role="button" href="#collapseFive" onclick="return false" aria-expanded="true" aria-controls="collapseFive">Address of The Organization</a> </h4>
                                    </div>
                                    <div id="collapseFive" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFive" data-parent="#accordion">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label for="organization_adddress">Address of the Organization*</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Organization Address *" value="{{ old('organization_adddress') }}" name="organization_adddress" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="landmark">Nearby Landmark *</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Landmark" value="{{ old('landmark') }}" name="landmark" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="city">City/Town/Village *</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="City/Town/Village" value="{{ old('city') }}" name="city" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="pin">Pincode *</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Pin Code" value="{{ old('pin') }}" name="pin" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="state">State/Union Territory *</label>
                                                    <div class="form-group form-float">
                                                        <select class="form-control show-tick" data-live-search="true" name="state" data-show-subtext="true" data-dropup-auto='false' required>
                                                            <option>Type 1</option>
                                                            <option>Type 2</option>
                                                            <option>Type 3</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="district">District *</label>
                                                    <div class="form-group form-float">
                                                        <select class="form-control show-tick" data-live-search="true" name="district" data-show-subtext="true" data-dropup-auto='false' required>
                                                            <option>Type 1</option>
                                                            <option>Type 2</option>
                                                            <option>Type 3</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="block">Tehsil/Mandal/Block *</label>
                                                    <div class="form-group form-float">
                                                        <select class="form-control show-tick" data-live-search="true" name="block" data-show-subtext="true" data-dropup-auto='false' required>
                                                            <option>Type 1</option>
                                                            <option>Type 2</option>
                                                            <option>Type 3</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="constituency">Parliament Constituency *</label>
                                                    <div class="form-group form-float">
                                                        <select class="form-control show-tick" data-live-search="true" name="constituency" data-show-subtext="true" data-dropup-auto='false' required>
                                                            <option>Type 1</option>
                                                            <option>Type 2</option>
                                                            <option>Type 3</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-3">
                                                    <label for="city">Address Proof *</label>
                                                    <div class="form-group form-float">
                                                        <select class="form-control show-tick" data-live-search="true" name="address" data-show-subtext="true" data-dropup-auto='false' required>
                                                            <option>Type 1</option>
                                                            <option>Type 2</option>
                                                            <option>Type 3</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="address_doc">Address Proof Document *</label>
                                                    <div class="form-group form-float">
                                                        <input id="address_doc" type="file" class="form-control" name="address_doc" required>
                                                        <span id="address_doc_error"  style="color:red;"></span>                                                            
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-3">
                                                    <label for="incorp_cert">Incorportaion Certificate *</label>
                                                    <div class="form-group form-float">
                                                        <input id="incorp_cert" type="file" class="form-control" name="incorp_cert" required>
                                                        <span id="incorp_cert_error"  style="color:red;"></span>                                                            
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="tel_elec_doc">Telephone/Electricity *</label>
                                                    <div class="form-group form-float">
                                                        <input id="tel_elec_doc" type="file" class="form-control" name="tel_elec_doc" required>
                                                        <span id="tel_elec_doc_error"  style="color:red;"></span>                                                            
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="bank_doc">Bank Statement *</label>
                                                    <div class="form-group form-float">
                                                        <input id="bank_doc" type="file" class="form-control" name="bank_doc" required>
                                                        <span id="bank_doc_error"  style="color:red;"></span>                                                            
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="row d-flex justify-content-around">
                                                <div class="col-sm-4">
                                                    <label for="income_cert">Incometax Certificate *</label>
                                                    <div class="form-group form-float">
                                                        <input id="income_cert" type="file" class="form-control" name="income_cert" required>
                                                        <span id="income_cert_error"  style="color:red;"></span>                                                            
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="rent_doc">Rent/ Lease Agreement</label>
                                                    <div class="form-group form-float">
                                                        <input id="rent_doc" type="file" class="form-control" name="rent_doc">
                                                        <span id="rent_doc_error"  style="color:red;"></span>                                                            
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
                                        <h4 class="panel-title"> <a role="button" href="#collapseSix" onclick="return false" aria-expanded="true" aria-controls="collapseSix">Financial Information</a> </h4>
                                    </div>
                                    <div id="collapseSix" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingSix" data-parent="#accordion">
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
                                            {{-- </div>
                                            <div class="row d-flex justify-content-center"> --}}
                                                <div class="col-sm-3">
                                                    <label for="gst">GST Account Number</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="GST Number" onkeyup="this.value = this.value.toUpperCase();" value="{{ old('gst') }}" name="gst">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="gst_doc">GST Registration Certificate</label>
                                                    <div class="form-group form-float">
                                                        <input id="gst_doc" type="file" class="form-control" name="gst_doc">
                                                        <span id="gst_doc_error"  style="color:red;"></span>                                                            
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <button type="button" onclick="validatedata('collapseSix,collapseFive');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Previous</button>
                                                </div>
                                                <div class="col-sm-6 text-right">
                                                    <button type="button" onclick="validatedata('collapseSix,collapseSeven');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-right"></span> Next</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-primary">
                                    <div class="panel-heading" role="tab" id="headingSeven">
                                        <h4 class="panel-title"> <a role="button" href="#collapseSeven" onclick="return false" aria-expanded="true" aria-controls="collapseSeven">Authorized Signatory Info</a> </h4>
                                    </div>
                                    <div id="collapseSeven" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingSeven" data-parent="#accordion">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label for="offer_latter">Offer Latter *</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Offer Latter Number" value="{{ old('offer_latter') }}" name="offer_latter" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="offer_approval">Offer LetterApproval Date *</label>
                                                    <div class="form-group form-float date_picker">
                                                        <input type="text" class="form-control date_datepicker" placeholder="Approval Date" value="{{ old('offer_approval') }}" name="offer_approval" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="offer_latter_doc">Offer Latter File *</label>
                                                    <div class="form-group form-float">
                                                        <input id="offer_latter_doc" type="file" class="form-control" name="offer_latter_doc" required>
                                                        <span id="offer_latter_doc_error"  style="color:red;"></span>                                                            
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label for="sanction_letter">Sanction Letter *</label>
                                                    <div class="form-group form-float">
                                                        <input type="text" class="form-control" placeholder="Sanction Latter Number" value="{{ old('sanction_letter') }}" name="sanction_letter" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="sanction_approval">Sanction Letter Approval Date *</label>
                                                    <div class="form-group form-float date_picker">
                                                        <input type="text" class="form-control date_datepicker" placeholder="Approval Date" value="{{ old('sanction_approval') }}" name="sanction_approval" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="sanction_letter_doc">Sanction Letter File *</label>
                                                    <div class="form-group form-float">
                                                        <input id="sanction_letter_doc" type="file" class="form-control" name="sanction_letter_doc" required>
                                                        <span id="sanction_letter_doc_error"  style="color:red;"></span>                                                            
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <button id="last_prev_btn" type="button" onclick="validatedata('collapseSeven,collapseSix');" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Previous</button>
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

</script>



<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/partner/jquery.repeatable.js')}}"></script>
<script src="{{asset('assets/js/pages/partner/complete-registration.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>

<script src="{{asset('assets/plugins/jquery-steps/jquery.steps.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-notify/bootstrap-notify.js')}}"></script>

<script src="{{asset('assets/js/pages/forms/form-wizard.js')}}"></script>
<script src="{{asset('assets/js/pages/common/notifications.js')}}"></script>



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

    

    /* Additional Methods for Validating PAN & GST  */
    
        jQuery.validator.addMethod("pan", function(value, element)
            {
                return this.optional(element) || /^[A-Z]{5}\d{4}[A-Z]{1}$/.test(value);
            }, "Please enter a valid PAN");
        jQuery.validator.addMethod("gst", function(value, element)
            {
                return this.optional(element) || /^([0-9]{2}[A-Z]{4}([A-Z]{1}|[0-9]{1})[0-9]{4}[A-Z]{1}([A-Z]|[0-9]){3}){0,15}$/.test(value);
            }, "Please enter a valid GST Number");
        jQuery.validator.addMethod("website", function(value, element)
            {
                return this.optional(element) || /^((https?|ftp|smtp):\/\/)?(www.)?[a-z0-9]+\.[a-z]+(\/[a-zA-Z0-9#]+\/?)*$/.test(value);
            }, "Please enter a valid Website url");
        jQuery.validator.addMethod("email", function(value, element)
            {
                return this.optional(element) || /^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i.test(value);
            }, "Please enter a valid Email");

        jQuery("#form_complete_registration").validate({
            rules: {
                "pan": {pan: true},
                "gst": {gst: true},
                "website": {website: true},
                "[type=email]": {website: true}
            },
        });

    /* End Additional Methods for Validating PAN & GST  */

</script>
@stop
