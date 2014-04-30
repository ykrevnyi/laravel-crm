<?php 
	$monthes = array(
	    1 => 'Января', 2 => 'Февраля', 3 => 'Марта', 4 => 'Апреля',
	    5 => 'Мая', 6 => 'Июня', 7 => 'Июля', 8 => 'Августа',
	    9 => 'Сентября', 10 => 'Октября', 11 => 'Ноября', 12 => 'Декабря'
	);
?>

<div class="container">
		
	<div class="row">
		<div class="col-lg-12">
			<h1>Список проектов</h1>
		</div>
	</div>

	<div class="row page-filter">
		<div class="col-lg-7">
			<form action="">
				<div class="pull-left filter-name-container">
					{{ Form::label('filter_name', 'Фильтр', array('class' => 'filter-name-field-label')) }}
					{{ Form::text('filter_name', Input::get('filter_name', ''), array('id' => 'filter_name', 'class' => 'filter-name-field form-control')) }}
				</div>

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

				<a href="{{ URL::route('projects.index') }}" class="btn btn-default">
					<span class="glyphicon glyphicon-remove"></span>
				</a>
			</form>
		</div>
		<div class="col-lg-5 text-right">
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

							<td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($project->proj_created_at))->diffForHumans() }}</td>
							<td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($project->proj_end_date))->diffForHumans() }}</td>

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
	// Init date range filter
	$('#reportrange').daterangepicker(
	    {
	      ranges: {
			'Сегодня': [moment(), moment()],
			'Вчера': [moment().subtract('days', 1), moment().subtract('days', 1)],
			'Последние 7 дней': [moment().subtract('days', 6), moment()],
			'Последние 30 дней': [moment().subtract('days', 29), moment()],
			'Этот месяц': [moment().startOf('month'), moment().endOf('month')],
			'Предыдущий месяц': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
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