@extends('layout.master')
@section('title', 'Payment Order')
{{-- @section('parentPageTitle', 'Partners-verify') --}}
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/timeline.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}">
<style>
    .datepicker-inline {
        width: 100%;
    }
    .datepicker table {
        width: 100%;
    }
    </style>
@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                    @if (!is_null($pay_order->agency->aa_id))
                        <div class="text-center">
                            <h6>
                                AA ID: <span style='color:blue'>{{$pay_order->agency->aa_id}}</span> <br> <br>
                                <span style='color:{{($pay_order->agency->status)?"green":"red"}}'>{{($pay_order->agency->status)?"Active":"Inactive"}}</span>
                            </h6>
                        </div>
                        <br>
                    @endif
                   
                    <ul class="cbp_tmtimeline">
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>SPOC Details</span></time>
                            <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-account"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">SPOC Name</small>
                                        <p>{{$pay_order->agency->name}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">SPOC Aadhaar No</small>
                                        <p>{{$pay_order->agency->aadhaar}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted"> SPOC Email</small>
                                        <p>{{$pay_order->agency->email}}</p>
                                        <hr>
                                    </div>
                                  
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">SPOC Mobile</small>
                                        <p>{{$pay_order->agency->mobile}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">SPOC Gender</small>
                                        <p>{{$pay_order->agency->gender}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">SPOC Designation</small>
                                        <p>{{$pay_order->agency->designation}}</p>
                                        <hr>
                                    </div>
                
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">SPOC Landline</small>
                                        <p>{{$pay_order->agency->landline}}</p>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </li>
                        
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>General Information</span></time>
                            <div class="cbp_tmicon bg-blue"> <i class="zmdi zmdi-local-store"></i></div>
                            <div class="cbp_tmlabel">
                                
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Agency name</small>
                                        <p>{{$pay_order->agency->agency_name}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                            <small class="text-muted">Organization Type</small>
                                            <p>{{$pay_order->agency->org_type}}</p>
                                            <hr>
                                    </div>
                                    <div class="col-sm-4">
                                            <small class="text-muted">Organization ID/Registration No.</small>
                                            <p>{{$pay_order->agency->org_id}}</p>
                                            <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">SLA Start Date</small>
                                        <p>{{$pay_order->agency->sla_date}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                            <small class="text-muted">SLA End date</small>
                                            <p>{{$pay_order->agency->sla_end_date}}</p>
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
                        <h2><strong>All</strong> Assessed Batch</h2>
                    </div>
                    <div class="body">
                        <form id="form_payorder" action="{{route('admin.paymentorder.accept')}}" method="post" >

                        @if (!is_null($pay_order->payment_order_id))
                        <div class="text-center">
                            <h6>
                                PAYMENT ORDER: <span style='color:blue'>{{$pay_order->payment_order_id}}</span> <br> <br>
                                Ref No: <span style='color:blue'>{{$pay_order->ref_no}}</span> <br> <br>
                            </h6>
                        </div>
                        <br>
                    @endif
                        <div class="table-responsive">
                            <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        @if (!$pay_order->verified)
                                            <th><input type="checkbox" class="checks" onchange="checkAll(this)" /></th>
                                        @else
                                            <th>Sl. No.</th>
                                        @endif
                                        <th>Batch ID</th>
                                        <th>Job Role</th>
                                        <th>Assessment status</th>
                                        <th>Assessment Date</th>
                                        <th>Total candidate</th>
                                        <th>Amount</th>
                                        <th>Order On</th>
                                        <th>View Candidate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pay_order->paymentorder as $payorder)
                                        
                                    <tr>
                                        @if (!$pay_order->verified)
                                            <td><input type="checkbox" class="checks" name="chkbox[]" value="{{$payorder->agencyBatch->id}}"></td>
                                        @else
                                            <td>Sl. No.</td>   
                                        @endif
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
                                            <td><a class="badge bg-green margin-0" href="{{route('admin.batch.bt-candidate',['id'=>Crypt::encrypt($payorder->agencyBatch->bt_id)])}}" >View Candidate</a></td>
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
                                        <td><a class="badge bg-green margin-0" href="{{route('admin.batch.reass-bt-candidate',['id'=>Crypt::encrypt($payorder->agencyBatch->reass_id)])}}" >View Candidate</a></td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                            <br><br>
                            @csrf
                            <input type="hidden" name="po_id" value="{{$pay_order->id}}">
                            <div class="row d-flex justify-content-around">
                                @if (!$pay_order->verified)
                                <input type="hidden" name="verify" value="verify">
                                   <div class="col-sm-4">
                                        <label for="verification_date">Verification Date <span style="color:red"> <strong>*</strong></span></label>
                                        <div class="form-group form-float date_picker">
                                            <input type="text" class="form-control date_datepicker" placeholder="Verification Date" id="verification_date" name="verification_date"  required>
                                        </div>
                                    </div>
                                @endif
                                @if ($pay_order->verified===1 && $pay_order->payment_done === 0)
                                <input type="hidden" name="paymentMade" value="paymentMade">
                                    <div class="col-sm-4">
                                        <label for="payment_date">Payment Date <span style="color:red"> <strong>*</strong></span></label>
                                        <div class="form-group form-float date_picker ">
                                            <input type="text" class="form-control" placeholder="Payment Date"  id="payment_date" name="payment_date"  required>
                                        </div>
                                    </div>
                                @endif
                                </div>
                                <br>
                            
                            {{-- @auth('admin') --}}
                            <div class="text-center" >
                                @if (!auth()->guard('admin')->user()->ministry)
                                    @if ($pay_order->verified===0 )
                                        <button class="btn btn-success" type="submit" id="save-btn" >Mark as Verified</button>
                                        <button class="btn btn-danger" type="button" onclick="popupReject('{{Crypt::encrypt($pay_order->id)}}');">Reject</button>
                                    @elseif($pay_order->verified===1 && $pay_order->payment_done === 0)
                                        <button class="btn btn-success" type="submit" >Payment Done</button>
                                    @endif
                                @endif
                            </div>
                        {{-- @endauth  --}}
                        
                    </form>
                    </div>
                </div>
            </div>
        </div>
</div>
@stop
@section('page-script')
<script>
    function checkAll(ele) {
    var checkboxes = document.getElementsByTagName('input');
    if (ele.checked) {
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].type == 'checkbox') {
                checkboxes[i].checked = true;
            }
        }
    } else {
        for (var i = 0; i < checkboxes.length; i++) {
            //console.log(i)
            if (checkboxes[i].type == 'checkbox') {
                checkboxes[i].checked = false;
            }
        }
    }
}


</script>
<script>
    $('#save-btn').attr("disabled",true);
    $('.checks').click(function(){
    $('#save-btn').attr("disabled",!$(this).is(":checked"));   
})
</script>
<script>

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
</script>

{{-- <script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script> --}}
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.js')}}"></script>

<script src="{{asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>

<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{asset('assets/js/scpwd-common.js')}}"></script>

<script>
      $(function () {
    
    /* Intializing Bootstrap DatePicker */
    $('.date_picker .form-control').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
    
    /* End Bootstrap DatePicker */
    
});
</script>
@stop