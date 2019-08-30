<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"> <!-- Favicon-->
        <title>:: {{ config('app.name') }} :: @yield('title')</title>
        <meta name="description" content="@yield('meta_description', config('app.name'))">
        <meta name="author" content="@yield('meta_author', config('app.name'))">
        @yield('meta')
        {{-- See https://laravel.com/docs/5.7/blade#stacks for usage --}}
        @stack('before-styles')
        <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">

        @stack('after-styles')
        @if (trim($__env->yieldContent('page-styles')))
            @yield('page-styles')
        @endif

        <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/color_skins.css') }}">
        @stack('after-styles')
        @if (trim($__env->yieldContent('page-style')))
            @yield('page-style')
        @endif
    </head>    
    <?php 
        $setting = !empty($_GET['theme']) ? $_GET['theme'] : '';
        $theme = "theme-cyan";
        $menu = "";
        if ($setting == 'p') {
            $theme = "theme-purple";
        } else if ($setting == 'b') {
            $theme = "theme-blue";
        } else if ($setting == 'g') {
            $theme = "theme-green";
        } else if ($setting == 'o') {
            $theme = "theme-orange";
        } else if ($setting == 'bl') {
            $theme = "theme-blush";
        } else {
             $theme = "theme-cyan";
        }
    ?>
    <body class="<?= $theme ?> {{ Request::is('layoutformat/rtl') ? 'rtl' : '' }} {{ Request::is('layoutformat/horizontal') ? 'index2' : '' }} {{ Request::is('layoutformat/smallmenu') ? 'menu_sm' : '' }}">
        <!-- Page Loader -->
        <div class="page-loader-wrapper">
            <div class="loader">
                <div class="m-t-30"><img class="zmdi-hc-spin" src="../assets/images/logo.svg" width="48" height="48" alt="SCPwD"></div>
                <p>Please wait...</p>
            </div>
        </div>
        <div id="wrapper">
            @include('layout.overlaymenu')
            @include('layout.navbar')
            @if (Request::segment(2) === 'horizontal' )
                @include('layout.hmenu')
            @else
                @include('layout.sidebar')
            @endif
            @include('layout.rightchat')
            @include('layout.rightsidebar')
            <section class="content">
                <div class="block-header">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <h2>@yield('title')</h2>
                            <ul class="breadcrumb p-l-0 p-b-0">
                                <li class="breadcrumb-item"><a href="{{route(strtok(Route::current()->getName(), '.').'.dashboard')}}"><i class="zmdi zmdi-home"></i>SCPwD</a></li>
                                @if (trim($__env->yieldContent('parentPageTitle')))
                                    <li class="breadcrumb-item">@yield('parentPageTitle')</li>
                                @endif
                                @if (trim($__env->yieldContent('title')))
                                    <li class="breadcrumb-item active">@yield('title')</li>
                                @endif
                            </ul>
                        </div>
                        @if (Request::segment(2) === 'rtl' )
                            <div class="col-lg-6 col-md-6 col-sm-12 text-left">
                            @else
                            <div class="col-lg-6 col-md-6 col-sm-12 text-right">
                        @endif
                            {{-- <div class="inlineblock text-center m-r-15 m-l-15 pt-1 hidden-md-down">
                                <div class="sparkline" data-type="bar" data-width="97%" data-height="25px" data-bar-Width="2" data-bar-Spacing="5" data-bar-Color="#706bd1">3,2,6,5,9,8,7,9,5,1,3,5,7,4,6</div>
                                <small>Page Views</small>
                            </div>
                            <div class="inlineblock text-center m-r-15 m-l-15 pt-1 hidden-md-down">
                                <div class="sparkline" data-type="bar" data-width="97%" data-height="25px" data-bar-Width="2" data-bar-Spacing="5" data-bar-Color="#f9666e">1,3,5,7,4,6,3,2,6,5,9,8,7,9,5</div>
                                <small>Visitors</small>
                            </div> --}}
                            @if (Request::segment(2) === 'dashboard' )
                                <button class="btn btn-primary btn-round btn-simple hidden-sm-down float-right m-l-10">Create New</button>
                            @endif
                        </div>
                    </div>
                </div>
                @yield('content')
            </section>
            @if (trim($__env->yieldContent('modal')))
                @yield('modal')
            @endif
        </div>
        <!-- Scripts -->
        @stack('before-scripts')
        <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>    
        <script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>

        <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
        <script>
            // Wraptheme Website live
            var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
            (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/5c6d4867f324050cfe342c69/default';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
            })();
        </script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <!-- Include this after the sweet alert js file -->
        @include('sweet::alert')
        @stack('after-scripts')
        @if (trim($__env->yieldContent('page-script')))
            @yield('page-script')
		@endif
    </body>
</html>
