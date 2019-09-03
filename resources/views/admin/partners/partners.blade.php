@extends('layout.master')
@section('title', 'Partners')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
@stop
@section('content')
{{-- DATA Tables --}}

<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>Training Partners</strong> Record </h2>
            </div>
            <div class="body">
                <button type="button" class="btn  btn-simple btn-sm btn-default btn-filter" data-target="all">All</button>
                <button type="button" class="btn  btn-simple btn-sm btn-success btn-filter" data-target="approved">Active</button>
                <button type="button" class="btn  btn-simple btn-sm btn-warning btn-filter" data-target="suspended">Suspended</button>
                <button type="button" class="btn  btn-simple btn-sm btn-info btn-filter" data-target="pending">Pending</button>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Spoc Name</th>
                                <th>Spoc Email</th>
                                <th>Spoc Mobile</th>
                                <th style="width:20px;">Incorp. Document</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key=>$item)
                                
                            <tr data-status="approved">
                            <td>{{$key+1}}</td>
                            <td>{{$item->spoc_name}}</td>
                                <td>{{$item->spoc_email}}</td>
                                <td>{{$item->spoc_mobile}}</td>
                                <td class="text-center">
                                        <a class="btn-icon-mini" href="#largeModal{{$item->id}}" data-toggle="modal" data-target="#largeModal{{$item->id}}"><i class="zmdi zmdi-eye"></i></a>
                                </td>
                                <td><span class="badge badge-success">Approved</span></td>
                            </tr>
                            <div class="modal fade" id="largeModal{{$item->id}}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            {{-- <div class="modal-header">
                                                <h4 class="title" id="largeModalLabel">Modal title</h4>
                                            </div> --}}
                                            <div class="modal-body embed-responsive embed-responsive-16by9">
                                                    <iframe class="embed-responsive-item" src="{{route('files.partner-file',['action'=>'view','filename'=>basename($item->incorp_doc)])}}" allowfullscreen>
                                                </iframe>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="{{route('files.partner-file',['action'=>'download','filename'=>basename($item->incorp_doc)])}}" download="{{substr($item->incorp_doc,8)}}" class="btn btn-default btn-round waves-effect">Download</a>
                                                <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                           
                        </tbody>
                        {{-- <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Age</th>
                                <th>Start date</th>
                                <th>Salary</th>
                            </tr>
                        </tfoot> --}}
                    </table>
                    </div>
            </div>
        </div>
    </div>
</div>

{{-- End DATA Tables --}}


@stop
@section('page-script')
<script>
    $(document).ready(function () {
        $('.star').on('click', function () {
            $(this).toggleClass('star-checked');
        });

        $('.ckbox label').on('click', function () {
            $(this).parents('tr').toggleClass('selected');
        });

        $('.btn-filter').on('click', function () {
            var $target = $(this).data('target');
            if ($target != 'all') {
                $('.table tr').css('display', 'none');
                $('.table tr[data-status="' + $target + '"]').fadeIn('slow');
            } else {
                $('.table tr').css('display', 'none').fadeIn('slow');
            }
        });
    });
</script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop