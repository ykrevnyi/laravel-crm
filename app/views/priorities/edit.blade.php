<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="text-center">{{ $priority->name }}</h1>
		</div>
	</div>

	@if ($errors->count())
		<div class="row">
			<div class="col-lg-12">
				<div class="alert alert-danger">
					@foreach ($errors->all() as $error)
						{{ $error }} <br>
					@endforeach
				</div>
			</div>
		</div>
	@endif

	<div class="row">
		<div class="col-lg-12">
			
			{{ Form::open(array('route' => array('priorities.update', $priority->id), 'method' => 'put', 'class' => 'form-horizontal')) }}
				<div class="form-group">
					{{ Form::label('name', 'Название', array('class' => 'col-sm-3 control-label')) }}
					<div class="col-sm-9">
						{{ Form::text('name', Input::old('name', $priority->name), array('class' => 'form-control', 'autofocus')) }}
					</div>
				</div>

				<div class="form-group">
					{{ Form::label('color', 'Цвет', array('class' => 'col-sm-3 control-label')) }}
					<div class="col-sm-9">
						{{ Form::text('color', Input::old('color', $priority->color), array('class' => 'color-picker form-control')) }}
					</div>
				</div>

				<div class="form-group text-center">
					<button class="btn btn-success" type="submit">
						Далее
						<span class="glyphicon glyphicon-chevron-right"></span>
					</button>
				</div>
				
			{{ Form::close() }}

		</div>
	</div>
</div>