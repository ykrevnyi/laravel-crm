<h1>{{$project->proj_name}}</h1>

{{ Form::open(array('method'=>'DELETE', 'route'=>array('projects.destroy', $project->proj_id))) }}
	{{ Form::submit('remove project', array('onclick' => 'return confirm("Are you sure?")')) }}
{{ Form::close() }}

{{ Form::open(array('route' => array('projects.update', $project->proj_id), 'method' => 'put')) }}
	
	<p>
		{{ Form::label('proj_id', 'proj_id') }}
		{{ Form::text('proj_id', $project->proj_id, array('disabled')) }}
	</p>

	<p>
		{{ Form::label('proj_status', 'proj_status') }}
		{{ Form::select('proj_status', array(0 => 'В работе', 1 => 'Готов'), $project->proj_status) }}
	</p>

	<p>
		{{ Form::label('proj_name', 'proj_name') }}
		{{ Form::text('proj_name', $project->proj_name) }}
	</p>

	<p>
		{{ Form::label('proj_desc_short', 'proj_desc_short') }}
		{{ Form::textarea('proj_desc_short', $project->proj_desc_short) }}
	</p>

	<p>
		{{ Form::label('proj_desc', 'proj_desc') }}
		{{ Form::textarea('proj_desc', $project->proj_desc) }}
	</p>

	<p>
		{{ Form::label('proj_persents', 'proj_persents') }}
		{{ Form::text('proj_persents', $project->proj_persents) }}
	</p>

	<p>
		{{ Form::label('proj_price', 'proj_price') }}
		{{ Form::text('proj_price', $project->proj_price) }}
	</p>

	<p>
		{{ Form::label('proj_price_per_hour', 'proj_price_per_hour') }}
		{{ Form::text('proj_price_per_hour', $project->proj_price_per_hour) }}
	</p>

	<p>
		{{ Form::label('proj_billed_hours', 'proj_billed_hours') }}
		{{ Form::text('proj_billed_hours', $project->proj_billed_hours) }}
	</p>

	<p>
		{{ Form::label('proj_actual_hours', 'proj_actual_hours') }}
		{{ Form::text('proj_actual_hours', $project->proj_actual_hours) }}
	</p>

	<p>
		{{ Form::label('proj_end_date', 'proj_end_date') }}
		{{ Form::text('proj_end_date', $project->proj_end_date) }}
	</p>

	<p>
		Priority: 
		{{ Form::select('proj_priority_id', $priorities, $project->proj_priority_id) }}
	</p>

	<p>
		{{ Form::select('related_users[]', $users['all'], $users['selected'], array('multiple')) }}
	</p>

	{{ Form::submit('save project') }}
{{ Form::close() }}


<h4>Related users</h4>

<ul>
</ul>


<h4>Transaction list</h4>

<table class="table">
	<tr>
		<th>id</th>
		<th>name</th>
		<th>value</th>
		<th>is expense</th>
		<th>purpose</th>
		<th>money account</th>
		<th>created at</th>
		<th>updated at</th>
		<th>delete</th>
	</tr>

	@foreach ($transactions as $transaction)
		<tr>
			<td>{{ $transaction->trans_id }}</td>
			<td>{{ $transaction->trans_name }}</td>
			<td>{{ $transaction->trans_value }}</td>
			<td>{{ $transaction->trans_is_expense }}</td>
			<td>{{ $transaction->trans_purpose }}</td>
			<td>{{ $transaction->money_account_name }}</td>
			<td>{{ $transaction->trans_created_at }}</td>
			<td>{{ $transaction->trans_updated_at }}</td>
			<td><a href="#" class="delete-transaction" data-id="{{ $transaction->trans_id }}">remove</a></td>
		</tr>
	@endforeach
</table>