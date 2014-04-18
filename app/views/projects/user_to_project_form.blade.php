<li style="display: none">
	{{ $user->firstname . ' ' . $user->lastname }} 
	Role: 
	{{ Form::select('user_role_id', $user_roles, $user->user_role_id, array('class' => 'user-role-id')) }} 

	<span class="remove-user-prom-project btn btn-danger btn-xs" data-user-id="{{ $user->id }}">
		<span class="glyphicon glyphicon-remove"></span>
	</span>
</li>