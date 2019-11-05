@extends('custom-logins.app')
@section('content')
  <div class="wrap-login100 p-l-40 p-r-40 p-t-45 p-b-20">
    <form method="POST" id="form_agency_login" action="{{ route('agency.login') }}" class="login100-form">
    
      @csrf  
      <span class="login100-form-title p-b-10"> <img src="{{ asset('assets/images/scpwd-logo.png') }}" alt="" srcset="" /> </span>
      <span class="login100-form-title m-b-10">Assessment Agency Login</span>
      @if(Session::has('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
      @endif
        @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif
      <div class="wrap-input100 m-b-20">
          <div class="form-group">
              <input type="text" class="input100" name="aa_id" value="{{ old('aa_id') }}" placeholder="User ID" required autofocus>                                
          </div>
        @if ($errors->has('aa_id'))
        <span class="invalid-feedback" style="display:block" role="alert">
          <strong>{{ $errors->first('aa_id') }}</strong>
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

        <div class="d-flex justify-content-around p-t-30 p-b-20">
          <a href="{{ route('agency.password.request') }}" class="txt2 hov1"> Forgot Password </a>
        </div>
      
    </form>
  </div>
@endsection