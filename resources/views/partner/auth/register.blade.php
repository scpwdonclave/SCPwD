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
    <form method="POST" id="form_partner_login" action="{{ route('partner.register') }}" class="login100-form">
    
      @csrf  
      <span class="login100-form-title p-b-10"> <img src="{{ asset('assets/images/scpwd-logo.png') }}" alt="" srcset="" /> </span>
      <span class="login100-form-title m-b-10">TP Registration</span>
      
      <div class="wrap-input100 m-b-5">
          <div class="form-group">
              <input type="text" class="input100" name="name" value="{{ old('name') }}" placeholder="Name" required>                                
          </div>
        @if ($errors->has('name'))
        <span class="invalid-feedback" style="display:block" role="alert">
          <strong>{{ $errors->first('name') }}</strong>
        </span>
        @endif
      </div>

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
              <input type="email" class="input100" name="email" value="{{ old('email') }}" placeholder="Email" required>                                
          </div>
        @if ($errors->has('email'))
        <span class="invalid-feedback" style="display:block" role="alert">
          <strong>{{ $errors->first('email') }}</strong>
        </span>
        @endif
      </div>

      <div class="wrap-input100 m-b-5">
          <div class="form-group">
              <input type="number" minlength="10" maxlength="10" class="input100" name="mobile" placeholder="Mobile" required>                                
          </div>
        @if ($errors->has('mobile'))
        <span class="invalid-feedback" style="display:block" role="alert">
          <strong>{{ $errors->first('mobile') }}</strong>
        </span>
        @endif
      </div>

        <div class="container-login100-form-btn">
          <button type="submit" class="login100-form-btn">Register</button>
        </div>

        <div class="d-flex justify-content-around p-t-30 p-b-20">
          <a href="{{ route('partner.login') }}" class="txt2 hov1"> TP Login </a>
        </div>
      
    </form>
  </div>
@endsection