@extends('layout.master')
@section('title', 'Payment Order')
@section('parentPageTitle', 'My Pay Order')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">

@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header d-flex justify-content-between">
                        <h2><strong>My</strong> Payment Order</h2>
                       
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                        <tr>
                                        <th>Sl. No.</th>
                                        <th>Payment Order ID</th>
                                        <th>My Ref No</th>
                                        <th>Payment Order Date</th>
                                        <th>Verification Date</th>
                                        <th>Payment Date</th>
                                        <th>Status</th>
                                        <th>View</th>
                                       
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pay_order as $key=>$item)
                                        
                                    <tr>
                                    <td>{{$key+1}}</td>
                                    @if ($item->payment_order_id != null)
                                    <td>{{$item->payment_order_id}}</td>
                                        
                                    @else
                                    <td  class="text-muted">Not Verified</td>
                                        
                                    @endif
                                    <td>{{$item->ref_no}}</td>
                                    <td>{{\Carbon\Carbon::parse($item->po_date)->format('d-m-Y')}}</td>
                                    @if ($item->verification_date !=null )
                                    <td>{{\Carbon\Carbon::parse($item->verification_date)->format('d-m-Y')}}</td>
                                    @else
                                      <td class="text-muted">N/A</td>  
                                    @endif
                                    @if ( $item->payment_date !=null)
                                   
                                    <td>{{\Carbon\Carbon::parse($item->payment_date)->format('d-m-Y')}}</td>
                                    @else
                                      <td class="text-muted">N/A</td>  
                                    @endif
                                    @if ($item->verified ===0 && $item->payment_done===0)
                                     <td style="color:blue">Processing</td>   
                                    @elseif ($item->verified ===1 && $item->payment_done===0)
                                     <td style="color:blue">Verified</td>   
                                    @elseif($item->verified ===1 && $item->payment_done===1)
                                     <td style="color:green">Payment Done</td>   
                                        
                                    @endif
                                    <td><a class="badge bg-green margin-0" href="{{route('agency.payorder.mypayorder',['id'=>Crypt::encrypt($item->id)])}}" >View Pay Order</a></td>
                                    </tr>
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
<script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
@stop