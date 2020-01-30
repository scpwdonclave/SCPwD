@extends('layout.master') 
@section('title', 'Dashboard')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}"/>
@stop
@section('content')
<div class="container-fluid home">
    <div class="row clearfix">
        <div class="col-lg-4 col-sm-6">
            <div class="card">
                <div class="body">
                    
                    <h3 class="m-b-0 number count-to" data-from="0" data-to="{{$partners_cnt}}" data-speed="2000" data-fresh-interval="700">{{$partners_cnt}}<i class="zmdi zmdi-trending-up float-right"></i></h3>
                        <strong><p class="text-muted"><span style="color:blue">Total Registered Training Partners</span></p></strong>
                        {{-- <div class="progress">
                            <div class="progress-bar l-turquoise" role="progressbar" aria-valuenow="{{$activePartner*100/$partnerCount}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$activePartner*100/$partnerCount}}%;"></div>
                        </div> --}}
                        {{-- <div class="row d-flex justify-content-around">
                            <small>Active {{$activePartner*100/$partnerCount}}%</small>
                            <small>Inactive {{$inactivePartner*100/$partnerCount}}%</small>
                        </div> --}}
                  
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6">
            <div class="card">
                <div class="body">
                   
                        <h3 class="m-b-0 number count-to" data-from="0" data-to="{{$centers_cnt}}" data-speed="2000" data-fresh-interval="700">{{$centers_cnt}} <i class="zmdi zmdi-trending-up float-right"></i></h3>
                        <strong><p class="text-muted"><span style="color:blue">Total Registered Training Centers</span></p></strong>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6">
            <div class="card">
                <div class="body">
                <h3 class="m-b-0 number count-to" data-from="0" data-to="{{$trainer_cnt}}" data-speed="2000" data-fresh-interval="700">{{$trainer_cnt}} <i class="zmdi zmdi-trending-up float-right"></i></h3>
                    <strong><p class="text-muted"><span style="color:blue">Total Registered Trainers</span></p></strong>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6">
            <div class="card">
                <div class="body">
                   <h3 class="m-b-0 number count-to" data-from="0" data-to="{{$candidates_cnt}}" data-speed="2000" data-fresh-interval="700">{{$candidates_cnt}} <i class="zmdi zmdi-trending-up float-right"></i></h3>
                    <strong><p class="text-muted"><span style="color:blue">Total Registered Candidates</span></p></strong>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6">
            <div class="card">
                <div class="body">
                   <h3 class="m-b-0 number count-to" data-from="0" data-to="{{$agency_cnt}}" data-speed="2000" data-fresh-interval="700">{{$agency_cnt}} <i class="zmdi zmdi-trending-up float-right"></i></h3>
                    <strong><p class="text-muted"><span style="color:blue">Total Registered Agency</span></p></strong>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6">
            <div class="card">
                <div class="body">
                   <h3 class="m-b-0 number count-to" data-from="0" data-to="{{$assessor_cnt}}" data-speed="2000" data-fresh-interval="700">{{$assessor_cnt}} <i class="zmdi zmdi-trending-up float-right"></i></h3>
                    <strong><p class="text-muted"><span style="color:blue">Total Registered Assessor</span></p></strong>
                </div>
            </div>
        </div>
    </div>
   
{{-- ======================= --}}

<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>Statistics</strong> FY : {{$finyear}}</h2>
                
            </div>
            <div class="body">
                <canvas id="line_chart" height="85"></canvas>
            </div>
        </div>
    </div>
              
