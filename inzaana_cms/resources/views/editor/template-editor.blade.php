@extends('layouts.editor-master') 
@section('title', 'Edit Template') 

@section('header-style')
	<link href="{{ asset('editor_asset/css/main.css') }}" rel="stylesheet" />
	<link href="{{ asset('editor_asset/css/bootstrap.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('editor_asset/css/bootstrap-dialog.css') }}" rel="stylesheet" />
	<link href="{{ asset('editor_asset/css/jquery-ui.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('editor_asset/css/drag_drop_style.css') }}" rel="stylesheet" />
	<link href="{{ asset('editor_asset/css/control_palette.css') }}" rel="stylesheet" />
	<link href="{{ asset('editor_asset/css/control_template.css') }}" rel="stylesheet" />
	<link href="{{ asset('editor_asset/css/spectrum.css') }}" rel="stylesheet" />
	<link rel="stylesheet"
		href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet"
		href="{{ asset('editor_asset/css/jquery-te-1.4.0.css') }}">
	<link href="{{ asset('editor_asset/css/control_template.css') }}" rel="stylesheet" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link href="{{ asset('editor_asset/css/control_editor.css') }}" rel="stylesheet" />
@endsection

@section('header-script')
	<script>
		var isInEditor = true;
	</script>
	<script src="{{ asset('editor_asset/js/tinymce/tinymce.min.js') }}"></script>
	<script src="{{ asset('editor_asset/js/jquery-2.1.1.min.js') }}"></script>
	<script src="{{ asset('editor_asset/js/jquery.flexisel.js') }}"></script>
	<script src="{{ asset('editor_asset/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('editor_asset/js/bootstrap-dialog.js') }}"></script>
	<script src="{{ asset('editor_asset/js/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('editor_asset/js/spectrum.js') }}"></script>
	<script src="{{ asset('editor_asset/js/main.js') }}"></script>

	<?php
		include ("templates/$category_name/$template_name/header.html");
	?>
	<script src="{{ asset('editor_asset/js/savePage.js') }}"></script>
	<script src="{{ asset('editor_asset/js/drag_drop.js') }}"></script>
	<script src="{{ asset('editor_asset/js/menu.js') }}"></script>
	<script type="text/javascript" src="{{ asset('editor_asset/js/template_editor.js') }}"></script>
	<script type="text/javascript" src="{{ asset('editor_asset/js/jquery-te-1.4.0.min.js') }}"
			charset="utf-8"></script>
	<script src="{{ asset('editor_asset/js/outside-click.js') }}"></script>
	<script src="{{ asset('editor_asset/js/control_palette.js') }}"></script>
	<script src="{{ asset('editor_asset/js/jquery.path.js') }}"></script>
	<script src="{{ asset('editor_asset/js/control_editor.js') }}"></script>
@endsection

@section('content')
	<!-- <div> -->
		<!-- WE ALREADY HAVE ANOTHER SAVE BUTTON FOR IN MASTER PAGE - SO WE PUT HERE AS HIDDEN -->
<!-- 		<button class="template_save_btn btn btn-success hidden"
			onclick="savePage(user_id, template_id);" style="display: block;">Save
		</button> -->
		<!-- BELOW CANVAS IS MOVED TO MASTER PAGE WILL BE DEPRECATED IN FUTURE -->
		<!-- <canvas id="hidden-canvas" style="display:none"></canvas> -->
	<!-- </div> -->

	<br />
	<br />
	<br />

	<!-- Template Elements  Here -->

	<div id="frame" class="droppedFields">
		<div style="background-color: white;">
			<div class="container">
				<div class="navbar-header">
					<button data-target="#mainNav" data-toggle="collapse"
						class="navbar-toggle" type="button">
						<span class="sr-only">Toggle navigation</span> <span
							class="icon-bar"></span> <span class="icon-bar"></span> <span
							class="icon-bar"></span>
					</button>
				</div>
				<div id="mainNav" class="collapse navbar-collapse">
					@if( $isEdit )
					
						<ul id="menu" class="nav navbar-nav navbar">
							@foreach($viewMenus as $viewMenu)
								@if($viewMenu->content)
									<li>
										<a href="#" onclick="onMenuClick(this);">{{ $viewMenu->menu_title }}</a>
									</li>
								@endif
							@endforeach
							@if($viewMenus->count() > 0)
								<li class="add-menu"><a>+</a></li>
							@endif
						</ul>

					@else

						<?php include ("templates/$category_name/$template_name/menu.html");?>
					@endif
				</div>
			</div>
		</div>

		@include('editor.control-template')
		
		<div id="body" contentEditable="false" >
			@if(!$isEdit)
	        	<?php include ("templates/$category_name/$template_name/body.html");?>

				<div id="footer">
					<?php include ("templates/$category_name/$template_name/footer.html");?>
				</div>
	        @endif
	    </div>
	</div>

	<div id="control_palette" style="z-index: 100000000000000 !important">
		@include('editor.control-palette')
	</div>

	<div id="control_editor">
		@include('editor.control-editor')
	</div>
@endsection
