@extends('layout.master')
@section('title', 'Profile')
@section('page-style')
<!-- Custom Css -->
<link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/color_skins.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
@stop
@section('content')
<div class="container-fluid home">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            @if (Request::segment(1) != 'agency' && Request::segment(1) != 'assessor')
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
                    <form id="form_profile" method="POST" action="{{ route(Request::segment(1).'.profile') }}">
                        @csrf
                        @php
                            if(Request::segment(1) === 'partner'){$user = $partner;} else {$user = $center;}
                        @endphp
                        
                        <div class="row d-flex justify-content-around">
                            <div class="col-sm-4">
                                <label for="spoc_name">SPOC Name</label>
                                <div class="form-group form-float">
                                    <input type="text" class="form-control" placeholder="SPOC Name" value="{{ $user->spoc_name }}" name="spoc_name" {{(Request::segment(1)==='partner')?'required':'readonly'}} >
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="email">SPOC Email</label>
                                <div class="form-group form-float">
                                    <input type="email" class="form-control" placeholder="SPOC Email" value="{{ $user->email }}" name="email" {{(Request::segment(1)==='partner')?'required':'readonly'}} >
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="spoc_mobile">SPOC Phone</label>
                                <div class="form-group form-float">
                                    <input type="text" class="form-control" placeholder="SPOC Mobile" value="{{ $user->spoc_mobile }}" name="spoc_mobile" {{(Request::segment(1)==='partner')?'required':'readonly'}} >
                                </div>
                            </div>
                        </div>
                        @if (Request::segment(1) === 'center')
                        <br>
                            <div class="text-center">
                                <h6 style="color:blue">Only Admins and your Training Partner are authorised to Change your SPOC Info</h6>
                            </div>
                        <br>
                        @endif
                        <div class="row d-flex justify-content-around">
                            <div class="col-sm-6">
                                <div class="d-flex justify-content-between container-fluid">
                                    <label for="spoc_name">Password</label><span class="input-group-addon1" onclick="viewpass()"><i id="password_eye" class="zmdi zmdi-eye-off"></i></span>
                                </div>
                                <div class="form-group form-float">
                                    <input id="password" type="password" class="form-control" placeholder="{{(Request::segment(1)==='center')?'Enter New Password':'Unchnaged'}}" name="password" {{(Request::segment(1)==='center')?'required':''}}>
                                </div>
                            </div>
                        </div>
                        @auth('partner')
                            @if (Request::segment(1) === 'partner')                            
                                @can('partner-profile-verified', Auth::shouldUse('partner'))
                                    <div class="row d-flex justify-content-around">
                                        <button type="submit" id="submit_form" class="btn btn-primary"><span class="glyphicon glyphicon-cloud-upload"></span>  UPDATE</button>
                                    </div>
                                @endcan
                                @cannot('partner-profile-verified', Auth::shouldUse('partner'))
                                    <div class="d-flex justify-content-center p-t-30">
                                        <h6>You Can Update These Details Once your Account get Verified</h6>
                                    </div>
                                @endcannot
                            @endif
                        @endauth
                        @auth('center')
                            @if (Request::segment(1) === 'center')
                                <div class="row d-flex justify-content-around">
                                    <button type="submit" id="submit_form" class="btn btn-primary"><span class="glyphicon glyphicon-cloud-upload"></span>  UPDATE</button>
                                </div>
                            @endif
                        @endauth
                        {{-- {{Auth::shouldUse('partner')->complete_profile}} --}}
                    </form>
                </div>
            </div>
            @endif
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
                "email": {email: true}
            },
        });

    /* End Custom Validation  */

    /* Password Eye Click */
        function viewpass(){
            if ($('#password_eye').hasClass("zmdi-eye-off")) {
                $( '#password_eye' ).removeClass( "zmdi-eye-off" );
                $( '#password_eye' ).addClass( "zmdi-eye" );
                $( '#password' ).prop('type','text');
            } else {
                $( '#password_eye' ).removeClass( "zmdi-eye" );
                $( '#password_eye' ).addClass( "zmdi-eye-off" );
                $( '#password' ).prop('type','password');
            }
        }
    /* End Password Eye Click */
   
</script>
@endsection