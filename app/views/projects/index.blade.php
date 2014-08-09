<?php 
	$monthes = array(
	    1 => 'Января', 2 => 'Февраля', 3 => 'Марта', 4 => 'Апреля',
	    5 => 'Мая', 6 => 'Июня', 7 => 'Июля', 8 => 'Августа',
	    9 => 'Сентября', 10 => 'Октября', 11 => 'Ноября', 12 => 'Декабря'
	);

	$dh = new Date_HumanDiff();
	$dh->setTranslator(new Date_HumanDiff_Locale_ru);
?>

<div class="container">
		
	<div class="row">
		<div class="col-lg-12">
			<h1>Список проектов</h1>
		</div>
	</div>

	<div class="row page-filter">
		<div class="col-lg-9">
			<form action="">
				<div class="pull-left filter-name-container">
					{{ Form::label('filter_name', 'Фильтр', array('class' => 'filter-name-field-label')) }}
					{{ Form::text('filter_name', Input::get('filter_name', ''), array('id' => 'filter_name', 'class' => 'filter-name-field form-control')) }}
				</div>

				@if ($ignore_dates)
					<div id="reportrange" class="disabled pull-left">
				@else
					<div id="reportrange" class="pull-left">
				@endif
				    <i class="glyphicon glyphicon-time"></i>
				    <span>
				    	<?php echo($date_from->format('j ') . $monthes[ $date_from->format('n') ] . $date_from->format(' Y')); ?>
				    	 - 
				    	<?php echo($date_to->format('j ') . $monthes[ $date_to->format('n') ] . $date_to->format(' Y')); ?>
			    	</span>
				    <b class="caret"></b>
				</div>

				<input type="hidden" name="date_from" id="date_from" value="{{ $date_from->format('d-m-Y') }}">
				<input type="hidden" name="date_to" id="date_to" value="{{ $date_to->format('d-m-Y') }}">

				<label class="ignore-date-checkbox-checkbox">
					{{ Form::checkbox('ignore_dates', 'Y', $ignore_dates, array('id' => 'ignore-dates')) }} 
					Игнорировать дату
				</label>

				<button type="submit" class="filter-search-btn btn btn-info">
					<span class="glyphicon glyphicon-search"></span>
				</button>

				<a href="{{ URL::route('projects.index') }}" class="btn btn-default">
					<span class="glyphicon glyphicon-remove"></span>
				</a>
			</form>
		</div>
		<div class="col-lg-3 text-right">
			{{ HTML::linkRoute('projects.create', 'Создать проект', array(), array('class' => 'btn btn-info')) }}
		</div>
	</div>

	<br>


	<div class="row">
		<div class="col-lg-12">

			@if (count($project_list))
				<table class="table vertical-aligned">
					<tr>
						<th width="50"></th>
						<th>№</th>
						<th>Статус</th>
						<th>Название</th>
						<th>Короткое описание</th>

						<th>Создан</th>
						<th>Дата сдачи</th>

						<th></th>
					</tr>

					@foreach ($project_list as $project)
						<tr>
							<td style="background: {{$project->proj_priority_color}};"></td>
							<td>{{$project->proj_id}}</td>
							<td>
								@if ($project->proj_status)
									Готов
								@else
									В работе
								@endif
							</td>
							<td>
								{{ HTML::linkRoute('projects.show', $project->proj_name, array('id' => $project->proj_id)) }}
							</td>
							<td>{{$project->proj_desc_short}}</td>

							<td>{{ $project->proj_created_at }}</td>
							<td>{{ $project->proj_end_date }}</td>

							<td class="text-right">
								{{ HTML::linkRoute('projects.edit', 'Редактировать', array('id' => $project->proj_id), array('class' => 'btn btn-default')) }}
							</td>
						</tr>
					@endforeach
				</table>
			@else
				<div class="empty-message text-center">
					<span class="glyphicon glyphicon-briefcase"></span>
					<h3>Нет проектов :(</h3>
				</div>
			@endif

		</div>
	</div>
</div>

<script type="text/javascript">
	// Ignore dates
	$('#ignore-dates').on('change', function() {
		var $this = $(this);

		if ($this.is(':checked')) {
			$('#reportrange').addClass('disabled');
		} else {
			$('#reportrange').removeClass('disabled');
		};
	});

	// Init date range filter
	$('#reportrange').daterangepicker(
	    {
	      ranges: {
			'Этот месяц': [moment().startOf('month'), moment().endOf('month')],
			'3 месяца назад': [moment().startOf('month').subtract('month', 3), moment().endOf('month')],
			'6 месяцев назад': [moment().startOf('month').subtract('month', 6), moment().endOf('month')],
			'1 год назад': [moment().startOf('month').subtract('month', 12), moment().endOf('month')],
			'2 года назад': [moment().startOf('month').subtract('month', 24), moment().endOf('month')],
	      },
	      format: 'DD-MM-YYYY',
	      startDate: "{{ $date_from->format('d-m-Y') }}",
	      endDate: "{{ $date_to->format('d-m-Y') }}"
	    },
	    function(start, end) {
	        $('#reportrange span').html(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));

	        $('#date_from').val(start.format('DD-MM-YYYY'));
	        $('#date_to').val(end.format('DD-MM-YYYY'));
	    }
	);
</script>