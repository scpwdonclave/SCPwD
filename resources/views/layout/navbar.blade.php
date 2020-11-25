<nav class="navbar">
    <ul class="nav navbar-nav navbar-left">
        <li>
            <div class="navbar-header">    
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="{{route(Request::segment(1).'.dashboard.dashboard')}}"><img src="{{asset('assets/images/scpwd-logo.png')}}" width="100" alt="SCPwD"></a>
            </div>
        </li>
        <li>
            <a href="javascript:void(0);" class="menu-sm" data-close="true">
                <i class="zmdi zmdi-arrow-left"></i>
                <i class="zmdi zmdi-arrow-right"></i>
            </a>
        </li>
        {{-- <li class="dropdown app_menu"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"><i class="zmdi zmdi-apps"></i></a>
            <ul class="dropdown-menu pullDown">
                <li><a href="javascript:void(0)"><i class="zmdi zmdi-arrows m-r-10"></i><span>Notes</span></a></li>
                <li><a href="javascript:void(0)"><i class="zmdi zmdi-view-column m-r-10"></i><span>Taskboard</span></a></li>                
            </ul>
        </li> --}}
        @php
            if (Auth::guard(Request::segment(1))->check()) {
                switch (Request::segment(1)) {
                    case 'admin':
                        if(Auth::guard('admin')->user()->supadmin){
                            $notifications = \App\Notification::where([['rel_with', '=', Request::segment(1)],['read', '=', 0],['rel_id', '=',null]])->orWhere([['rel_with', '=', Request::segment(1)],['read', '=', 0],['rel_id','=', 1]])->orderBy('created_at', 'desc')->get();
                        }else{
                            $notifications = \App\Notification::where([['rel_with', '=', Request::segment(1)],['read', '=', 0],['rel_id', '=',null]])->orWhere([['rel_with', '=', Request::segment(1)],['read', '=', 0],['rel_id','=', 0]])->orderBy('created_at', 'desc')->get();
                        }
                        break;
                    case 'partner':
                        $notifications = \App\Notification::where([['rel_with', '=', Request::segment(1)],['read', '=', 0],['rel_id', '=', Auth::guard('partner')->user()->id]])->orderBy('created_at', 'desc')->get();
                        break;                                
                    case 'center':
                        $notifications = \App\Notification::where([['rel_with', '=', Request::segment(1)],['read', '=', 0],['rel_id', '=', Auth::guard('center')->user()->id]])->orderBy('created_at', 'desc')->get();
                        break;                                
                    case 'agency':
                        $notifications = \App\Notification::where([['rel_with', '=', Request::segment(1)],['read', '=', 0],['rel_id', '=', Auth::guard('agency')->user()->id]])->orderBy('created_at', 'desc')->get();
                        break;
                    case 'assessor':
                        $notifications = \App\Notification::where([['rel_with', '=', Request::segment(1)],['read', '=', 0],['rel_id', '=', Auth::guard('assessor')->user()->id]])->orderBy('created_at', 'desc')->get();
                        break;
                }
            }
        @endphp
        <li class="dropdown notifications hidden-sm-down">
            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"><i class="zmdi zmdi-notifications"></i>
                <span id="label-count" class="label-count"></span>
            </a>
            <ul id="notification_ul" class="dropdown-menu pullDown">
                <li id="notification_header" class="header d-flex justify-content-between">Notifications
                    @if (count($notifications))
                        @if (request()->segment(1)=='admin')
                            @if (!auth()->guard('admin')->user()->ministry)
                                <span style="cursor: pointer;color:red;" onclick="dismiss('{{Auth::guard(Request::segment(1))->user()->id}},{{Request::segment(1)}}');">
                                    DISMISS ALL
                                </span>
                            @endif
                        @else
                            <span style="cursor: pointer;color:red;" onclick="dismiss('{{Auth::guard(Request::segment(1))->user()->id}},{{Request::segment(1)}}');">
                                DISMISS ALL
                            </span>
                        @endif
                    @endif
                </li>

                <li class="body">
                    @if (count($notifications))
                        <ul class="menu list-unstyled">
                            @foreach ($notifications as $notification)
                                <li id="notification_{{$notification->id}}" class="countli">
                                    <a href="{{route(Request::segment(1).'.notification.click',Crypt::encrypt($notification->id))}}">
                                        <div class="media">
                                            <div class="media-body">
                                                {{-- <span class="name">{{$notification->title}}<span class="time" onclick="dismiss('{{$notification->id}}');" style="color:red">DISMISS</span></span> --}}
                                                <span class="name">{{$notification->title}}</span>
                                                <span class="message">{!!$notification->message!!}</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <span class="text-center">
                            <span class="d-flex justify-content-center"  style="margin-top:30px">
                                <i class="zmdi zmdi-hc-3x zmdi-mood"></i>
                            </span>
                            <span class="d-flex justify-content-center"  style="margin-bottom:30px">
                                <h6>All Caught up</h6>
                            </span>
                        </span>
                    @endif
                </li>
                <li id="notification_header" class="header d-flex justify-content-center"><span style="cursor: pointer;color:blue;" onclick="location.href='{{route(Request::segment(1).'.notifications')}}'">View All Notifications</span></li>

            </ul>
        </li>
        <li style="width:50%">
            <span class="d-flex justify-content-center">
               <strong>SCPwD : PARTNER MANAGEMENT SYSTEM</strong>
            </span>
        </li>
        <li class="float-right">
            <span class="btn_overlay" style="font-size:10px; cursor:default">
                <strong>Developed & Maintained By <a href="https://onclavesystems.com/" target="blank"> <span style="color:blue">Onclave Systems</span> </a></strong>
            </span>
            
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