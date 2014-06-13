<div class="container">
	<h1>Список пользователей</h1>

	<!-- List all users -->
	@if (count($data['users']))
		<table class="table">
			<tr>
				<th>Login:</th>
				<th>Full name:</th>
				<th>Email:</th>
				<th>Actions:</th>
			</tr>
			@foreach ($data['users'] as $user)
				<tr>
					<td>{{ $user->login }}</td>
					<td>
						{{ HTML::linkRoute('users.show', $user->firstname . ' ' . $user->lastname, array('id' => $user->id)) }}
					</td>
					<td>{{ $user->mail }}</td>
					<td>
						@if ($user->level == 'user')
							<a href="#" data-user-id="{{ $user->id }}" data-perm="0" class="action-change-perm btn btn-default active">user</a>
						@else
							<a href="#" data-user-id="{{ $user->id }}" data-perm="0" class="action-change-perm btn btn-default">user</a>
						@endif

						@if ($user->level == 'teammate')
							<a href="#" data-user-id="{{ $user->id }}" data-perm="500" class="action-change-perm btn btn-default active">teammate</a>
						@else
							<a href="#" data-user-id="{{ $user->id }}" data-perm="500" class="action-change-perm btn btn-default">teammate</a>
						@endif

						@if ($user->level == 'admin')
							<a href="#" data-user-id="{{ $user->id }}" data-perm="5000" class="action-change-perm btn btn-default active">admin</a>
						@else
							<a href="#" data-user-id="{{ $user->id }}" data-perm="5000" class="action-change-perm btn btn-default">admin</a>
						@endif
					</td>
				</tr>
			@endforeach
		</table>
	@else
		<h2>no users in system :(</h2>
	@endif

	{{ $data['links'] }}

</div>

<script type="text/javascript">
	$(document).on('ready', function() {
		$('.action-change-perm').on('click', function(e) {
			var $this = $(this);

			$.ajax({
				url: '/users/' + $this.data('user-id'),
				method: 'put',
				dataType: 'json',
				data: {
					perm: $this.data('perm')
				}
			}).done(function(resp) {
				if (resp.error) {
					noty({
						text: resp.error, 
						timeout: 2500, 
						layout: "topCenter", 
						type: "alert"
					});
				} else {
					$this
						.siblings().removeClass('active')
						.end().addClass('active');
				}

				console.log(resp)
			});

			e.preventDefault();
		});
	});
</script>