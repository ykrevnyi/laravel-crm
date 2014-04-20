<div class="container">

	<div class="row">
		<div class="col-lg-12">
			<h1 class="text-center">
				{{$project->proj_name}}
				<span 
					class="label label-default" 
					style="background: {{$project->proj_priority_color}};"
				> </span>
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
			<h4>Общая информация</h4>

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
	</div>

	<div class="row">
		<div class="col-lg-12">
			<h4>Учет цены/времени</h4>

			<table class="table table-bordered">
				<tr>
					<th>Название</th>
					<th>Цена в час</th>
					<th>Затраченое время</th>
					<th>Сума</th>
				</tr>

				@foreach ($hours as $hour)
					<tr>
						<td>{{ $hour->name }}</td>
						<td>{{ $hour->price_per_hour }} $</td>
						<td>{{ $hour->total_hours }} ч.</td>
						<td>{{ $hour->total_price }} $</td>
					</tr>
				@endforeach

				<tr>
					<td class="text-right" colspan="3">Итого, за проект:</td>
					<td><b>{{ $total_project_price }} $</b></td>
				</tr>

				<tr>
					<td class="text-right" colspan="3">Оплачено:</td>
					<td><b>{{ $total_transaction_price }} $</b></td>
				</tr>

				<tr>
					<td class="text-right" colspan="3">Итого:</td>
					<td><b>{{ $project_balance }} $</b></td>
				</tr>
			</table>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<h4>Даты</h4>

			<table class="table table-bordered">
				<tr>
					<th>Дата сдачи</th>
					<th>Дата создания</th>
					<th>Обновлено</th>
				</tr>
				<tr>
					<td>{{$project->proj_end_date}}</td>
					<td>{{$project->proj_created_at}}</td>
					<td>{{$project->proj_updated_at}}</td>
				</tr>
			</table>
		</div>
	</div>

	<!-- Related users -->
	<div class="panel panel-default">
		<div class="panel-heading">Пользователи</div>

		<table class="table table-bordered">
			<tr>
				<th>Пользователь</th>
				<th>Статус</th>
				<th>Время</th>
			</tr>
			@foreach ($related_users as $user)
				<tr>
					<td>{{ $user->firstname . ' ' . $user->lastname }}</td>
					<td>
						@foreach ($user_roles as $role_key => $role)
							@if ($role_key == $user->user_role_id)
								{{ $role }}
							@endif
						@endforeach
					</td>
					<td>{{ $user->payed_hours }} ч.</td>
				</tr>
			@endforeach
		</table>
	</div>

	<!-- Transactions -->
	<div class="panel panel-default">
		<div class="panel-heading clearfix">
			<h5 class="pull-left">Транзакции</h5>
			<a id="add-transaction" href="#" class="btn btn-info pull-right">Добавить</a>
		</div>

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
						<td><span class="glyphicon glyphicon-arrow-left"></span></td>
				@else
					<tr class="success">
						<td><span class="glyphicon glyphicon-arrow-right"></span></td>
				@endif
					
					<td>{{ $transaction->trans_id }}</td>
					<td>{{ $transaction->trans_name }}</td>
					<td>{{ $transaction->trans_value }}</td>
					<td>{{ $transaction->trans_purpose }}</td>
					<td>{{ $transaction->money_account_name }}</td>
					<td>{{ $transaction->trans_created_at }}</td>
					<td>{{ $transaction->trans_updated_at }}</td>
					<td>
						<a href="#" class="delete-transaction btn btn-danger" data-id="{{ $transaction->trans_id }}">Удалить</a>
					</td>
				</tr>
			@endforeach
		</table>
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

	$('#add-transaction').on('click', function(e) {
		$.fancybox.open({
			href: '/transactions/modal',
			type: 'iframe',
			padding: 0,
			maxWidth: 780
		});

		e.preventDefault();
	});
</script>