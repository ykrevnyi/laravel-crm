<div class="container">

	{{ Form::open(array('route' => 'attempt', 'class' => 'form-signin')) }}
		<h2 class="form-signin-heading">Please sign in</h2>
		
		{{ Form::email('email', '', array('class' => 'form-control', 'placeholder' => 'Email', 'autofocus')) }}
		
		{{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password')) }}

		<label class="checkbox">
			{{ Form::hidden('remember', '0') }}
			{{ Form::checkbox('remember', '1', '0')}} Remember me
		</label>

		{{ Form::submit('Sign in', array('class' => 'btn btn-lg btn-primary btn-block', 'type' => 'submit')) }}
	{{ Form::close() }}

	
	@if ($errors->count())
		<ul>
			<li>{{ $errors->first('email'); }}</li>
			<li>{{ $errors->first('password'); }}</li>
		</ul>
	@endif

	{{-- Show if user is not exists --}}
	@if (Session::has('redmine_user_error'))
		{{ Session::get('redmine_user_error') }}
	@endif

</div>