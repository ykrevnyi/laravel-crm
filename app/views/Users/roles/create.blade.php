<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="text-center">Добавить должность</h1>
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
			
			{{ Form::open(array('route' => 'users.roles.store', 'class' => 'form-horizontal')) }}
				<div class="form-group">
					{{ Form::label('name', 'Название', array('class' => 'col-sm-3 control-label')) }}
					<div class="col-sm-9">
						{{ Form::text('name', Input::old('name', ''), array('class' => 'form-control', 'autofocus')) }}
					</div>
				</div>

				<div class="form-group has-feedback">
					{{ Form::label('price_per_hour', 'Цена в час', array('class' => 'col-sm-3 control-label')) }}
					<div class="col-sm-9">
						{{ Form::text('price_per_hour', Input::old('price_per_hour', ''), array('class' => 'form-control')) }}
						<span class="glyphicon glyphicon-usd form-control-feedback"></span>
					</div>
				</div>

				<div class="form-group has-feedback">
					{{ Form::label('price_per_hour_payable', 'Цена в час (сотрудника)', array('class' => 'col-sm-3 control-label')) }}
					<div class="col-sm-9">
						{{ Form::text('price_per_hour_payable', Input::old('price_per_hour_payable', ''), array('class' => 'form-control')) }}
						<span class="glyphicon glyphicon-usd form-control-feedback"></span>
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