<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="text-center">Управление валютами</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 text-center">
			{{ HTML::linkRoute('currencies.create', 'Добавить новую валюту', array(), array('class' => 'btn btn-info')) }}
		</div>
	</div>

	<br>

	<div class="row">
		<div class="col-lg-12">
			<table class="table">
				<tr>
					<th>Название</th>
					<th>Цена</th>
					<th class="text-right">Действие</th>
				</tr>
				@foreach ($currencies as $currency)
					<tr>
						<td>{{ $currency['name'] }}</td>
						<td>{{ $currency['price'] }} {{ CURRENCY }}</td>
						<td class="text-right">
							{{ Form::open(array('route' => array('currencies.destroy', 'id' => $currency['id']), 'method' => 'delete')) }}
							{{ HTML::linkRoute('currencies.edit', 'Редактировать', array('id' => $currency['id']), array('class' => 'btn btn-default')) }}
							
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