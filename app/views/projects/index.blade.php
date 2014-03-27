<table class="table table-bordered">
	<tr>
		<td>priority</td>
		<td>id</td>
		<td>status</td>
		<td>name</td>
		<td>desc_short</td>
		<td>persents</td>
		<td>price</td>
		<td>price_per_hour</td>
		<td>billed_hours</td>
		<td>actual_hours</td>

		<td>end_date</td>
		<td>create_at</td>
		<td>updated_at</td>

		<td></td>
	</tr>

	@foreach ($project_list as $project)
		<tr>
			<td style="background: {{$project->proj_priority_color}};"></td>
			<td>{{$project->proj_id}}</td>
			<td>{{$project->proj_status}}</td>
			<td>{{$project->proj_name}}</td>
			<td>{{$project->proj_desc_short}}</td>
			<td>{{$project->proj_persents}}</td>
			<td>{{$project->proj_price}}</td>
			<td>{{$project->proj_price_per_hour}}</td>
			<td>{{$project->proj_billed_hours}}</td>
			<td>{{$project->proj_actual_hours}}</td>

			<td>{{$project->proj_end_date}}</td>
			<td>{{$project->proj_created_at}}</td>
			<td>{{$project->proj_updated_at}}</td>
			<td>{{ HTML::linkRoute('projects.edit', 'edit', array('id' => $project->proj_id)) }}</td>
		</tr>
	@endforeach
</table>