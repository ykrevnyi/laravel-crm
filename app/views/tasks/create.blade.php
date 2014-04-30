<div class="col-lg-12">
	<h3>Задача: <span class="create-task-title">новая задача</span></h3>
</div>

<div class="task-create-wizzard col-lg-12">
	{{ Form::open(array('route' => array('task.store'), 'class' => 'create-task-form form-horizontal', 'id' => 'create-task-form')) }}
		<div class="form-group">
			{{ Form::label('name', 'Название', array('class' => 'control-label')) }}
			{{ Form::text('name', '', array('class' => 'form-control input-sm 2way-binding', 'data-binding' => 'create-task-title', 'autofocus')) }}
			<span class="help-block"></span>
		</div>

		<div class="form-group">
			{{ Form::label('short_description', 'Короткое описание', array('class' => 'control-label')) }}
			{{ Form::textarea('short_description', '', array('class' => 'form-control input-sm')) }}
			<span class="help-block"></span>
		</div>

		<div class="form-group">
			{{ Form::label('description', 'Детальное описание', array('class' => 'control-label')) }}
			{{ Form::textarea('description', '', array('class' => 'form-control input-sm')) }}
			<span class="help-block"></span>
		</div>

		<div class="form-group">
			{{ Form::button('Отмена', array('class' => 'btn btn-default pull-left close-task-form-btn')) }}

			<button class="create-task-btn btn btn-success pull-right">
				<span class="glyphicon glyphicon-user"></span>
				привязать пользователей
			</button>

			<div class="task-action-bnt-group btn-group pull-right hidden">
				<button data-action="close" type="button" class="btn btn-default has-tooltip">
					закрыть
				</button>
				<button data-action="create" type="button" class="btn btn-default has-tooltip">
					продолжить
				</button>
				<button data-action="refresh" type="button" class="btn btn-default has-tooltip">
					обновить статистику
				</button>
			</div>

			<span class="task-action-bnt-group-title pull-right">Сохранить и </span>
		</div>
	{{ Form::close() }}

	<div id="related-users-container-ajax"></div>
</div>


<script type="text/javascript">
	window.init2wayBinding();

	$('#create-task-form').on('submit', submitTaskForm);
	$('.create-task-btn').on('click', submitTaskFormCaller);
	$('.close-task-form-btn').on('click', closeTask);

	// Close task on `esc` key
	$(document).on('keyup', function(e) {
		if (e.keyCode == 27) {
			closeTask();
		};
	});

	// Enable tooltips
	$('.has-tooltip').tooltip({container: 'body'});

</script>