@extends('layouts.app')


@section('cssarea')
<!-- Morris chart -->
  <link rel="stylesheet" href="{{asset('css/bower_components/morris.js/morris.css')}}">
@endsection
@section('dynamiccontent')
<div class="container">
    <div class="row">
        <div class="col-md-11">
            <div class="panel panel-default">
                <div class="panel-heading">Daily Production Report of {{$productname->name}}<div class="pull-right">Daily Graph {{date('d-M-Y h:i a')}}</div></div>
                <div>
                	<div class="row">
                		<div class="col-md-3">
                			<strong style="background-color:rgba(0,255,0,0.3);">Produced</strong>
                		</div>
                		<div class="col-md-3">
                			<strong style="background-color:rgba(255,0,0,0.3);">Dispatches</strong>
                		</div>
                		<div class="col-md-3">
                			<strong style="background-color:rgba(0,0,255,0.3);">Sale Return</strong>
                		</div>
                		<div class="col-md-3">
                			<strong style="background-color:rgba(192,192,192,0.3);">Received</strong>
                		</div>
                	</div>
                	<canvas id="myChart" width="400"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scriptarea')
<!-- Morris.js charts -->
<script src="{{asset('css/bower_components/chart.js/Chart.js')}}"></script>
<!-- Morris.js charts -->
<script src="{{asset('css/bower_components/raphael/raphael.min.js')}}"></script>
<script src="{{asset('css/bower_components/morris.js/morris.min.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('css/bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>
<script>
		var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
		var lineChartData = {
			labels : [@foreach($myData as $key)
                	"{{\Carbon\Carbon::parse($key->created_at)->format('d M')}}",
                	@endforeach],
			datasets : [
				{
					label: "Daily Produced",
					fillColor : "rgba(0,255,0,0.3)",
					strokeColor : "rgba(0,255,0,0.4)",
					pointColor : "rgba(0,255,0,0.4)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(0,255,0,0.4)",
					data : [@foreach($myData as $key)
                	"{{$key->produced}}",
                	@endforeach]
				},
				{
					label: "Daily Dispatches",
					fillColor : "rgba(255,0,0,0.3)",
					strokeColor : "rgba(255,0,0,0.4)",
					pointColor : "rgba(255,0,0,0.4)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(255,0,0,0.4)",
					data : [@foreach($myData as $key)
                	"{{$key->dispatches}}",
                	@endforeach]
				},
				{
					label: "Daily Sale Return",
					fillColor : "rgba(0,0,255,0.3)",
					strokeColor : "rgba(0,0,255,0.4)",
					pointColor : "rgba(0,0,255,0.4)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(0,0,255,0.4)",
					data : [@foreach($myData as $key)
                	"{{$key->sale_return}}",
                	@endforeach]
				}
				,{
					label: "Daily Received",
					fillColor : "rgba(192,192,192,0.3)",
					strokeColor : "rgba(192,192,192,0.4)",
					pointColor : "rgba(192,192,192,0.4)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(192,192,192,0.4)",
					data : [@foreach($myData as $key)
                	"{{$key->received}}",
                	@endforeach]
				}
			],
			options: {
                responsive: true,
                title:{
                    display:true,
                    text:'Chart.js Line Chart'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        }
                    }]
                }
            }
			
            
		}
	window.onload = function(){
		var ctx = document.getElementById("myChart").getContext("2d");
		window.myLine = new Chart(ctx).Line(lineChartData, {
			responsive: true,
		});
	}
	</script>
@endsection