<h1 class="text-center">creating new project</h1>

<div class="container">

	<div class="row">
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
							{{ Form::text('proj_name', '', array('class' => 'form-control')) }}
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
						{{ Form::label('proj_price', 'Цена', array('class' => 'col-sm-3 control-label')) }}
						<div class="col-sm-3">
							{{ Form::text('proj_price', '', array('class' => 'form-control')) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('proj_price_per_hour', 'Цена в час', array('class' => 'col-sm-3 control-label')) }}
						<div class="col-sm-3">
							{{ Form::text('proj_price_per_hour', '', array('class' => 'form-control')) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('proj_billed_hours', 'Проплаченых часов', array('class' => 'col-sm-3 control-label')) }}
						<div class="col-sm-3">
							{{ Form::text('proj_billed_hours', '', array('class' => 'form-control')) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('proj_actual_hours', 'Реальное затраченое время', array('class' => 'col-sm-3 control-label')) }}
						<div class="col-sm-3">
							{{ Form::text('proj_actual_hours', '', array('class' => 'form-control')) }}
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

					<div class="text-center">
						{{ Form::submit('Сохранить', array('class' => 'btn btn-success')) }}
					</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>

	<br>

</div>


<script type="text/javascript">
	var $userSelectList = $('#user-selected-list'),
		$form = $('#user-select-form'),
		userCnt = 0;

	// Add user to the project
	$('#submit-user-for-project').on('click', function(e) {
		var $this = $(this),
			url = "{{ URL::route('addUserToProject', '') }}";

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
			url = "{{ URL::route('removeUserFromProject', '') }}";

		$this.addClass('.active').attr('disabled', 'disabled');

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
	$('#user-selected-list .user-role-id').on('change', function(e) {
		var $this = $(this),
			currentVal = $this.select2('val'),
			prevVal = $this.data('current-val'),
			url = "{{ URL::route('changeUserProjectRole', '') }}";

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