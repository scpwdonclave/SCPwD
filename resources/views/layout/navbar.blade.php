<nav class="navbar">
    <ul class="nav navbar-nav navbar-left">
        <li>
            <div class="navbar-header">
                @if (Request::segment(2) === 'horizontal')
                    <a href="javascript:void(0);" class="h-bars"></a>
                @else
                    <a href="javascript:void(0);" class="bars"></a>
                @endif
                <a class="navbar-brand" href="{{route(strtok(Route::current()->getName(), '.').'.dashboard')}}"><img src="../assets/images/scpwd-logo.png" width="100" alt="sQuare"></a>
            </div>
        </li>
        @if (Request::segment(2) === 'horizontal' )
        
        @else
        <li>
            <a href="javascript:void(0);" class="menu-sm" data-close="true">
                <i class="zmdi zmdi-arrow-left"></i>
                <i class="zmdi zmdi-arrow-right"></i>
            </a>
        </li>
        @endif
        <li class="dropdown app_menu"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"><i class="zmdi zmdi-apps"></i></a>
            <ul class="dropdown-menu pullDown">
                {{-- <li><a href="{{route('app.mail-inbox')}}"><i class="zmdi zmdi-email m-r-10"></i><span>Mail</span></a></li>
                <li><a href="{{route('app.contact-list')}}"><i class="zmdi zmdi-accounts-list m-r-10"></i><span>Contacts</span></a></li>
                <li><a href="{{route('app.chat')}}"><i class="zmdi zmdi-comment-text m-r-10"></i><span>Chat</span></a></li>
                <li><a href="{{route('pages.invoices')}}"><i class="zmdi zmdi-arrows m-r-10"></i><span>Invoices</span></a></li>
                <li><a href="{{route('app.calendar')}}"><i class="zmdi zmdi-calendar-note m-r-10"></i><span>Calendar</span></a></li> --}}
                <li><a href="javascript:void(0)"><i class="zmdi zmdi-arrows m-r-10"></i><span>Notes</span></a></li>
                <li><a href="javascript:void(0)"><i class="zmdi zmdi-view-column m-r-10"></i><span>Taskboard</span></a></li>                
            </ul>
        </li>
        <li class="dropdown notifications hidden-sm-down"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"><i class="zmdi zmdi-notifications"></i>
            <span id="label-count" class="label-count"></span>
            </a>
            <ul class="dropdown-menu pullDown">
                <li class="body">
                    @auth('partner')
                        @if (Request::segment(1) === 'partner')
                            @if (!Auth::guard('partner')->user()->complete_profile)
                            <li class="header">New Registration</li>
                            <ul class="menu list-unstyled">
                                <li class="countli">
                                    <a href="javascript:void(0);">
                                        <div class="media">
                                            <div class="media-body">
                                                <span class="name">Activate your Account</span>
                                                <span class="message">Kindly Complete your Full Registration to gain Full Access.</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul> 
                            @endif
                        @endif
                    @endauth
                </li>
            </ul>
        </li>
        <li class="float-right">  
            <a class="mega-menu" href="{{strtok(Route::current()->getName(), '.')}}/logout" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                <i class="zmdi zmdi-power"></i>
            </a>
            <form id="logout-form" action="{{ route(strtok(Route::current()->getName(), '.').'.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>            
        </li>        
    </ul>
</nav>