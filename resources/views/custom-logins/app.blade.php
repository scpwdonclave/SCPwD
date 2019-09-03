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

        /* For Firefox */
        input[type='number'] {
            -moz-appearance:textfield;
        }
        /* Webkit browsers like Safari and Chrome */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="container-login100" style="background-image: url('{{ asset('assets/images/cover.jpg') }}');">
        @yield('content')
    </div>

    {{-- Scripts --}}
    <script>
        $(document).on("wheel", "input[type=number]", function (e) {
            $(this).blur();
        });
    </script>
    @yield('page-script')
    
    <script src="{{asset('assets/plugins/jquery-validation/jquery.validate.js')}}"></script>
    <script src="{{ asset('assets/js/scpwd-common.js') }}"></script>
    <script src="{{ asset('assets/js/main-login.js') }}"></script>
</body>
</html>