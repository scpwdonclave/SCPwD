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
                            <small>Active {{$activeCenter*100/$centerCount}}%</small>
                            <small>Inactive {{$inactiveCenter*100/$centerCount}}%</small>
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
                <h2><strong>Statistics</strong></h2>
                
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
                                    <th>AB</th>
                                    <th>STUDENTS</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Uttar Pradesh</td>
                                    <td>1223</td>
                                    <td>156</td>
                                    <td>61</td>
                                    <td>2011</td>
                                  
                                </tr>
                                <tr>
                                    <td>Madhya pradesh</td>
                                    <td>665</td>
                                    <td>69</td>
                                    <td>63</td>
                                    <td>7889</td>
                                   
                                </tr>
                                <tr>
                                    <td>West Bengal</td>
                                    <td>447</td>
                                    <td>669</td>
                                    <td>66</td>
                                    <td>2009</td>
                                   
                                </tr>
                                <tr>
                                    <td>Tamil Nadu</td>
                                    <td>554</td>
                                    <td>661</td>
                                    <td>22</td>
                                    <td>2012</td>
                                    
                                </tr>
                                <tr>
                                    <td>Kerala</td>
                                    <td>332</td>
                                    <td>226</td>
                                    <td>330</td>
                                    <td>2008</td>
                                   
                                </tr>
                                <tr>
                                    <td>Chennai</td>
                                    <td>889</td>
                                    <td>3554</td>
                                    <td>61</td>
                                    <td>2012</td>
                                    
                                </tr>
                               
                               
                            </tbody>
                           
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Quick Details</strong></h2>
                   
                </div>
                <div class="body">
                    <ul class="list-unstyled activity">
                        <li>
                            <a href="javascript:void(0)">
                                <i class="zmdi zmdi-pin bg-blue"></i>                    
                                <div class="info">
                                    <h4>17 New Training Center</h4>                    
                                    <small>&nbsp;</small>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <i class="zmdi zmdi-file-text bg-red"></i>
                                <div class="info">
                                    <h4>7 Training Partner</h4>                    
                                    <small>&nbsp;</small>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <i class="zmdi zmdi-account-box-phone bg-green"></i>
                                <div class="info">
                                    <h4>4 Examinations</h4>                    
                                    <small>&nbsp;</small>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <i class="zmdi zmdi-email bg-amber"></i>
                                <div class="info">
                                    <h4>4172 Students Passed</h4>
                                    <small>&nbsp;</small>
                                </div>
                            </a>
                        </li>                            
                        <li>
                            <a href="javascript:void(0)">
                                <i class="zmdi zmdi-refresh-alt bg-red"></i>
                                <div class="info">
                                    <h4>172 Students Failed</h4>
                                    <small>&nbsp;</small>
                                </div>
                            </a>
                        </li>                            
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix social-widget">
        <div class="col-lg-3 col-sm-6">
            <div class="card info-box-2 hover-zoom-effect twitter-widget">
                <div class="icon"><i class="zmdi zmdi-twitter"></i></div>
                <div class="content">
                    <div class="text">Twitt</div>
                    <div class="number">8K</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card info-box-2 hover-zoom-effect instagram-widget">
                <div class="icon"><i class="zmdi zmdi-instagram"></i></div>
                <div class="content">
                    <div class="text">Followers</div>
                    <div class="number">231</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card info-box-2 hover-zoom-effect linkedin-widget">
                <div class="icon"><i class="zmdi zmdi-linkedin"></i></div>
                <div class="content">
                    <div class="text">Followers</div>
                    <div class="number">2510</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card info-box-2 hover-zoom-effect behance-widget">
                <div class="icon"><i class="zmdi zmdi-behance"></i></div>
                <div class="content">
                    <div class="text">Project</div>
                    <div class="number">121</div>
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
                labels: ["April", "May", "June", "July","August","September","October","November","December","January", "February", "March"],
                datasets: [{
                    label: "Training partner",
                    data: <?php echo json_encode($res);?>,
                    borderColor: 'rgba(0,128,128, 0.2)',
                    backgroundColor: 'rgba(0,128,128, 0.4)',
                    pointBorderColor: 'rgba(0,128,128, 0.3)',
                    pointBackgroundColor: 'rgba(0,128,128, 0.2)',
                    pointBorderWidth: 1
                }, {
                    label: "Training Center",
                    data: <?php echo json_encode($res1);?>,                    
                    borderColor: 'rgba(49,79,232, 0.2)',
                    backgroundColor: 'rgba(49,79,232, 0.4)',
                    pointBorderColor: 'rgba(49,79,232, 0)',
                    pointBackgroundColor: 'rgba(49,79,232, 0.9)',
                    pointBorderWidth: 1
                }, {
                    label: "Trainer",
                    data: <?php echo json_encode($res2);?>,                    
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