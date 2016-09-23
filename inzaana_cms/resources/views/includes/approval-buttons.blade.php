
@if( $status == 'APPROVED' )
  <button type="button" class="btn btn-danger">Reject</button>
@elseif( $status == 'REJECTED' )
  <button type="button" class="btn btn-success">Approve</button>
@else
  <button type="button" class="btn btn-success">Approve</button>
  <button type="button" class="btn btn-danger">Reject</button>
@endif