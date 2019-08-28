{{-- @extends('partner.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-body">
                    <form method="POST" action="{{ route('partner.register') }}" aria-label="{{ __('Register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">SPOC Name</label>

                            <div class="col-md-6">
                                <input id="spoc_name" type="text" class="form-control{{ $errors->has('spoc_name') ? ' is-invalid' : '' }}" name="spoc_name" value="{{ old('spoc_name') }}" required>

                                @if ($errors->has('spoc_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('spoc_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mobile" class="col-md-4 col-form-label text-md-right">Mobile</label>

                            <div class="col-md-6">
                                <input id="mobile" type="number" min="0" maxlength="10" class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile" required>

                                @if ($errors->has('mobile'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
 --}}

@extends('custom-logins.app')
@section('content')
  <div class="wrap-login100 p-l-40 p-r-40 p-t-45 p-b-20">
    <form method="POST" id="form_partner_login" action="{{ route('partner.register') }}" class="login100-form" enctype="multipart/form-data">
    
      @csrf  
      <span class="login100-form-title p-b-10"> <img src="{{ asset('assets/images/scpwd-logo.png') }}" alt="" srcset="" /> </span>
      <span class="login100-form-title m-b-10">Training Partner Registration</span>
        @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif
      <div class="wrap-input100 m-b-5">
          <div class="form-group">
              <input type="text" class="input100" name="spoc_name" value="{{ old('spoc_name') }}" placeholder="SPOC Name" required>                                
          </div>
        @if ($errors->has('spoc_name'))
        <span class="invalid-feedback" style="display:block" role="alert">
          <strong>{{ $errors->first('spoc_name') }}</strong>
        </span>
        @endif
      </div>
      
      <div class="wrap-input100 m-b-5">
          <div class="form-group">
              <input type="email" class="input100" name="spoc_email" value="{{ old('spoc_email') }}" placeholder="SPOC Email" required>                                
          </div>
        @if ($errors->has('spoc_email'))
        <span class="invalid-feedback" style="display:block" role="alert">
          <strong>{{ $errors->first('spoc_email') }}</strong>
        </span>
        @endif
      </div>

      <div class="wrap-input100 m-b-5">
          <div class="form-group">
              <input type="number" minlength="10" maxlength="10" class="input100" name="spoc_mobile" value="{{ old('spoc_mobile') }}" placeholder="SPOC Mobile" required>                                
          </div>
        @if ($errors->has('spoc_mobile'))
        <span class="invalid-feedback" style="display:block" role="alert">
          <strong>{{ $errors->first('spoc_mobile') }}</strong>
        </span>
        @endif
      </div>
      
      <div class="wrap-input100 m-b-5">
          <div class="form-group">
              <label class="d-flex justify-content-center" style="color:#4b2354;font-weight:bold">Incorporation certifiate</label>                                                            
              <input id="incorp_cert" type="file" class="input100" name="incorp_cert" required>
              <span id="incorp_cert_error"  style="color:red;"></span>                                                            
          </div>
        @if ($errors->has('incorp_cert'))
        <span class="invalid-feedback" style="display:block" role="alert">
          <strong>{{ $errors->first('incorp_cert') }}</strong>
        </span>
        @endif
      </div>

        <div class="container-login100-form-btn">
          <button type="submit" class="login100-form-btn">Register</button>
        </div>

        <div class="d-flex justify-content-around p-t-30 p-b-20">
          <a href="{{ route('partner.login') }}" class="txt2 hov1"> Training Partner Login </a>
        </div>
      
    </form>
  </div>
@endsection

@section('page-script')

<script>
    $(function(){
        /* Start File Type Validation for jpg,jpeg,png,pdf */         
        
            var _URL = window.URL || window.webkitURL;
            $("[type='file']").change(function(e) {
                
            var image, file;
            for (var i = this.files.length - 1; i >= 0; i--) {
            if ((file = this.files[i])) {
                    image = new Image();
                    var fileType = file["type"];
                    var ValidImageTypes = ["image/jpg", "image/jpeg", "image/png", "application/pdf", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.wordprocessingml.document" ];
                    if ($.inArray(fileType, ValidImageTypes) < 0) {
                        $("#"+e.currentTarget.id).val('');
                        $("#" + e.currentTarget.id + "_error").text('Supported jpg, jpeg, png, pdf, docs, xls, xlsx');
                    } else {
                        $("#" + e.currentTarget.id + "_error").text('');
                    }
                    image.src = _URL.createObjectURL(file);
                }
            }
            });
        
        /* End File Type Validation for jpg,jpeg,png,pdf */

    });
</script>

@endsection