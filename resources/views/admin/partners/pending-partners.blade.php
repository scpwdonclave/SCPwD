@extends('layout.master')
@section('title', 'Pending Partners')
@section('parentPageTitle', 'Partners')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
@stop
@section('content')

<div class="container-fluid">
        <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Pending</strong> Partners </h2>
                           
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                            <tr>
                                            <th>#</th>
                                            <th>Spoc Name</th>
                                            <th>Spoc Email</th>
                                            <th>Spoc Mobile</th>
                                            <th style="width:20px;">Incorp. Document</th>
                                            <th>Status</th>
                                            <th>View</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key=>$item)
                                                
                                            <tr>
                                                <td class="text-center">{{$key+1}}</td>
                                                <td class="text-center">{{$item->spoc_name}}</td>
                                                <td class="text-center">{{$item->email}}</td>
                                                <td class="text-center">{{$item->spoc_mobile}}</td>
                                                <td class="text-center">
                                                    <a class="" href="#largeModal{{$item->id}}" data-toggle="modal" data-target="#largeModal{{$item->id}}"><i class="zmdi zmdi-eye"></i></a>
                                                </td>
                                                @if($item->status==1 && $item->complete_profile==1 && $item->pending_verify==1)
                                                    <td class="text-center"><span class="badge badge-info">Pending</span></td>
                                                    <td class="text-center" ><a class="badge bg-green margin-0" href="{{route('admin.training_partner.partner.verify',['id'=>$item->id])}}" >View</a></td>                                    
                                                @elseif($item->status==1 && $item->complete_profile==0 && $item->pending_verify==null)
                                                    <td class="text-center"><span class="badge badge-warning">First Instance</span></td>
                                                    <td class="text-center"><a class="badge bg-grey margin-0" href="javascript:void(0);" disabled>View</a></td>
                                                @endif
                                            </tr>
                                            
                                            <div class="modal fade" id="largeModal{{$item->id}}" tabindex="-1" role="dialog">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-body embed-responsive embed-responsive-16by9">
                                                                <iframe class="embed-responsive-item" src="{{route('partner.files.partner-file',['action'=>'view','filename'=>basename($item->incorp_doc)])}}" allowfullscreen runat="server">
                                                            </iframe>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="{{route('partner.files.partner-file',['action'=>'download','filename'=>basename($item->incorp_doc)])}}" download="{{substr($item->incorp_doc,8)}}" class="btn btn-default btn-round waves-effect">Download</a>
                                                            <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                           
                                        </tbody>
                                   
                                </table>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
</div>
@stop
@section('page-script')
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop