<aside id="leftsidebar" class="sidebar">
    <div class="menu">
        <ul class="list">
            <li>
                <div class="user-info">
                    <div class="image"><a href="{{route(Request::segment(1).'.profile')}}"><img src="{{asset('assets/images/avater.png')}}" alt="User"></a></div>
                    <div class="detail">
                        @switch(Request::segment(1))
                            @case('admin')
                                <h4>{{Auth::guard('admin')->user()->name}}</h4>
                                <p class="m-b-0">{{Auth::guard('admin')->user()->email}}</p>
                                @break
                             @case('partner')
                                <h4>{{Auth::guard('partner')->user()->org_name}}</h4>
                                <p class="m-b-0">{{Auth::guard('partner')->user()->tp_id}}</p>
                                @break
                             @case('center')
                                <h4>{{Auth::guard('center')->user()->center_name}}</h4>
                                <p class="m-b-0">{{Auth::guard('center')->user()->tc_id}}</p>
                                @break
                             @case('agency')
                                <h4>{{Auth::guard('agency')->user()->agency_name}}</h4>
                                <p class="m-b-0">{{Auth::guard('agency')->user()->aa_id}}</p>
                                @break
                             @case('assessor')
                                <h4>{{Auth::guard('assessor')->user()->name}}</h4>
                                <p class="m-b-0">{{Auth::guard('assessor')->user()->as_id}}</p>
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
                    @if (Request::segment(1) != 'agency' && Request::segment(1) != 'assessor')
                        <li class="{{ Request::segment(3) === 'job_roles' ? 'active' : null }}"><a href="{{route(Request::segment(1).'.dashboard.jobroles')}}">Job Roles</a></li>
                    @endif
                    
                    @if (Request::segment(1) === 'admin')
                        <li class="{{ Request::segment(3) === 'scheme' ? 'active' : null }}"><a href="{{route('admin.dashboard.scheme')}}">Schemes</a></li>
                        <li class="{{ Request::segment(3) === 'holiday' ? 'active' : null }}"><a href="{{route('admin.dashboard.holiday')}}">Holidays</a></li>
                        <li class="{{ Request::segment(3) === 'department' ? 'active' : null }}"><a href="{{route('admin.dashboard.department')}}">Department</a></li>
                        <li class="{{ Request::segment(3) === 'logins' ? 'active' : null }}"><a href="{{route('admin.dashboard.logins')}}">Logins Audit</a></li>
                    @endif
                    
                </ul>
            </li>
            @auth('admin')
                @if (Request::segment(1) === 'admin')
                <li class="{{ Request::segment(2) === 'mis' ? 'active open' : null }}">
                    <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-calendar-check"></i><span>MIS</span></a>
                    <ul class="ml-menu">
                        <li class="{{ Request::is('admin/mis/quick_view') ? 'active' : null }}"><a href="{{route('admin.mis.quick_view')}}"> Quick View</a></li>
                        <li class="{{ Request::is('admin/mis/old_mis_view') ? 'active' : null }}"><a href="{{route('admin.mis.old_mis_view')}}"> Old Mis View</a></li>
                        <li class="{{ Request::is('admin/mis/summary') ? 'active' : null }}"><a href="{{route('admin.mis.summary')}}"> Summary</a></li>
                        {{-- <li class="{{ Request::is('admin/training_partners/pending-partners') ? 'active' : null }}"><a href="{{route('admin.tp.pp')}}"> Pending Partners</a></li> --}}
                    </ul>
                </li> 
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
                    <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-tumblr"></i><span>Trainers</span></a>
                    <ul class="ml-menu">
                        <li class="{{ Request::is('admin/trainer/trainers') ? 'active' : null }}"><a href="{{route('admin.tc.trainers')}}">Trainers</a></li>
                        <li class="{{ Request::is('admin/trainer/pending-trainers') ? 'active' : null }}"><a href="{{route('admin.tc.pending-trainers')}}">Pending Trainers</a></li>
                    </ul>
                </li> 
                <li class="{{ Request::segment(2) === 'batches' ? 'active open' : null }}">
                    <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-badge-check"></i><span>Batches</span></a>
                    <ul class="ml-menu">
                        <li class="{{ Request::is('admin/batches/batches') ? 'active' : null }}"><a href="{{route('admin.batch.batches')}}"> Approved Batches</a></li>
                        <li class="{{ Request::is('admin/batches/pending-batches') ? 'active' : null }}"><a href="{{route('admin.batch.pb')}}"> Pending Batches</a></li>
                        <li class="{{ Request::is('admin/batches/batch-updates') ? 'active' : null }}"><a href="{{route('admin.batch.bu')}}"> Batch Updates</a></li>
                    </ul>
                </li> 
                <li class="{{ Request::segment(2) === 'agency' ? 'active open' : null }}">
                    <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-globe-alt"></i><span>Agencies</span></a>
                    <ul class="ml-menu">
                        <li class="{{ Request::is('admin/agency/agencies') ? 'active' : null }}"><a href="{{route('admin.agency.agencies')}}"> All Agency</a></li>
                        {{-- <li class="{{ Request::is('admin/batches/pending-batches') ? 'active' : null }}"><a href="{{route('admin.batch.pb')}}"> Pending Batches</a></li> --}}
                    </ul>
                </li> 
                <li class="{{ Request::segment(2) === 'assessor' ? 'active open' : null }}">
                    <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-balance"></i><span>Assessors</span></a>
                    <ul class="ml-menu">
                        <li class="{{ Request::is('admin/assessor/assessors') ? 'active' : null }}"><a href="{{route('admin.as.assessors')}}">Assessors</a></li>
                        <li class="{{ Request::is('admin/assessor/pending-assessors') ? 'active' : null }}"><a href="{{route('admin.as.pending-assessors')}}"> Pending Assessors</a></li>
                        
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
                <li class="{{ Request::segment(2)==='assessors' ? 'active open' : (Request::is('agency/assessors') ? 'active open' : null) }}"><a href="{{route('agency.assessors')}}"><i class="zmdi zmdi-account-box"></i><span>Assessor</span></a></li> 

                <li class="{{ Request::segment(2)==='batches' ? 'active open' : null }}">
                    <a href="javascript:void(0);" class="menu-toggle" ><i class="zmdi zmdi-account-box"></i><span>My Batch</span></a>
                    <ul class="ml-menu">
                        <li class="{{ Request::is('agency/batches/approved') ? 'active' : null }}"><a href="{{route('agency.batch')}}">Approved Batch</a></li>
                        <li class="{{ Request::is('agency/batches/pending') ? 'active' : null }}"><a href="{{route('agency.pending-batch')}}">Pending Batch</a></li>
                    </ul>
                </li>  
                @endif
            @endauth

            @auth('assessor')
                @if (Request::segment(1) === 'assessor')
                <li class="{{ Request::segment(2) === 'batches' ? 'active open' : null }}">
                    <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-accounts"></i><span>Batches</span></a>
                    <ul class="ml-menu">
                        <li class="{{ Request::is('assessor/batches') ? 'active' : null }}"><a href="{{route('assessor.batch')}}"> Assigned Batch</a></li>
                        <li class="{{ Request::is('assessor/batches/assessments') ? 'active' : null }}"><a href="{{route('assessor.pending.approval')}}">Assessments</a></li>
                        <li class="{{ Request::is('assessor/batches/reassessments') ? 'active' : null }}"><a href="{{route('assessor.reassessments')}}">Re-Assessments</a></li>
                        {{-- <li class="{{ Request::is('admin/training_partners/pending-partners') ? 'active' : null }}"><a href="{{route('admin.tp.pp')}}"> Pending Partners</a></li> --}}
                    </ul>
                </li>
                
                @endif
            @endauth

            @if (Request::segment(1) != 'admin' && Request::segment(1) != 'agency' && Request::segment(1) != 'assessor')
                <li class="{{ Request::segment(2)==='batches' ? 'active open' : (Request::is('partner/add-batch') ? 'active open' : null ) }}"><a href="{{route(Request::segment(1).'.batches')}}"><i class="zmdi zmdi-accounts-alt"></i><span>Batches</span></a></li>
                <li class="{{ Request::segment(2)==='reassessments' ? 'active open' : null }}"><a href="{{route(Request::segment(1).'.reassessments')}}"><i class="zmdi zmdi-rotate-left"></i><span>Re-Assessments</span></a></li>
            @endif

            @if (Request::segment(1) === 'admin')
                
                <li class="{{ Request::segment(2) === 'assessment' ? 'active open' : null }}">
                    <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-accounts"></i><span>Assessment</span></a>
                    <ul class="ml-menu">
                        <li class="{{ Request::is(Request::segment(1).'/assessment/all-assessment') ? 'active' : null }}"><a href="{{route(Request::segment(1).'.assessment.all-assessment')}}">Assessments</a></li>
                        <li class="{{ Request::is(Request::segment(1).'/assessment/pending-assessment') ? 'active' : null }}"><a href="{{route(Request::segment(1).'.assessment.pending-assessment')}}">Pending Approval</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'reassessment' ? 'active open' : null }}">
                    <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-rotate-left"></i><span>Re-Assessment</span></a>
                    <ul class="ml-menu">
                        {{-- @if (Request::segment(1) === 'agency')
                            <li class="{{ Request::is('agency/reassessment/batches') ? 'active' : null }}"><a href="{{route('agency.reassessment.batches')}}">Batches</a></li>
                        @endif --}}
                        <li class="{{ Request::is('admin/reassessment/reassessment-status') ? 'active' : null }}"><a href="{{route('admin.reassessment.reassessment-status')}}">Result & Certificates</a></li>
                        <li class="{{ Request::is('admin/reassessment/reassessments') ? 'active' : null }}"><a href="{{route('admin.reassessment.reassessments')}}">Re-Assessments</a></li>
                        <li class="{{ Request::is('admin/reassessment/agency-rejected') ? 'active' : null }}"><a href="{{route('admin.reassessment.agencyrejected')}}">Agency Re-Assign</a></li>
                    </ul>
                </li>
            @endif

            @if (Request::segment(1) === 'agency')
            {{-- <li class="{{ Request::segment(2) === 'assessment' ? 'active open' : null }}">
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-accounts"></i><span>Assessment</span></a>
                <ul class="ml-menu">
                    <li class="{{ Request::is(Request::segment(1).'/assessment/all-assessment') ? 'active' : null }}"><a href="{{route(Request::segment(1).'.assessments')}}">Assessments</a></li>
                    <li class="{{ Request::is(Request::segment(1).'/assessment/pending-assessment') ? 'active' : null }}"><a href="{{route(Request::segment(1).'.assessment.pending-assessment')}}">Pending Approval</a></li>
                </ul>
            </li> --}}
            <li class="{{ Request::segment(2)==='assessments' ? 'active open' : (Request::is('agency/assessments') ? 'active open' : null) }}"><a href="{{route('agency.assessments')}}"><i class="zmdi zmdi-border-color"></i><span>Assessments</span></a></li>
            <li class="{{ Request::segment(2)==='reassessments' ? 'active open' : (Request::is('agency/reassessments') ? 'active open' : null) }}"><a href="{{route('agency.reassessments')}}"><i class="zmdi zmdi-rotate-left"></i><span>Re-Assessments</span></a></li>
            
            @endif

            @if (Request::segment(1) === 'admin' || Request::segment(1) === 'partner' || Request::segment(1) === 'center')
                <li class="{{ Request::segment(2)==='placements' ? 'active open' : null }}"><a href="{{route(Request::segment(1).'.placements')}}"><i class="zmdi zmdi-male-female"></i><span>Placements</span></a></li>
            @endif

            @if (Request::segment(1) === 'admin')
            <li class="{{ Request::segment(2) === 'paymentorder' ? 'active open' : null }}">
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-star-circle"></i><span>Payment Order</span></a>
                <ul class="ml-menu">
                    <li class="{{ Request::is('admin/paymentorder/pending-request') ? 'active' : null }}"><a href="{{route('admin.paymentorder.pending-request')}}">Pending Request</a></li>
                    <li class="{{ Request::is('admin/paymentorder/closed-request') ? 'active' : null }}"><a href="{{route('admin.paymentorder.closed-request')}}">All Payment Order</a></li>
                </ul>
            </li>
            <li class="{{ Request::segment(2) === 'invoice' ? 'active open' : null }}">
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-shield-security"></i><span>Invoice</span></a>
                <ul class="ml-menu">
                    <li class="{{ Request::is('admin/invoice/create-assessment-invoice') ? 'active' : null }}"><a href="{{route('admin.invoice.pending-invoice')}}">Assessment</a></li>
                    <li class="{{ Request::is('admin/invoice/create-re-assessment-invoice') ? 'active' : null }}"><a href="{{route('admin.invoice.reassessment-invoice')}}">Re-Assessment</a></li>
                    <li class="{{ Request::is('admin/invoice/all-invoice') ? 'active' : null }}"><a href="{{route('admin.invoice.all-invoice')}}">All Invoice</a></li>
                </ul>
            </li>
            <li class="{{ Request::segment(2) === 'support' ? 'active open' : null }}">
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-twitch"></i><span>Support</span></a>
                <ul class="ml-menu">
                    <li class="{{ Request::is('admin/support/pending-request') ? 'active' : null }}"><a href="{{route('admin.support.pending-request')}}">Pending Request</a></li>
                    <li class="{{ Request::is('admin/support/closed-request') ? 'active' : null }}"><a href="{{route('admin.support.closed-request')}}">Closed Request</a></li>
                </ul>
            </li>
            @endif
            @if (Request::segment(1) === 'agency')
            <li class="{{ Request::segment(2) === 'payment-order' ? 'active open' : null }}">
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-star-circle"></i><span>Payment Order</span></a>
                <ul class="ml-menu">
                    <li class="{{ Request::is('admin/payment-order/tc-wise') ? 'active' : null }}"><a href="{{route('agency.payment-order.tc-wise')}}">TC Wise</a></li>
                    <li class="{{ Request::is('admin/payment-order/batch-wise') ? 'active' : null }}"><a href="{{route('agency.payment-order.batch-wise')}}">Batch Wise</a></li>
                    <li class="{{ Request::is('admin/payment-order/my-payment-order') ? 'active' : null }}"><a href="{{route('agency.payment-order.my-payment-order')}}">My Payment Order</a></li>
                </ul>
            </li>
            @endif
            
            @if (Request::segment(1)==='agency' || Request::segment(1)==='assessor' || Request::segment(1)==='center' || Request::segment(1)==='partner')
                <li class="{{ Request::segment(2) === 'support' ? 'active open' : null }}">
                    <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-twitch"></i><span>Support</span></a>
                    <ul class="ml-menu">
                        <li class="{{ Request::is(Request::segment(1).'/support/complain') ? 'active' : null }}"><a href="{{route(Request::segment(1).'.support.complain')}}">Complain</a></li>
                        <li class="{{ Request::is(Request::segment(1).'/support/my-complain') ? 'active' : null }}"><a href="{{route(Request::segment(1).'.support.my-complain')}}">My Complain</a></li>
                    </ul>
                </li> 
            @endif

        </ul>
    </div>
</aside>