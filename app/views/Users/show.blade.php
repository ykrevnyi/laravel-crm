<?php 
	$monthes = array(
	    1 => 'Января', 2 => 'Февраля', 3 => 'Марта', 4 => 'Апреля',
	    5 => 'Мая', 6 => 'Июня', 7 => 'Июля', 8 => 'Августа',
	    9 => 'Сентября', 10 => 'Октября', 11 => 'Ноября', 12 => 'Декабря'
	);
?>

<!-- Project info -->
<div class="container">

	<div class="row page-filter">
		<div class="col-lg-12">
			<form action="" class="user-filter-form text-center">
				<div id="reportrange" class="pull-left">
				    <i class="glyphicon glyphicon-time"></i>
				    <span>
				    	<?php echo($date_from_formated->format('j ') . $monthes[ $date_from_formated->format('n') ] . $date_from_formated->format(' Y')); ?>
				    	 - 
				    	<?php echo($date_to_formated->format('j ') . $monthes[ $date_to_formated->format('n') ] . $date_to_formated->format(' Y')); ?>
			    	</span>
				    <b class="caret"></b>
				</div>

				<input type="hidden" name="date_from" id="date_from" value="{{ $date_from }}">
				<input type="hidden" name="date_to" id="date_to" value="{{ $date_to }}">

				<button type="submit" class="filter-search-btn btn btn-info">
					<span class="glyphicon glyphicon-search"></span>
				</button>
			</form>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<h2>{{ $user->firstname }} {{ $user->lastname }}</h2>

			<table class="table">
				<tr>
					<th>Email</th>
					<th>Уровень доступа</th>
					<th>Телефон</th>
					<th>Адрес</th>
					<th>Skype</th>
					<th>День рождения</th>
				</tr>
				<tr>
					<td>{{ $user->mail or '-' }}</td>
					<td>{{ $user->level or '-' }}</td>
					<td>{{ $user->phone or '-' }}</td>
					<td>{{ $user->address or '-' }}</td>
					<td>{{ $user->skype or '-' }}</td>
					<td>{{ $user->birthday or '-' }}</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<h2>Проекты</h2>
		</div>
	</div>

	<ul class="nav nav-tabs">
		<li class="active">
			<a href="#basic" data-toggle="tab">Информация</a>
	    </li>
	    <li>
	    	<a href="#related-transactions" data-toggle="tab">
	    		Транзакции
	    		<span class="badge">{{ count($transactions) }}</span>
    		</a>
	    </li>
	    <li>
	    	<a href="#related-projects" data-toggle="tab">
	    		Проекты
	    		<span class="badge">{{ count($projects) }}</span>
    		</a>
	    </li>
	    <li>
	    	<a href="#related-tasks" data-toggle="tab">
	    		Задания
	    		<span class="badge">{{ count($tasks) }}</span>
    		</a>
	    </li>
	    @if (count($user_persents_price['tasks']))
		    <li>
		    	<a href="#user-percents" data-toggle="tab">
		    		Проценты задач
		    		<span class="badge">{{ count($user_persents_price['tasks']) }}</span>
	    		</a>
		    </li>
	    @endif
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">

	    <!-- Basic info -->
	    <div class="tab-pane active" id="basic">
	    	<table class="table table-bordered">
	    		<tr>
	    			<td class="text-right" width="50%"><b>Сума</b></td>
	    			<td>{{ $total_price }} $</td>
	    		</tr>
	    		<tr>
	    			<td class="text-right" width="50%"><b>Оплачено</b></td>
	    			<td>{{ $total_transaction_price }} $</td>
	    		</tr>
	    		<tr>
	    			<td class="text-right" width="50%"><b>
	    				@if ($user_balance > 0)
	    					Кредит
	    				@elseif ($user_balance == 0)
	    					Остаток
	    				@else
	    					Дебет
	    				@endif
	    			</b></td>
	    			<td>{{ abs($user_balance) }} $</td>
	    		</tr>
	    	</table>
	    </div>

	    <!-- Related transactions -->
	    <div class="tab-pane" id="related-transactions">
	    	@if ( ! count($transactions))
				<div class="empty-message text-center">
					<span class="glyphicon glyphicon-transfer"></span>
					<h3>Нет транзакций :(</h3>
				</div>
			@else
				<table class="vertical-aligned table table-bordered">
					<tr>
						<th></th>
						<th>№</th>
						<th>Название</th>
						<th>Кол-во</th>
						<th>Назначение</th>
						<th>Счет</th>
						<th>Создана</th>
						<th>Обновлена</th>
						<th></th>
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

	    <!-- Related projects -->
	    <div class="tab-pane" id="related-projects">
	    	@if ($projects)
	    		<h3 class="text-center">Итого по проектам - {{ $total_price }} $</h3>

				@foreach ($projects as $project)
					<table class="table table-bordered">
						<tr>
							<th class="text-center active" colspan="4">{{ $project['name'] }}</th>
						</tr>
						<tr>
							<th>Должность</th>
							<th>Сума</th>
						</tr>
						@foreach ($project['related_user_roles'] as $role)
							<tr>
								<td>{{ $role->role_name }}</td>
								<td>{{ $role->period_total_price }} $</td>
							</tr>
						@endforeach

						<tr>
							<th class="text-right">Итого</th>
							<th>{{ $project['total_price'] }} $</th>
						</tr>
					</table>
				@endforeach
			@else
				<div class="empty-message text-center">
					<span class="glyphicon glyphicon-briefcase"></span>
					<h3>Нет проектов :(</h3>
				</div>
			@endif
	    </div>

	    <!-- Related tasks -->
	    <div class="tab-pane" id="related-tasks">
	    	@if ($tasks)
	    		<h3 class="text-center">Итого по задачам - {{ $total_price }} $</h3>

	    		<table class="table table-bordered">
	    			<tr>
						<th>Задание</th>
						<th>Должность</th>
						<th>Время</th>
						<th>Цена за час</th>
						<th>Сума</th>
					</tr>
					@foreach ($tasks as $task)
						<tr>
							<td>{{ $task->name }}</td>
							<td>{{ $task->role_name }}</td>
							<td>{{ $task->payed_hours }} ч.</td>

							@if ($task->percents)
								<td>{{ $task->period_price_per_hour }} %</td>
								<td>{{ $task->total_task_price * $task->period_price_per_hour / 100 }} $</td>
							@else
								<td>{{ $task->period_price_per_hour }} $</td>
								<td>{{ $task->total_task_price }} $</td>
							@endif
						</tr>
					@endforeach
	    		</table>
			@else
				<div class="empty-message text-center">
					<span class="glyphicon glyphicon-tasks"></span>
					<h3>Нет задач :(</h3>
				</div>
			@endif
	    </div>

	    <!-- Calculated user percents -->
	    <div class="tab-pane" id="user-percents">
	    	@if (count($user_persents_price['tasks']))
	    		<h3 class="text-center">Итого по процентным ставкам - {{ $user_persents_price['total'] }} $</h3>

	    		<table class="table table-bordered vertical-aligned">
	    			<tr>
						<th>Задача</th>
						<th class="text-center">Ставка</th>
						<th class="text-center">Сума</th>
					</tr>
					@foreach ($user_persents_price['tasks'] as $task)
						<tr>
							<td class="table-container-td">
								@if (count($task['related_user_roles']))
									<table class="table table-bordered">
										<tr>
											<th>Должность</th>
											<th>Цена за час</th>
											<th>Часов</th>
											<th>Сума</th>
										</tr>
										@foreach ($task['related_user_roles'] as $related_role)
											<tr>
												<td>{{ $related_role->role_name }}</td>
												<td>{{ $related_role->price_per_hour }} $</td>
												<td>{{ $related_role->payed_hours }} ч.</td>
												<td>{{ $related_role->total_price }} $</td>
											</tr>
										@endforeach

										@if (count($task['percentable_roles']))
											<tr>
												<td class="text-right" colspan="3">
													<b>Участвует в задаче, как:</b>
													{{ implode(', ', $task['percentable_roles']) }}
												</td>
												<td>{{ $task['percents'] }} %</td>
											</tr>
										@endif

										<tr>
											<th class="text-right" colspan="3">Итого:</th>
											<th>{{ $task['total_price'] }} $</th>
										</tr>
									</table>
								@else
									-
								@endif
							</td>
							<td class="text-center">{{ $task['percents'] }} %</td>
							<td class="text-center">{{ $task['total_percent_price'] }} $</td>
						</tr>
					@endforeach
	    		</table>
			@else
				<div class="empty-message text-center">
					<span class="glyphicon glyphicon-tasks"></span>
					<h3>Нет задач %(</h3>
				</div>
			@endif
	    </div>
    </div>

</div>

<script type="text/javascript">
var monthStart = moment().startOf('month'),
	monthEnd = moment().endOf('month');

	// Init date range filter
	$('#reportrange').daterangepicker(
	    {
	      ranges: {
			'Этот месяц': [monthStart, monthEnd],
			'Прошлый месяц': [moment().startOf('month').subtract('month', 1), monthEnd],
			'2 месяца назад': [moment().startOf('month').subtract('month', 2), monthEnd],
			'3 месяца назад': [moment().startOf('month').subtract('month', 3), monthEnd],
			'6 месяцев назад': [moment().startOf('month').subtract('month', 6), monthEnd],
			'12 месяцев назад': [moment().startOf('month').subtract('month', 12), monthEnd]
	      },
	      format: 'DD-MM-YYYY',
	      startDate: "{{ $date_from }}",
	      endDate: "{{ $date_to }}"
	    },
	    function(start, end) {
	        $('#reportrange span').html(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));

	        $('#date_from').val(start.format('DD-MM-YYYY'));
	        $('#date_to').val(end.format('DD-MM-YYYY'));
	    }
	);
</script>