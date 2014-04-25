<!-- New task form -->
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right slow-loader" id="task-form"></nav>

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
					<th>Название {{empty($related_tasks)}}</th>
					<th>Короткое описание</th>
					<th>Создана</th>
					<th>Учет времени</th>
					<th></th>
				</tr>

				@foreach ($related_tasks as $task)
					<tr>
						<td>{{ $task->id }}</td>
						<td>{{ $task->name }}</td>
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
			<a id="add-transaction" href="#" class="btn btn-info pull-right">Добавить</a>
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
							<a href="#" class="delete-transaction btn btn-danger" data-id="{{ $transaction->trans_id }}"><span class="glyphicon glyphicon-remove"></span></a>
						</td>
					</tr>
				@endforeach
			</table>
		@endif
	</div>

</div>


<script type="text/javascript">
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
		$.fancybox.open({
			href: '/transactions/modal',
			type: 'iframe',
			padding: 0,
			maxWidth: 780
		});

		e.preventDefault();
	});

	// Show form for creating new task
	var $taskForm = $('#task-form');

	// Show form for creating new task
	window.toggleTaskForm = function(e) {
		$('body').toggleClass('cbp-spmenu-push-toleft');
		$taskForm.toggleClass('cbp-spmenu-open');

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