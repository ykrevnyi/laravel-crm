<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="text-center">Должности пользователей</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 text-center">
			{{ HTML::linkRoute('users.roles.create', 'Добавить новую должность', array(), array('class' => 'btn btn-info')) }}
		</div>
	</div>

	<br>

	<div class="row">
		<div class="col-lg-12">
			<table class="table">
				<tr>
					<th>Название</th>
					<th>Цена в час</th>
					<th>Цена в час (сотрудника)</th>
					<th class="text-right">Действие</th>
				</tr>
				@foreach ($roles as $role)
					<tr>
						<td>{{ $role['name'] }}</td>
						<td>{{ $role['price_per_hour'] }}</td>
						<td>{{ $role['price_per_hour_payable'] }}</td>
						<td class="text-right">
							{{ Form::open(array('route' => array('users.roles.destroy', 'id' => $role['id']), 'method' => 'delete')) }}
							{{ HTML::linkRoute('users.roles.edit', 'Редактировать', array('id' => $role['id']), array('class' => 'btn btn-default')) }}
							
								{{ Form::submit('Удалить', array('class' => 'btn btn-danger remove-action')) }}
							{{ Form::close() }}
						</td>
					</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('.remove-action').on('click', function(e) {
		if ( ! confirm('Удалить?')) {
			e.preventDefault();
		}
	})
</script>