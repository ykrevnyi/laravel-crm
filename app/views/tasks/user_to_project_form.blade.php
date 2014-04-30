<li class="list-group-item" style="display: none">
	<b>{{ $user->firstname . ' ' . $user->lastname }}</b> 
	{{ Form::select('user_role_id', $user_roles, $user->user_role_id, array('class' => 'user-role-id', 'data-current-val' => $user->user_role_id, 'data-user-id' => $user->id)) }} 

	@if (in_array($user->user_role_id, $persentable_roles))
		{{ Form::text('user_payed_hours', $user->payed_hours, array('class' => 'update-user-payed-hours user-payed-hours form-control input-sm', 'data-user-id' => $user->id, 'disabled' => 'disabled')) }} ч.
	@else
		{{ Form::text('user_payed_hours', $user->payed_hours, array('class' => 'update-user-payed-hours user-payed-hours form-control input-sm', 'data-user-id' => $user->id)) }} ч.
	@endif

	<span class="remove-user-from-task btn btn-danger btn-xs" data-user-id="{{ $user->id }}">
		<span class="glyphicon glyphicon-remove"></span>
	</span>
</li>

<script type="text/javascript">
	// Set roles to ban
	window.persentableRoles = [ {{ implode(',', $persentable_roles) }} ];
</script>