</div>
{{-- ======================= --}}
    
 <div class="row clearfix">
        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Referrer</strong></h2>
                   
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th>LOCATION</th>
                                    <th>TP</th>
                                    <th>TC</th>
                                    <th>AA</th>
                                    <th>CANDIDATES</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stack as $key=>$item)
                                @if ($item[0]!=0 || $item[1]!=0 || $item[2]!=0 || $item[3]!=0)
                                <tr>
                                <td>{{$key}}</td>
                                <td>{{$item[0]}}</td>
                                <td>{{$item[1]}}</td>
                                <td>{{$item[2]}}</td>
                                <td>{{$item[3]}}</td>
                               </tr>
                                @endif    
                                @endforeach
                               
                               
                               
                            </tbody>
                           
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="header">
                <h2><strong>Quick Details</strong> Month : {{$fmonth}} ({{$finyear}})</h2>
                   
                </div>
                <div class="body">
                    <ul class="list-unstyled activity">
                        <li>
                            <a href="javascript:void(0)">
                                <i class="zmdi zmdi-pin bg-blue"></i>                    
                                <div class="info">
                                    <h4>{{$conclu[0]}} Training Center</h4>                    
                                    <small>&nbsp;</small>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <i class="zmdi zmdi-file-text bg-red"></i>
                                <div class="info">
                                    <h4>{{$conclu[1]}} Training Partner</h4>                    
                                    <small>&nbsp;</small>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <i class="zmdi zmdi-account-box-phone bg-green"></i>
                                <div class="info">
                                    <h4>{{$conclu[2]}} Examinations</h4>                    
                                    <small>&nbsp;</small>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <i class="zmdi zmdi-email bg-amber"></i>
                                <div class="info">
                                    <h4>{{$conclu[3]}} Students Passed</h4>
                                    <small>&nbsp;</small>
                                </div>
                            </a>
                        </li>                            
                        <li>
                            <a href="javascript:void(0)">
                                <i class="zmdi zmdi-refresh-alt bg-red"></i>
                                <div class="info">
                                    <h4>{{$conclu[4]}} Students Failed</h4>
                                    <small>&nbsp;</small>
                                </div>
                            </a>
                        </li>                            
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
</div>
@stop
@section('page-script')

<script>
$(function () {
    new Chart(document.getElementById("line_chart").getContext("2d"), getChartJs('line'));
       
});

function getChartJs(type) {
    var config = null;

    if (type === 'line') {
        config = {
            type: 'line',
            data: {
                labels: @json($mnarr),
                datasets: [{
                    label: "Training partner",
                    data: @json($res),
                    borderColor: 'rgba(0,128,128, 0.2)',
                    backgroundColor: 'rgba(0,128,128, 0.4)',
                    pointBorderColor: 'rgba(0,128,128, 0.3)',
                    pointBackgroundColor: 'rgba(0,128,128, 0.2)',
                    pointBorderWidth: 1
                }, {
                    label: "Training Center",
                    data: @json($res1),                    
                    borderColor: 'rgba(49,79,232, 0.2)',
                    backgroundColor: 'rgba(49,79,232, 0.4)',
                    pointBorderColor: 'rgba(49,79,232, 0)',
                    pointBackgroundColor: 'rgba(49,79,232, 0.9)',
                    pointBorderWidth: 1
                }, {
                    label: "Candidate",
                    data: @json($res2),                    
                    borderColor: 'rgba(126,239,186, 0.2)',
                    backgroundColor: 'rgba(126,239,186, 0.4)',
                    pointBorderColor: 'rgba(126,239,186, 0)',
                    pointBackgroundColor: 'rgba(126,239,186, 0.9)',
                    pointBorderWidth: 1
                }]
            },
            options: {
                responsive: true,
                legend: false,
                
            }
        }
    }
    return config;
}


</script>

<script src="{{asset('assets/plugins/chartjs/Chart.bundle.js')}}"></script>
{{-- <script src="{{asset('assets/js/pages/charts/chartjs.js')}}"></script> --}}


<script src="{{asset('assets/bundles/morrisscripts.bundle.js')}}"></script>
<script src="{{asset('assets/bundles/jvectormap.bundle.js')}}"></script>
<script src="{{asset('assets/bundles/knob.bundle.js')}}"></script>

<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
{{-- <script src="{{asset('assets/js/pages/index.js')}}"></script> --}}
@stop