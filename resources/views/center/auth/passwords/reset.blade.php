@extends('custom-logins.app')
@section('content')
  <div class="wrap-login100 p-l-40 p-r-40 p-t-45 p-b-20">
    <form method="POST" id="form_reset_process" action="{{ route('center.password.request') }}" class="login100-form">
      @csrf  
      <span class="login100-form-title p-b-10"> <img class="login-logo" onclick="location.href='{{route('index')}}'" src="{{ asset('assets/images/scpwd-logo.png') }}" alt="" srcset="" /> </span>
      <span class="login100-form-title m-b-10">Training Center Password Reset</span>

      @if (session('status'))
      <div class="alert alert-success text-center" role="alert">
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
        
        <div class="p-t-20 copyrighttext">
          <p>&copy; {{date("Y")}} (SCPwD) . All Rights Reserved <br> Developed &amp; Maintained by <a href="https://onclavesystems.com/" class="copylink" target="blank">Onclave Systems</a></p>
        </div>
    </form>
  </div>
@endsection