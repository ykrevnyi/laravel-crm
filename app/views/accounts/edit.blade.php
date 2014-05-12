<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="text-center">Счет: <span class="create-account-title">{{ $account->name }}</span></h1>
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
			
			{{ Form::open(array('route' => array('accounts.update', $account->id), 'method' => 'put', 'class' => 'form-horizontal')) }}
				<div class="form-group">
					{{ Form::label('name', 'Название', array('class' => 'col-sm-3 control-label')) }}
					<div class="col-sm-9">
						{{ Form::text('name', Input::old('name', $account->name), array('class' => '2way-binding form-control', 'autofocus', 'data-binding' => 'create-account-title')) }}
					</div>
				</div>

				<div class="form-group has-feedback">
					{{ Form::label('losses', 'Процент потерь', array('class' => 'col-sm-3 control-label')) }}
					<div class="col-sm-9">
						{{ Form::text('losses', Input::old('losses', $account->losses), array('class' => 'form-control')) }}
						<span class="form-control-feedback">%</span>
					</div>
				</div>

				<div class="form-group">
					{{ Form::label('currency_id', 'Валюта', array('class' => 'col-sm-3 control-label')) }}
					<div class="col-sm-9">
						{{ Form::select('currency_id', $currencies, $account->currency_id) }}
					</div>
				</div>

				<div class="form-group text-center">
					{{ HTML::linkRoute('accounts.index', 'Отменить', array(), array('class' => 'btn btn-default')) }}

					<button class="btn btn-success" type="submit">
						Далее
						<span class="glyphicon glyphicon-chevron-right"></span>
					</button>
				</div>
				
			{{ Form::close() }}

		</div>
	</div>
</div>