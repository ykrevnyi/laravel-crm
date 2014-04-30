<div class="project-create-wizzard">

	<h1 class="text-center">
		Проект: <span class="create-project-title">новый проект</span>
	</h1>

	<div class="container">

		@if ($errors->count())
			<div class="row">
				<div class="col-lg-12">
					<div class="alert alert-danger">
						@foreach ($errors->all() as $error)
							{{ $error }} <br>
						@endforeach
					</div>
				</div>
			</div>
		@endif

		<div class="row project-form-data">
			<div class="col-lg-12">

				<div class="form-horizontal">
					{{ Form::open(array('route' => array('projects.index'))) }}

						<div class="form-group">
							{{ Form::label('proj_status', 'Статус проекта', array('class' => 'col-sm-3 control-label')) }}
							<div class="col-sm-9">
								{{ Form::select('proj_status', array(0 => 'В работе', 1 => 'Готов'), '') }}
							</div>
						</div>

						<div class="form-group">
							{{ Form::label('proj_name', 'Название', array('class' => 'col-sm-3 control-label')) }}
							<div class="col-sm-9">
								{{ Form::text('proj_name', '', array('class' => '2way-binding form-control', 'data-binding' => 'create-project-title', 'autofocus')) }}
							</div>
						</div>

						<div class="form-group">
							{{ Form::label('proj_desc_short', 'Короткое описание', array('class' => 'col-sm-3 control-label')) }}
							<div class="col-sm-9">
								{{ Form::textarea('proj_desc_short', '', array('class' => 'form-control')) }}
							</div>
						</div>

						<div class="form-group">
							{{ Form::label('proj_desc', 'Детальное описание', array('class' => 'col-sm-3 control-label')) }}
							<div class="col-sm-9">
								{{ Form::textarea('proj_desc', '', array('class' => 'form-control')) }}
							</div>
						</div>

						<div class="form-group">
							{{ Form::label('proj_persents', 'Выполнено (%)', array('class' => 'col-sm-3 control-label')) }}
							<div class="col-sm-3">
								{{ Form::text('proj_persents', '', array('class' => 'form-control')) }}
							</div>
						</div>

						<div class="form-group">
							{{ Form::label('proj_end_date', 'Дата сдачи', array('class' => 'col-sm-3 control-label')) }}
							<div class="col-sm-3">
								{{ Form::text('proj_end_date', '', array('class' => 'form-control datepicker')) }}
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">Приоритет:</label>
							<div class="col-sm-9">
								{{ Form::select('proj_priority_id', $priorities, '') }}
							</div>
						</div>

						<div class="project-submit-btn text-center">
							{{ HTML::linkRoute('projects.index', 'Отменить', array(), array('class' => 'btn btn-default')) }}

							<button class="btn btn-success" type="submit">
								Далее
								<span class="glyphicon glyphicon-chevron-right"></span>
							</button>
						</div>
					{{ Form::close() }}
				</div>
			</div>

			<div id="related-users-container-ajax"></div>
		</div>

		<br>

	</div>

</div>