@extends('layout.master')
@section('title', 'Job Roles')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">

@stop
@section('parentPageTitle', 'Dashboard')
@section('content')
<div class="container-fluid">
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
                                        <td class="text-center"> <form id="removesector_{{$sector->id}}" action="#" method="post">@csrf <input type="hidden" name="data" value="{{$sector->id.','.$sector->sector}}"><button type="submit" class="btn btn-round btn-danger waves-effect btn-sm"><i class="zmdi zmdi-delete"></i></button></form></td>
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
                        <button id="btn_roles" onclick="showform(1)" class="btn btn-primary btn-sm btn-round waves-effect">Add New Role</button>                       
                </div>
                <div class="body">
                    <form style="display:none" id="form_roles" action="{{route('admin.dashboard.disability_action')}}" method="post">
                        @csrf
                        <div class="row d-flex justify-content-around">
                            <div class="col-sm-5">
                                <label for="role_sector">Sector *</label>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" data-live-search="true" name="role_sector" data-show-subtext="true" data-dropup-auto='false' required>
                                        @foreach ($sectors as $sector)
                                            <option value="{{$sector->id}}">{{$sector->sector}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <label for="role_disability">Disability *</label>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" data-live-search="true" name="role_disability[]" multiple data-show-subtext="true" data-dropup-auto='false' required>
                                        @foreach ($disabilities as $disability)
                                            <option value="{{$disability->id}}" data-subtext="({{ $disability->disability }})">{{$disability->initials}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row d-flex-justify-content-center">
                            <div class="col-sm-4">
                                <label for="role_name">Job Role *</label>
                                <div class="form-group form-float year_picker">
                                    <input type="text" class="form-control" placeholder="Job Role Name" value="{{ old('role_name') }}" name="role_name" required>
                                    @if ($errors->has('role_name'))
                                        <span style="color:red">{{$errors->first('role_name')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="role_qp">QP Code *</label>
                                <div class="form-group form-float year_picker">
                                    <input type="text" class="form-control" placeholder="QP Code" value="{{ old('role_qp') }}" name="role_qp" required>
                                    @if ($errors->has('role_qp'))
                                        <span style="color:red">{{$errors->first('role_qp')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="role_nsqf">NSQF Level *</label>
                                <div class="form-group form-float year_picker">
                                    <input type="number" class="form-control" placeholder="NSQF Level" value="{{ old('role_nsqf') }}" name="role_nsqf" required>
                                    @if ($errors->has('role_nsqf'))
                                        <span style="color:red">{{$errors->first('role_nsqf')}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    
                        <div class="row d-flex justify-content-center">
                            <button class="btn btn-round btn-primary" type="submit">ADD</button>
                        </div>
                    </form>
                    <div id="table_roles" class="table-responsive">
                        <table id="disability_table" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Initials</th>
                                    <th>Disability</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($disabilities as $key=>$disability)
                                <tr style="height:5px !important">
                                <td>{{$key+1}}</td>
                                <td>{{$disability->initials}}</td>
                                    <td>{{$disability->disability}}</td>
                                    <td class="text-center"><span class="badge badge-{{($disability->status)?'success':'danger'}}">{{($disability->status)?'Active':'Inactive'}}</span></td>
                                    <td class="text-center"> <form id="updateform_{{$disability->id}}" action="#" method="post">@csrf <input type="hidden" name="data" value="{{$disability->id.','.$disability->disability}}"><button type="submit" class="btn btn-round btn-{{($disability->status)?'danger':'primary'}} waves-effect">{{($disability->status)?'Disable':'Enable'}}</button></form></td>
                                </tr>
                                @endforeach --}}
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

    $('form[id^=removesector_]').submit(function(e){
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
        if (v) {
            $('#form_roles').toggle('slide');
            if ($('#btn_roles').text() == 'Add New Role') {
                $('#btn_roles').text('View Roles Table');
            } else {
                $('#btn_roles').text('Add New Role');
            }
            $('#table_roles').toggle('slide');

        } else {
            $('#form_sector').toggle('slide');
            if ($('#btn_sector').text() == 'Add New Sector') {
                $('#btn_sector').text('View Sectors Table');
            } else {
                $('#btn_sector').text('Add New Sector');
            }
            $('#table_sector').toggle('slide');
        }
        
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

<script>
    $("table[id*='_table'").dataTable({
        dom: 'Bfrtip',
        buttons: []
    });
</script>
@endsection