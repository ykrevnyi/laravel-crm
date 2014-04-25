<?php 
	$monthes = array(
	    1 => 'Января', 2 => 'Февраля', 3 => 'Марта', 4 => 'Апреля',
	    5 => 'Мая', 6 => 'Июня', 7 => 'Июля', 8 => 'Августа',
	    9 => 'Сентября', 10 => 'Октября', 11 => 'Ноября', 12 => 'Декабря'
	);
?>

<!-- Project info -->
<div class="container">

	<div class="row page-filter">
		<div class="col-lg-12">
			<form action="" class="user-filter-form text-center">
				<div id="reportrange" class="pull-left">
				    <i class="glyphicon glyphicon-time"></i>
				    <span>
				    	<?php echo($date_from_formated->format('j ') . $monthes[ $date_from_formated->format('n') ] . $date_from_formated->format(' Y')); ?>
				    	 - 
				    	<?php echo($date_to_formated->format('j ') . $monthes[ $date_to_formated->format('n') ] . $date_to_formated->format(' Y')); ?>
			    	</span>
				    <b class="caret"></b>
				</div>

				<input type="hidden" name="date_from" id="date_from" value="{{ $date_from }}">
				<input type="hidden" name="date_to" id="date_to" value="{{ $date_to }}">

				<button type="submit" class="filter-search-btn btn btn-info">
					<span class="glyphicon glyphicon-search"></span>
				</button>
			</form>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<h2>{{ $user->firstname }} {{ $user->lastname }}</h2>

			<table class="table">
				<tr>
					<th>Email</th>
					<th>Уровень доступа</th>
					<th>Телефон</th>
					<th>Адрес</th>
					<th>Skype</th>
					<th>День рождения</th>
				</tr>
				<tr>
					<td>{{ $user->mail or '-' }}</td>
					<td>{{ $user->level or '-' }}</td>
					<td>{{ $user->phone or '-' }}</td>
					<td>{{ $user->address or '-' }}</td>
					<td>{{ $user->skype or '-' }}</td>
					<td>{{ $user->birthday or '-' }}</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<h2>Проекты</h2>
		</div>
	</div>

	<!-- Related projects -->
	@if ($projects)
		@foreach ($projects as $project)
			<hr>
			
			<table class="table table-bordered">
				<caption><b>{{ $project->name }}</b></caption>
				<tr>
					<th>Должность</th>
					<th>Часов</th>
					<th>Цена в час</th>
					<th>Сума</th>
				</tr>
				@foreach ($project->info as $info)
					<tr>
						<td>{{ $info->name }}</td>
						<td>{{ $info->total_payed_hours }} ч.</td>
						<td>{{ $info->price_per_hour_payable }} $</td>
						<td>{{ $info->total }} $</td>
					</tr>
				@endforeach

				<tr>
					<th class="text-right" colspan="3">Итого</th>
					<th>{{ $project->total_price }} $</th>
				</tr>
			</table>
		@endforeach
	@else
		Пусто
	@endif
</div>

<script type="text/javascript">
var monthStart = moment().startOf('month'),
	monthEnd = moment().endOf('month');

	// Init date range filter
	$('#reportrange').daterangepicker(
	    {
	      ranges: {
			'Этот месяц': [monthStart, monthEnd],
			'Прошлый месяц': [moment().startOf('month').subtract('month', 1), monthEnd],
			'2 месяца назад': [moment().startOf('month').subtract('month', 2), monthEnd],
			'3 месяца назад': [moment().startOf('month').subtract('month', 3), monthEnd],
			'6 месяцев назад': [moment().startOf('month').subtract('month', 6), monthEnd],
			'12 месяцев назад': [moment().startOf('month').subtract('month', 12), monthEnd]
	      },
	      format: 'DD-MM-YYYY',
	      startDate: "{{ $date_from }}",
	      endDate: "{{ $date_to }}"
	    },
	    function(start, end) {
	        $('#reportrange span').html(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));

	        $('#date_from').val(start.format('DD-MM-YYYY'));
	        $('#date_to').val(end.format('DD-MM-YYYY'));
	    }
	);
</script>