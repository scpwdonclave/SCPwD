@extends('layout.master')
@section('title', 'User Profile')
@section('parentPageTitle', 'Pages')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/css/timeline.css')}}">
@stop
@section('content')
<div class="container-fluid profile-page">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12">
            <div class="card profile-header bg-dark">
                <div class="body col-white">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="profile-image float-md-right"> <img src="../assets/images/profile_av.jpg" alt=""> </div>
                        </div>
                        <div class="col-lg-9 col-md-8 col-12">
                            <h4 class="m-t-0 m-b-0"><strong>Michael</strong> Deo</h4>
                            <span class="job_post">Ui UX Designer</span>
                            <p>795 Folsom Ave, Suite 600 San Francisco, CADGE 94107</p>
                            <div>
                                <button class="btn btn-primary btn-round">Follow</button>
                                <button class="btn btn-primary btn-round btn-simple">Message</button>
                            </div>
                            <p class="social-icon m-t-5 m-b-0">
                                <a title="Twitter" href="javascript:void(0);"><i class="zmdi zmdi-twitter"></i></a>
                                <a title="Facebook" href="javascript:void(0);"><i class="zmdi zmdi-facebook"></i></a>
                                <a title="Google-plus" href="javascript:void(0);"><i class="zmdi zmdi-twitter"></i></a>
                                <a title="Behance" href="javascript:void(0);"><i class="zmdi zmdi-behance"></i></a>
                                <a title="Instagram" href="javascript:void(0);"><i class="zmdi zmdi-instagram "></i></a>
                            </p>
                        </div>                            
                    </div>
                </div>                    
            </div>
        </div>
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <ul class="row profile_state list-unstyled">
                    <li class="col-lg-2 col-md-4 col-6">
                        <div class="body">
                            <i class="zmdi zmdi-camera col-amber"></i>
                            <h5 class="m-b-0 number count-to" data-from="0" data-to="2365" data-speed="1000" data-fresh-interval="700">2365</h5>
                            <small>Shots View</small>
                        </div>
                    </li>
                    <li class="col-lg-2 col-md-4 col-6">
                        <div class="body">
                            <i class="zmdi zmdi-thumb-up col-blue"></i>
                            <h5 class="m-b-0 number count-to" data-from="0" data-to="1203" data-speed="1000" data-fresh-interval="700">1203</h5>
                            <small>Likes</small>
                        </div>
                    </li>
                    <li class="col-lg-2 col-md-4 col-6">
                        <div class="body">
                            <i class="zmdi zmdi-comment-text col-red"></i>
                            <h5 class="m-b-0 number count-to" data-from="0" data-to="324" data-speed="1000" data-fresh-interval="700">324</h5>
                            <small>Comments</small>
                        </div>
                    </li>
                    <li class="col-lg-2 col-md-4 col-6">
                        <div class="body">
                            <i class="zmdi zmdi-account text-success"></i>
                            <h5 class="m-b-0 number count-to" data-from="0" data-to="1980" data-speed="1000" data-fresh-interval="700">1980</h5>
                            <small>Profile Views</small>
                        </div>
                    </li>
                    <li class="col-lg-2 col-md-4 col-6">
                        <div class="body">
                            <i class="zmdi zmdi-desktop-mac text-info"></i>
                            <h5 class="m-b-0 number count-to" data-from="0" data-to="251" data-speed="1000" data-fresh-interval="700">251</h5>
                            <small>Website View</small>
                        </div>
                    </li>
                    <li class="col-lg-2 col-md-4 col-6">
                        <div class="body">
                            <i class="zmdi zmdi-attachment text-warning"></i>
                            <h5 class="m-b-0 number count-to" data-from="0" data-to="52" data-speed="1000" data-fresh-interval="700">52</h5>
                            <small>Attachment</small>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-4 col-md-12">
            <div class="card">
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#friends">Friends</a></li>                        
                </ul>
                <div class="tab-content">
                    <div class="tab-pane body active" id="about">
                        <small class="text-muted">Email address: </small>
                        <p>michael@gmail.com</p>
                        <hr>
                        <small class="text-muted">Phone: </small>
                        <p>+ 202-555-9191</p>
                        <hr>
                        <small class="text-muted">Mobile: </small>
                        <p>+ 202-555-2828</p>
                        <hr>
                        <small class="text-muted">Birth Date: </small>
                        <p class="m-b-0">October 22th, 1990</p>
                    </div>
                    <div class="tab-pane body" id="friends">
                        <ul class="new_friend_list list-unstyled row">
                            <li class="col-lg-4 col-md-2 col-sm-6 col-4">
                                <a href="">
                                    <img src="../assets/images/sm/avatar1.jpg" class="img-thumbnail" alt="User Image">
                                    <h6 class="users_name">Jackson</h6>
                                    <small class="join_date">Today</small>
                                </a>
                            </li>
                            <li class="col-lg-4 col-md-2 col-sm-6 col-4">
                                <a href="">
                                    <img src="../assets/images/sm/avatar2.jpg" class="img-thumbnail" alt="User Image">
                                    <h6 class="users_name">Aubrey</h6>
                                    <small class="join_date">Yesterday</small>
                                </a>
                            </li>
                            <li class="col-lg-4 col-md-2 col-sm-6 col-4">
                                <a href="">
                                    <img src="../assets/images/sm/avatar3.jpg" class="img-thumbnail" alt="User Image">
                                    <h6 class="users_name">Oliver</h6>
                                    <small class="join_date">08 Nov</small>
                                </a>
                            </li>
                            <li class="col-lg-4 col-md-2 col-sm-6 col-4">
                                <a href="">
                                    <img src="../assets/images/sm/avatar4.jpg" class="img-thumbnail" alt="User Image">
                                    <h6 class="users_name">Isabella</h6>
                                    <small class="join_date">12 Dec</small>
                                </a>
                            </li>
                            <li class="col-lg-4 col-md-2 col-sm-6 col-4">
                                <a href="">
                                    <img src="../assets/images/sm/avatar1.jpg" class="img-thumbnail" alt="User Image">
                                    <h6 class="users_name">Jacob</h6>
                                    <small class="join_date">12 Dec</small>
                                </a>
                            </li>
                            <li class="col-lg-4 col-md-2 col-sm-6 col-4">
                                <a href="">
                                    <img src="../assets/images/sm/avatar5.jpg" class="img-thumbnail" alt="User Image">
                                    <h6 class="users_name">Matthew</h6>
                                    <small class="join_date">17 Dec</small>
                                </a>
                            </li>                            
                        </ul>
                    </div>                        
                </div>
            </div>
            <div class="card">
                <div class="header">
                    <h2><strong>Who</strong> to follow</h2>
                    <ul class="header-dropdown">
                        <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                            <ul class="dropdown-menu dropdown-menu-right float-right">
                                <li><a href="javascript:void(0);">Edit</a></li>
                                <li><a href="javascript:void(0);">Delete</a></li>
                                <li><a href="javascript:void(0);">Report</a></li>
                            </ul>
                        </li>
                        <li class="remove">
                            <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <ul class="follow_us list-unstyled">
                        <li class="online">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object " src="../assets/images/xs/avatar4.jpg" alt="">
                                    <div class="media-body">
                                        <span class="name">Chris Fox</span>
                                        <span class="message">Designer, Blogger</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>                            
                        </li>
                        <li class="online">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object " src="../assets/images/xs/avatar5.jpg" alt="">
                                    <div class="media-body">
                                        <span class="name">Joge Lucky</span>
                                        <span class="message">Java Developer</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>                            
                        </li>
                        <li class="offline">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object " src="../assets/images/xs/avatar2.jpg" alt="">
                                    <div class="media-body">
                                        <span class="name">Isabella</span>
                                        <span class="message">CEO, Thememakker</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>                            
                        </li>
                        <li class="offline">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object " src="../assets/images/xs/avatar1.jpg" alt="">
                                    <div class="media-body">
                                        <span class="name">Folisise Chosielie</span>
                                        <span class="message">Art director, Movie Cut</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>                            
                        </li>
                        <li class="online">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object " src="../assets/images/xs/avatar3.jpg" alt="">
                                    <div class="media-body">
                                        <span class="name">Alexander</span>
                                        <span class="message">Writter, Mag Editor</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>                            
                        </li>                        
                    </ul>
                </div>
            </div>
            <div class="card">
                <div class="header">
                    <h2><strong>Recent</strong> Activity</h2>
                    <ul class="header-dropdown">
                        <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                            <ul class="dropdown-menu dropdown-menu-right float-right">
                                <li><a href="javascript:void(0);">Edit</a></li>
                                <li><a href="javascript:void(0);">Delete</a></li>
                                <li><a href="javascript:void(0);">Report</a></li>
                            </ul>
                        </li>
                        <li class="remove">
                            <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="body user_activity">
                    <div class="streamline b-accent">
                        <div class="sl-item">
                            <img class="user rounded-circle" src="../assets/images/xs/avatar4.jpg" alt="">
                            <div class="sl-content">
                                <h5 class="m-b-0">Admin Birthday</h5>
                                <small>Jan 21 <a href="javascript:void(0);" class="text-info">Sophia</a>.</small>
                            </div>
                        </div>
                        <div class="sl-item">
                            <img class="user rounded-circle" src="../assets/images/xs/avatar5.jpg" alt="">
                            <div class="sl-content">
                                <h5 class="m-b-0">Add New Contact</h5>
                                <small>30min ago <a href="javascript:void(0);">Alexander</a>.</small>
                                <small><strong>P:</strong> +264-625-2323</small>
                                <small><strong>E:</strong> maryamamiri@gmail.com</small>
                            </div>
                        </div>
                        <div class="sl-item">
                            <img class="user rounded-circle" src="../assets/images/xs/avatar6.jpg" alt="">
                            <div class="sl-content">
                                <h5 class="m-b-0">Code Change</h5>
                                <small>Today <a href="javascript:void(0);">Grayson</a>.</small>
                                <small>The standard chunk of Lorem Ipsum used since the 1500s is reproduced</small>
                            </div>
                        </div>
                        <div class="sl-item">
                            <img class="user rounded-circle" src="../assets/images/xs/avatar7.jpg" alt="">
                            <div class="sl-content">
                                <h5 class="m-b-0">New Email</h5>
                                <small>45min ago <a href="javascript:void(0);" class="text-info">Fidel Tonn</a>.</small>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-12">
            <div class="card bg-dark">
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#mypost">My Post</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#timeline">Timeline</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#usersettings">Setting</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="mypost">
                    <div class="card">
                        <div class="body">
                            <div class="form-group">
                                <textarea rows="4" class="form-control no-resize" placeholder="Please type what you want..."></textarea>
                            </div>
                            <div class="post-toolbar-b">
                                <button class="btn btn-warning btn-icon  btn-icon-mini btn-round"><i class="zmdi zmdi-attachment"></i></button>
                                <button class="btn btn-warning btn-icon  btn-icon-mini btn-round"><i class="zmdi zmdi-camera"></i></button>
                                <button class="btn btn-primary btn-round">Post</button>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="body post-box">                                
                            <div class="post-img">
                                <img src="../assets/images/image1.jpg" class="img-fluid" alt="">
                            </div>                                
                            <h5 class="m-t-20 m-b-0 post_title">It is a long established fact that a be distracted</h5>                                
                            <p>If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text</p>                                
                            <div class="form-group m-b-0">
                                <button class="btn btn-info btn-round">Like 5</button>
                                <button class="btn btn-primary btn-simple btn-round">Reply</button>
                                <span class="date m-l-20"><i class="zmdi zmdi-alarm"></i> 7min ago</span>
                            </div>
                            <hr>
                        </div>
                        <div class="body post-box">                                
                            <div class="post-img">
                                <img src="../assets/images/image2.jpg" class="img-fluid" alt="">
                            </div>                                
                            <h5 class="m-t-20 m-b-0 post_title">need to be sure there isn't anything embarrassing</h5>                                
                            <p>If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text</p>                                
                            <div class="form-group m-b-0">
                                <button class="btn btn-info btn-round">Like 5</button>
                                <button class="btn btn-primary btn-simple btn-round">Reply</button>
                                <span class="date m-l-20"><i class="zmdi zmdi-alarm"></i> 1hr ago</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane" id="timeline">
                    <div class="card">
                        <div class="body">
                            <ul class="cbp_tmtimeline">
                                <li>
                                    <time class="cbp_tmtime" datetime="2017-11-04T18:30"><span class="hidden">25/12/2017</span> <span class="large">Now</span></time>
                                    <div class="cbp_tmicon"><i class="zmdi zmdi-account"></i></div>
                                    <div class="cbp_tmlabel empty"> <span>No Activity</span> </div>
                                </li>
                                <li>
                                    <time class="cbp_tmtime" datetime="2017-11-04T03:45"><span>03:45 AM</span> <span>Today</span></time>
                                    <div class="cbp_tmicon bg-info"><i class="zmdi zmdi-label"></i></div>
                                    <div class="cbp_tmlabel">
                                        <h2><a href="javascript:void(0);">Art Ramadani</a> <span>posted a status update</span></h2>
                                        <p>Tolerably earnestly middleton extremely distrusts she boy now not. Add and offered prepare how cordial two promise. Greatly who affixed suppose but enquire compact prepare all put. Added forth chief trees but rooms think may.</p>
                                    </div>
                                </li>
                                <li>
                                    <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>01:22 PM</span> <span>Yesterday</span></time>
                                    <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-case"></i></div>
                                    <div class="cbp_tmlabel">
                                        <h2><a href="javascript:void(0);">Job Meeting</a></h2>
                                        <p>You have a meeting at <strong>Laborator Office</strong> Today.</p>
                                    </div>
                                </li>
                                <li>
                                    <time class="cbp_tmtime" datetime="2017-10-22T12:13"><span>12:13 PM</span> <span>Two weeks ago</span></time>
                                    <div class="cbp_tmicon bg-blush"><i class="zmdi zmdi-pin"></i></div>
                                    <div class="cbp_tmlabel">
                                        <h2><a href="javascript:void(0);">Arlind Nushi</a> <span>checked in at</span> <a href="javascript:void(0);">New York</a></h2>
                                        <blockquote>
                                            <p class="blockquote blockquote-primary">
                                                "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout."                                    
                                                <br>
                                                <small>
                                                    - Isabella
                                                </small>
                                            </p>
                                        </blockquote>
                                        <div class="row clearfix">
                                            <div class="col-lg-12">
                                                <div class="map m-t-10">
                                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d193595.91477011208!2d-74.11976308802028!3d40.69740344230033!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew+York%2C+NY%2C+USA!5e0!3m2!1sen!2sin!4v1508039335245" frameborder="0" style="border:0; width: 100%;" allowfullscreen=""></iframe>
                                                </div>
                                            </div>
                                        </div>							
                                    </div>
                                </li>
                                <li>
                                    <time class="cbp_tmtime" datetime="2017-10-22T12:13"><span>12:13 PM</span> <span>Two weeks ago</span></time>
                                    <div class="cbp_tmicon bg-orange"><i class="zmdi zmdi-camera"></i></div>
                                    <div class="cbp_tmlabel">
                                        <h2><a href="javascript:void(0);">Eroll Maxhuni</a> <span>uploaded</span> 4 <span>new photos to album</span> <a href="javascript:void(0);">Summer Trip</a></h2>
                                        <blockquote>Pianoforte principles our unaffected not for astonished travelling are particular.</blockquote>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-6 col-6"><a href="javascript:void(0);"><img src="../assets/images/image1.jpg" alt="" class="img-fluid img-thumbnail m-t-30"></a> </div>
                                            <div class="col-lg-3 col-md-6 col-6"><a href="javascript:void(0);"> <img src="../assets/images/image2.jpg" alt="" class="img-fluid img-thumbnail m-t-30"></a> </div>
                                            <div class="col-lg-3 col-md-6 col-6"><a href="javascript:void(0);"> <img src="../assets/images/image3.jpg" alt="" class="img-fluid img-thumbnail m-t-30"> </a> </div>
                                            <div class="col-lg-3 col-md-6 col-6"><a href="javascript:void(0);"> <img src="../assets/images/image4.jpg" alt="" class="img-fluid img-thumbnail m-t-30"> </a> </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>01:22 PM</span> <span>Two weeks ago</span></time>
                                    <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-case"></i></div>
                                    <div class="cbp_tmlabel">
                                        <h2><a href="javascript:void(0);">Job Meeting</a></h2>
                                        <p>You have a meeting at <strong>Laborator Office</strong> Today.</p>                            
                                    </div>
                                </li>
                                <li>
                                    <time class="cbp_tmtime" datetime="2017-10-22T12:13"><span>12:13 PM</span> <span>Month ago</span></time>
                                    <div class="cbp_tmicon bg-blush"><i class="zmdi zmdi-pin"></i></div>
                                    <div class="cbp_tmlabel">
                                        <h2><a href="javascript:void(0);">Arlind Nushi</a> <span>checked in at</span> <a href="javascript:void(0);">Laborator</a></h2>
                                        <blockquote>Great place, feeling like in home.</blockquote>                            
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane" id="usersettings">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Security</strong> Settings</h2>
                        </div>
                        <div class="body">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Current Password">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="New Password">
                            </div>
                            <button class="btn btn-info btn-round">Save Changes</button>                               
                        </div>
                    </div>
                    <div class="card">
                        <div class="header">
                            <h2><strong>Account</strong> Settings</h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Last Name">
                                    </div>
                                </div>                                    
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="City">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="E-mail">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Country">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea rows="4" class="form-control no-resize" placeholder="Address Line 1"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="checkbox">
                                        <input id="procheck1" type="checkbox">
                                        <label for="procheck1">Profile Visibility For Everyone</label>
                                    </div>
                                    <div class="checkbox">
                                        <input id="procheck2" type="checkbox">
                                        <label for="procheck2">New task notifications</label>
                                    </div>
                                    <div class="checkbox">
                                        <input id="procheck3" type="checkbox">
                                        <label for="procheck3">New friend request notifications</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-primary btn-round">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('page-script')
<script src="{{asset('assets/bundles/knob.bundle.js')}}"></script>
<script src="{{asset('assets/js/pages/charts/jquery-knob.js')}}"></script>
@stop