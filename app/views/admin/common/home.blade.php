<div class="container">

	@if (Session::has('error'))
		<div class="alert alert-warning">{{ Session::get('error') }}</div>
	@endif

	<h1>{{ $title }}</h1>
</div>