<li class="list-group-item" style="display: none">
	<b>{{ $user->firstname . ' ' . $user->lastname }}</b> - 
	{{ Form::select('user_role_id', $user_roles, $user->user_role_id, array('class' => 'user-role-id', 'data-current-val' => $user->user_role_id, 'data-user-id' => $user->id)) }} 

	<span class="remove-user-prom-project btn btn-danger btn-xs" data-user-id="{{ $user->id }}">
		<span class="glyphicon glyphicon-remove"></span>
	</span>
</li>