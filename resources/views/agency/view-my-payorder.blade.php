@extends('layout.master')
@section('title', 'Payment Order')
{{-- @section('parentPageTitle', 'Partners-verify') --}}
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/timeline.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">





@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                    @if (!is_null($pay_order->payment_order_id))
                        <div class="text-center">
                            <h6>
                                PAYMENT ORDER: <span style='color:blue'>{{$pay_order->payment_order_id}}</span> <br> <br>
                                REFERENCE NO: <span style='color:blue'>{{$pay_order->ref_no}}</span> <br> <br>
                                
                            </h6>
                        </div>
                        <br>
                    @endif
                   
                    <ul class="cbp_tmtimeline">
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Payment Order Details</span></time>
                            <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-account"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Payment Order Date</small>
                                        
                                        <p>{{\Carbon\Carbon::parse($pay_order->po_date)->format('d-m-Y')}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">Verification Date</small>
                                        @if ($pay_order->verification_date !=null )
                                        <p>{{\Carbon\Carbon::parse($pay_order->verification_date)->format('d-m-Y')}}</p>
                                        @else
                                        <p>N/A</p>
                                        @endif
                                      <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Payment Date</small>
                                        @if ($pay_order->payment_date !=null )
                                        <p>{{\Carbon\Carbon::parse($pay_order->payment_date)->format('d-m-Y')}}</p>
                                        @else
                                        <p>N/A</p>
                                        @endif
                                        <hr>
                                    </div>
                                  
                                </div>
                            </div>
                        </li>
                        </ul>
                   
                      <br><br> 
                     
                   
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header d-flex justify-content-between">
                        <h2><strong>All</strong> Batch of this Order</h2>
                       
                    </div>
                    <div class="body">
                       
                        <div class="table-responsive">
                            <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                        <tr>
                                        <th>Sl. No.</th>
                                        <th>Batch ID</th>
                                        <th>Job Role</th>
                                        <th>Assessment status</th>
                                        <th>Assessment Date</th>
                                        <th>Total Candidate</th>
                                        <th>Amount</th>
                                        <th>Order On</th>
                                        <th>View Candidate</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pay_order->paymentorder as $payorder)
                                        
                                    <tr>
                                        <td>Sl. No.</td>
                                        @if ($payorder->agencyBatch->reass_id===null)
                                            
                                        <td>{{$payorder->agencyBatch->batch->batch_id}}</td>
                                        <td>{{$payorder->agencyBatch->batch->jobrole->job_role}}</td>
                                        <td>Assessment</td>
                                        <td>{{\Carbon\Carbon::parse($payorder->agencyBatch->batch->assessment)->format('d-m-Y')}}</td>
                                        <td>{{$payorder->total_candidate}}</td>
                                        <td>{{$payorder->amount}}</td>
                                        @if ($payorder->po_on===1)
                                        <td style="color:blue">Count Made on Assigned</td>
                                            
                                        @else
                                        <td style="color:blue">Count Made on Appeared</td>
                                            
                                        @endif
                                        
                                        <td><a class="badge bg-green margin-0" href="{{route('agency.batch.bt-candidate',['id'=>Crypt::encrypt($payorder->agencyBatch->bt_id)])}}" >View Candidate</a></td>


                                        @else
                                        <td>{{$payorder->agencyBatch->reassessment->batch->batch_id}}</td>
                                        <td>{{$payorder->agencyBatch->reassessment->batch->jobrole->job_role}}</td>
                                        <td>Re-Assessment</td>
                                        <td>{{\Carbon\Carbon::parse($payorder->agencyBatch->reassessment->assessment)->format('d-m-Y')}}</td>   
                                        <td>{{$payorder->total_candidate}}</td>
                                        <td>{{$payorder->amount}}</td>
                                        @if ($payorder->po_on===1)
                                        <td style="color:blue">Count Made on Assigned</td>
                                            
                                        @else
                                        <td style="color:blue">Count Made on Appeared</td>
                                            
                                        @endif
                                        <td><a class="badge bg-green margin-0" href="{{route('agency.batch.reass-bt-candidate',['id'=>Crypt::encrypt($payorder->agencyBatch->reass_id)])}}" >View Candidate</a></td>
                                        @endif
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
{{-- <script>

    function popupReject(id) {

        var confirmatonText = document.createElement("div");
        var _token=$('[name=_token]').val();
        color = 'red'; text = 'Rejection'; 
        displayText='Provide Payment Order Rejection Reason ';
        confirmatonText="input"
        
        swal({
            text: displayText,
            content: confirmatonText,
            icon: "info",
            buttons: true,
            buttons: {
                    cancel: "No, Cancel",
                    confirm: {
                        text: "Confirm Reject",
                        closeModal: false
                    }
                },
            closeModal: false,
            closeOnEsc: false,
        }).then(function(val){
            if (val != null) {
                if (val === '') {
                    swal('Attention', 'Please Describe the Reason of Rejection Payment Order', 'info');
                } else {
                    let url = "{{route('admin.paymentorder.reject',[':id',':reason'])}}";
                    url = url.replace(':id', id); 
                    location.href = url.replace(':reason', val);
                }
            }
        });
    }
</script> --}}

{{-- <script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script> --}}
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.js')}}"></script>



<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{asset('assets/js/scpwd-common.js')}}"></script>

@stop