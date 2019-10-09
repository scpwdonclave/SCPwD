@extends('layout.master')
@section('title', 'Job Roles')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
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
    <div class="row">
        @if ($errors->any())
            <div class="card">
                <div class="body">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="row clearfix">
            <div class="col-lg-6">
                <div class="card">
                    <div class="header d-flex justify-content-between">
                        <h2><strong>Manage</strong> Sector</h2>
                        <button id="btn_sector" onclick="showform(0)" class="btn btn-primary btn-sm btn-round waves-effect">Add New Sector</button>                       
                    </div>
                    <div class="body">
                        <form style="display:none" id="form_sector" action="{{route('admin.dashboard.jobroles')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="sector">Sector *</label>
                                    <div class="form-group form-float year_picker">
                                        <input type="text" class="form-control" placeholder="Sector Name" value="{{ old('sector') }}" name="sector" required>
                                        @if ($errors->has('sector'))
                                            <span style="color:red">{{$errors->first('sector')}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row d-flex justify-content-center">
                                <button class="btn btn-round btn-primary" type="submit">ADD</button>
                            </div>
                        </form>

                        <div id="table_sector" class="table-responsive">
                            <table id="sector_table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Sectors</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sectors as $key=>$sector)
                                    <tr style="height:5px !important">
                                    <td>{{$key+1}}</td>
                                    <td>{{$sector->sector}}</td>
                                    <td class="text-center"> <form id="removeform_Sector_{{$sector->id}}" action="#" method="post">@csrf <input type="hidden" name="data" value="{{$sector->id.','.$sector->sector}}"><button type="submit" class="btn btn-simple btn-danger btn-icon btn-icon-mini btn-round"><i class="zmdi zmdi-delete"></i></button></form></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="header d-flex justify-content-between">
                        <h2><strong>Manage</strong> Expository</h2>
                        <button id="btn_expository" onclick="showform(1)" class="btn btn-primary btn-sm btn-round waves-effect">Add New Expository</button>                       
                    </div>
                    <div class="body">
                        <form style="display:none" id="form_expository" action="{{route('admin.dashboard.jobroles')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="expository">Expository *</label>
                                    <div class="form-group form-float year_picker">
                                        <input type="text" class="form-control" placeholder="Expository Name" value="{{ old('expository') }}" name="expository" required>
                                        @if ($errors->has('expository'))
                                            <span style="color:red">{{$errors->first('expository')}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="initials">Initial *</label>
                                    <div class="form-group form-float year_picker">
                                        <input type="text" class="form-control" placeholder="Expository Initial" value="{{ old('initials') }}" name="initials" required>
                                        @if ($errors->has('initials'))
                                            <span style="color:red">{{$errors->first('initials')}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row d-flex justify-content-center">
                                <button class="btn btn-round btn-primary" type="submit">ADD</button>
                            </div>
                        </form>

                        <div id="table_expository" class="table-responsive">
                            <table id="exository_table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Initials</th>
                                        <th>Expositories</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($expositories as $key=>$expository)
                                    <tr style="height:5px !important">
                                    <td>{{$key+1}}</td>
                                    <td>{{$expository->initials}}</td>
                                    <td>{{$expository->e_expository}}</td>
                                    <td class="text-center"> <form id="removeform_Expository_{{$expository->id}}" action="#" method="post">@csrf <input type="hidden" name="data" value="{{$expository->id.','.$expository->expository}}"><button type="submit" class="btn btn-simple btn-danger btn-icon btn-icon-mini btn-round"><i class="zmdi zmdi-delete"></button></form></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="header d-flex justify-content-between">
                        <h2><strong>Manage</strong> Job Roles</h2>                        
                        <button id="btn_roles" onclick="showform(2)" class="btn btn-primary btn-sm btn-round waves-effect">Add New Job Role</button>                       
                </div>
                <div class="body">
                    <form style="display:none" id="form_roles" action="{{route('admin.dashboard.jobroles')}}" method="post">
                        @csrf
                        <div class="row d-flex justify-content-around">
                            <div class="col-sm-5">
                                <label for="sector_id">Sector *</label>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" data-live-search="true" name="sector_id" data-show-subtext="true" data-dropup-auto='true' required>
                                        @foreach ($sectors as $sector)
                                            <option value="{{$sector->id}}">{{$sector->sector}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <label for="role_expository">Expository *</label>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick selectpicker" data-live-search="true" name="role_expository[]" multiple data-show-subtext="true" data-dropup-auto='true' required>
                                        @foreach ($expositories as $expository)
                                            <option value="{{$expository->id}}" data-subtext="({{ $expository->e_expository }})">{{$expository->initials}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row d-flex-justify-content-center">
                            <div class="col-sm-4">
                                <label for="job_role">Job Role *</label>
                                <div class="form-group form-float year_picker">
                                    <input type="text" class="form-control" placeholder="Job Role Name" value="{{ old('job_role') }}" name="job_role" required>
                                    @if ($errors->has('job_role'))
                                        <span style="color:red">{{$errors->first('job_role')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="qp_code">QP Code *</label>
                                <div class="form-group form-float year_picker">
                                    <input type="text" class="form-control" placeholder="QP Code" value="{{ old('qp_code') }}" name="qp_code" required>
                                    @if ($errors->has('qp_code'))
                                        <span style="color:red">{{$errors->first('qp_code')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="nsqf_level">NSQF Level *</label>
                                <div class="form-group form-float year_picker">
                                    <input type="number" class="form-control" placeholder="NSQF Level" value="{{ old('nsqf_level') }}" name="nsqf_level" required>
                                    @if ($errors->has('nsqf_level'))
                                        <span style="color:red">{{$errors->first('nsqf_level')}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    
                        <div class="row d-flex justify-content-center">
                            <button class="btn btn-round btn-primary" type="submit">ADD</button>
                        </div>
                    </form>
                    <div id="table_roles" class="table-responsive">
                        <table id="roles_table" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Sector</th>
                                    <th>Job Role</th>
                                    <th>QP Code</th>
                                    <th>NSQF</th>
                                    <th>Disabilities</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $item1='';
                                @endphp
                                @foreach ($jobroles as $key=>$jobrole)
                                <tr style="height:5px !important">
                                    <td>{{$jobrole->sector->sector}}</td>
                                    <td>{{$jobrole->job_role}}</td>
                                    <td>{{$jobrole->qp_code}}</td>
                                    <td>{{$jobrole->nsqf_level}}</td>
                                    @foreach ($jobrole->expositories as $item)
                                        @php
                                            $item1 = $item->initials.', '.$item1;
                                        @endphp
                                    @endforeach
                                    <td>{{$item1}}</td>
                                    <td class="text-center"> <form id="removeform_JobRole_{{$jobrole->id}}" action="#" method="post">@csrf <input type="hidden" name="data" value="{{$jobrole->id.','.$jobrole->job_role}}"><button type="submit" class="btn btn-simple btn-danger btn-icon btn-icon-mini btn-round"><i class="zmdi zmdi-delete"></button></form></td>
                                </tr>
                                @php
                                    $item1='';
                                @endphp
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

    $('[name=expository]').on('change', function(e){
        var matches = e.currentTarget.value.match(/\b(\w)/g);
        $('[name=initials]').val(matches.join('').toUpperCase());        
    });

    $('form[id^=removeform_]').submit(function(e){
        e.preventDefault();
        var section = e.currentTarget.id.split('_');
        // console.log(value[1]);

        
        var data = e.currentTarget.data.value.split(',');
        var _token = e.currentTarget._token.value;
        var dataString = {_token:_token, id:data[0], name:data[1], section: section[1]};
        var confirmatonText = document.createElement("div");
        confirmatonText.innerHTML = "You are about to Remove <br><span style='font-weight:bold; color:red;'>"+ data[1] +"</span><br>"+section[1];
        swal({
            title: "Are you Sure ?",
            content: confirmatonText,
            icon: "info",
            buttons: true,
            buttons: {
                    cancel: "Not Now",
                    confirm: {
                        text: "Confirm Remove",
                        closeModal: false
                    }
                },
            closeModal: false,
            closeOnEsc: false,
        }).then(function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    url: "{{ route('admin.dashboard.jobroles') }}",
                    method: "POST",
                    data: dataString,
                    success: function(data){
                        var SuccessResponseText = document.createElement("div");
                        SuccessResponseText.innerHTML = data['message'];
                        if (data['type'] === 'success') {
                            setTimeout(function () {
                                swal({title: "Job Done", content: SuccessResponseText, icon: "success", closeOnEsc: false}).then(function(){
                                    setTimeout(function(){location.reload()},150);
                                });
                            }, 2000);
                        } else {
                            setTimeout(function () {
                                swal({title: "Abort", content: SuccessResponseText, icon: "error", closeOnEsc: false}).then(function(){
                                    setTimeout(function(){location.reload()},150);
                                });
                            }, 2000);
                        }
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
        
    });


    
    $("table[id*='_table']").not("#roles_table").attr('data-page-length',5);
    function showform(v){
        switch (v) {
            case 0:
                $('#form_sector').toggle('slide');
                if ($('#btn_sector').text() == 'Add New Sector') {
                    $('#btn_sector').text('View Sectors Table');
                } else {
                    $('#btn_sector').text('Add New Sector');
                }
                $('#table_sector').toggle('slide');
                break;
            case 1:
                $('#form_expository').toggle('slide');
                if ($('#btn_expository').text() == 'Add New Expository') {
                    $('#btn_expository').text('View Expositories Table');
                } else {
                    $('#btn_expository').text('Add New Expository');
                }
                $('#table_expository').toggle('slide');
                break;
            case 2:
                $('#form_roles').toggle('slide');
                if ($('#btn_roles').text() == 'Add New Job Role') {
                    $('#btn_roles').text('View Job Roles Table');
                } else {
                    $('#btn_roles').text('Add New Job Role');
                }
                $('#table_roles').toggle('slide');
                break;
        
            default:
                break;
        }
        
    }

    $('.selectpicker').selectpicker({
        dropupAuto: true
    });


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

<script>
    $("table[id*='_table'").dataTable({
        dom: 'Bfrtip',
        buttons: []
    });
</script>
@endsection