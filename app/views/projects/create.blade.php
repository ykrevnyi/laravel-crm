<h1>New project</h1>

{{ Form::open(array('route' => array('projects.index'))) }}

	<p>
		{{ Form::label('proj_status', 'proj_status') }}
		{{ Form::select('proj_status', array(0 => 'В работе', 1 => 'Готов')) }}
	</p>

	<p>
		{{ Form::label('proj_name', 'proj_name') }}
		{{ Form::text('proj_name') }}
	</p>

	<p>
		{{ Form::label('proj_desc_short', 'proj_desc_short') }}
		{{ Form::textarea('proj_desc_short') }}
	</p>

	<p>
		{{ Form::label('proj_desc', 'proj_desc') }}
		{{ Form::textarea('proj_desc') }}
	</p>

	<p>
		{{ Form::label('proj_persents', 'proj_persents') }}
		{{ Form::text('proj_persents') }}
	</p>

	<p>
		{{ Form::label('proj_price', 'proj_price') }}
		{{ Form::text('proj_price') }}
	</p>

	<p>
		{{ Form::label('proj_price_per_hour', 'proj_price_per_hour') }}
		{{ Form::text('proj_price_per_hour') }}
	</p>

	<p>
		{{ Form::label('proj_billed_hours', 'proj_billed_hours') }}
		{{ Form::text('proj_billed_hours') }}
	</p>

	<p>
		{{ Form::label('proj_actual_hours', 'proj_actual_hours') }}
		{{ Form::text('proj_actual_hours') }}
	</p>

	<p>
		{{ Form::label('proj_end_date', 'proj_end_date') }}
		{{ Form::text('proj_end_date') }}
	</p>

	<p>
		Priority: 
		{{ Form::select('proj_priority_id', $priorities) }}
	</p>

	{{ Form::submit('save project') }}
{{ Form::close() }}