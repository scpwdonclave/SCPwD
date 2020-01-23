@extends('layout.master')
@section('title', 'Quick View')
@section('parentPageTitle', 'MIS')

@section('page-style')


@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-2 col-sm-6">
            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-account-box zmdi-hc-3x col-green"></i></h6>
                    <span>Enrolled</span>
                <h3 class="m-b-10"><span class="number count-to" data-from="0" data-to="{{$b_total_candidate}}" data-speed="2000" data-fresh-interval="700">{{$b_total_candidate}}</span></h3>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-6">
            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-cast zmdi-hc-3x col-blue"></i></h6>
                    <span>Ongoing Training</span>
                <h3 class="m-b-10 number count-to" data-from="0" data-to="{{$bt_can_cnt}}" data-speed="2000" data-fresh-interval="700">{{$bt_can_cnt}}</h3>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-6">
            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-dns zmdi-hc-3x col-pink"></i></h6>
                    <span>Trained</span>
                <h3 class="m-b-10 number count-to" data-from="0" data-to="{{$trained_can_cnt}}" data-speed="2000" data-fresh-interval="700">{{$trained_can_cnt}}</h3>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-6">
            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-border-color zmdi-hc-3x col-brown"></i></h6>
                    <span>Assessed</span>
                <h3 class="m-b-10 number count-to" data-from="0" data-to="{{$assessed_can_cnt}}" data-speed="2000" data-fresh-interval="700">{{$assessed_can_cnt}}</h3>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-6">
            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-check-square zmdi-hc-3x col-amber"></i></h6>
                    <span>Passed</span>
                <h3 class="m-b-10 number count-to" data-from="0" data-to="{{$candidate_passed}}" data-speed="2000" data-fresh-interval="700">{{$candidate_passed}}</h3>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-6">
            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-minus-circle zmdi-hc-3x col-red"></i></h6>
                    <span>Fail</span>
                <h3 class="m-b-10 number count-to" data-from="0" data-to="{{$candidate_failed}}" data-speed="2000" data-fresh-interval="700">{{$candidate_failed}}</h3>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-6">
            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-turning-sign zmdi-hc-3x"></i></h6>
                    <span>Absent</span>
                <h3 class="m-b-10 number count-to" data-from="0" data-to="{{$candidate_absent}}" data-speed="2000" data-fresh-interval="700">{{$candidate_absent}}</h3>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-6">
            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-card-off zmdi-hc-3x col-cyan"></i></h6>
                    <span>Drop-Out</span>
                    <h3 class="m-b-10 number count-to" data-from="0" data-to="0" data-speed="2000" data-fresh-interval="700">0</h3>
                    
                </div>
            </div>
        </div>
       
    </div>
    <div class="row clearfix">
       
        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="header">
                    <h2>Enroll By <strong>District</strong></h2>
                   
                </div>
                <div class="body">
                    <div class="cwidget-scroll">
                        <canvas id="bar_chart" height="15000" ></canvas>
                    </div> 
                    <br><br>
                </div>
            </div>
        </div>            
        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="header">
                    <h2>Enroll By <strong>Parliament Constituency</strong></h2>
                   
                </div>
                <div class="body">
                    <div class="cwidget-scroll">
                        <canvas id="bar_chart2" height="12000"></canvas>
                    </div>
                    <br><br>  
                </div>
            </div>
        </div>            
    </div>
    
</div>

<div class="container-fluid">
    <div class="row clearfix">
       
        <div class="col-lg-12 col-md-6">
            <div class="card">
                <div class="header">
                    <h2>Top Job Role Wise<strong> Enrolled</strong></h2>
                   
                </div>
                <div class="body">
                    <div class="cwidget-scroll">
                        <canvas id="bar_chart3" height="350" ></canvas>
                    </div>
                    <br><br> 
                </div>
            </div>
        </div>            
                   
    </div>
    
</div>
@stop
@section('page-script')


<script>
    $(function () {
        new Chart(document.getElementById("bar_chart").getContext("2d"), getDistrictChart('bar'));
        new Chart(document.getElementById("bar_chart2").getContext("2d"), getParliamentChart('bar'));
        new Chart(document.getElementById("bar_chart3").getContext("2d"), getJobChart('bar'));
});

function getDistrictChart(type) {
    var config = null;

    if (type === 'bar') {
        config = {
            type: 'horizontalBar',
           
            data: {
                labels: @json($state),
                datasets: [{
                    label: "Candidate",
                    data: @json($candidate),
                    backgroundColor: '#26c6da',
                    strokeColor: "rgba(255,118,118,0.1)",
                }]
            },
            options: {
                responsive: true,
                legend: false,
                scales: {
              
            xAxes: [{
                    stacked: true,
                    position: "top",
                    id: "x-axis-0",
                    ticks: {
                    stepSize: 1
                    }
                }],

          
                }
            }
        }
    }
    return config;
}
function getParliamentChart(type) {
    var config = null;

    if (type === 'bar') {
        config = {
            type: 'horizontalBar',
           
            data: {
                labels: @json($parl_name),
                datasets: [{
                    label: "Candidate",
                    data: @json($p_can_count),
                    backgroundColor: '#26c6da',
                    strokeColor: "rgba(255,118,118,0.1)",
                }]
            },
            options: {
                responsive: true,
                scales: {
                    xAxes: [{
                    stacked: true,
                    position: "top",
                    id: "x-axis-0",
                    ticks: {
                    stepSize: 1
                    }
                }],
                },
                legend: false
                
            }
        }
    }
    return config;
}
function getJobChart(type) {
    var config = null;

if (type === 'bar') {
    config = {
        type: 'horizontalBar',
       
        data: {
            labels: @json($job_name),
            datasets: [{
                label: "Candidate",
                data: @json($t_candidate),
                backgroundColor: '#26c6da',
                strokeColor: "rgba(255,118,118,0.1)",
            }]
        },
        options: {
            responsive: true,
            legend: false,
            scales: {
            xAxes: [{
                stacked: true,
                position: "top",
                id: "x-axis-0",
                ticks: {
                stepSize: 1
                }
            }],
		yAxes: [{
           
			categoryPercentage: 0.6,
			barPercentage: 0.6,
            
		}]
	},
        }
    }
}
return config;
}
</script>


<script src="{{asset('assets/plugins/chartjs/Chart.bundle.js')}}"></script>
@stop