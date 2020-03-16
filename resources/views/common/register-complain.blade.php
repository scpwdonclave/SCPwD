@extends('layout.master')
@section('title', 'Register Complain')
@section('parentPageTitle', 'Support')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}">
<link href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">
@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Register</strong> Complain</h2>                         
                </div>
                <div class="body">
                    <form id="form_complain" action="{{route(Request::segment(1).'.support.register-complain')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="subject">Subject <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group form-float">
                                    <input type="text" class="form-control" placeholder="Please Enter Subject"  name="subject" required>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <label for="issue">Select Issue <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" data-live-search="true" name="issue" data-dropup-auto='false' required>
                                        <option value="">--Select--</option>
                                        <option value="Technical Issue">Technical Issue</option>
                                        <option value="Non-Technical Issue">Non-Technical Issue</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label>Choose File</label>
                                <div class="form-group form-float">
                                    <input id="screen" type="file" class="form-control" name="screen_shot[]" multiple>
                                    <span id="screen_error" style="color:red;"></span>                                                            
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="issue">Description <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <textarea rows="4" class="form-control no-resize" name="description" placeholder="Please type what you want..." required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <button class="btn btn-round btn-primary" type="submit">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('page-script')
<script>
 $(function(){
         /* Start File Type Validation */         
         
    var _URL = window.URL || window.webkitURL;
    $("[type='file']").change(function(e) {
        var image, file;
        for (var i = this.files.length - 1; i >= 0; i--) {
            if ((file = this.files[i])) {
                
                size = Math.round((file.size/1024/1024) * 100) / 100; // Size in MB

                image = new Image();
                var fileType = file["type"];
                
                var ValidImageTypes = ["image/jpg", "image/jpeg", "image/png", "application/pdf"];
                var txt_msg='File has to be in jpg, jpeg, png ,pdf';
                

                if ($.inArray(fileType, ValidImageTypes) < 0) {
                    $("#"+e.currentTarget.id).val('');
                    $("#" + e.currentTarget.id + "_error").text(txt_msg);
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
         
         /* End File Type Validation */
});
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
<script src="{{asset('assets/js/scpwd-common.js')}}"></script>

@endsection