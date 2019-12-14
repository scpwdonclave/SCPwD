<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"> <!-- Favicon-->
    <title>Welcome To SCPwD | Skill Council for Persons with Disability</title>
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/index-util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/index-main.css') }}">
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
</head>
<body>
    @yield('content')
    
    @if (trim($__env->yieldContent('modal')))
        @yield('modal')
    @endif

    <script src="{{asset('assets/plugins/jquery/jquery-v3.2.1.min.js')}}"></script>
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>    
    <script src="{{asset('assets/js/tilt.jquery.min.js')}}"></script>
    @if (trim($__env->yieldContent('page-script')))
        @yield('page-script')
    @endif
    <script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
</body>
</html>