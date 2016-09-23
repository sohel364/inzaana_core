
@if( $status == 'ON_APPROVAL' )
<span class="label label-warning">Pending</span>
@elseif( $status == 'REJECTED' )
<span class="label label-danger">Rejected</span>
@else
<span class="label label-success">Approved</span>
@endif