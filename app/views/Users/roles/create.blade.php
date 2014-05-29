<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="text-center">
				Должность: <span class="create-role-title">новая должность</span>
			</h1>
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
						{{ Form::text('name', Input::old('name', ''), array('class' => '2way-binding form-control', 'data-binding' => 'create-role-title', 'autofocus')) }}
					</div>
				</div>

				<div class="form-group has-feedback">
					{{ Form::label('price_per_hour', 'Цена в час', array('class' => 'col-sm-3 control-label')) }}
					<div class="col-sm-9">
						{{ Form::text('price_per_hour', Input::old('price_per_hour', ''), array('class' => 'form-control')) }}
						<span class="form-control-feedback">{{ CURRENCY }}</span>
					</div>
				</div>

				<div class="form-group has-feedback">
					{{ Form::label('price_per_hour_payable', 'Цена в час (сотрудника)', array('class' => 'col-sm-3 control-label')) }}
					<div class="col-sm-9">
						{{ Form::text('price_per_hour_payable', Input::old('price_per_hour_payable', ''), array('class' => 'form-control')) }}
						<span class="form-control-feedback">{{ CURRENCY }}</span>
					</div>
				</div>

				<div class="form-group has-feedback">
					{{ Form::label('percents', 'Цена зависит от процентов', array('class' => 'col-sm-3 control-label')) }}
					<div class="col-sm-9">
						@if (Input::old('percents'))
							<input type="checkbox" name="percents" class="iphone-checkbox" value="Y" checked>
						@else
							<input type="checkbox" name="percents" class="iphone-checkbox" value="Y">
						@endif
					</div>
				</div>

				<div class="form-group text-center">
					{{ HTML::linkRoute('users.roles.index', 'Отменить', array(), array('class' => 'btn btn-default')) }}

					<button class="btn btn-success" type="submit">
						Далее
						<span class="glyphicon glyphicon-chevron-right"></span>
					</button>
				</div>
				
			{{ Form::close() }}

		</div>
	</div>
</div>