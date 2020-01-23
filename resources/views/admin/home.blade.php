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
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="body">
                    {{-- @foreach ($res as $item)

                        <h1>{{$item}}</h1> 
                    @endforeach --}}
                    
                    @php
                        $partnerCount = $partners->count();
                        $activePartner = 0; $inactivePartner = 0;
                        foreach ($partners as $partner) { ($partner->status) ? $activePartner++ : $inactivePartner++ ; }
                    @endphp
                    @if ($partnerCount > 0)
                        <h3 class="m-b-0 number count-to" data-from="0" data-to="{{$partnerCount}}" data-speed="2000" data-fresh-interval="700">{{$partnerCount}} <i class="zmdi zmdi-trending-up float-right"></i></h3>
                        <strong><p class="text-muted"><span style="color:blue">Total Training Partners</span></p></strong>
                        <div class="progress">
                            <div class="progress-bar l-turquoise" role="progressbar" aria-valuenow="{{$activePartner*100/$partnerCount}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$activePartner*100/$partnerCount}}%;"></div>
                        </div>
                        <div class="row d-flex justify-content-around">
                            <small>Active {{$activePartner*100/$partnerCount}}%</small>
                            <small>Inactive {{$inactivePartner*100/$partnerCount}}%</small>
                        </div>
                    @else
                        <strong><p class="text-muted"><span style="color:blue">No Training Partners Has been Registered yet</span></p></strong>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="body">
                    @php
                        $centerCount = $centers->count();
                        $activeCenter = 0; $inactiveCenter = 0;
                        foreach ($centers as $center) { ($center->status) ? $activeCenter++ : $inactiveCenter++ ; }
                    @endphp
                    @if ($centerCount>0)
                        <h3 class="m-b-0 number count-to" data-from="0" data-to="{{$centerCount}}" data-speed="2000" data-fresh-interval="700">{{$centerCount}} <i class="zmdi zmdi-trending-up float-right"></i></h3>
                        <strong><p class="text-muted"><span style="color:blue">Total Training Centers</span></p></strong>
                        <div class="progress">
                            <div class="progress-bar l-turquoise" role="progressbar" aria-valuenow="{{$activeCenter*100/$centerCount}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$activeCenter*100/$centerCount}}%;"></div>
                        </div>
                        <div class="row d-flex justify-content-around">
                            <small>Active {{round($activeCenter*100/$centerCount,2)}}%</small>
                            <small>Inactive {{round($inactiveCenter*100/$centerCount,2)}}%</small>
                        </div>
                    @else
                       <strong><p class="text-muted"><span style="color:blue">No Training Centers Has been Registered yet</span></p></strong>                        
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="body">
                    <h3 class="m-b-0 number count-to" data-from="0" data-to="2105" data-speed="2000" data-fresh-interval="700">2105 <i class="zmdi zmdi-trending-up float-right"></i></h3>
                    <strong><p class="text-muted"><span style="color:blue">Total Trainers</span></p></strong>
                    <div class="progress">
                        <div class="progress-bar l-blue" role="progressbar" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100" style="width: 68%;"></div>
                    </div>
                    <small>Change 23%</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="body">
                    @php
                        $candidateCount = $candidates->count();
                        $activeCandidate = 0; $inactiveCandidate = 0;
                        foreach ($candidates as $candidate) { ($candidate->status) ? $activeCandidate++ : $inactiveCandidate++ ; }
                    @endphp
                    @if ($candidateCount>0)
                        <h3 class="m-b-0 number count-to" data-from="0" data-to="{{$candidateCount}}" data-speed="2000" data-fresh-interval="700">{{$candidateCount}} <i class="zmdi zmdi-trending-up float-right"></i></h3>
                        <strong><p class="text-muted"><span style="color:blue">Total Candidates</span></p></strong>
                        <div class="progress">
                            <div class="progress-bar l-turquoise" role="progressbar" aria-valuenow="{{$activeCandidate*100/$candidateCount}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$activeCandidate*100/$candidateCount}}%;"></div>
                        </div>
                        <div class="row d-flex justify-content-around">
                            <small>Active {{$activeCandidate*100/$candidateCount}}%</small>
                            <small>Inactive {{$inactiveCandidate*100/$candidateCount}}%</small>
                        </div>
                    @else
                        <strong><p class="text-muted"><span style="color:blue">No Candidates Has been Registered yet</span></p></strong>
                    @endif
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
                <canvas id="line_chart" height="75"></canvas>
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
                <h2><strong>Quick Details</strong> FY : {{$finyear}}</h2>
                   
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