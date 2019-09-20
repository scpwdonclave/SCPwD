@extends('layout.master')
@section('title', 'Schemes')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
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
        <div class="col-lg-8">
            <div class="card">
                <div class="header">
                    <h2><strong>Scheme</strong> Section</h2>                        
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="scheme_table" class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Scheme</th>
                                    <th>Year</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schemes as $key=>$scheme)
                                <tr style="height:5px !important">
                                <td>{{$key+1}}</td>
                                <td>{{$scheme->scheme}}</td>
                                <td>{{$scheme->year}}</td>
                                <td class="text-center"> <form id="editform_{{$scheme->id}}" action="#" method="post">@csrf <input type="hidden" name="data" value="{{$scheme->id.','.$scheme->scheme}}"><button type="submit" class="btn btn-round btn-primary btn-sm waves-effect"><i class="zmdi zmdi-edit"></i></button></form></td>
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
                    <h2><strong>Add</strong> Scheme</h2>                        
                </div>
                <div class="body">
                    <form id="form_scheme" action="{{route('admin.dashboard.scheme_action')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="scheme">Scheme *</label>
                                <div class="form-group form-float">
                                    <input type="text" class="form-control" placeholder="Scheme Name" value="{{ old('scheme') }}" name="scheme" required>
                                    @if ($errors->has('scheme'))
                                        <span style="color:red">{{$errors->first('scheme')}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="year">Year *</label>
                                <div class="form-group form-float">
                                    <select id="year" class="form-control show-tick" data-live-search="true" name="year" data-dropup-auto='false' required>
                                    </select>
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
    $('form[id^=editform_]').submit(function(e){
        e.preventDefault();
        var data = e.currentTarget.data.value.split(',');
        var _token = e.currentTarget._token.value;
        var confirmatonText = document.createElement("div");
        confirmatonText.innerHTML = "You are about to Remove <br><span style='font-weight:bold; color:blue;'>"+ data[1] +"</span><br>Scheme";
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
                    cancel: "Cencel",
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

    $('#scheme_table').attr('data-page-length',5);


    /* Add Finantial Year Items to Scheme Year */
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
    /* End Add Finantial Year Items to Scheme Year */

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