@extends('layout.master')
@section('title', 'Editable')
@section('parentPageTitle', 'Table')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Editable</strong> Tables<small>You can edit any columns except header/footer</small> </h2>
                    <ul class="header-dropdown">
                        <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="javascript:void(0);">Action</a></li>
                                <li><a href="javascript:void(0);">Another action</a></li>
                                <li><a href="javascript:void(0);">Something else</a></li>
                            </ul>
                        </li>
                        <li class="remove">
                            <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <table id="mainTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Cost</th>
                                <th>Profit</th>
                                <th>Fun</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Car</td>
                                <td>100</td>
                                <td>200</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>Bike</td>
                                <td>330</td>
                                <td>240</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>Plane</td>
                                <td>430</td>
                                <td>540</td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>Yacht</td>
                                <td>100</td>
                                <td>200</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>Segway</td>
                                <td>330</td>
                                <td>240</td>
                                <td>1</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th><strong>TOTAL</strong></th>
                                <th>1290</th>
                                <th>1420</th>
                                <th>5</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/editable-table/mindmup-editabletable.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/editable-table.js')}}"></script>
@stop