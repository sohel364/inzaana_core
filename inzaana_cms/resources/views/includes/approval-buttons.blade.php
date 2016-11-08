<form id="approval-confirmation-form" class="form-horizontal" method="POST" action="{{ route( $route['namespace'] . $route['type'] . '.approvals.confirm', compact('id')) }}">
	
	{!! csrf_field() !!}

	<select id="confirmation-select" name="confirmation-select">
	@if( $status == 'APPROVED' )
		<option value="reject" selected>Unapprove</option>
		<option value="remove" selected>Remove</option>
	@elseif( $status == 'REJECTED' )
		<option value="approve" selected>Approve</option>
		<option value="remove" selected>Remove</option>
	@elseif( $status == 'ON_APPROVAL' )
		<option value="approve">Approve</option>
		<option value="reject" selected>Unapprove</option>
		<option value="remove" selected>Remove</option>
	@endif
	</select>
	<input id="approval-approve-btn" class="btn btn-success btn-flat" type="submit" value="Confirm"></input>
</form>
