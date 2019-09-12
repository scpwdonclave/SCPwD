<nav class="navbar">
    <ul class="nav navbar-nav navbar-left">
        <li>
            <div class="navbar-header">
                @if (Request::segment(2) === 'horizontal')
                    <a href="javascript:void(0);" class="h-bars"></a>
                @else
                    <a href="javascript:void(0);" class="bars"></a>
                @endif
                <a class="navbar-brand" href="{{route(Request::segment(1).'.dashboard.dashboard')}}"><img src="{{asset('assets/images/scpwd-logo.png')}}" width="100" alt="SCPwD"></a>
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
                        @php
                        if (Auth::guard(Request::segment(1))->check()) {
                            switch (Request::segment(1)) {
                                case 'admin':
                                    $notifications = \App\Notification::where([['rel_with', '=', Request::segment(1)],['read', '=', 0]])->orderBy('created_at', 'desc')->get();
                                    break;
                                case 'partner':
                                    $notifications = \App\Notification::where([['rel_with', '=', Request::segment(1)],['read', '=', 0],['rel_id', '=', Auth::guard('partner')->user()->id]])->orderBy('created_at', 'desc')->get();
                                    break;                                
                                case 'center':
                                    $notifications = \App\Notification::where([['rel_with', '=', Request::segment(1)],['read', '=', 0],['rel_id', '=', Auth::guard('center')->user()->id]])->orderBy('created_at', 'desc')->get();
                                    break;                                
                            }
                        }
                        @endphp
                        @if (count($notifications))
                        <li id="notification_header" class="header">Notifcations</li>
                            <ul class="menu list-unstyled">
                                @foreach ($notifications as $notification)
                                    <li id="notification_{{$notification->id}}" class="countli">
                                        <a href="javascript:void(0);">
                                            <div class="media">
                                                <div class="media-body">
                                                    <span class="name">{{$notification->title}}<span class="time" onclick="dismiss('{{$notification->id}}');" style="color:red">DISMISS</span></span>
                                                    <span class="message">{!!$notification->message!!}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                           </ul> 
                        @endif
                </li>
            </ul>
        </li>
        <li>
            <div class="navbar-header">
                <div class="row"><h6>SCPwD</h6>:A Management Portal for SCPwD</div>
            </div>
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