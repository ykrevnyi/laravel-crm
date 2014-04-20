<h1 class="text-center">{{$project->proj_name}}</h1>

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
							{{ Form::text('proj_name', $project->proj_name, array('class' => 'form-control')) }}
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
						{{ Form::label('proj_price', 'Цена', array('class' => 'col-sm-3 control-label')) }}
						<div class="col-sm-3">
							{{ Form::text('proj_price', $project->proj_price, array('class' => 'form-control')) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('proj_price_per_hour', 'Цена в час', array('class' => 'col-sm-3 control-label')) }}
						<div class="col-sm-3">
							{{ Form::text('proj_price_per_hour', $project->proj_price_per_hour, array('class' => 'form-control')) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('proj_billed_hours', 'Проплаченых часов', array('class' => 'col-sm-3 control-label')) }}
						<div class="col-sm-3">
							{{ Form::text('proj_billed_hours', $project->proj_billed_hours, array('class' => 'form-control')) }}
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

	<!-- Related users -->
	<div class="panel panel-default">
		<div class="panel-heading">Пользователи</div>

		<div class="panel-body text-center">
			<div id="user-select-form">
				Имя: 
				{{ Form::select('related_users_list', $users, 0, array('class' => 'user-id')) }}

				Должность: 
				{{ Form::select('related_user_role_list', $user_roles, 0, array('class' => 'user-role-id')) }}

				<a id="submit-user-for-project" href="#" class="btn btn-xs btn-success">
					<span class="glyphicon glyphicon-plus"></span>
				</a>
			</div>
		</div>

		<ul class="list-group" id="user-selected-list">
			@foreach ($related_users as $user)
				<li class="list-group-item">
					<b>{{ $user['fullname'] }}</b> - 
					{{ Form::select('user_role_id', $user_roles, $user['user_role_id'], array('class' => 'user-role-id', 'data-current-val' => $user['user_role_id'], 'data-user-id' => $user['id'])) }} 

					<span class="remove-user-prom-project btn btn-danger btn-xs" data-user-id="{{ $user['id'] }}">
						<span class="glyphicon glyphicon-remove"></span>
					</span>
				</li>
			@endforeach
		</ul>
	</div>
	
</div>


<script type="text/javascript">
	$('select').select2();

	var $userSelectList = $('#user-selected-list'),
		$form = $('#user-select-form'),
		userCnt = 0;

	// Add user to the project
	$('#submit-user-for-project').on('click', function(e) {
		var $this = $(this),
			url = "{{ URL::route('addUserToProject', $project->proj_id) }}";

		$this.addClass('.active').attr('disabled', 'disabled');

		$.ajax({
			url: url,
			type: 'post',
			dataType: 'json',
			data: {
				user_id: $form.find('.select2-container.user-id').select2('val'),
				user_role_id: $form.find('.select2-container.user-role-id').select2('val')
			}
		})
		.done(function(data) {
			if ( ! data.status) {
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


	// Remove user from the project
	$('body').on('click', '.remove-user-prom-project', function(e) {
		var $this = $(this),
			url = "{{ URL::route('removeUserFromProject', $project->proj_id) }}";

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
			url = "{{ URL::route('changeUserProjectRole', $project->proj_id) }}";

		$this.data('current-val', currentVal);
		$this.attr('disabled', 'disabled');
		$this.siblings('.remove-user-prom-project').attr('disabled', 'disabled');

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
			if ( ! data.status) {
				$this.select2('val', prevVal);

				noty({
					text: "Данный пользователь с таким статусом уже существует!", 
					timeout: 2500, 
					layout: "topCenter", 
					type: "error"
				});
			};

			$this.removeAttr('disabled');
			$this.siblings('.remove-user-prom-project').removeAttr('disabled');
		});

		e.preventDefault();
	});
</script>