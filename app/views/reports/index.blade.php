<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart);
  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Месяц', 'Продажи', 'Затраты'],
      @foreach ($results as $el)
      	['{{ $el["month_name"] }}', {{ $el["profit"] }}, {{ $el["expence"] }}],
      @endforeach
    ]);

    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
    chart.draw(data);
  }
</script>


<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="text-center">Производительность за последние полгода</h3>
			<div id="chart_div" style="width: 900px; height: 500px; margin: 0 auto;"></div>
		</div>
	</div>
</div>