<tr>
                                      
<td>{{ $key or '' }}<input name="title_{{ $properties['id'] }}" type="text" value="{{ $key or '' }}" hidden></td>  

@if(!isset($is_operational_view) || $is_operational_view)                                         
<td>{{ $properties['view_type'] or '' }}<input name="option_{{ $properties['id'] }}" type="text" value="{{ $properties['view_type'] or '' }}" hidden></td>
@endif

<td>{{ $properties['values'] or '' }}<input name="values_{{ $properties['id'] }}" type="text" value="{{ $properties['values'] or '' }}" hidden></td>

@if(!isset($is_operational_view) || $is_operational_view)                                         
<td><a href="#" id="delete_me" class="btn btn-xs btn-danger">x</a></td>
@endif

</tr>