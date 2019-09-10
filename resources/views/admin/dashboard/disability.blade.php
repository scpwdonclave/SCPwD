@extends('layout.master')
@section('title', 'Disabilities')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
@stop
@section('parentPageTitle', 'Dashboard')
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-8">
            <div class="card">
                <div class="header">
                    <h2><strong>Disability</strong> Section</h2>                        
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="disability_table" class="table table-bordered table-striped table-hover dataTable js-exportable">
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
                                @foreach ($disabilities as $key=>$disability)
                                <tr style="height:5px !important">
                                <td>{{$key+1}}</td>
                                <td>{{$disability->initials}}</td>
                                    <td>{{$disability->disability}}</td>
                                    <td class="text-center"><span class="badge badge-{{($disability->status)?'success':'danger'}}">{{($disability->status)?'Active':'Inactive'}}</span></td>
                                    <td class="text-center"> <form id="updateform_{{$disability->id}}" action="#" method="post">@csrf <input type="hidden" name="data" value="{{$disability->id.','.$disability->disability}}"><button type="submit" class="btn btn-round btn-{{($disability->status)?'danger':'primary'}} waves-effect">{{($disability->status)?'Disable':'Enable'}}</button></form></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="header">
                    <h2><strong>Add</strong> Disability</h2>                        
                </div>
                <div class="body">
                    <form id="form_disability" action="{{route('admin.dashboard.disability_action')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="disability">Disability *</label>
                                <div class="form-group form-float year_picker">
                                    <input type="text" class="form-control" placeholder="Disability Name" value="{{ old('disability') }}" name="disability" required>
                                    @if ($errors->has('disability'))
                                        <span style="color:red">{{$errors->first('disability')}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="initial">Initials *</label>
                                <div class="form-group form-float year_picker">
                                    <input type="text" class="form-control" placeholder="Disability Initials" value="{{ old('initials') }}" name="initials" required>
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
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('page-script')

<script>
    $('[name=disability]').on('change', function(e){
        var matches = e.currentTarget.value.match(/\b(\w)/g);
        $('[name=initials]').val(matches.join('').toUpperCase());        
    });

    $('form[id^=updateform_]').submit(function(e){
        e.preventDefault();
        var data = e.currentTarget.data.value.split(',');
        var _token = e.currentTarget._token.value;
        var dataString = {_token:_token, id:data[0], name:data[1]};
        var confirmatonText = document.createElement("div");
        confirmatonText.innerHTML = "You are about to Update the Status of <br><span style='font-weight:bold; color:blue;'>"+ data[1] +"</span>";
        swal({
            title: "Are you Sure ?",
            content: confirmatonText,
            icon: "info",
            buttons: true,
            buttons: {
                    cancel: "Not Now",
                    confirm: {
                        text: "Confirm Update",
                        closeModal: false
                    }
                },
            closeModal: false,
            closeOnEsc: false,
        }).then(function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    url: "{{ route('admin.dashboard.disability_action') }}",
                    method: "POST",
                    data: dataString,
                    success: function(data){
                        var SuccessResponseText = document.createElement("div");
                        SuccessResponseText.innerHTML = data['message'];
                        setTimeout(function () {
                            swal({title: "Job Done", content: SuccessResponseText, icon: "success", closeOnEsc: false}).then(function(){
                                setTimeout(function(){location.reload()},150);
                            });
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
        
    });


    
    $('#disability_table').attr('data-page-length',5);
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