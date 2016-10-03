<form id="approval-confirmation-form" class="form-horizontal" method="POST" action="{{ route( 'user::' . $route . '.approvals.confirm', compact('id')) }}">
	
	{!! csrf_field() !!}

	<select id="confirmation-select" name="confirmation-select">
	@if( $status == 'APPROVED' )
		<option value="reject" selected>Reject</option>
	@elseif( $status == 'REJECTED' )
		<option value="approve" selected>Approve</option>
	@else
		<option value="approve">Approve</option>
		<option value="reject" selected>Reject</option>
	@endif
	</select>
	<input id="approval-approve-btn" class="btn btn-success btn-flat" type="submit" value="Confirm"></input>
</form>
