@extends('layout.authentication')
@section('title', 'Lockscreen')
@section('content')
<div class="authentication sidebar-collapse">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-transparent">
        <div class="container">        
            <div class="navbar-translate n_logo">
                <a class="navbar-brand" href="javascript:void(0);" title="" target="_blank">sQuare</a>
                <button class="navbar-toggler" type="button">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </button>
            </div>
            <div class="navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="{{route('dashboard.dashboard')}}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="javascript:void(0);">Search Result</a></li>
                    <li class="nav-item">
                        <a class="nav-link" title="Follow us on Twitter" href="javascript:void(0);" target="_blank">
                            <i class="zmdi zmdi-twitter"></i>
                            <span class="d-lg-none d-xl-none m-l-10">Twitter</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" title="Like us on Facebook" href="javascript:void(0);" target="_blank">
                            <i class="zmdi zmdi-facebook"></i>
                            <span class="d-lg-none d-xl-none m-l-10">Facebook</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" title="Follow us on Instagram" href="javascript:void(0);" target="_blank">                        
                            <i class="zmdi zmdi-instagram"></i>
                            <span class="d-lg-none d-xl-none m-l-10">Instagram</span>
                        </a>
                    </li>                
                    <li class="nav-item">
                        <a class="nav-link btn btn-white btn-round" href="{{route('authentication.register')}}">SIGN UP</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="page-header">
        <div class="page-header-image" style="background-image:url(../assets/images/login.jpg)"></div>
        <div class="container">
            <div class="col-md-12 content-center">
                <div class="card-plain">
                    <form class="form">
                        <div class="header">
                            <div class="logo-container expandUp">
                                <img class="rounded-circle" src="../assets/images/profile_av.jpg" alt="">
                            </div>
                            <h5>Michael</h5>
                            <span>Locked</span>
                        </div>
                        <div class="content">
                            <div class="input-group input-lg">
                                <input type="password" class="form-control" placeholder="Enter your Password">
                                <span class="input-group-addon">
                                    <i class="zmdi zmdi-lock"></i>
                                </span>
                            </div>
                        </div>
                        <div class="footer">
                            <a href="{{route('authentication.login')}}" class="btn btn-primary btn-round btn-lg btn-block waves-effect waves-light">LOG IN</a>
                            <h5><a href="javascript:void(0);" class="link">Need Help?</a></h5>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container">
                <nav>
                    <ul>
                        <li><a href="https://thememakker.com/contact/" target="_blank">Contact Us</a></li>
                        <li><a href="https://thememakker.com/about/" target="_blank">About Us</a></li>
                        <li><a href="javascript:void(0);">FAQ</a></li>
                    </ul>
                </nav>
                <div class="copyright">
                    &copy;
                    <script>
                        document.write(new Date().getFullYear())
                    </script>,
                    <span>Designed by <a href="https://thememakker.com/" target="_blank">ThemeMakker</a></span>
                </div>
            </div>
        </footer>
    </div>
</div>
@stop