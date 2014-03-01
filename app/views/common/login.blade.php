<div class="login-wrapper">
    <a href="http://rm.xmarkup.ru/">
        <img class="logo" src="/public/img/logo.png" alt="logo">
    </a>

    <div class="box">
        <div class="content-wrap">
        	{{ Form::open(array('route' => 'attempt', 'class' => 'form-signin')) }}
				<h2 class="form-signin-heading">Авторизация</h2>
				
				{{ Form::text('email', '', array('class' => 'form-control', 'placeholder' => 'Эл. почта', 'autofocus')) }}
				
				{{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Пароль')) }}

				{{ Form::submit('Войти', array('class' => 'btn-glow primary login', 'type' => 'submit')) }}
			{{ Form::close() }}

			@if ($errors->count())
				<div class="alert alert-danger">
					<div>{{ $errors->first('email'); }}</div>
					<div>{{ $errors->first('password'); }}</div>
				</div>
			@endif

			{{-- Show if user is not exists --}}
			@if (Session::has('redmine_user_error'))
				<div class="alert alert-danger">
					{{ Session::get('redmine_user_error') }}
				</div>
			@endif
        </div>
    </div>

    <div class="no-account">
        <p>Нет аккаунта?</p>
        <a href="http://rm.xmarkup.ru/account/register">Зарегистрируйся</a>
    </div>
</div>