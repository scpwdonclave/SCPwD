@extends('layout.master')
@section('title', 'Schemes')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
<style>
.table td {
    padding: .10rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
    text-align: center;
}
</style>
@stop
@section('parentPageTitle', 'Dashboard')
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header d-flex justify-content-between">
                    <h2><strong>Scheme</strong> Section</h2>
                    <button id="btn_scheme" onclick="toggleit()" class="btn btn-primary btn-sm btn-round waves-effect">Add New Scheme</button>
                </div>
                <div class="body">
                    <form style="display:none" id="form_scheme" action="{{route('admin.dashboard.scheme_action')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="scheme">Scheme <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group form-float">
                                    <input type="text" class="form-control" placeholder="Scheme Name" value="{{ old('scheme') }}" name="scheme" required>
                                    @if ($errors->has('scheme'))
                                        <span style="color:red">{{$errors->first('scheme')}}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <label for="year">Year <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group form-float">
                                    <select id="year" class="form-control show-tick" data-live-search="true" name="year" onchange="redesign()" data-dropup-auto='false' required>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <label for="dept">Department <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" data-live-search="true" name="dept" data-show-subtext="true" data-dropup-auto='false' required>
                                        @foreach ($departments as $department)
                                            <option value="{{$department->id}}" data-subtext="{{ $department->dept_address }}" >{{ $department->dept_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="invoice_on">Invoice on Total <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" name="invoice_on" data-dropup-auto='false' required>
                                        <option value="0">Appeared</option>
                                        <option value="1">Assigned</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <label for="disability">Disabilty Type <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" name="disability" data-dropup-auto='false' required>
                                        <option value="0">Single Type</option>
                                        <option value="1">Multi Type</option>
                                    </select>
                                </div>
                            </div>
                        
                            <div class="col-sm-4">
                                <label for="finyear">Include Financial Year in Cert. No <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group form-float">
                                    <select id="finyear" class="form-control show-tick" data-live-search="true" name="finyear" onchange="redesign()" data-dropup-auto='false' required>
                                        <option value="1">Include Financial Year</option>
                                        <option value="0">Exclude Financial Year</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="cert_format">Certificate Number Format <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group form-float">
                                    <input type="text" class="form-control" placeholder="Certificate Number Format" value="{{ old('cert_format') }}" onkeyup="redesign()" name="cert_format" required>
                                    @if ($errors->has('cert_format'))
                                        <span style="color:red">{{$errors->first('cert_format')}}</span>
                                    @endif
                                </div>
                            </div>
                        
                        
                            <div class="col-sm-4">
                                <label for="logo">Scheme Logo <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group form-float">
                                    <input type="file" id="logo" class="form-control" name="logo" required>
                                    <span id="logo_error"  style="color:red;"></span>
                                </div>
                            </div>
                        
                            <div class="col-sm-4" id="cert_no_div" style="display:none;">
                                <label>Certificate Number will look like</label>
                                <div class="form-group form-float text-center">
                                    <span id="cert_no" style="color:blue;font-weight:bold;"></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row d-flex justify-content-center">
                            <button class="btn btn-round btn-primary" type="submit">ADD</button>
                        </div>
                    </form>

                    <div id="table_scheme" class="table-responsive">
                        <table id="scheme_table" class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Department</th>
                                    <th>Scheme</th>
                                    <th>Invoice on Total</th>
                                    <th>Disability Type</th>
                                    <th>Certificate Format</th>
                                    <th>Logo</th>
                                    <th>Action</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schemes as $scheme)
                                    <tr style="height:5px !important">
                                        <td>{{$scheme->department->dept_name}}</td>
                                        <td>{{$scheme->scheme}}</td>
                                        <td>{{$scheme->disability?'Assigned':'Appeared'}}</td>
                                        <td>{{$scheme->invoice_on?'Multy Type':'Single Type'}}</td>
                                        <td>{!!$scheme->cert_format."<span style='color:red;'>UniqueDigit</span>".($scheme->fin_yr?'/'.substr($scheme->year, 2):null)!!}</td>
                                        <td> <img src="{{route('admin.scheme',basename($scheme->logo))}}" width="50" alt="No Image"> </td>
                                        <td class="text-center"> <form id="editform_{{$scheme->id}}" action="#" method="post">@csrf <input type="hidden" name="data" value="{{$scheme->id.','.$scheme->scheme}}"><button type="submit" class="btn btn-primary btn-icon btn-icon-mini btn-round"><i class="zmdi zmdi-edit"></i></button></form></td>
                                        <td class="text-center"><button type="button" onclick="popup('{{Crypt::encrypt($scheme->id).','.$scheme->status.','.$scheme->scheme}}')" style="background:{{($scheme->status)?'#f72329':'#33a334'}}" class="btn btn-icon btn-icon-mini btn-round"><i class="zmdi zmdi-swap-vertical"></i></button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('page-script')

<script>
    /* Onload Function */
    $(() => {
        filevalidate();
    });
    /* End Onload Function */


    $('form[id^=editform_]').submit(function(e){
        e.preventDefault();
        var data = e.currentTarget.data.value.split(',');
        var _token = e.currentTarget._token.value;
        swal({
            text: "Please Provide Updated Scheme Name",
            content: {
                element: "input",
                attributes: {
                    value: data[1],
                    type: "text",
                },
            },
            icon: "info",
            buttons: true,
            buttons: {
                    cancel: "Cancel",
                    confirm: {
                        text: "Confirm Update",
                        closeModal: false
                    }
                },
            closeModal: false,
            closeOnEsc: false,
        }).then(function(val){
            var dataString = {_token:_token, id:data[0], name:data[1], value:val};
            if (val) {
                $.ajax({
                    url: "{{ route('admin.dashboard.scheme_action') }}",
                    method: "POST",
                    data: dataString,
                    success: function(data){
                        var SuccessResponseText = document.createElement("div");
                        SuccessResponseText.innerHTML = data['message'];
                        swal({title: "Job Done", content: SuccessResponseText, icon: data['type'], closeModal: true,timer: 3000, buttons: false}).then(function(){location.reload();});
                    },
                    error:function(data){
                        var errors = JSON.parse(data.responseText);
                        setTimeout(function () {
                            swal("Sorry", "Something Went Wrong, Please Try Again", "error");
                        }, 2000);
                    }
                });
            } else if (val!=null) {
                swal('Attention', 'You Have not Changed anything yet', 'info');
            }
        });
        
    });

    function popup(v){
        var data = v.split(',');
        var confirmatonText = document.createElement("div");
        var color=''; var text='';
        var _token=$('[name=_token]').val();
        if (data[1]==1) {color = 'red'; text = 'Deactivate';} else {color = 'green'; text = 'Activate';}
        var scheme=data[2];
        confirmatonText.innerHTML = "You are about to <span style='font-weight:bold; color:"+color+";'>"+text+"</span> This <span style='font-weight:bold; color:blue;'>"+scheme+"</span> Scheme";
        swal({
            text: "Are you Sure ?",
            content: confirmatonText,
            icon: "info",
            buttons: true,
            buttons: {
                    cancel: "No, Cancel",
                    confirm: {
                        text: "Confirm Update Status",
                        closeModal: false
                    }
                },
            closeModal: false,
            closeOnEsc: false,
        }).then(function(val){
            var dataString = {_token, id:data[0]};
            if (val) {
                $.ajax({
                    url: "{{ route('admin.dashboard.scheme_action') }}",
                    method: "POST",
                    data: dataString,
                    success: function(data){
                        var SuccessResponseText = document.createElement("div");
                        SuccessResponseText.innerHTML = data['message'];
                        setTimeout(function () {
                            swal({title: "Job Done", content: SuccessResponseText, icon: data['type'], closeModal: true,timer: 3000, buttons: false}).then(function(){location.reload();});
                        }, 2000);
                    },
                    error:function(data){
                        var errors = JSON.parse(data.responseText);
                        setTimeout(function () {
                            swal("Sorry", "Something Went Wrong, Please Try Again", "error");
                        }, 2000);
                    }
                });
            }
        });
    }




    $('#scheme_table').attr('data-page-length',5);


    /* Add Financial Year Items to Scheme Year */
    $(function(){
        var now = new Date();
        var value;
        var initial_year = (now.getMonth() > 2) ? now.getFullYear() : (now.getFullYear()-1);
        for (let i = 2016; i <= (initial_year+1); i++) {
            value = i+'-'+((i+1)%100);
            $('#year').append('<option value="' + value + '">' + value + '</option>');
            $('#year').selectpicker('refresh');
        }
    });
    /* End Add Financial Year Items to Scheme Year */

    /* File Type Validation */
    function filevalidate(){
        var _URL = window.URL || window.webkitURL;
        $("[type='file']").change(function(e) {
            var image, file;
            for (var i = this.files.length - 1; i >= 0; i--) {
                if ((file = this.files[i])) {
                    size = Math.round((file.size/1024/1024) * 100) / 100; // Size in MB

                    image = new Image();
                    var fileType = file["type"];
                    var ValidImageTypes = ["image/jpg", "image/jpeg", "image/png"];
                    if ($.inArray(fileType, ValidImageTypes) < 0) {
                        $("#"+e.currentTarget.id).val('');
                        
                        $("#" + e.currentTarget.id + "_error").text('File must be in jpg, jpeg or png Format');
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
    }
    /* End File Type Validation */

    /* Redesigning Certificate Number Format */
        function redesign(){
            let certno = $('[name=cert_format]').val();
            if (certno != '') {
                let finyear = $('[name=finyear]').val();
                if (finyear == '1') {
                    let year = $('[name=year]').val();
                    $('#cert_no').html(certno+'/1/'+year.substring(2));
                } else {
                    $('#cert_no').html(certno+'/1');
                }
                $('#cert_no_div').slideDown();
            } else {
                $('#cert_no_div').slideUp();
                $('#cert_no').html('');
            }
        }
    /* End Redesigning Certificate Number Format */


    // * Toggle Function

    function toggleit() {
        $('#form_scheme').toggle('slide');
        if ($('#btn_scheme').text() == 'Add New Scheme') {
            $('#btn_scheme').text('View Scheme Table');
        } else {
            $('#btn_scheme').text('Add New Scheme');
        }
        $('#table_scheme').toggle('slide');
    }

</script>

<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{asset('assets/js/scpwd-common.js')}}"></script>
@endsection