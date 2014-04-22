<div class="col-lg-12">
	<h3>Задача: <span class="create-task-title">новая задача</span></h3>
</div>

<div class="task-create-wizzard col-lg-12">
	{{ Form::open(array('route' => array('task.store'), 'class' => 'create-task-form form-horizontal', 'id' => 'create-task-form')) }}
		<div class="form-group">
			{{ Form::label('name', 'Название', array('class' => 'control-label')) }}
			{{ Form::text('name', '', array('class' => 'form-control input-sm 2way-binding', 'data-binding' => 'create-task-title')) }}
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

		{{ Form::button('Отмена', array('class' => 'btn btn-default pull-left show-task-form-btn')) }}
		<button class="create-task-btn btn btn-success pull-right">
			Далее
			<span class="glyphicon glyphicon-chevron-right"></span>
		</button>
	{{ Form::close() }}

	<div id="related-users-container-ajax"></div>
</div>


<script type="text/javascript">
	$('.show-task-form-btn').on('click', window.toggleTaskForm);

	// Create new task
	var submitTaskForm = function(e) {
		var $this = $(this);

		$taskForm.addClass('slow-loader');
		$this.find('.create-task-btn').attr('disabled', 'disabled');

		$.ajax({
			url: "{{ URL::route('task.store') }}",
			type: 'post',
			dataType: 'json',
			data: {
				project_id: "{{ $project_id }}",
				data: $this.serialize()
			}
		})
		.done(function(json) {
			$taskForm.removeClass('slow-loader');

			// Clear all the messages and `has-error` classes
			$this.find('.form-group').removeClass('has-error');
			$this.find('.help-block').html('');
			$this.find('.create-task-btn').removeAttr('disabled')

			// Validation completed
			if (json.status) {
				// Append and show users form
				var decoded = $('<div/>').html(json.view).text();

				$('#related-users-container-ajax').html(decoded);
				$('.task-create-wizzard').addClass('step-2');

				// Close form on click `.create-task-btn`
				$this.find('.create-task-btn')
					.removeAttr('disabled')
					.html('Сохранить')
					.off('click')
					.on('click', closeTask);
			} else {
				$.each(json.messages, function(index, val) {
					// Add error classes and append error messages
					$this.find('*[name=' + index + ']')
						.closest('.form-group').addClass('has-error')
						.find('.help-block').html(val[0]);
				});
			};
		});

		e.preventDefault();
	};

	// Here we bind new execution context to the "Save" button
	// 1st time - submit form
	// 2nd time - close it
	var submitTaskFormCaller = function(e) {
		$('#create-task-form').submit();

		e.preventDefault();
	}

	$('#create-task-form').on('submit', submitTaskForm);
	$('.create-task-btn').on('click', submitTaskFormCaller);

	// Clear task form data and closes it
	var closeTask = function(e) {
		// Clear form
		$('#create-task-form').find('input[type=text], textarea').val('');

		// Remove users form
		$('#related-users-container-ajax').html('');

		// Close form and clear binding (from title)
		window.toggleTaskForm();
		window.drop2wayBinding();

		e.preventDefault();
	};

</script>