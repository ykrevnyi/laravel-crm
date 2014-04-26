<h1 class="text-center">
	Проект: <span class="create-project-title">{{$project->proj_name}}</span>
</h1>

<div class="container">

	<div class="row">
		<div class="col-lg-12">

			<div class="form-horizontal">
				{{ Form::open(array('route' => array('projects.update', $project->proj_id), 'method' => 'put')) }}

					<div class="form-group">
						{{ Form::label('proj_id', '№', array('class' => 'col-sm-3 control-label')) }}
						<div class="col-sm-9">
							{{ Form::text('proj_id', $project->proj_id, array('disabled'), array('class' => 'form-control')) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('proj_status', 'Статус проекта', array('class' => 'col-sm-3 control-label')) }}
						<div class="col-sm-9">
							{{ Form::select('proj_status', array(0 => 'В работе', 1 => 'Готов'), $project->proj_status) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('proj_name', 'Название', array('class' => 'col-sm-3 control-label')) }}
						<div class="col-sm-9">
							{{ Form::text('proj_name', $project->proj_name, array('class' => '2way-binding form-control', 'data-binding' => 'create-project-title')) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('proj_desc_short', 'Короткое описание', array('class' => 'col-sm-3 control-label')) }}
						<div class="col-sm-9">
							{{ Form::textarea('proj_desc_short', $project->proj_desc_short, array('class' => 'form-control')) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('proj_desc', 'Детальное описание', array('class' => 'col-sm-3 control-label')) }}
						<div class="col-sm-9">
							{{ Form::textarea('proj_desc', $project->proj_desc, array('class' => 'form-control')) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('proj_persents', 'Выполнено (%)', array('class' => 'col-sm-3 control-label')) }}
						<div class="col-sm-3">
							{{ Form::text('proj_persents', $project->proj_persents, array('class' => 'form-control')) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('proj_actual_hours', 'Реальное затраченое время', array('class' => 'col-sm-3 control-label')) }}
						<div class="col-sm-3">
							{{ Form::text('proj_actual_hours', $project->proj_actual_hours, array('class' => 'form-control')) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('proj_end_date', 'Дата сдачи', array('class' => 'col-sm-3 control-label')) }}
						<div class="col-sm-3">
							{{ Form::text('proj_end_date', $project->proj_end_date, array('class' => 'form-control datepicker')) }}
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">Приоритет:</label>
						<div class="col-sm-9">
							{{ Form::select('proj_priority_id', $priorities, $project->proj_priority_id) }}
						</div>
					</div>

					<div class="text-center">
						{{ Form::submit('Сохранить', array('class' => 'btn btn-success')) }}
					</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>

	<br>

	<div class="row">
		<div class="col-lg-12">
			<div class="text-center">
				{{ Form::open(array('method'=>'DELETE', 'route'=>array('projects.destroy', $project->proj_id))) }}
					{{ Form::submit('Удалить проект', array('onclick' => 'return confirm("Are you sure?")', 'class' => 'btn btn-danger')) }}
				{{ Form::close() }}
			</div>
		</div>
	</div>

	<br>
	
</div>