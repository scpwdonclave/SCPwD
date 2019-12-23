@extends('custom-logins.app')
@section('content')
  <div class="wrap-login100 p-l-40 p-r-40 p-t-45 p-b-20">
    <form method="POST" id="form_reset_request" action="{{ route('agency.password.email') }}" class="login100-form">
      @csrf  
      <span class="login100-form-title p-b-10"> <img class="login-logo" src="{{ asset('assets/images/scpwd-logo.png') }}" alt="" srcset="" /> </span>
      <span class="login100-form-title m-b-10">Assessment Agency Password Reset</span>      
      
      @if (session('status'))
      <div class="alert alert-success" role="alert">
          {{ session('status') }}
      </div>
      @endif
        <div class="wrap-input100 m-b-20">
            <div class="form-group">
                <input type="email" class="input100" name="email" value="{{ old('email') }}" placeholder="SPOC Email" required>                                
            </div>
          @if ($errors->has('email'))
          <span class="invalid-feedback" style="display:block" role="alert">
            <strong>{{ $errors->first('email') }}</strong>
          </span>
          @endif
        </div>

        <div class="container-login100-form-btn">
          <button type="submit" class="login100-form-btn">Send Password Reset Link</button>
        </div>

        <div class="text-center p-t-30">
          <a href="{{ route('agency.login') }}" class="txt2 hov1"> Login Here </a>
        </div>
        
        <div class="p-t-20 copyrighttext">
          <p>&copy; {{date("Y")}} (SCPwD) . All Rights Reserved <br> Developed &amp; Maintained by <a href="https://onclavesystems.com/" class="copylink" target="blank">Onclave Systems</a></p>
        </div>
      
    </form>
  </div>
@endsection