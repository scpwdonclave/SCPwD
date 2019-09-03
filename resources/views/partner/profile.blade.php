@extends('partner.layouts.app')
@section('title', 'Profile')
@section('page-style')
<link href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/animate-css/animate.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-steps/jquery.steps.css')}}">
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
                    <h2><strong>My</strong> Profile</h2>
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
                    <form id="form_profile" method="POST" action="{{ route('partner.profile') }}">
                        @csrf
                        <div class="row d-flex justify-content-around">
                            <div class="col-sm-4">
                                <label for="spoc_name">SPOC Name</label>
                                <div class="form-group form-float">
                                    <input type="text" class="form-control" placeholder="SPOC Name" value="{{ $partner->spoc_name }}" name="spoc_name" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="spoc_email">SPOC Email</label>
                                <div class="form-group form-float">
                                    <input type="email" class="form-control" placeholder="SPOC Email" value="{{ $partner->spoc_email }}" name="spoc_email" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="spoc_mobile">SPOC Phone</label>
                                <div class="form-group form-float">
                                    <input type="text" class="form-control" placeholder="SPOC Mobile" value="{{ $partner->spoc_mobile }}" name="spoc_mobile" required>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-around">
                            <button type="submit" id="submit_form" class="btn btn-primary"><span class="glyphicon glyphicon-cloud-upload"></span>  UPDATE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/js/scpwd-common.js')}}"></script>



<script type="text/javascript">

    /* Custom Validation  */

        $("#form_profile").validate({
            rules: {
                "spoc_mobile": {mobile: true},
                "spoc_email": {email: true}
            },
        });

    /* End Custom Validation  */
   
</script>
@endsection