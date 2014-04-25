<!-- New task form -->
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="task-form"></nav>

<!-- Project info -->
<div class="container">

	<div class="row">
		<div class="col-lg-12">
			<h1 class="text-center" style="color: {{$project->proj_priority_color}};">
				{{$project->proj_name}}
			</h1>
			<hr>
		</div>
	</div>

	<!-- Basic project information -->
	<div class="row">
		<div class="col-lg-12">
			<h4>Описание</h4>
			{{ $project->proj_desc }}
		</div>
	</div>

	<hr>

	<div class="row">
		<div class="col-lg-12">
			<ul class="nav nav-tabs">
			    <li class="active"><a href="#basic" data-toggle="tab">Общая информация</a>
			    </li>
			    <li><a href="#price" data-toggle="tab">Учет цены</a>
			    <li><a href="#related-users" data-toggle="tab">Связанные пользователи</a>
			    </li>
			    <li><a href="#timing" data-toggle="tab">Даты</a>
			    </li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
			    <!-- Basic info tab -->
			    <div class="tab-pane active" id="basic">
			    	<table class="table table-bordered">
						<tr>
							<th>№</th>
							<th>Статус проекта</th>
							<th>Готово (%)</th>
						</tr>
						<tr>
							<td>{{$project->proj_id}}</td>
							<td>{{$project->proj_status}}</td>
							<td>{{$project->proj_persents}}</td>
						</tr>
					</table>
			    </div>

			    <!-- Price table tab -->
			    <div class="tab-pane" id="price">
			    	@if (count($related_users_totals))
						<table class="table table-bordered">
							<tr>
								<th>Должность</th>
								<th>Сума</th>
							</tr>

							@foreach ($related_users_totals as $user)
								@if ($user->period_total_price)
									<tr>
										<td>{{ $user->role_name }}</td>
										<td>{{ $user->period_total_price }} $</td>
									</tr>
								@endif
							@endforeach

							<tr>
								<th class="text-right">Итого:</th>
								<th>{{ $total_project_price }} $</th>
							</tr>

							<tr>
								<th class="text-right">Оплачено:</th>
								<th>{{ $total_transaction_price }} $</th>
							</tr>

							<tr>
								<th class="text-right">Остаток:</th>
								<th>{{ $project_balance }} $</th>
							</tr>
						</table>
					@else
						<div class="no-users text-center">
							<span class="glyphicon glyphicon-user"></span>
							<h3>Нет пользователей</h3>
						</div>
					@endif
			    </div>

			    <!-- Related users tab -->
			    <div class="tab-pane" id="related-users">
			    	@if (count($related_users))
						<table class="table table-bordered">
							<tr>
								<th>Пользователь</th>
								<th>Должность</th>
								<th>Период действия цены</th>
								<th>Цена в час</th>
								<th>Время</th>
								<th>Сума</th>
							</tr>

							@foreach ($related_users as $user)
								<tr>
									<td>{{ $user->firstname . ' ' . $user->lastname }}</td>
									<td>{{ $user->role_name }}</td>
									<td>с <i>{{ $user->period_created_at }}</i> по <i>{{ $user->period_deprecated_at }}</i></td>
									<td>{{ $user->period_price_per_hour }} $</td>
									<td>{{ $user->payed_hours }} ч.</td>
									<td>{{ $user->period_total_price }} $</td>
								</tr>
							@endforeach

							<tr>
								<th colspan="5" class="text-right">Итого:</th>
								<th>{{ $total_project_price }} $</th>
							</tr>
						</table>
					@else
						<div class="no-users text-center">
							<span class="glyphicon glyphicon-user"></span>
							<h3>Нет пользователей</h3>
						</div>
					@endif
			    </div>

			    <!-- Dates tab -->
			    <div class="tab-pane" id="timing">
			    	<table class="table table-bordered">
						<tr>
							<th>Дата сдачи</th>
							<th>Дата создания</th>
							<th>Обновлено</th>
						</tr>
						<tr>
							<td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($project->proj_end_date))->diffForHumans() }} <i>({{ $project->proj_end_date }})</i></td>
							<td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($project->proj_created_at))->diffForHumans() }} <i>({{ $project->proj_created_at }})</i></td>
							<td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($project->proj_updated_at))->diffForHumans() }} <i>({{ $project->proj_updated_at }})</i></td>
						</tr>
					</table>
			    </div>
			</div>

		</div>
	</div>


	<!-- Related tasks -->
	<div class="panel panel-default">
		<div class="panel-heading clearfix">
			<h5 class="pull-left">Задачи</h5>
			<a href="#" class="show-task-form-btn btn btn-info pull-right">Добавить</a>
		</div>

		@if (empty($related_tasks))
			<h3 class="text-center">Задач пока нет - можно отдыхать ^^</h3>
		@else
			<table class="vertical-aligned table table-bordered">
				<tr>
					<th>№</th>
					<th>Название</th>
					<th>Короткое описание</th>
					<th>Создана</th>
					<th>Учет времени</th>
					<th></th>
				</tr>

				@foreach ($related_tasks as $task)
					<tr>
						<td>{{ $task->id }}</td>
						<td>
							<a href="#" class="edit-task-action" data-id="{{ $task->id }}">{{ $task->name }}</a>
						</td>
						<td>{{ $task->short_description }}</td>
						<td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($task->created_at))->diffForHumans() }}</td>
						
						<td class="table-container-td">
							@if (count($task->related_users))
								<table class="table table-bordered">
									<tr>
										<th>Имя</th>
										<th>Должность</th>
										<th>Цена за час</th>
										<th>Часов</th>
										<th>Сума</th>
									</tr>
									@foreach ($task->related_users as $task_user)
										<tr>
											<td>{{ $task_user->firstname }} {{ $task_user->lastname }}</td>
											<td>{{ $task_user->role_name }}</td>
											<td>{{ $task_user->price_per_hour }} $</td>
											<td>{{ $task_user->payed_hours }} ч.</td>
											<td>{{ $task_user->total_price }} $</td>
										</tr>
									@endforeach

									<tr>
										<th colspan="4" class="text-right">Итого</th>
										<th>{{ $task->total_task_price }} $</th>
									</tr>
								</table>
							@else
								-
							@endif
						</td>
						
						<td class="text-center">
							<a href="#" class="delete-task btn btn-danger btn-sm" data-id="{{ $task->id }}"><span class="glyphicon glyphicon-remove"></span></a>
						</td>
					</tr>
				@endforeach
			</table>
		@endif
	</div>

	<!-- Transactions -->
	<div class="panel panel-default">
		<div class="panel-heading clearfix">
			<h5 class="pull-left">Транзакции</h5>
			<a id="add-transaction" data-transaction-object-type="project" href="#" class="btn btn-info pull-right">Добавить</a>
		</div>

		@if ( ! count($transactions))
			<h3 class="text-center">Нет транзакций :.(</h3>
		@else
			<table class="vertical-aligned table table-bordered">
				<tr>
					<th></th>
					<th>№</th>
					<th>Название</th>
					<th>Кол-во</th>
					<th>Цель</th>
					<th>Счет</th>
					<th>Создана</th>
					<th>Обновлена</th>
					<th>Удалить</th>
				</tr>

				@foreach ($transactions as $transaction)
					@if ($transaction->trans_is_expense)
						<tr class="active">
							<td class="text-center"><span class="glyphicon glyphicon-arrow-left"></span></td>
					@else
						<tr class="success">
							<td class="text-center"><span class="glyphicon glyphicon-arrow-right"></span></td>
					@endif
						
						<td>{{ $transaction->trans_id }}</td>
						<td>{{ $transaction->trans_name }}</td>
						<td>{{ $transaction->trans_value }}</td>
						<td>{{ $transaction->trans_purpose }}</td>
						<td>{{ $transaction->money_account_name }}</td>
						<td>{{ $transaction->trans_created_at }}</td>
						<td>{{ $transaction->trans_updated_at }}</td>
						<td class="text-center">
							<a href="#" class="delete-transaction btn btn-danger btn-sm" data-id="{{ $transaction->trans_id }}"><span class="glyphicon glyphicon-remove"></span></a>
						</td>
					</tr>
				@endforeach
			</table>
		@endif
	</div>

</div>


<script type="text/javascript">
	// Show form for creating new task
	var $taskForm = $('#task-form');

	// Create new task
	var submitTaskForm = function(e) {
		var $this = $(this);

		$taskForm.addClass('slow-loader');
		$this.find('.create-task-btn').attr('disabled', 'disabled');

		$.ajax({
			url: $this.attr('action'),
			type: $this.data('method') || 'post',
			dataType: 'json',
			data: {
				project_id: "{{ $project->proj_id }}",
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
				// If it was PUT request (update task)
				// we will simply close the window without doing anything
				if ($this.data('method') =='put') {
					closeTask();
				} else {
					// Append and show users form
					var decoded = $('<div/>').html(json.view).text();

					$('#related-users-container-ajax').html(decoded);
					$('.task-create-wizzard').addClass('step-2');

					// Disable all the fields
					$('#create-task-form')
						.find('input[type=text], textarea')
						.attr('disabled', 'disabled');

					// Close form on click `.create-task-btn`
					$this.find('.create-task-btn')
						.removeAttr('disabled')
						.html('Сохранить')
						.off('click')
						.on('click', closeTask);
				};
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
	};

	// Clear task form data and closes it
	var closeTask = function(e) {
		$('#create-task-form').off('submit');
		$('.create-task-btn').off('click');
		$('.close-task-form-btn').off('click');

		// Remove users form
		$('#related-users-container-ajax').html('');
		$taskForm.html('');

		// Close form and clear binding (from title)
		window.toggleTaskForm();
		window.drop2wayBinding();

		if (e != undefined) {
			e.preventDefault();
		};
	};


	// Remove transaction
	$('.delete-transaction').on('click', function(e) {
		var $this = $(this);

		$this.attr('disabled', 'disabled');

		$.ajax({
			url: '/transactions/' + $this.data('id'),
			dataType: 'json',
			method: 'delete'
		}).done(function(resp) {
			if (resp.error) {
				noty({
					text: resp.error, 
					timeout: 2500, 
					layout: "topCenter", 
					type: "error"
				});
			} else {
				$this.closest('tr').remove();

				noty({
					text: resp.success, 
					timeout: 2500, 
					layout: "topCenter", 
					type: "success"
				});
			}

			$this.removeAttr('disabled', 'disabled');
		});

		e.preventDefault();
	});

	// Open new transaction form in popup
	$('#add-transaction').on('click', function(e) {
		var relationType = $(this).data('transaction-object-type') || 'none';

		$.fancybox.open({
			href: "/transactions/modal/" + relationType + "/{{ $project->proj_id }}",
			type: 'iframe',
			padding: 0,
			maxWidth: 780
		});

		e.preventDefault();
	});

	// Show form for creating new task
	window.toggleTaskForm = function(e) {
		$('body').toggleClass('cbp-spmenu-push-toleft');
		$taskForm.toggleClass('cbp-spmenu-open');

		// Set loading state
		$taskForm.addClass('slow-loader');

		if (e != undefined) {
			e.preventDefault();
		};
	};

	// Load task form
	$('.show-task-form-btn').on('click', function(e) {
		toggleTaskForm();

		$.ajax({
			url: '/projects/{{ $project->proj_id }}/tasks/create',
			type: 'get',
			dataType: 'html'
		})
		.done(function(html) {
			$taskForm.removeClass('slow-loader').html(html);
		});

		e.preventDefault();
	});

	// Load task form
	$('.edit-task-action').on('click', function(e) {
		toggleTaskForm();

		$.ajax({
			url: '/projects/{{ $project->proj_id }}/tasks/' + $(this).data('id') + '/edit',
			type: 'get',
			dataType: 'html'
		})
		.done(function(html) {
			$taskForm.removeClass('slow-loader').html(html);
		});

		e.preventDefault();
	});

	// Remove task
	$('.delete-task').on('click', function(e) {
		var $this = $(this);

		$this.attr('disabled', 'disabled');

		$.ajax({
			url: '/projects/{{ $project->proj_id }}/tasks/' + $this.data('id'),
			dataType: 'json',
			method: 'delete'
		}).done(function(resp) {
			if (resp.status) {
				$this.closest('tr').remove();

				noty({
					text: "Задача удалена", 
					timeout: 2500, 
					layout: "topCenter", 
					type: "success"
				});
			} else {
				noty({
					text: "Ошибка удаления задачи", 
					timeout: 2500, 
					layout: "topCenter", 
					type: "error"
				});
			}

			$this.removeAttr('disabled', 'disabled');
		});

		e.preventDefault();
	});
</script>