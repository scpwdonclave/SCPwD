<aside id="leftsidebar" class="sidebar">
    <div class="menu">
        <ul class="list">
            <li>
                <div class="user-info">
                    @php
                        $url = (Request::segment(1) === 'partner') ? route('partner.profile') : '#';
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
                </ul>
            </li>
            @auth('admin')
                @if (Request::segment(1) === 'admin')
                <li class="{{ Request::segment(2) === 'partners' ? 'active open' : null }}">
                    <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-gamepad"></i><span>Training Partners</span></a>
                    <ul class="ml-menu">
                        <li class="{{ Request::is('admin/partners') ? 'active' : null }}"><a href="{{route('admin.partners')}}">Partners</a></li>
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
                        <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-pin"></i><span>Training Centers</span></a>
                        <ul class="ml-menu">
                            <li class="{{ Request::is('partner/training_centers/centers') ? 'active' : null }}"><a href="{{route('partner.tc.centers')}}">Centers</a></li>
                        </ul>
                    </li>
                @endif
            @endauth
            


{{--             
            <li class="{{ Request::segment(1) === 'app' ? 'active open' : null }}">
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-apps"></i><span>App</span></a>
                <ul class="ml-menu">
                    <li class="{{ Request::is('app/mail-compose') ? 'active' : null }}"><a href="{{route('app.mail-compose')}}">Mail Compose</a></li>
                    <li class="{{ Request::is('app/mail-inbox') ? 'active' : null }}"><a href="{{route('app.mail-inbox')}}">Mail Inbox</a></li>
                    <li class="{{ Request::is('app/chat') ? 'active' : null }}"><a href="{{route('app.chat')}}">Chat</a></li>
                    <li class="{{ Request::is('app/calendar') ? 'active' : null }}"><a href="{{route('app.calendar')}}">Calendar</a></li>
                    <li class="{{ Request::is('app/contact-list') ? 'active' : null }}"><a href="{{route('app.contact-list')}}">Contact list</a></li>
                    <li class="{{ Request::is('app/taskboard') ? 'active' : null }}"><a href="{{route('app.taskboard')}}">TaskBoard</a></li>
                </ul>
            </li> --}}
            {{-- <li class="{{ Request::segment(1) === 'file-manager' ? 'active open' : null }}">
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-file"></i><span>File Manager</span></a>
                <ul class="ml-menu">
                    <li class="{{ Request::is('file-manager/dashboard') ? 'active' : null }}"><a href="{{route('file-manager.dashboard')}}">Dashboard</a></li>
                    <li class="{{ Request::is('file-manager/documents') ? 'active' : null }}"><a href="{{route('file-manager.documents')}}">Documents</a></li>
                    <li class="{{ Request::is('file-manager/media') ? 'active' : null }}"><a href="{{route('file-manager.media')}}">Media</a></li>
                    <li class="{{ Request::is('file-manager/image') ? 'active' : null }}"><a href="{{route('file-manager.image')}}">Images</a></li>
                </ul>
            </li>
            <li class="{{ Request::segment(1) === 'blog' ? 'active open' : null }}">
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-globe"></i><span>Blog</span></a>
                <ul class="ml-menu">
                    <li class="{{ Request::is('blog/dashboard') ? 'active' : null }}"><a href="{{route('blog.dashboard')}}">Dashboard</a></li>
                    <li class="{{ Request::is('blog/blog-post') ? 'active' : null }}"><a href="{{route('blog.blog-post')}}">Blog Post</a></li>
                    <li class="{{ Request::is('blog/blog-list') ? 'active' : null }}"><a href="{{route('blog.blog-list')}}">Blog List</a></li>
                    <li class="{{ Request::is('blog/blog-grid') ? 'active' : null }}"><a href="{{route('blog.blog-grid')}}">Blog Grid</a></li>
                    <li class="{{ Request::is('blog/blog-detail') ? 'active' : null }}"><a href="{{route('blog.blog-detail')}}">Blog Detail</a></li>
                </ul>
            </li>
            <li class="{{ Request::segment(1) === 'ui-elements' ? 'active open' : null }}">
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-swap-alt"></i><span>User Interface (UI)</span></a>
                <ul class="ml-menu">
                    <li class="{{ Request::is('ui-elements/ui-kit') ? 'active' : null }}"><a href="{{route('ui-elements.ui-kit')}}">UI Kit</a></li>
                    <li class="{{ Request::is('ui-elements/alerts') ? 'active' : null }}"><a href="{{route('ui-elements.alerts')}}">Alerts</a></li>
                    <li class="{{ Request::is('ui-elements/collapse') ? 'active' : null }}"><a href="{{route('ui-elements.collapse')}}">Collapse</a></li>
                    <li class="{{ Request::is('ui-elements/colors') ? 'active' : null }}"><a href="{{route('ui-elements.colors')}}">Colors</a></li>
                    <li class="{{ Request::is('ui-elements/dialogs') ? 'active' : null }}"><a href="{{route('ui-elements.dialogs')}}">Dialogs</a></li>
                    <li class="{{ Request::is('ui-elements/icons') ? 'active' : null }}"><a href="{{route('ui-elements.icons')}}">Icons</a></li>
                    <li class="{{ Request::is('ui-elements/list-group') ? 'active' : null }}"><a href="{{route('ui-elements.list-group')}}">List Group</a></li>
                    <li class="{{ Request::is('ui-elements/media-object') ? 'active' : null }}"><a href="{{route('ui-elements.media-object')}}">Media Object</a></li>
                    <li class="{{ Request::is('ui-elements/modals') ? 'active' : null }}"><a href="{{route('ui-elements.modals')}}">Modals</a></li>
                    <li class="{{ Request::is('ui-elements/notifications') ? 'active' : null }}"><a href="{{route('ui-elements.notifications')}}">Notifications</a></li>
                    <li class="{{ Request::is('ui-elements/progress-bars') ? 'active' : null }}"><a href="{{route('ui-elements.progress-bars')}}">Progress Bars</a></li>
                    <li class="{{ Request::is('ui-elements/range-sliders') ? 'active' : null }}"><a href="{{route('ui-elements.range-sliders')}}">Range Sliders</a></li>
                    <li class="{{ Request::is('ui-elements/nestable') ? 'active' : null }}"><a href="{{route('ui-elements.nestable')}}">Nestable</a></li>
                    <li class="{{ Request::is('ui-elements/tabs') ? 'active' : null }}"><a href="{{route('ui-elements.tabs')}}">Tabs</a></li>
                    <li class="{{ Request::is('ui-elements/waves') ? 'active' : null }}"><a href="{{route('ui-elements.waves')}}">waves</a></li>
                </ul>
            </li>
            <li class="{{ Request::segment(1) === 'widgets' ? 'active open' : null }}">
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-widgets"></i><span>Widgets</span></a>
                <ul class="ml-menu">
                    <li class="{{ Request::is('widgets/app') ? 'active' : null }}"><a href="{{route('widgets.app')}}">Apps Widgetse</a></li>
                    <li class="{{ Request::is('widgets/data') ? 'active' : null }}"><a href="{{route('widgets.data')}}">Data Widgetse</a></li>
                </ul>
            </li>
            <li class="header">ECOMMERCE</li>
            <li class="{{ Request::segment(1) === 'ecommerce' ? 'active open' : null }}">
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-shopping-cart"></i><span>Ecommerce</span></a>
                <ul class="ml-menu">
                    <li class="{{ Request::is('ecommerce/dashboard') ? 'active' : null }}"><a href="{{route('ecommerce.dashboard')}}">Dashboard</a></li>
                    <li class="{{ Request::is('ecommerce/product') ? 'active' : null }}"><a href="{{route('ecommerce.product')}}">Product</a></li>
                    <li class="{{ Request::is('ecommerce/product-list') ? 'active' : null }}"><a href="{{route('ecommerce.product-list')}}">Product List</a></li>
                    <li class="{{ Request::is('ecommerce/product-detail') ? 'active' : null }}"><a href="{{route('ecommerce.product-detail')}}">Product detail</a></li>
                    <li class="{{ Request::is('ecommerce/orders') ? 'active' : null }}"><a href="{{route('ecommerce.orders')}}">Orders</a></li>
                    <li class="{{ Request::is('ecommerce/cart') ? 'active' : null }}"><a href="{{route('ecommerce.cart')}}">Cart</a></li>
                    <li class="{{ Request::is('ecommerce/checkout') ? 'active' : null }}"><a href="{{route('ecommerce.checkout')}}">Checkout</a></li>
                </ul>
            </li>
            <li class="header">FORMS, CHARTS, TABLES</li>
            <li class="{{ Request::segment(1) === 'forms' ? 'active open' : null }}">
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-assignment"></i><span>Forms</span></a>
                <ul class="ml-menu">
                    <li class="{{ Request::is('forms/basic-elements') ? 'active' : null }}"><a href="{{route('forms.basic-elements')}}">Basic Elements</a></li>
                    <li class="{{ Request::is('forms/advance-elements') ? 'active' : null }}"><a href="{{route('forms.advance-elements')}}">Advanced Elements</a></li>
                    <li class="{{ Request::is('forms/examples') ? 'active' : null }}"><a href="{{route('forms.examples')}}">Form Examples</a></li>
                    <li class="{{ Request::is('forms/validation') ? 'active' : null }}"><a href="{{route('forms.validation')}}">Form Validation</a></li>
                    <li class="{{ Request::is('forms/wizard') ? 'active' : null }}"><a href="{{route('forms.wizard')}}">Form Wizard</a></li>
                    <li class="{{ Request::is('forms/editors') ? 'active' : null }}"><a href="{{route('forms.editors')}}">Editor</a></li>
                    <li class="{{ Request::is('forms/dragdrop') ? 'active' : null }}"><a href="{{route('forms.dragdrop')}}">File Upload</a></li>
                </ul>
            </li>
            <li class="{{ Request::segment(1) === 'table' ? 'active open' : null }}">
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-grid"></i><span>Tables</span></a>
                <ul class="ml-menu">
                    <li class="{{ Request::is('table/normal') ? 'active' : null }}"><a href="{{route('table.normal')}}">Normal Tables</a></li>
                    <li class="{{ Request::is('table/basic') ? 'active' : null }}"><a href="{{route('table.basic')}}">Tables Basic</a></li>
                    <li class="{{ Request::is('table/jquery-datatable') ? 'active' : null }}"><a href="{{route('table.jquery-datatable')}}">Jquery Datatables</a></li>
                    <li class="{{ Request::is('table/editable') ? 'active' : null }}"><a href="{{route('table.editable')}}">Editable Tables</a></li>
                    <li class="{{ Request::is('table/color') ? 'active' : null }}"><a href="{{route('table.color')}}">Tables Color</a></li>
                    <li class="{{ Request::is('table/filter') ? 'active' : null }}"><a href="{{route('table.filter')}}">Table Filter</a></li>
                    <li class="{{ Request::is('table/dragger') ? 'active' : null }}"><a href="{{route('table.dragger')}}">Table dragger</a></li>
                </ul>
            </li>
            <li class="{{ Request::segment(1) === 'charts' ? 'active open' : null }}">
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-chart"></i><span>Charts</span></a>
                <ul class="ml-menu">
                    <li class="{{ Request::is('charts/morris') ? 'active' : null }}"><a href="{{route('charts.morris')}}">Morris</a> </li>
                    <li class="{{ Request::is('charts/flot') ? 'active' : null }}"><a href="{{route('charts.flot')}}">Flot</a> </li>
                    <li class="{{ Request::is('charts/chartjs') ? 'active' : null }}"><a href="{{route('charts.chartjs')}}">ChartJS</a> </li>
                    <li class="{{ Request::is('charts/sparkline') ? 'active' : null }}"><a href="{{route('charts.sparkline')}}">Sparkline Chart</a></li>
                    <li class="{{ Request::is('charts/jquery-knob') ? 'active' : null }}"><a href="{{route('charts.jquery-knob')}}">Jquery Knob</a> </li>
                    <li class="{{ Request::is('charts/c3') ? 'active' : null }}"><a href="{{route('charts.c3')}}">C3 Charts</a></li>
                    <li class="{{ Request::is('charts/echart') ? 'active' : null }}"><a href="{{route('charts.echart')}}">E Chart</a></li>
                </ul>
            </li>
            <li class="header">EXTRA COMPONENTS</li>
            <li class="{{ Request::segment(1) === 'map' ? 'active open' : null }}">
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-map"></i><span>Maps</span></a>
                <ul class="ml-menu">
                    <li class="{{ Request::is('map/yandex') ? 'active' : null }}"><a href="{{route('map.yandex')}}">YandexMap</a></li>
                    <li class="{{ Request::is('map/jvector') ? 'active' : null }}"><a href="{{route('map.jvector')}}">jVectorMap</a></li>
                </ul>
            </li>
            <li class="sm_menu_btm {{ Request::segment(1) === 'authentication' ? 'active open' : null }}">
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-lock"></i><span>Authentication</span></a>
                <ul class="ml-menu">
                    <li class="{{ Request::is('authentication/login') ? 'active' : null }}"><a href="{{route('authentication.login')}}">Sign In</a></li>
                    <li class="{{ Request::is('authentication/register') ? 'active' : null }}"><a href="{{route('authentication.register')}}">Sign Up</a></li>
                    <li class="{{ Request::is('authentication/forgot-password') ? 'active' : null }}"><a href="{{route('authentication.forgot-password')}}">Forgot Password</a></li>
                    <li class="{{ Request::is('authentication/page404') ? 'active' : null }}"><a href="{{route('authentication.page404')}}">Page 404</a></li>
                    <li class="{{ Request::is('authentication/page500') ? 'active' : null }}"><a href="{{route('authentication.page500')}}">Page 500</a></li>
                    <li class="{{ Request::is('authentication/offline') ? 'active' : null }}"><a href="{{route('authentication.offline')}}">Page Offline</a></li>
                    <li class="{{ Request::is('authentication/lockscreen') ? 'active' : null }}"><a href="{{route('authentication.lockscreen')}}">Locked Screen</a></li>
                </ul>
            </li>
            <li class="sm_menu_btm {{ Request::segment(1) === 'pages' ? 'active open' : null }}">
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-copy"></i><span>Sample Pages</span></a>
                <ul class="ml-menu">
                    <li class="{{ Request::is('pages/blank-page') ? 'active' : null }}"><a href="{{route('pages.blank-page')}}">Blank Page</a></li>
                    <li class="{{ Request::is('pages/image-gallery') ? 'active' : null }}"><a href="{{route('pages.image-gallery')}}">Image Gallery</a></li>
                    <li class="{{ Request::is('pages/profile') ? 'active' : null }}"><a href="{{route('pages.profile')}}">Profile</a></li>
                    <li class="{{ Request::is('pages/timeline') ? 'active' : null }}"><a href="{{route('pages.timeline')}}">Timeline</a></li>
                    <li class="{{ Request::is('pages/pricing') ? 'active' : null }}"><a href="{{route('pages.pricing')}}">Pricing</a></li>
                    <li class="{{ Request::is('pages/invoices') ? 'active' : null }}"><a href="{{route('pages.invoices')}}">Invoices</a></li>
                    <li class="{{ Request::is('pages/search-results') ? 'active' : null }}"><a href="{{route('pages.search-results')}}">Search Results</a></li>
                </ul>
            </li>
            <li class="{{ Request::is('pages/faq') ? 'active' : null }}"><a href="{{route('pages.faq')}}"><i class="zmdi zmdi-circle-o text-success"></i><span>Faqs</span></a></li> --}}
        </ul>
    </div>
</aside>