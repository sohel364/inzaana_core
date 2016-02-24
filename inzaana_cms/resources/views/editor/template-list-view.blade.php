<?php
$dirs=scandir("./templates");
for($i=2;$i<sizeof($dirs);$i++)
{		
?>
	<li>
		<a href="{{ route('user::templates') }}"><i class="fa"></i> {{$dirs[$i]}} <i class="fa fa-angle-left pull-right"></i></a>
		<ul class="treeview-menu">	
		<?php 
		$templates=scandir("./templates/$dirs[$i]");	
		for($j=2; $j<sizeof($templates);$j++)
		{
		?>
		 	<li>
		 		<a href="{{ route('user::templates.editor.browse', [ 'category' => $dirs[$i], 'template'=> $templates[$j] ]) }}"><i class="fa"></i> {{ $templates[$j] }}</a>
			</li>
		
		<?php 
		}
		?>
		</ul>
	</li>		
<?php 
}
?>
