<aside id="leftsidebar" class="sidebar">
    <div class="menu">
        <ul class="list">
            <li>
                <div class="user-info">
                    @php
                        $url = (Request::segment(1) === 'admin') ? '#' : route(Request::segment(1).'.profile');
                    @endphp
                    <div class="image"><a href='{{$url}}'><img src="{{asset('assets/images/avater.png')}}" alt="User"></a></div>
                    <div class="detail">
                        @switch(Request::segment(1))
                            @case('admin')
                                <h4>{{Auth::guard('admin')->user()->name}}</h4>
                                <p class="m-b-0">{{Auth::guard('admin')->user()->email}}</p>
                                @break
                             @case('partner')
                                <h4>{{Auth::guard('partner')->user()->spoc_name}}</h4>
                                <p class="m-b-0">{{Auth::guard('partner')->user()->tp_id}}</p>
                                @break
                             @case('center')
                                <h4>{{Auth::guard('center')->user()->spoc_name}}</h4>
                                <p class="m-b-0">{{Auth::guard('center')->user()->tc_id}}</p>
                                @break
                             @case('agency')
                                <h4>{{Auth::guard('agency')->user()->name}}</h4>
                                <p class="m-b-0">{{Auth::guard('agency')->user()->aa_id}}</p>
                                @break
                            @default
                        @endswitch
                    </div>
                </div>
            </li>
            <li class="header">MAIN</li>
            <li class="{{ Request::segment(2) === 'dashboard' ? 'active open' : null }}">
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a>
                <ul class="ml-menu">
                    <li class="{{ Request::segment(3) === 'dashboard' ? 'active' : null }}"><a href="{{route(Request::segment(1).'.dashboard.dashboard')}}">Dashboard</a></li>
                    @if (Request::segment(1) != 'agency')
                        <li class="{{ Request::segment(3) === 'job_roles' ? 'active' : null }}"><a href="{{route(Request::segment(1).'.dashboard.jobroles')}}">Job Roles</a></li>
                    @endif
                    
                    @if (Request::segment(1) === 'admin')
                        
                    <li class="{{ Request::segment(3) === 'scheme' ? 'active' : null }}"><a href="{{route('admin.dashboard.scheme')}}">Schemes</a></li>
                    <li class="{{ Request::segment(3) === 'holiday' ? 'active' : null }}"><a href="{{route('admin.dashboard.holiday')}}">Holidays</a></li>
                    @endif
                    
                </ul>
            </li>
            @auth('admin')
                @if (Request::segment(1) === 'admin')
                <li class="{{ Request::segment(2) === 'training_partners' ? 'active open' : null }}">
                    <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-accounts"></i><span>Training Partners</span></a>
                    <ul class="ml-menu">
                        <li class="{{ Request::is('admin/training_partners/partners') ? 'active' : null }}"><a href="{{route('admin.tp.partners')}}"> Empanelled Partners</a></li>
                        <li class="{{ Request::is('admin/training_partners/pending-partners') ? 'active' : null }}"><a href="{{route('admin.tp.pp')}}"> Pending Partners</a></li>
                    </ul>
                </li> 
                <li class="{{ Request::segment(2) === 'training_centers' ? 'active open' : null }}">
                    <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-store"></i><span>Training Centers</span></a>
                    <ul class="ml-menu">
                        <li class="{{ Request::segment(3)==='centers' ? 'active' : null }}"><a href="{{route('admin.tc.centers')}}">Centers</a></li>
                        <li class="{{ Request::is('admin/training_centers/pending-centers') ? 'active' : null }}"><a href="{{route('admin.tc.pending-centers')}}">Pending Centers</a></li>
                        <li class="{{ Request::segment(3)==='candidates' ? 'active' : null }}"><a href="{{route('admin.tc.candidates')}}">Candidates</a></li>
                    </ul>
                </li> 
                <li class="{{ Request::segment(2) === 'trainer' ? 'active open' : null }}">
                    <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-accounts-alt"></i><span>Trainers</span></a>
                    <ul class="ml-menu">
                        <li class="{{ Request::is('admin/trainer/trainers') ? 'active' : null }}"><a href="{{route('admin.tc.trainers')}}">Trainers</a></li>
                        <li class="{{ Request::is('admin/trainer/pending-trainers') ? 'active' : null }}"><a href="{{route('admin.tc.pending-trainers')}}">Pending Trainers</a></li>
                    </ul>
                </li> 
                <li class="{{ Request::segment(2) === 'batches' ? 'active open' : null }}">
                    <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-accounts"></i><span>Batches</span></a>
                    <ul class="ml-menu">
                        <li class="{{ Request::is('admin/batches/batches') ? 'active' : null }}"><a href="{{route('admin.batch.batches')}}"> Approved Batches</a></li>
                        <li class="{{ Request::is('admin/batches/pending-batches') ? 'active' : null }}"><a href="{{route('admin.batch.pb')}}"> Pending Batches</a></li>
                        <li class="{{ Request::is('admin/batches/batch-updates') ? 'active' : null }}"><a href="{{route('admin.batch.bu')}}"> Batch Updates</a></li>
                    </ul>
                </li> 
                <li class="{{ Request::segment(2) === 'agency' ? 'active open' : null }}">
                    <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-accounts"></i><span>Agencies</span></a>
                    <ul class="ml-menu">
                        <li class="{{ Request::is('admin/agency/agencies') ? 'active' : null }}"><a href="{{route('admin.agency.agencies')}}"> All Agency</a></li>
                        {{-- <li class="{{ Request::is('admin/batches/pending-batches') ? 'active' : null }}"><a href="{{route('admin.batch.pb')}}"> Pending Batches</a></li> --}}
                    </ul>
                </li> 
                @endif
            @endauth
                    
            @auth('partner')
            @if (Request::segment(1) === 'partner')
                @if (!$partner->complete_profile)
                    <li class="{{ Request::is('partner/complete_registration') ? 'active open' : null }}"><a href="{{route('partner.comp-register')}}"><i class="zmdi zmdi-account-box"></i><span>Registration</span></a></li>
                @endif
                    <li class="{{ Request::segment(2) === 'training_centers' ? 'active open' : null }}">
                        <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-store"></i><span>Training Centers</span></a>
                        <ul class="ml-menu">
                            <li class="{{ Request::segment(3)==='centers' ? 'active' : null }}"><a href="{{route('partner.tc.centers')}}">Centers</a></li>
                            <li class="{{ Request::segment(3)==='candidates' ? 'active' : null }}"><a href="{{route('partner.tc.candidates')}}">Candidates</a></li>
                        </ul>
                    </li>
                    <li class="{{ Request::segment(2)==='trainers' ? 'active open' : (Request::is('partner/add-trainer') ? 'active open' : null ) }}"><a href="{{route('partner.trainers')}}"><i class="zmdi zmdi-accounts"></i><span>Trainers</span></a></li>
                @endif
            @endauth

            @auth('center')
                @if (Request::segment(1) === 'center')
                    <li class="{{ Request::segment(2)==='candidates' ? 'active open' : (Request::is('center/add-candidate') ? 'active open' : null) }}"><a href="{{route('center.candidates')}}"><i class="zmdi zmdi-account-box"></i><span>Candidates</span></a></li>
                @endif
            @endauth

            @auth('agency')
                @if (Request::segment(1) === 'agency')
                    
                @endif
            @endauth
            @if (Request::segment(1) != 'admin' && Request::segment(1) != 'agency')
                <li class="{{ Request::segment(2)==='batches' ? 'active open' : (Request::is('partner/add-batch') ? 'active open' : null ) }}"><a href="{{route(Request::segment(1).'.batches')}}"><i class="zmdi zmdi-accounts-alt"></i><span>Batches</span></a></li>
            @endif
        </ul>
    </div>
</aside>