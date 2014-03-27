<h1>{{$project->proj_name}}</h1>

<table class="table table-bordered">
	<tr>
		<td>priority</td>
		<td>id</td>
		<td>status</td>
		<td>name</td>
		<td>desc_short</td>
		<td>desc</td>
		<td>persents</td>
		<td>price</td>
		<td>price_per_hour</td>
		<td>billed_hours</td>
		<td>actual_hours</td>

		<td>end_date</td>
		<td>create_at</td>
		<td>updated_at</td>
	</tr>
	<tr>
		<td style="background: {{$project->proj_priority_color}};"></td>
		<td>{{$project->proj_id}}</td>
		<td>{{$project->proj_status}}</td>
		<td>{{$project->proj_name}}</td>
		<td>{{$project->proj_desc_short}}</td>
		<td>{{$project->proj_desc}}</td>
		<td>{{$project->proj_persents}}</td>
		<td>{{$project->proj_price}}</td>
		<td>{{$project->proj_price_per_hour}}</td>
		<td>{{$project->proj_billed_hours}}</td>
		<td>{{$project->proj_actual_hours}}</td>

		<td>{{$project->proj_end_date}}</td>
		<td>{{$project->proj_created_at}}</td>
		<td>{{$project->proj_updated_at}}</td>
	</tr>
</table>

<h4>Related users</h4>

<ul>
	@foreach ($related_users as $user)
		<li>
			{{$user->firstname}} {{$user->lastname}}
			( {{$user->mail}} )
		</li>
	@endforeach
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