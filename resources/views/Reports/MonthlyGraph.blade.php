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
                <div class="panel-heading">Daily Report of {{$productname->name}}<div class="pull-right">{{date('d-M-Y h:i a')}}</div></div>
                <div>
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
					label: "My First dataset",
					fillColor : "rgba(220,220,220,0.2)",
					strokeColor : "rgba(220,220,220,1)",
					pointColor : "rgba(220,220,220,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(220,220,220,1)",
					data : [@foreach($myData as $key)
                	"{{$key->produced}}",
                	@endforeach]
				}
			]
		}
	window.onload = function(){
		var ctx = document.getElementById("myChart").getContext("2d");
		window.myLine = new Chart(ctx).Line(lineChartData, {
			responsive: true,
		});
	}
	</script>
@endsection