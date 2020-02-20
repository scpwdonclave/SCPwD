@extends('layout.master')
@section('title', 'Add Placement')
@section('parentPageTitle', 'Placements')
@section('page-style')
<!-- Custom Css -->
<link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/color_skins.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
<style>
/* .datepicker-inline {
    width: 100%;
}
.datepicker table {
    width: 100%;
} */

</style>
@stop
@section('content')
<div class="container-fluid home">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header d-flex justify-content-between">
                    <h2><strong>Add</strong> Placement</h2>
                    <a class="btn btn-primary btn-round waves-effect" href="{{route('center.placements')}}">My Placements</a>                      
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
                    <form id="form_candidate" method="POST" action="{{ route('center.placement.submit') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="candidate">Choose Candidate <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group form-float">
                                    <select id="candidate" class="form-control show-tick" name="candidate" data-live-search="true" data-dropup-auto='false' required>
                                        @foreach ($center_candidates as $centercandidate)
                                            @if (!$centercandidate->placement)
                                                <option value="{{$centercandidate->id}}">{{ $centercandidate->candidate->name.' ('.$centercandidate->candidate->cd_id.')' }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label id="placed_in" for="placed_in">Placed In <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group form-float">
                                    <input type="text" class="form-control" placeholder="Candidate Placed in" name="placed_in" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label id="placed_on" for="placed_on">Placed On <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group form-float placed_on">
                                    <input type="text" class="form-control" placeholder="Candidate Placed on" name="placed_on" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="offer_letter">Upload Offer Letter <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group form-float">
                                    <input type="file" id="offer_letter" class="form-control" name="offer_letter" required>
                                    <span id="offer_letter_error" style="color:red"></span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="appointment_letter">Upload Appointment Letter</label>
                                <div class="form-group form-float">
                                    <input type="file" id="appointment_letter" class="form-control" name="appointment_letter">
                                    <span id="appointment_letter_error" style="color:red"></span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="payslip">Three Months Salary Slip</label>
                                <div class="form-group form-float">
                                    <input type="file" id="payslip" class="form-control" name="payslip[]" multiple>
                                    <span id="payslip_error" style="color:red"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <button type="submit" class="btn btn-primary btn-round">Add Placement</button>
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

    /* File Type Validation */
        $(()=>{
            var _URL = window.URL || window.webkitURL;
            $("[type='file']").change(function(e) {
                
                var image, file;
                var l = this.files.length;
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

                            if (e.currentTarget.id === 'payslip') {
                                if (l !== 3) {
                                    $("#"+e.currentTarget.id).val('');
                                    $("#" + e.currentTarget.id + "_error").text('You have to choose exact 3 Files');
                                }
                            }

                            image.src = _URL.createObjectURL(file);
                        }
                    }
            });
        });
        
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
    
        $('.placed_on .form-control').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy',
        });
    
    /* End Bootstrap DatePicker */
    
});


</script>
@endsection