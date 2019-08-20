{{-- @extends('multiauth::layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ucfirst(config('multiauth.prefix')) }} Reset Password</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.password.request') }}" aria-label="{{ __('Admin Reset Password') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}"
                                    required autofocus> @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span> @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                                    required> @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span> @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

@extends('custom-logins.app')
@section('content')
  <div class="wrap-login100 p-l-55 p-r-55 p-t-50 p-b-30">
        {{-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}
    <form method="POST" id="form_reset_process" action="{{ route('admin.password.request') }}" class="login100-form">
      @csrf  
      <span class="login100-form-title p-b-10"> <img src="{{ asset('assets/images/scpwd-logo.png') }}" alt="" srcset="" /> </span>
      <span class="login100-form-title m-b-10">Admin Reset</span>

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

        {{-- <div class="text-center p-t-57 p-b-20">
          <a href="{{ route('admin.login') }}" class="txt2 hov1"> Login Here </a>
        </div> --}}
      
    </form>
  </div>
@endsection