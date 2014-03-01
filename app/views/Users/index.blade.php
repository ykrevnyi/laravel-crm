<div class="container">
	<h1>{{ $title }}</h1>

	<!-- If user logged in -->
	@if ($data['user'])
		<h3>Hello, {{ $data['user']['name'] }}</h3>
	@endif


	<!-- List all users -->
	<table class="table">
		<tr>
			<th>Name:</th>
			<th>Password:</th>
			<th>Active:</th>
		</tr>
		@foreach ($data['users'] as $user)
			<tr>
				<td>{{ $user->name }}</td>
				<td>{{ $user->password }}</td>
				<td>{{ $user->active }}</td>
			</tr>
		@endforeach
	</table>


</div>