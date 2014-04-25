<div class="col-lg-12">
	<h3>Задача: <span class="create-task-title">{{ $task->name }}</span></h3>
</div>

<div class="task-create-wizzard col-lg-12">
	{{ Form::open(array('route' => array('task.update', $project_id, $task_id), 'data-method' => 'put',  'class' => 'create-task-form form-horizontal', 'id' => 'create-task-form')) }}
		<div class="form-group">
			{{ Form::label('name', 'Название', array('class' => 'control-label')) }}
			{{ Form::text('name', $task->name, array('class' => 'form-control input-sm 2way-binding', 'data-binding' => 'create-task-title')) }}
			<span class="help-block"></span>
		</div>

		<div class="form-group">
			{{ Form::label('short_description', 'Короткое описание', array('class' => 'control-label')) }}
			{{ Form::textarea('short_description', $task->short_description, array('class' => 'form-control input-sm')) }}
			<span class="help-block"></span>
		</div>

		<div class="form-group">
			{{ Form::label('description', 'Детальное описание', array('class' => 'control-label')) }}
			{{ Form::textarea('description', $task->description, array('class' => 'form-control input-sm')) }}
			<span class="help-block"></span>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">Пользователи</div>

			<div class="panel-body text-center">
				<div id="user-select-form">
					Имя: 
					{{ Form::select('related_users_list', $users, 0, array('class' => 'user-id')) }}

					Должность: 
					{{ Form::select('related_user_role_list', $user_roles, 0, array('class' => 'user-role-id')) }}

					{{ Form::text('user_payed_hours', '', array('class' => 'user-payed-hours form-control input-sm')) }} ч.

					<a id="submit-user-for-task" href="#" class="btn btn-xs btn-success">
						<span class="glyphicon glyphicon-plus"></span>
					</a>
				</div>
			</div>

			<ul class="list-group" id="user-selected-list">
				@foreach ($related_users as $user)
					<li class="list-group-item">
						<b>{{ $user->firstname . ' ' . $user->lastname }}</b> 
						{{ Form::select('user_role_id', $user_roles, $user->user_role_id, array('class' => 'user-role-id', 'data-current-val' => $user->user_role_id, 'data-user-id' => $user->user_id)) }} 

						{{ Form::text('user_payed_hours', $user->payed_hours, array('class' => 'update-user-payed-hours user-payed-hours form-control input-sm', 'data-user-id' => $user->user_id)) }} ч.

						<span class="remove-user-from-task btn btn-danger btn-xs" data-user-id="{{ $user->user_id }}">
							<span class="glyphicon glyphicon-remove"></span>
						</span>
					</li>
				@endforeach
			</ul>
		</div>

		{{ Form::button('Отмена', array('class' => 'btn btn-default pull-left close-task-form-btn')) }}
		
		<button class="save-task-btn btn btn-success pull-right">Сохранить</button>
	{{ Form::close() }}

	<div id="related-users-container-ajax"></div>
</div>

<script type="text/javascript">
	window.init2wayBinding();

	$('#create-task-form').on('submit', submitTaskForm);
	$('.create-task-btn').on('click', submitTaskFormCaller);
	$('.close-task-form-btn').on('click', closeTask);
</script>

<script type="text/javascript">
	$('select').select2();

	var $userSelectList = $('#user-selected-list'),
		$form = $('#user-select-form'),
		userCnt = 0;

	// Add user to the task
	$('#submit-user-for-task').on('click', function(e) {
		var $this = $(this),
			url = "{{ URL::route('addUserToTask', $task_id) }}";

		$this.addClass('.active').attr('disabled', 'disabled');

		$.ajax({
			url: url,
			type: 'post',
			dataType: 'json',
			data: {
				user_id: $form.find('.select2-container.user-id').select2('val'),
				user_role_id: $form.find('.select2-container.user-role-id').select2('val'),
				user_payed_hours: $form.find('.user-payed-hours').val()
			}
		})
		.done(function(data) {
			if (data.status != true) {
				noty({
					text: "Данный пользователь с таким статусом уже существует!", 
					timeout: 2500, 
					layout: "topCenter", 
					type: "error"
				});
			} else {
				var decoded = $('<div/>').html(data.view).text();

				// Append new user relation select form
				$userSelectList.append(decoded);
				$userSelectList.find('li:last').slideDown('fast');

				$('select').select2();
			};
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			$this.removeClass('.active').removeAttr('disabled');
		});

		e.preventDefault();
	});


	// Remove user from the task
	$('body').on('click', '.remove-user-from-task', function(e) {
		var $this = $(this),
			url = "{{ URL::route('removeUserFromTask', $task_id) }}";

		$this.addClass('.active').attr('disabled', 'disabled');
		$this.siblings('.user-role-id').attr('disabled', 'disabled');

		$.ajax({
			url: url,
			type: 'post',
			dataType: 'json',
			data: {
				user_id: $this.data('user-id'),
				user_role_id: $this.siblings('.user-role-id').select2('val')
			}
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			$this.removeClass('.active').closest('li').slideUp('fast');
		});

		e.preventDefault();
	});


	// Change user role
	$('body').on('change', '#user-selected-list .user-role-id', function(e) {
		var $this = $(this),
			currentVal = $this.select2('val'),
			prevVal = $this.data('current-val'),
			url = "{{ URL::route('changeUserTaskRole', $task_id) }}";

		$this.data('current-val', currentVal);
		$this.attr('disabled', 'disabled');
		$this.siblings('.remove-user-from-task').attr('disabled', 'disabled');

		$.ajax({
			url: url,
			type: 'post',
			dataType: 'json',
			data: {
				user_id: $this.data('user-id'),
				user_role_id: currentVal,
				prev_user_role_id: prevVal
			}
		})
		.done(function(data) {
			if (data.status != true) {
				$this.select2('val', prevVal);

				noty({
					text: "Данный пользователь с таким статусом уже существует!", 
					timeout: 2500, 
					layout: "topCenter", 
					type: "error"
				});
			};

			$this.removeAttr('disabled');
			$this.siblings('.remove-user-from-task').removeAttr('disabled');
		});

		e.preventDefault();
	});


	// Change user payed hours
	$('body').on('change', '#user-selected-list .update-user-payed-hours', function(e) {
		var $this = $(this),
			$select = $this.siblings('select.user-role-id'),
			url = "{{ URL::route('changeUserTaskPayedHours', $task_id) }}";

		$this.attr('disabled', 'disabled');
		$select.attr('disabled', 'disabled');
		$this.siblings('.remove-user-from-task').attr('disabled', 'disabled');

		$.ajax({
			url: url,
			type: 'post',
			dataType: 'json',
			data: {
				user_id: $this.data('user-id'),
				user_role_id: $select.val(),
				user_payed_hours: $this.val()
			}
		})
		.done(function(data) {
			$this.removeAttr('disabled');
			$select.removeAttr('disabled');
			$this.siblings('.remove-user-from-task').removeAttr('disabled');
		});

		e.preventDefault();
	});
</script>