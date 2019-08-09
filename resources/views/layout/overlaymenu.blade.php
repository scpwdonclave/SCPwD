<div class="overlay_menu">
    <button class="btn btn-primary btn-icon btn-icon-mini btn-round"><i class="zmdi zmdi-close"></i></button>
    <div class="container">        
        <div class="row clearfix">
            <div class="card links">
                <div class="body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <h6>App</h6>
                            <ul class="list-unstyled">
                                <li class="{{ Request::is('app/mail-compose') ? 'active' : null }}"><a href="{{route('app.mail-compose')}}">Mail Compose</a></li>
                                <li class="{{ Request::is('app/mail-inbox') ? 'active' : null }}"><a href="{{route('app.mail-inbox')}}">Mail Inbox</a></li>
                                <li class="{{ Request::is('app/chat') ? 'active' : null }}"><a href="{{route('app.chat')}}">Chat</a></li>
                                <li class="{{ Request::is('app/calendar') ? 'active' : null }}"><a href="{{route('app.calendar')}}">Calendar</a></li>
                                <li class="{{ Request::is('app/contact-list') ? 'active' : null }}"><a href="{{route('app.contact-list')}}">Contact list</a></li>
                                <li class="{{ Request::is('app/taskboard') ? 'active' : null }}"><a href="{{route('app.taskboard')}}">TaskBoard</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <h6>User Interface (UI)</h6>
                            <ul class="list-unstyled">
                                <li class="{{ Request::is('ui-elements/ui-kit') ? 'active' : null }}"><a href="{{route('ui-elements.ui-kit')}}">UI Kit</a></li>
                                <li class="{{ Request::is('ui-elements/alerts') ? 'active' : null }}"><a href="{{route('ui-elements.alerts')}}">Alerts</a></li>
                                <li class="{{ Request::is('ui-elements/collapse') ? 'active' : null }}"><a href="{{route('ui-elements.collapse')}}">Collapse</a></li>
                                <li class="{{ Request::is('ui-elements/dialogs') ? 'active' : null }}"><a href="{{route('ui-elements.dialogs')}}">Dialogs</a></li>
                                <li class="{{ Request::is('ui-elements/modals') ? 'active' : null }}"><a href="{{route('ui-elements.modals')}}">Modals</a></li>
                                <li class="{{ Request::is('ui-elements/range-sliders') ? 'active' : null }}"><a href="{{route('ui-elements.range-sliders')}}">Range Sliders</a></li>
                                <li class="{{ Request::is('ui-elements/tabs') ? 'active' : null }}"><a href="{{route('ui-elements.tabs')}}">Tabs</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <h6>Sample Pages</h6>
                            <ul class="list-unstyled">
                                <li class="{{ Request::is('pages/image-gallery') ? 'active' : null }}"><a href="{{route('pages.image-gallery')}}">Image Gallery</a></li>
                                <li class="{{ Request::is('pages/profile') ? 'active' : null }}"><a href="{{route('pages.profile')}}">Profile</a></li>
                                <li class="{{ Request::is('pages/timeline') ? 'active' : null }}"><a href="{{route('pages.timeline')}}">Timeline</a></li>
                                <li class="{{ Request::is('pages/pricing') ? 'active' : null }}"><a href="{{route('pages.pricing')}}">Pricing</a></li>
                                <li class="{{ Request::is('pages/invoices') ? 'active' : null }}"><a href="{{route('pages.invoices')}}">Invoices</a></li>
                                <li class="{{ Request::is('pages/search-results') ? 'active' : null }}"><a href="{{route('pages.search-results')}}">Search Results</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <h6>About</h6>
                            <ul class="list-unstyled">
                                <li><a href="https://thememakker.com/our-facts/" target="_blank">About</a></li>
                                <li><a href="https://thememakker.com/contact/" target="_blank">Contact Us</a></li>
                                <li><a href="https://thememakker.com/all-templates/" target="_blank">Admin Templates</a></li>
                                <li><a href="https://thememakker.com/web-design/" target="_blank">Services</a></li>
                                <li><a href="https://thememakker.com/our-work/" target="_blank">Portfolio</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="social">
                    <a class="icon" href="https://www.facebook.com/thememakkerteam" target="_blank"><i class="zmdi zmdi-facebook"></i></a>
                    <a class="icon" href="https://www.behance.net/thememakker" target="_blank"><i class="zmdi zmdi-behance"></i></a>
                    <a class="icon" href="javascript:void(0);"><i class="zmdi zmdi-twitter"></i></a>
                    <a class="icon" href="javascript:void(0);"><i class="zmdi zmdi-linkedin"></i></a>                    
                    <p>Coded by WrapTheme<br> Designed by <a href="https://thememakker.com/" target="_blank">thememakker.com</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="overlay"></div>