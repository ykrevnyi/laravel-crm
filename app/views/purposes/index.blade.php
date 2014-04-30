<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="text-center">Все назначения транзакций</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 text-center">
			{{ HTML::linkRoute('transactions.purposes.create', 'Добавить новое назначение', array(), array('class' => 'btn btn-info')) }}
		</div>
	</div>

	<br>

	<div class="row">
		<div class="col-lg-12">
			<table class="table">
				<tr>
					<th>Название</th>
					<th class="text-right">Действие</th>
				</tr>
				@foreach ($purposes as $purpose)
					<tr>
						<td>{{ $purpose->name }}</td>
						<td class="text-right">
							{{ Form::open(array('route' => array('transactions.purposes.destroy', 'id' => $purpose->id), 'method' => 'delete')) }}
								{{ HTML::linkRoute('transactions.purposes.edit', 'Редактировать', array('id' => $purpose->id), array('class' => 'btn btn-default')) }}
							
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