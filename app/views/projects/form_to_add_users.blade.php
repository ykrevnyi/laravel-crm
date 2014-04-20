<!-- Related users -->
<div class="panel panel-default">
	<div class="panel-heading">Пользователи</div>

	<div class="panel-body text-center">
		<div id="user-select-form">
			Имя: 
			{{ Form::select('related_users_list', $users, 0, array('class' => 'user-id')) }}

			Должность: 
			{{ Form::select('related_user_role_list', $user_roles, 0, array('class' => 'user-role-id')) }}

			{{ Form::text('user_payed_hours', '', array('class' => 'user-payed-hours form-control input-sm')) }} ч.

			<a id="submit-user-for-project" href="#" class="btn btn-xs btn-success">
				<span class="glyphicon glyphicon-plus"></span>
			</a>
		</div>
	</div>

	<ul class="list-group" id="user-selected-list"></ul>
</div>


<script type="text/javascript">
	$('select').select2();

	var $userSelectList = $('#user-selected-list'),
		$form = $('#user-select-form'),
		userCnt = 0;

	// Add user to the project
	$('#submit-user-for-project').on('click', function(e) {
		var $this = $(this),
			url = "{{ URL::route('addUserToProject', $project_id) }}";

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
			url = "{{ URL::route('removeUserFromProject', $project_id) }}";

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
			url = "{{ URL::route('changeUserProjectRole', $project_id) }}";

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


	// Change user payed hours
	$('body').on('change', '#user-selected-list .update-user-payed-hours', function(e) {
		var $this = $(this),
			$select = $this.siblings('select.user-role-id'),
			url = "{{ URL::route('changeUserProjectPayedHours', $project_id) }}";

		$this.attr('disabled', 'disabled');
		$select.attr('disabled', 'disabled');
		$this.siblings('.remove-user-prom-project').attr('disabled', 'disabled');

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
			$this.siblings('.remove-user-prom-project').removeAttr('disabled');
		});

		e.preventDefault();
	});
</script>