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
                    <h2><strong>Manage</strong> QP Section</h2>
                    <button id="btn_qp" onclick="showform(1)" class="btn btn-primary btn-sm btn-round waves-effect">Add New QP Record</button>                       
                </div>
                <div class="body">
                    <form style="display:none" id="form_qp" action="{{route('admin.dashboard.jobroles')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="qp_name">QP Name *</label>
                                <div class="form-group form-float">
                                    <input type="text" class="form-control" placeholder="QP Name" value="{{ old('qp_name') }}" name="qp_name" required>
                                    @if ($errors->has('qp_name'))
                                        <span style="color:red">{{$errors->first('qp_name')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="qp_code">QP Code *</label>
                                <div class="form-group form-float">
                                    <input type="text" class="form-control" placeholder="QP Code" value="{{ old('qp_code') }}" name="qp_code" required>
                                    @if ($errors->has('qp_code'))
                                        <span style="color:red">{{$errors->first('qp_code')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="nsqf_level">NSQF Level *</label>
                                <div class="form-group form-float">
                                    <input type="text" class="form-control" placeholder="NSQF Level" value="{{ old('nsqf_level') }}" name="nsqf_level" required>
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

                    <div id="table_qp" class="table-responsive">
                        <table id="job_table" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>QP Name</th>
                                    <th>QP Code</th>
                                    <th>NSQF</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($qps as $key=>$qp)
                                <tr style="height:5px !important">
                                <td>{{$key+1}}</td>
                                <td>{{$qp->qp_name}}</td>
                                <td>{{$qp->qp_code}}</td>
                                <td>{{$qp->nsqf_level}}</td>
                                <td class="text-center"> <form id="qp_removeform_{{$qp->id}}" action="#" method="post">@csrf <input type="hidden" name="data" value="{{$qp->id.','.$qp->qp_name}}"><button type="submit" class="btn btn-danger btn-round waves-effect btn-sm"><i class="zmdi zmdi-delete"></i></button></form></td>
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
                        <h2><strong>Manage</strong> Expositories</h2>                        
                        <button id="btn_expository" onclick="showform(2)" class="btn btn-primary btn-sm btn-round waves-effect">Add New Expository</button>                       
                </div>
                <div class="body">
                    <form style="display:none" id="form_expository" action="{{route('admin.dashboard.jobroles')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="expository">Expository *</label>
                                <div class="form-group form-float">
                                    <input type="text" class="form-control" placeholder="Expository Name" value="{{ old('expository') }}" name="expository" required>
                                    @if ($errors->has('expository'))
                                    <span style="color:red">{{$errors->first('expository')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="initials">Initials *</label>
                                <div class="form-group form-float">
                                    <input type="text" class="form-control" placeholder="Expository Initials" value="{{ old('initials') }}" name="initials" required>
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
                        <table id="expository_table" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Expository</th>
                                    <th>Initials</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach ($expositories as $key=>$expository)
                                    <tr style="height:5px !important">
                                    <td>{{$key+1}}</td>
                                    <td>{{$expository->expository}}</td>
                                    <td>{{$expository->initials}}</td>
                                    <td class="text-center"> <form id="expository_removeform_{{$expository->id}}" action="#" method="post">@csrf <input type="hidden" name="data" value="{{$expository->id.','.$expository->expository}}"><button type="submit" class="btn btn-danger btn-round waves-effect btn-sm"><i class="zmdi zmdi-delete"></i></button></form></td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-4">
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
                                <div class="form-group form-float">
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
                        <table id="job_table" class="table table-bordered table-striped table-hover">
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
                                <td class="text-center"> <form id="sector_removeform_{{$sector->id}}" action="#" method="post">@csrf <input type="hidden" name="data" value="{{$sector->id.','.$sector->sector}}"><button type="submit" class="btn btn-danger btn-round waves-effect btn-sm"><i class="zmdi zmdi-delete"></i></button></form></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="header d-flex justify-content-between">
                    <h2><strong>Manage</strong> Roles</h2>
                    <button id="btn_role" onclick="showform(3)" class="btn btn-primary btn-sm btn-round waves-effect">Add New Role</button>                       
                </div>
                <div class="body">
                    <form style="display:none" id="form_role" action="{{route('admin.dashboard.jobroles')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="sector_role">Sector *</label>
                                <div class="form-group form-float">
                                    <select name="sector_role" class="form-control show-tick" data-live-search="true" required >
                                        @foreach ($sectors as $sector)
                                            <option value="{{ $sector->id }}">{{$sector->sector}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="qp_role">QP Details *</label>
                                <div class="form-group form-float">
                                    <select name="qp_role" class="form-control show-tick" data-live-search="true" required >
                                        @foreach ($qps as $qp)
                                            <option value="{{ $qp->id }}" data-subtext="{{$qp->qp_code.' | '.$qp->nsqf_level}}">{{$qp->qp_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-around">
                            <div class="col-sm-6">
                                <label for="expository_role">Expository *</label>
                                <div class="form-group form-float">
                                    <select name="expository_role[]" class="form-control show-tick" data-live-search="true" required multiple>
                                        @foreach ($expositories as $expository)
                                            <option value="{{ $expository->id }}" data-subtext="{{$expository->expository}}">{{$expository->initials}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>   
                        </div>
                    
                        <div class="row d-flex justify-content-center">
                            <button class="btn btn-round btn-primary" type="submit">ADD</button>
                        </div>
                    </form>

                    <div id="table_role" class="table-responsive">
                        <table id="job_table" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Sector</th>
                                    <th>QP Details</th>
                                    <th>NSQF Level</th>
                                    <th>Expository</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($expos as $expo)
                                <tr style="height:5px !important">
                                    <td>{{$expo->sector}}</td>
                                    <td>{{$expo->qp}}</td>
                                    <td>{{$expo->nsqf}}</td>
                                    <td>{{$expo->expository}}</td>
                                    <td class="text-center"> <form id="sector_removeform_{{$expo->id}}" action="#" method="post">@csrf <input type="hidden" name="data" value="{{$expo->id.','.$expo->sector}}"><button type="submit" class="btn btn-danger btn-round waves-effect btn-sm"><i class="zmdi zmdi-delete"></i></button></form></td>
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

    $('form[id^=sector_removeform_]').submit(function(e){
        e.preventDefault();
        var data = e.currentTarget.data.value.split(',');
        var _token = e.currentTarget._token.value;
        var dataString = {_token:_token, id:data[0], name:data[1]};
        var confirmatonText = document.createElement("div");
        confirmatonText.innerHTML = "You are about to Remove <span style='font-weight:bold; color:red;'>"+ data[1] +"</span> Sector";
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


    
    $("table[id*='_table']").attr('data-page-length',5);
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
                $('#form_qp').toggle('slide');
                if ($('#btn_qp').text() == 'Add New QP Record') {
                    $('#btn_qp').text('View QP Table');
                } else {
                    $('#btn_qp').text('Add New QP Record');
                }
                $('#table_qp').toggle('slide');
                break;
            case 2:
                $('#form_expository').toggle('slide');
                if ($('#btn_expository').text() == 'Add New Expository') {
                    $('#btn_expository').text('View Expository Table');
                } else {
                    $('#btn_expository').text('Add New Expository');
                }
                $('#table_expository').toggle('slide');
                break;
            case 3:
                $('#form_role').toggle('slide');
                if ($('#btn_role').text() == 'Add New Role') {
                    $('#btn_role').text('View Role Table');
                } else {
                    $('#btn_role').text('Add New Role');
                }
                $('#table_role').toggle('slide');
                break;
        
            default:
                break;
        }
    }


    /* Creating Initials for Expository */
    $('[name=expository]').on('change', function(e){
        var matches = e.currentTarget.value.match(/\b(\w)/g);
        $('[name=initials]').val(matches.join('').toUpperCase());        
    });
    /* End Creating Initials for Expository */


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