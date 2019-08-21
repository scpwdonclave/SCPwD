@extends('custom-logins.app')
@section('content')
  <div class="wrap-login100 p-l-40 p-r-40 p-t-45 p-b-20">
    <form method="POST" id="form_reset_process" action="{{ route('partner.password.request') }}" class="login100-form">
      @csrf  
      <span class="login100-form-title p-b-10"> <img src="{{ asset('assets/images/scpwd-logo.png') }}" alt="" srcset="" /> </span>
      <span class="login100-form-title m-b-10">Training Partner Password Reset</span>

      @if (session('status'))
      <div class="alert alert-success" role="alert">
          {{ session('status') }}
      </div>
      @endif
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="wrap-input100 m-b-20">
            <div class="form-group">
                <input id="email" type="email" class="input100" name="email" value="{{ old('email') }}" placeholder="Email" required>                                
            </div>
          @if ($errors->has('email'))
          <span class="invalid-feedback" style="display:block" role="alert">
            <strong>{{ $errors->first('email') }}</strong>
          </span>
          @endif
        </div>

        <div class="wrap-input100 m-b-20">
            <div class="form-group">
                <input id="password" type="password" class="input100" name="password" placeholder="New Password" required>                                
            </div>
            @if ($errors->has('password'))
            <span class="invalid-feedback" style="display:block" role="alert">
            <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
        </div>
        
        <div class="wrap-input100 m-b-20">
            <div class="form-group">
                <input id="password-confirm" type="password" class="input100" name="password_confirmation" placeholder="Confirm Password" required>                                
            </div>
            @if ($errors->has('password_confirmation'))
            <span class="invalid-feedback" style="display:block" role="alert">
            <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
            @endif
        </div>

        <div class="container-login100-form-btn">
          <button type="submit" class="login100-form-btn">Reset Password</button>
        </div>
    </form>
  </div>
@endsection