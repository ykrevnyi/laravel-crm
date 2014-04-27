<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="text-center">Управление приоритетами</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 text-center">
			{{ HTML::linkRoute('priorities.create', 'Добавить новый приоритет', array(), array('class' => 'btn btn-info')) }}
		</div>
	</div>

	<br>

	<div class="row">
		<div class="col-lg-12">
			<table class="table">
				<tr>
					<th>№</th>
					<th>Название</th>
					<th>Цвет</th>
					<th class="text-right">Действие</th>
				</tr>
				@foreach ($priorities as $priority)
					<tr>
						<td>{{ $priority->id }}</td>
						<td>{{ $priority->name }}</td>
						<td>
							<div style="width: 20px; height: 20px; background: {{ $priority->color }}; float: left;"></div> 
							<i>{{ $priority->color }}</i>
						</td>
						<td class="text-right">
							{{ Form::open(array('route' => array('priorities.destroy', 'id' => $priority->id), 'method' => 'delete')) }}
							{{ HTML::linkRoute('priorities.edit', 'Редактировать', array('id' => $priority->id), array('class' => 'btn btn-default')) }}
							
								{{ Form::submit('Удалить', array('class' => 'btn btn-danger')) }}
							{{ Form::close() }}
						</td>
					</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>