<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="text-center">Список всех счетов</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 text-center">
			{{ HTML::linkRoute('accounts.create', 'Добавить новый счет', array(), array('class' => 'btn btn-info')) }}
		</div>
	</div>

	<br>

	<div class="row">
		<div class="col-lg-12">
			<table class="table">
				<tr>
					<th>№</th>
					<th>Название</th>
					<th class="text-right">Действие</th>
				</tr>
				@foreach ($accounts as $account)
					<tr>
						<td>{{ $account->id }}</td>
						<td>{{ $account->name }}</td>
						<td class="text-right">
							{{ Form::open(array('route' => array('accounts.destroy', 'id' => $account->id), 'method' => 'delete')) }}
							{{ HTML::linkRoute('accounts.edit', 'Редактировать', array('id' => $account->id), array('class' => 'btn btn-default')) }}
							
								{{ Form::submit('Удалить', array('class' => 'btn btn-danger')) }}
							{{ Form::close() }}
						</td>
					</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>