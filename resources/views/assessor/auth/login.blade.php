@extends('custom-logins.app')
@section('content')
  <div class="wrap-login100 p-l-40 p-r-40 p-t-45 p-b-20">
    <form method="POST" id="form_assessor_login" action="{{ route('assessor.login') }}" class="login100-form">
    
      @csrf  
      <span class="login100-form-title p-b-10"> <img class="login-logo" src="{{ asset('assets/images/scpwd-logo.png') }}" alt="" srcset="" /> </span>
      <span class="login100-form-title m-b-10">Assessor Login</span>
      @if(Session::has('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
      @endif
        @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif
      <div class="wrap-input100 m-b-20">
          <div class="form-group">
              <input type="text" class="input100" name="as_id" value="{{ old('as_id') }}" placeholder="User ID" required autofocus>                                
          </div>
        @if ($errors->has('as_id'))
        <span class="invalid-feedback" style="display:block" role="alert">
          <strong>{{ $errors->first('as_id') }}</strong>
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

        <div class="d-flex justify-content-around p-t-30">
          <a href="{{ route('assessor.password.request') }}" class="txt2 hov1"> Forgot Password </a>
        </div>

        <div class="p-t-20 copyrighttext">
          <p>&copy; {{date("Y")}} (SCPwD) . All Rights Reserved <br> Developed &amp; Maintained by <a href="https://onclavesystems.com/" class="copylink" target="blank">Onclave Systems</a></p>
        </div>
      
    </form>
  </div>
@endsection