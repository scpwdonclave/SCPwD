@extends('custom-logins.app')
@section('content')
  <div class="wrap-login100 p-l-40 p-r-40 p-t-45 p-b-20">
    <form method="POST" id="form_admin_login" action="{{ route('admin.login') }}" class="login100-form">
    
      @csrf  
      <span class="login100-form-title p-b-10"> <img class="login-logo" onclick="location.href='{{route('index')}}'" src="{{ asset('assets/images/scpwd-logo.png') }}" alt="" srcset="" /> </span>
      <span class="login100-form-title m-b-10">Admin Login</span>
      @if(Session::has('warning'))
          <div class="alert alert-block alert-danger text-center">
              {{ nl2br(Session::get('warning')) }}
          </div>
      @endif
      <div class="wrap-input100 m-b-20">
          <div class="form-group">
              <input type="email" class="input100" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>                               
          </div>
        @if ($errors->has('email'))
        <span class="invalid-feedback" style="display:block" role="alert">
          <strong>{{ $errors->first('email') }}</strong>
        </span>
        @endif
      </div>

      <div class="wrap-input100 m-b-20">
          <div class="form-group">
              <input type="password" class="input100" name="password" placeholder="Password" required>                                
          </div>
        @if ($errors->has('password'))
        <span class="invalid-feedback" style="display:block" role="alert">
          <strong>{{ $errors->first('password') }}</strong>
        </span>
        @endif
      </div>

        <div class="container-login100-form-btn">
          <button type="submit" class="login100-form-btn">Login</button>
        </div>

        <div class="text-center p-t-30">
          <a href="{{ route('admin.password.request') }}" class="txt2 hov1"> Forgot Password </a>
        </div>
        
        <div class="p-t-20 copyrighttext">
          <p>&copy; {{date("Y")}} (SCPwD) . All Rights Reserved <br> Developed &amp; Maintained by <a href="https://onclavesystems.com/" class="copylink" target="blank">Onclave Systems</a></p>
        </div>
      
    </form>
  </div>
@endsection