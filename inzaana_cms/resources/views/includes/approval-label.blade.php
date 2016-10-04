
@if( $status == 'ON_APPROVAL' )
<span class="label label-warning">{{ $labelText }}</span>
@elseif( $status == 'REJECTED' )
<span class="label label-danger">{{ $labelText }}</span>
@elseif( $status == 'APPROVED' )
<span class="label label-success">{{ $labelText }}</span>
@endif