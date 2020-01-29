@extends('layout.master')
@section('title', 'Profile')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/color_skins.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
@stop
@section('content')
<div class="container-fluid home">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2><strong>My</strong> Profile</h2>
                </div>
                <div class="body">
                    <form id="form_profile" method="POST" action="{{ route(Request::segment(1).'.profile') }}">
                        @csrf
                        @php
                            switch (Request::segment(1)) {
                                case 'partner':
                                    $name = $partner->spoc_name;$email = $partner->email;$mobile = $partner->spoc_mobile;
                                    break;
                                case 'center':
                                    $name = $center->spoc_name;$email = $center->email;$mobile = $center->spoc_mobile;
                                    break;
                                case 'agency':
                                    $name = $agency->name;$email = $agency->email;$mobile = $agency->mobile;
                                    break;
                                case 'assessor':
                                    $name = $assessor->name;$email = $assessor->email;$mobile = $assessor->mobile;
                                    break;
                                default:
                                    $name = $admin->name;$email = $admin->email;
                                    if($admin->supadmin){
                                        $attribute = null;
                                        $attribute_pass = null;
                                        $password_text = 'Unchanged';
                                    } else {
                                        $attribute = 'readonly';
                                        $attribute_pass = 'required';
                                        $password_text = 'Enter New Password';
                                    }
                                    break;
                            }
                        @endphp
                        
                        <div class="row d-flex justify-content-around">
                            <div class={{(Request::segment(1)==='admin')?"col-sm-5":"col-sm-4"}}>
                                <label for="name">Name</label>
                                <div class="form-group form-float">
                                    <input type="text" class="form-control" placeholder="Name" value="{{ $name }}" name="name" {{(Request::segment(1)==='admin')?$attribute:((Request::segment(1)==='agency')?'readonly':((Request::segment(1)==='center' || Request::segment(1)==='assessor')?'readonly':'required'))}} >
                                </div>
                            </div>
                            <div class={{(Request::segment(1)==='admin')?"col-sm-5":"col-sm-4"}}>
                                <label for="email">Email</label>
                                <div class="form-group form-float">
                                    <input type="email" class="form-control" placeholder="Email" value="{{($errors->has('email'))?old('email'):$email}}" name="email" {{(Request::segment(1)==='admin')?$attribute:((Request::segment(1)==='agency')?'readonly':((Request::segment(1)==='center' || Request::segment(1)==='assessor')?'readonly':'required'))}} >
                                    <span style="color:red">{{($errors->has('email'))?$errors->first('email'):null}}</span>
                                </div>
                            </div>
                            @if (Request::segment(1)!=='admin')
                                <div class="col-sm-4">
                                    <label for="mobile">Contact</label>
                                    <div class="form-group form-float">
                                        <input type="text" class="form-control" placeholder="Mobile" value="{{($errors->has('mobile'))?old('mobile'):$mobile}}" name="mobile" {{(Request::segment(1)==='agency')?'readonly':((Request::segment(1)==='center' || Request::segment(1)==='assessor')?'readonly':'required')}} >
                                        <span style="color:red">{{($errors->has('mobile'))?$errors->first('mobile'):null}}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @if (Request::segment(1)==='admin')
                            @if (!$admin->supadmin)
                                <br>
                                    <div class="text-center">
                                        <h6 style="color:blue">Only Super Admin is authorised to Change your above Info</h6>
                                    </div>
                                <br>
                            @endif
                        @endif
                        @if (Request::segment(1)==='agency')
                            <br>
                                <div class="text-center">
                                    <h6 style="color:blue">Only Admins are authorised to Change your above Info</h6>
                                </div>
                            <br>
                        @endif
                        @if (Request::segment(1)==='center' || Request::segment(1)==='assessor')
                            <br>
                                <div class="text-center">
                                    <h6 style="color:blue">Only Admins and your {{(Request::segment(1)==='center')?'Training Partner':'Assessment Agency'}} are authorised to Change your above Info</h6>
                                </div>
                            <br>
                        @endif
                        <div class="row d-flex justify-content-around">
                            <div class="col-sm-6">
                                <div class="d-flex justify-content-between container-fluid">
                                    <label for="password">Password</label><span class="input-group-addon1" onclick="viewpass()"><i id="password_eye" class="zmdi zmdi-eye-off"></i></span>
                                </div>
                                <d-iv class="form-group form-float">
                                    <input id="password" type="password" class="form-control" placeholder="{{(Request::segment(1)==='admin')?$password_text:((Request::segment(1)==='agency')?'Enter New Password':((Request::segment(1)==='center' || Request::segment(1)==='assessor')?'Enter New Password':'Unchnaged'))}}" name="password" {{(Request::segment(1)==='admin')?$attribute_pass:((Request::segment(1)==='agency')?'required':((Request::segment(1)==='center' || Request::segment(1)==='assessor')?'required':null))}}>
                                </div>
                            </div>
                        </div>

                        @if (Request::segment(1)==='partner')
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
                        @else
                            <div class="row d-flex justify-content-around">
                                <button type="submit" id="submit_form" class="btn btn-primary"><span class="glyphicon glyphicon-cloud-upload"></span>  UPDATE</button>
                            </div>
                        @endif
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
                "mobile": {mobile: true},
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