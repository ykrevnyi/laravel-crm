<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="text-center">
				Курс: <span class="create-currency-title">{{ $currency['name'] }}</span>
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
			
			{{ Form::open(array('route' => array('currencies.update', $currency['id']), 'method' => 'put', 'class' => 'form-horizontal')) }}
				<div class="form-group">
					{{ Form::label('name', 'Название', array('class' => 'col-sm-3 control-label')) }}
					<div class="col-sm-9">
						{{ Form::text('name', Input::old('name', $currency['name']), array('class' => '2way-binding form-control', 'data-binding' => 'create-currency-title', 'autofocus')) }}
					</div>
				</div>

				<div class="form-group has-feedback">
					{{ Form::label('price', 'Цена', array('class' => 'col-sm-3 control-label')) }}
					<div class="col-sm-9">
						{{ Form::text('price', Input::old('price', $currency['price']), array('class' => 'price-picker form-control')) }}
						<span class="form-control-feedback">{{ CURRENCY }}</span>
					</div>
				</div>

				<div class="form-group">
					{{ Form::label('unit', 'Подпись', array('class' => 'col-sm-3 control-label')) }}
					<div class="col-sm-9">
						{{ Form::text('unit', Input::old('unit', $currency['unit']), array('class' => 'unit-picker form-control')) }}
					</div>
				</div>

				<div class="form-group text-center">
					{{ HTML::linkRoute('currencies.index', 'Отменить', array(), array('class' => 'btn btn-default')) }}
					
					<button class="btn btn-success" type="submit">
						Далее
						<span class="glyphicon glyphicon-chevron-right"></span>
					</button>
				</div>
				
			{{ Form::close() }}

		</div>
	</div>
</div>