<div class="container">
	<h1>{{ $title }}</h1>

	<!-- List all users -->
	<table class="table">
		<tr>
			<th>Login:</th>
			<th>Full name:</th>
			<th>Email:</th>
		</tr>
		@foreach ($users as $user)
			<tr>
				<td>{{ $user->login }}</td>
				<td>{{ $user->firstname . ' ' . $user->lastname }}</td>
				<td>{{ $user->mail }}</td>
			</tr>
		@endforeach
	</table>

	{{ $users->links() }}

</div>