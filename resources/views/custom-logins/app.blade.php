<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
        
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    {{-- Ico File --}}
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}"/>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SCPwD') }} :: {{ ucfirst(strtok(Route::current()->getName(), '.')) }}</title>

    <script src="{{asset('assets/plugins/jquery/jquery-v3.2.1.min.js')}}"></script>


    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fonts/iconic/css/material-design-iconic-font.min.css') }}" />
    
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/util-login.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/main-login.css') }}"/>

    <style>
        .error {
          color: red;
        }
    </style>
</head>

<body>
    {{-- <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ route('admin.home') }}">
                    {{ config('app.name', 'Laravel') }} {{ ucfirst(config('multiauth.prefix')) }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest('admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin.login')}}">{{ ucfirst(config('multiauth.prefix')) }} Login</a>
                        </li>
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" v-pre>
                                    {{ auth('admin')->user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @admin('super')
                                    <a class="dropdown-item" href="{{ route('admin.show') }}">{{ ucfirst(config('multiauth.prefix')) }}</a>
                                    <a class="dropdown-item" href="{{ route('admin.roles') }}">Roles</a>
                                @endadmin
                                    <a class="dropdown-item" href="{{ route('admin.password.change') }}">Change Password</a>
                                <a class="dropdown-item" href="/admin/logout" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div> --}}




<div class="container-login100" style="background-image: url('{{ asset('assets/images/cover.jpg') }}');">
    @yield('content')
</div>

    {{-- Scripts --}}
    <script src="{{asset('assets/plugins/jquery-validation/jquery.validate.js')}}"></script>
    <script src="{{ asset('assets/js/main-login.js') }}"></script>

</body>
</html>