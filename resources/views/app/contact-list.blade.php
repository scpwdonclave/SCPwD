@extends('layout.master')
@section('title', 'Contact')
@section('parentPageTitle', 'App')
@section('content')
<div class="container-fluid contact">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card action_bar bg-dark">
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-lg-1 col-md-2 col-2">
                            <div class="checkbox inlineblock delete_all">
                                <input id="deleteall" type="checkbox">
                                <label for="deleteall">
                                    All
                                </label>
                            </div>                                
                        </div>
                        <div class="col-lg-5 col-md-5 col-7">
                            <div class="input-group search">
                                <input type="text" class="form-control" placeholder="Search...">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-5 col-3 text-right">
                            <div class="btn-group hidden-sm-down" role="group">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-neutral dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="zmdi zmdi-label"></i>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right pullDown">
                                        <li>
                                            <a href="javascript:void(0);">Family</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">Work</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">Google</a>
                                        </li>
                                        <li role="separator" class="divider"></li>
                                        <li>
                                            <a href="javascript:void(0);">Create a Label</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <button type="button" class="btn btn-neutral hidden-sm-down">
                                <i class="zmdi zmdi-plus-circle"></i>
                            </button>
                            <button type="button" class="btn btn-neutral hidden-sm-down">
                                <i class="zmdi zmdi-archive"></i>
                            </button>
                            <button type="button" class="btn btn-neutral">
                                <i class="zmdi zmdi-delete"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>           
    </div>
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-hover m-b-0 c_list">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>                                    
                                    <th>Phone</th>                                    
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <input id="delete_2" type="checkbox">
                                            <label for="delete_2">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="../assets/images/xs/avatar1.jpg" class="rounded-circle avatar" alt="">
                                        <p class="c_name">John Smith <span class="badge badge-default m-l-10 hidden-sm-down">Family</span></p>
                                    </td>
                                    <td>
                                        <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>264-625-2583</span>
                                    </td>                                   
                                    <td>
                                        <address><i class="zmdi zmdi-pin"></i>123 6th St. Melbourne, FL 32904</address>
                                    </td>
                                    <td>
                                        <button class="btn btn-icon btn-neutral btn-icon-mini"><i class="zmdi zmdi-edit"></i></button>
                                        <button class="btn btn-icon btn-neutral btn-icon-mini"><i class="zmdi zmdi-delete"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <input id="delete_3" type="checkbox">
                                            <label for="delete_3">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="../assets/images/xs/avatar3.jpg" class="rounded-circle avatar" alt="">
                                        <p class="c_name">Hossein Shams <span class="badge badge-info m-l-10 hidden-sm-down">Google</span></p>
                                    </td>
                                    <td>
                                        <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>264-625-5689</span>
                                    </td>                                    
                                    <td>
                                        <address><i class="zmdi zmdi-pin"></i>44 Shirley Ave. West Chicago, IL 60185</address>
                                    </td>
                                    <td>
                                        <button class="btn btn-icon btn-neutral btn-icon-mini"><i class="zmdi zmdi-edit"></i></button>
                                        <button class="btn btn-icon btn-neutral btn-icon-mini"><i class="zmdi zmdi-delete"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <input id="delete_4" type="checkbox">
                                            <label for="delete_4">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="../assets/images/xs/avatar4.jpg" class="rounded-circle avatar" alt="">
                                        <p class="c_name">Maryam Amiri</p>
                                    </td>
                                    <td>
                                        <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>264-625-9513</span>
                                    </td>
                                    <td>
                                        <address><i class="zmdi zmdi-pin"></i>123 6th St. Melbourne, FL 32904</address>
                                    </td>
                                    <td>
                                        <button class="btn btn-icon btn-neutral btn-icon-mini"><i class="zmdi zmdi-edit"></i></button>
                                        <button class="btn btn-icon btn-neutral btn-icon-mini"><i class="zmdi zmdi-delete"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <input id="delete_5" type="checkbox">
                                            <label for="delete_5">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="../assets/images/xs/avatar6.jpg" class="rounded-circle avatar" alt="">
                                        <p class="c_name">Tim Hank<span class="badge badge-default m-l-10 hidden-sm-down">Family</span></p>
                                    </td>
                                    <td>
                                        <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>264-625-1212</span>
                                    </td>
                                    <td>
                                        <address><i class="zmdi zmdi-pin"></i>70 Bowman St. South Windsor, CT 06074</address>
                                    </td>
                                    <td>
                                        <button class="btn btn-icon btn-neutral btn-icon-mini"><i class="zmdi zmdi-edit"></i></button>
                                        <button class="btn btn-icon btn-neutral btn-icon-mini"><i class="zmdi zmdi-delete"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <input id="delete_6" type="checkbox">
                                            <label for="delete_6">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="../assets/images/xs/avatar7.jpg" class="rounded-circle avatar" alt="">
                                        <p class="c_name">Fidel Tonn<span class="badge badge-default m-l-10 hidden-sm-down">Family</span></p>
                                    </td>
                                    <td>
                                        <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>264-625-2323</span>
                                    </td>
                                    <td>
                                        <address><i class="zmdi zmdi-pin"></i>514 S. Magnolia St. Orlando, FL 32806</address>
                                    </td>
                                    <td>
                                        <button class="btn btn-icon btn-neutral btn-icon-mini"><i class="zmdi zmdi-edit"></i></button>
                                        <button class="btn btn-icon btn-neutral btn-icon-mini"><i class="zmdi zmdi-delete"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <input id="delete_7" type="checkbox">
                                            <label for="delete_7">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="../assets/images/xs/avatar8.jpg" class="rounded-circle avatar" alt="">
                                        <p class="c_name">Gary Camara<span class="badge badge-success m-l-10 hidden-sm-down">Work</span></p>
                                    </td>
                                    <td>
                                        <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>264-625-1005</span>
                                    </td>
                                    <td>
                                        <address><i class="zmdi zmdi-pin"></i>44 Shirley Ave. West Chicago, IL 60185</address>
                                    </td>
                                    <td>
                                        <button class="btn btn-icon btn-neutral btn-icon-mini"><i class="zmdi zmdi-edit"></i></button>
                                        <button class="btn btn-icon btn-neutral btn-icon-mini"><i class="zmdi zmdi-delete"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <input id="delete_8" type="checkbox">
                                            <label for="delete_8">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="../assets/images/xs/avatar9.jpg" class="rounded-circle avatar" alt="">
                                        <p class="c_name">Frank Camly</p>
                                    </td>
                                    <td>
                                        <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>264-625-9999</span>
                                    </td>
                                    <td>
                                        <address><i class="zmdi zmdi-pin"></i>123 6th St. Melbourne, FL 32904</address>
                                    </td>
                                    <td>
                                        <button class="btn btn-icon btn-neutral btn-icon-mini"><i class="zmdi zmdi-edit"></i></button>
                                        <button class="btn btn-icon btn-neutral btn-icon-mini"><i class="zmdi zmdi-delete"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <input id="delete_9" type="checkbox">
                                            <label for="delete_9">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="../assets/images/xs/avatar10.jpg" class="rounded-circle avatar" alt="">
                                        <p class="c_name">Tim Hank<span class="badge badge-default m-l-10 hidden-sm-down">Family</span></p>
                                    </td>
                                    <td>
                                        <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>264-625-1212</span>
                                    </td>
                                    <td>
                                        <address><i class="zmdi zmdi-pin"></i>70 Bowman St. South Windsor, CT 06074</address>
                                    </td>
                                    <td>
                                        <button class="btn btn-icon btn-neutral btn-icon-mini"><i class="zmdi zmdi-edit"></i></button>
                                        <button class="btn btn-icon btn-neutral btn-icon-mini"><i class="zmdi zmdi-delete"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="body">                            
                    <ul class="pagination pagination-primary m-b-0">
                        <li class="page-item"><a class="page-link" href="javascript:void(0);"><i class="zmdi zmdi-arrow-left"></i></a></li>
                        <li class="page-item active"><a class="page-link" href="javascript:void(0);">1</a></li>
                        <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
                        <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                        <li class="page-item"><a class="page-link" href="javascript:void(0);">4</a></li>
                        <li class="page-item"><a class="page-link" href="javascript:void(0);"><i class="zmdi zmdi-arrow-right"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@stop