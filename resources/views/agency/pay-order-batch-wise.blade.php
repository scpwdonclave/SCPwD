@extends('layout.master')
@section('title', 'Pay Order')
@section('parentPageTitle', 'Batch Wise')
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
                        <h2><strong>All</strong> Assessment</h2>
                       
                    </div>
                    <div class="body">
                        <form id="form_payorder" action="{{route('agency.payorder.batch-wise')}}" method="post" >
                            @csrf
                        <div class="table-responsive">
                            <table id="example" class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="checks" onchange="checkAll(this)" /></th>
                                        <th>Batch ID</th>
                                        <th>Job Role</th>
                                        <th>Assessment status</th>
                                        <th>Assessment Date</th>
                                        <th>View Candidate</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach ($aa_batch as $aa_batch)
                                        
                                    <tr>
                                        @if ($aa_batch->reass_id===null)
                                        
                                        <td><input type="checkbox" class="checks" name="chkbox[]" value="{{$aa_batch->id}}"></td>
                                        <td>{{$aa_batch->batch->batch_id}}</td>
                                        <td>{{$aa_batch->batch->jobrole->job_role}}</td>
                                        <td>Assessment</td>
                                        <td>{{\Carbon\Carbon::parse($aa_batch->batch->assessment)->format('d-m-Y')}}</td>
                                        <td><a class="badge bg-green margin-0" href="{{route('agency.batch.bt-candidate',['id'=>Crypt::encrypt($aa_batch->bt_id)])}}" >View Candidate</a></td>

                                        @else
                                        <td><input type="checkbox" class="checks" name="chkbox[]" value="{{$aa_batch->id}}"></td>
                                        <td>{{$aa_batch->reassessment->batch->batch_id}}</td>
                                        <td>{{$aa_batch->reassessment->batch->jobrole->job_role}}</td>
                                        <td>Re-Assessment</td>
                                        <td>{{\Carbon\Carbon::parse($aa_batch->reassessment->assessment)->format('d-m-Y')}}</td>   
                                        <td><a class="badge bg-green margin-0" href="{{route('agency.batch.reass-bt-candidate',['id'=>Crypt::encrypt($aa_batch->reass_id)])}}" >View Candidate</a></td>
                                        @endif
                                    </tr>
                                    @endforeach
                                   
                                       
                                    </tbody>
                            </table>
                            </div>
                            @if($aa_batch->count()>0)
                            <div class="row d-flex justify-content-around">
                                
                                <div class="col-sm-4">
                                    <label for="ref_no">Enter Ref No. <span style="color:red"> <strong>*</strong></span></label>
                                    <div class="form-group form-float">
                                        <input type="text" class="form-control " placeholder="Enter Ref No" id="ref_no" name="ref_no"  required>
                                    </div>
                                </div>
                               
                            </div>
                            <div class="text-center" >
                                <button class="btn btn-round btn-primary" type="submit" id="save-btn"> Submit Pay Order</button>
                            </div>
                            @endif
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
<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/js/scpwd-common.js')}}"></script>

@stop