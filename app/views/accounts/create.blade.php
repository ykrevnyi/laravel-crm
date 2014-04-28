<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="text-center">Счет: <span class="create-account-title">новый счет</span></h1>
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
			
			{{ Form::open(array('route' => 'accounts.store', 'class' => 'form-horizontal')) }}
				<div class="form-group">
					{{ Form::label('name', 'Название', array('class' => 'col-sm-3 control-label')) }}
					<div class="col-sm-9">
						{{ Form::text('name', Input::old('name', ''), array('class' => '2way-binding form-control', 'autofocus', 'data-binding' => 'create-account-title')) }}
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