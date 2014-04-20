<div class="container">
	
	<div class="row">
		<div class="col-lg-9">
			<h1>Список проектов</h1>
		</div>
		<div class="col-lg-3 text-right">
			{{ HTML::linkRoute('projects.create', 'Создать проект', array(), array('class' => 'btn btn-info')) }}
		</div>
	</div>


	<div class="row">
		<div class="col-lg-12">

			<table class="table">
				<tr>
					<th width="50"></th>
					<th>№</th>
					<th>Статус</th>
					<th>Название</th>
					<th>Короткое описание</th>

					<th>Создан</th>
					<th>Дата сдачи</th>

					<th></th>
				</tr>

				@foreach ($project_list as $project)
					<tr>
						<td style="background: {{$project->proj_priority_color}};"></td>
						<td>{{$project->proj_id}}</td>
						<td>{{$project->proj_status}}</td>
						<td>
							{{ HTML::linkRoute('projects.show', $project->proj_name, array('id' => $project->proj_id)) }}
						</td>
						<td>{{$project->proj_desc_short}}</td>

						<td>{{$project->proj_created_at}}</td>
						<td>{{$project->proj_end_date}}</td>

						<td>{{ HTML::linkRoute('projects.edit', 'Редактировать', array('id' => $project->proj_id)) }}</td>
					</tr>
				@endforeach
			</table>

		</div>
	</div>
</div>