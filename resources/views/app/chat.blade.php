@extends('layout.master')
@section('title', 'Chat')
@section('parentPageTitle', 'App')
@section('content')
<div class="container-fluid">
    <div class="row clearfix">           
        <div class="col-lg-12 col-xl-12">
            <div class="card chat-app">
                <div id="plist" class="people-list">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-addon">
                            <i class="zmdi zmdi-search"></i>
                        </span>
                    </div>
                    <ul class="nav nav-tabs p-l-0 p-r-0" role="tablist">
                        <li class="nav-item inlineblock"><a class="nav-link active" data-toggle="tab" href="#people">People</a></li>
                        <li class="nav-item inlineblock"><a class="nav-link" data-toggle="tab" href="#groups">Groups</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane stretchRight active" id="people">
                            <ul class="chat-list list-unstyled m-b-0">
                                <li class="clearfix">
                                    <img src="../assets/images/xs/avatar1.jpg" alt="avatar" />
                                    <div class="about">
                                        <div class="name">Vincent Porter</div>
                                        <div class="status"> <i class="zmdi zmdi-circle offline"></i> left 7 mins ago </div>                                            
                                    </div>
                                </li>
                                <li class="clearfix active">
                                    <img src="../assets/images/xs/avatar2.jpg" alt="avatar" />
                                    <div class="about">
                                        <div class="name">Aiden Chavez</div>
                                        <div class="status"> <i class="zmdi zmdi-circle online"></i> online </div>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <img src="../assets/images/xs/avatar3.jpg" alt="avatar" />
                                    <div class="about">
                                        <div class="name">Mike Thomas</div>
                                        <div class="status"> <i class="zmdi zmdi-circle online"></i> online </div>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <img src="../assets/images/xs/avatar4.jpg" alt="avatar" />
                                    <div class="about">
                                        <div class="name">Erica Hughes</div>
                                        <div class="status"> <i class="zmdi zmdi-circle online"></i> online </div>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <img src="../assets/images/xs/avatar5.jpg" alt="avatar" />
                                    <div class="about">
                                        <div class="name">Ginger Johnston</div>
                                        <div class="status"> <i class="zmdi zmdi-circle online"></i> online </div>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <img src="../assets/images/xs/avatar6.jpg" alt="avatar" />
                                    <div class="about">
                                        <div class="name">Tracy Carpenter</div>
                                        <div class="status"> <i class="zmdi zmdi-circle offline"></i> left 30 mins ago </div>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <img src="../assets/images/xs/avatar7.jpg" alt="avatar" />
                                    <div class="about">
                                        <div class="name">Christian Kelly</div>
                                        <div class="status"> <i class="zmdi zmdi-circle offline"></i> left 10 hours ago </div>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <img src="../assets/images/xs/avatar8.jpg" alt="avatar" />
                                    <div class="about">
                                        <div class="name">Monica Ward</div>
                                        <div class="status"> <i class="zmdi zmdi-circle online"></i> online </div>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <img src="../assets/images/xs/avatar9.jpg" alt="avatar" />
                                    <div class="about">
                                        <div class="name">Dean Henry</div>
                                        <div class="status"> <i class="zmdi zmdi-circle offline"></i> offline since Oct 28 </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div role="tabpanel" class="tab-pane stretchRight" id="groups">
                            <ul class="chat-list list-unstyled">
                                <li class="clearfix">
                                    <img src="../assets/images/xs/avatar6.jpg" alt="avatar"/>
                                    <div class="about">
                                        <div class="name">PHP Lead</div>
                                        <div class="status">6 People </div>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <img src="../assets/images/xs/avatar7.jpg" alt="avatar"/>
                                    <div class="about">
                                        <div class="name">UI UX Designer</div>
                                        <div class="status">10 People </div>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <img src="../assets/images/xs/avatar8.jpg" alt="avatar"/>
                                    <div class="about">
                                        <div class="name">TL Groups</div>
                                        <div class="status">2 People </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="chat">
                    <div class="chat-header clearfix">
                        <img src="../assets/images/xs/avatar2.jpg" alt="avatar" />
                        <div class="chat-about">
                            <div class="chat-with">Aiden Chavez</div>
                            <div class="chat-num-messages">already 8 messages</div>
                        </div>
                        <a href="javascript:void(0);" class="list_btn btn btn-primary btn-round float-md-right"><i class="zmdi zmdi-comments"></i></a>
                    </div>
                    <div class="chat-history">
                        <ul>
                            <li class="clearfix">
                                <div class="message-data text-right"> <span class="message-data-time" >10:10 AM, Today</span> &nbsp; &nbsp; <span class="message-data-name" >Michael</span> <i class="zmdi zmdi-circle me"></i> </div>
                                <div class="message other-message float-right"> Hi Aiden, how are you? How is the project coming along? </div>
                            </li>
                            <li>
                                <div class="message-data">
                                    <span class="message-data-name"><i class="zmdi zmdi-circle online"></i> Aiden</span> <span class="message-data-time">10:12 AM, Today</span>
                                </div>
                                <div class="message my-message">
                                    <p>Are we meeting today? Project has been already finished and I have results to show you.</p>
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-4 m-t-10"><a href="javascript:void(0);"><img src="../assets/images/image2.jpg" alt="" class="img-fluid img-thumbnail"></a> </div>
                                        <div class="col-sm-6 col-lg-4 m-t-10"><a href="javascript:void(0);"> <img src="../assets/images/image3.jpg" alt="" class="img-fluid img-thumbnail"></a> </div>
                                        <div class="col-sm-6 col-lg-4 m-t-10"><a href="javascript:void(0);"> <img src="../assets/images/image4.jpg" alt="" class="img-fluid img-thumbnail"> </a> </div>
                                    </div>
                                </div>
                            </li>                        
                            <li>
                                <div class="message-data"> <span class="message-data-name"><i class="zmdi zmdi-circle online"></i> Aiden</span> <span class="message-data-time">10:31 AM, Today</span> </div>
                                <i class="zmdi zmdi-circle online"></i> <i class="zmdi zmdi-circle online" style="color: #AED2A6"></i> <i class="zmdi zmdi-circle online" style="color:#DAE9DA"></i> </li>
                        </ul>
                    </div>
                    <div class="chat-message clearfix">
                        <div class="input-group p-t-15">
                            <input type="text" class="form-control" placeholder="Enter text here...">
                            <span class="input-group-addon">
                                <i class="zmdi zmdi-mail-send"></i>
                            </span>
                        </div>
                        <a href="javascript:void(0);" class="btn btn-raised btn-warning btn-round"><i class="zmdi zmdi-camera"></i></a>
                        <a href="javascript:void(0);" class="btn btn-raised btn-info btn-round"><i class="zmdi zmdi-file-text"></i></a>                            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('page-script')
<script>
    $(".list_btn").on('click',function(){
        $("#plist").toggleClass("open");
    });
</script>
@stop