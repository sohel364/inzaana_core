<?php
session_start();
error_reporting ( E_ERROR );
$category;
$template;
$template_id;
if (isset ( $_POST ['template'] ) && isset ( $_POST ['category'] )) {
	$turl = '../../templates/' . $_POST ['category'] . '/' . $_POST ['template'];
	$css = '../../templates/' . $_POST ['category'] . '/' . $_POST ['template'] . '/css/*.css';
	$jsdir = '../../templates/' . $_POST ['category'] . '/' . $_POST ['template'] . '/js/*.js';
	$category = $_POST ['category'];
	$template = $_POST ['template'];
} else if (isset ( $_GET ['template'] ) && isset ( $_GET ['category'] )) {
	$turl = '../../templates/' . $_GET ['category'] . '/' . $_GET ['template'];
	$css = '../../templates/' . $_GET ['category'] . '/' . $_GET ['template'] . '/css/*.css';
	$jsdir = '../../templates/' . $_GET ['category'] . '/' . $_GET ['template'] . '/js/*.js';
	$category = $_GET ['category'];
	$template = $_GET ['template'];
}
$user_id = NULL;
if (isset ( $_SESSION ['user_id'] )) {
	$user_id = $_SESSION ['user_id'];
}
if (isset ( $_POST ['templateid'] )) {
	$template_id = $_POST ['templateid'];
} else if (isset ( $_GET ['templateid'] )) {
	$template_id = $_GET ['templateid'];
} else {
	$template_id = NULL;
}
$isInEditor = true;
$_SESSION['isInEditor'] = $isInEditor;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Template</title>
<script src="{{ asset('editor_asset/js/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('editor_asset/js/jquery-2.1.1.min.js') }}"></script>
<script src="{{ asset('editor_asset/js/jquery.flexisel.js') }}"></script>
<script src="{{ asset('editor_asset/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('editor_asset/js/bootstrap-dialog.js') }}"></script>
<script src="{{ asset('editor_asset/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('editor_asset/js/spectrum.js') }}"></script>
<script src="{{ asset('editor_asset/js/jquery.sortable.js') }}"></script>
<script src="{{ asset('editor_asset/js/main.js') }}"></script>


<script type="text/javascript">
            var template_id = '<?php echo $template_id == NULL ? $category.'_'.$template : $template_id;?>';
            var currentCategory = '<?php echo $category;?>';
            var currentTemplate = '<?php echo $template;?>';
            var isUserLoggedIn = '<?php echo $user_id == NULL ? '0': '1';?>';
            var tempIsEdit = '<?php echo $template_id == NULL ? '0' : '1';?>';
            var isEdit = false;
			var user_id = '<?php echo $user_id;?>';
            if(tempIsEdit === '1') {
                isEdit = true;
            }
            var isInEditor = true;
</script>
<?php include ($turl.'/header.html');?>
<script src="{{ asset('editor_asset/js/savePage.js') }}"></script>
<script src="{{ asset('editor_asset/js/drag_drop.js') }}"></script>
<script src="{{ asset('editor_asset/js/menu.js') }}"></script>
<script type="text/javascript" src="{{ asset('editor_asset/js/template_editor.js') }}"></script>
<script type="text/javascript" src="{{ asset('editor_asset/js/jquery-te-1.4.0.min.js') }}"
		charset="utf-8"></script>
<script src="{{ asset('editor_asset/js/outside-click.js') }}"></script>
<script src="{{ asset('editor_asset/js/control_palette.js') }}"></script>


<?php foreach (glob("$jsdir") as $jsfile){
	//echo "<script src='$jsfile'></script>";
}
?>

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




<style>

#frame {
	background: white;
	float: left;
	height: 100%;
	width: 100%;
	margin-left: 5px;
	padding: 5px;
/* 	z-index: 10000000; */
}

.edit_option {
	position: absolute;
	top: 65px;
	left: 243px;
	background-color: white;
	/* background: url("../../images/img-noise-361x370.png"); */
	border-radius: 7px;
	border: 1px solid silver;
	padding: 5px;
	display: none;
}

.edit_option  table  tr, th, td {
	padding: 2px;
	border: 1px solid white;
}

.control_dialog {
	position: absolute;
	background: url("../../images/img-noise-361x370.png");
	border-radius: 7px;
	border: 1px solid silver;
}

.edit_option td:nth-child(even) {
	float: right;
	text-align: right;
}

.color {
	height: 30px;
	width: 30px;
}

.color_picker_container {
	background: white;
	border-radius: 10px;
	box-shadow: 0px 0px 10px #888888;
}

.color_picker_icon {
	background: white;
	border: .5px solid lightgrey;
	border-radius: 7px;
	width: 100%;
}

.sortable.grid li {
			line-height: 60px;
			float: left;
			width: 80px;
			height: 60px;
			text-align: center;
			border-radius: 5px;
			margin-left: 5px;
			margin-top: 5px;
		}
.grid {
			display: inline;			
}
.slider_thumbnail{		
			width: 80px;
			height: 60px;
			text-align: center;
			border: 1px solid lightgrey;
			border-radius: 5px;
}

.template_save_btn {
	position: fixed;
	top: 0;
	right: 0;
	z-index: 10000000000 !important;
	
}

.editor_topper_view {
	width: 80%;
}

.form_label{
	font-size: 17px;
}

.form_input {
	height: 35px;
}


</style>

</head>


<body>
	<div id="log"></div>

	<style>
#showsaveicon {
	width: 100%;
	height: 100%;
	position: fixed;
	z-index: 9999;
	background: url("http://localhost/WebBuilder/images/loading.gif")
		no-repeat center center rgba(0, 0, 0, 0.25)
}
</style>
	<div id="showsaveicon" style="display: none"></div>

	<div>
		<?php //include_once '../master_views/topper_view.php';?>
	</div>
<!-- 
	<div style="height: 25px;">
		<a onclick="savePage(user_id, template_id);" class="btn btn-inverse"
			style="margin-right: 118px; float: right;"><i class="icon-star"></i>
			Save</a>
	</div>
 -->
 
 
 	<div>
		<button class="template_save_btn btn btn-success"
			onclick="savePage(user_id, template_id);" style="<?php echo $user_id == NULL? "display: none;" : "display: block;"?>">Save</button>
		<canvas id="hidden-canvas" style="display:none"></canvas>
	</div>

	<br />
	<br />
	<br />
	
	
		<!-- Template Elements  Here -->

		<div id="frame" class="droppedFields">
			<div
				style="background: grey; margin-bottom: 10px; text-align: center;"> <?php include ($turl.'/title.html');?>	</div>
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
                        <?php if ($template_id == NULL) { ?>
						<?php //include ($turl.'/menu.html');?>
                        <?php //include ($turl.'/menu.php');?>
                        <?php } else { ?>
						<?php //include '../user_views/user_menu.php';?>
						<?php } ?>
					</div>

				</div>
			</div>
			
			<?php //include_once 'control_template.php';?>
			@include('editor.control-template')
			
			<div id="body" contentEditable="false" style="width:100%; height:1000px">
				<h1>{{$category}}</h1>
				<h1>{{$template}}</h1>
                            <?php //include ($turl.'/body.html');?>
                            <?php //include ($turl.'/body.php');?>
            </div>

			<div id="footer">
				<?php //include ($turl.'/footer.html');?>
			</div>
		</div>
		
		<div id="control_palette" style="z-index: 100000000000000 !important">
				<?php //include '../content_views/control_palette.php';?>
				@include('editor.control-palette')
			</div>

	</div>


	<!-- The option Menu -->

	<div id="page_option" style="display: none;" class="edit_option">
		<table style="">
			<caption style="font-weight: bold; text-align: center;">Page Control
				Options</caption>
			<tr>
				<td style=""></td>
				<td><button class="btn btn-xs btn-danger" id="page_delete_btn">
						<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
						Delete
					</button></td>
			</tr>

			<tr>
				<td>Page Name</td>
				<td><input id="input_page_name" type="text"></td>
			</tr>


			<tr>
				<td>other Options</td>
				<td>.........</td>
			</tr>
			<tr>
				<td>other Options</td>
				<td>.........</td>
			</tr>

			<tr>
				<td><button class="btn btn-sm btn-success" id="page_save_btn">
						<span class="glyphicon glyphicon-saved" aria-hidden="true"></span>Save
					</button></td>
				<td><button class="btn btn-xs btn-warning page_close_btn">Close</button></td>
			</tr>

		</table>
	</div>

	<style>
#table_color_set tr:hover, td:hover {
	border: 3px solid #ffffff;
	font-weight: bold;
}

.color-set-color>span {
	display: inline-block;
	height: 30px;
	width: 20px;
}
</style>
	<!-- Color Option-->
	<div id="background_option_image" class="edit_option"
		style="top: 325px;">
		<table style="">
			<caption style="font-weight: bold; text-align: center;">Chose
				Background</caption>

        <?php
								for($i = 0; $i < 4; $i ++) {
									?>
            <tr>
				<td class="color"></td>
				<td class="color"></td>
				<td class="color"></td>
			</tr>
        <?php
								}
								?>




        </tr>

		</table>

		<button class="btn btn-xs btn-warning page_close_btn">Close</button>
	</div>


	<!-- Image Option-->
	<div id="background_option_color" class="edit_option"
		style="top: 325px;">
		<table style="" id="table_color_set">
			<caption style="font-weight: bold; text-align: center;">Chose Color
				Set</caption>

			<!--        <tr class="color-set">-->
			<!--            <td  >cset1</td><td class="color-set-color">-->
			<!--                <span  style="background: red;"></span><span style="background: green" ></span> <span style="background: gray" ></span>-->
			<!--            </td>-->
			<!--        </tr>-->
			<!---->
			<!--        <tr class="color-set">-->
			<!--            <td  >cset2</td><td class="color-set-color">-->
			<!--                <span  style="background: yellow;"></span> <span style="background: blue" ></span> <span style="background: silver" ></span>-->
			<!--            </td>-->
			<!--        </tr>-->


		</table>

		<button class="btn btn-xs btn-warning page_close_btn">Close</button>
	</div>
	<!-- Option Menu End -->

	<div id="control_editor">
		<?php //include 'control_editor.php';?>
		@include('editor.control-editor')
	</div>
	
	<div id="control_option_dialog" class="dialog">
		<button id="dialog_btn_edit" class="btn dialog_btn "
			style="width: 100%">
			<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
			Edit
		</button>
		<button id="dialog_btn_resize" class="btn dialog_btn"
			style="width: 100%">
			<span class="glyphicon glyphicon-resize-full" aria-hidden="true"></span>
			Resize
		</button>
		<button id="dialog_btn_delete" class="btn dialog_btn"
			style="width: 100%">
			<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
			Delete
		</button>
		<button id="dialog_btn_cancel" class="btn dialog_btn"
			style="width: 100%">
			<span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
			Cancel
		</button>
		<!-- <ol id="selectable">
			<li class="ui-widget-content">Item 1</li>
			<li class="ui-widget-content">Item 2</li>
			<li class="ui-widget-content">Item 3</li>
			<li class="ui-widget-content">Item 4</li>
		</ol> -->

	</div>

	<div id="btn_edit_dialog" class="dialog">
		<p style="font-weight: lighter; font-size: small;">Add Text and Link
			to your Button. Chnage the style to make it look as you want</p>
		<div
			style="height: 150px; border: 1px solid lightgrey; border-radius: 8px; padding: 5px">
			<p style="padding-top: 5px; font-weight: lighter; font-size: small;">Button
				Text</p>
			<input id="btn_text" type="text" placeholder="Click Me"
				style="width: 100%; border: .5px solid lightgrey; border-radius: 5px;">

				<p style="padding-top: 5px; font-weight: lighter; font-size: small">Link
					To</p> <input id="btn_link" type="text" name="btn_link"
				placeholder="Fill in your URL"
				style="width: 100%; border: .5px solid lightgrey; border-radius: 5px;">
		
		</div>
		<hr></hr>
		<!-- <button id="btn_dialog_change_color" style="width: 100%; border-radius: 5px; background: #6cc8f9;"><font size= "4px" color= "white" weight="bold">Change Color</font></button>
		 -->
		<input type='text' id="color_picker" />
		<hr></hr>
		<button id="btn_dialog_cancel"
			style="border-radius: 5px; float: right; margin: 5px; background: white">
			Cancel</button>
		<button id="btn_dialog_save"
			style="border-radius: 5px; float: right; margin: 5px; background: white">
			Save</button>
	</div>
	
	
	<div id="text_input_edit_dialog" class="dialog">
		<p style="font-weight: lighter; font-size: small;">Text Input Editor, Take Input from user as your wish</p>
		<div
			style="height: 150px; border: 1px solid lightgrey; border-radius: 8px; padding: 5px">
			<p style="padding-top: 5px; font-weight: lighter; font-size: small;">Text Hint</p>
			<input id="text_input_hint_text" type="text"
				style="width: 100%; border: .5px solid lightgrey; border-radius: 5px;">
		
		</div>
		<hr></hr>
		<button id="btn_text_input_cancel"
			style="border-radius: 5px; float: right; margin: 5px; background: white">
			Cancel</button>
		<button id="btn_text_input_save"
			style="border-radius: 5px; float: right; margin: 5px; background: white">
			Save</button>
	</div>
	

	<div id="radio_btn_edit_dialog" class="dialog">
		<p style="font-weight: lighter; font-size: small;">Add Radio Button
			Options.</p>
		<div
			style="height: 150px; border: 1px solid lightgrey; border-radius: 8px; padding: 5px">
			<p style="padding-top: 5px; font-weight: lighter; font-size: small;">Radio
				Button Options</p>
			<textarea id="radio_btn_option_txt" value="Option 1\nOption2"
				style="width: 100%; height: 90px; resize: none; border: .5px solid lightgrey; border-radius: 5px;"></textarea>
		</div>
		<hr></hr>

		<hr></hr>
		<button id="radio_btn_dialog_cancel"
			style="border-radius: 5px; float: right; margin: 5px; background: white">
			Cancel</button>
		<button id="radio_btn_dialog_save"
			style="border-radius: 5px; float: right; margin: 5px; background: white">
			Save</button>
	</div>

	<div id="text_edit_dialog" class="dialog">
		<select id="dropdown_txt_editor_font_family" class="text_editor_component">			
			<option value="Arial" selected>Arial</option>
			<option value="Times New Roman">Times New Roman</option>
			<option value="Comic Sans MS">Comic Sans MS</option>
			<option value="Verdana">Verdana</option>
			<option value="Courier New">Courier New</option>
			<option value="Helvetica">Helvetica</option>
			<option value="sans-serif">sans-serif</option>
		</select> 
		<select id="dropdown_txt_editor_font_size" class="text_editor_component">
			<option value="8">8</option>
			<option value="10">10</option>
			<option value="14">14</option>
			<option value="15" selected>15</option>
			<option value="16">16</option>
			<option value="20">20</option>
			<option value="24">24</option>
			<option value="30">30</option>
			<option value="36">36</option>
			<option value="40">40</option>
			<option value="50">50</option>
			<option value="60">60</option>
		</select>
		<button id="btn_txt_editor_normal" class="text_editor_component">
			<span class="glyphicon glyphicon-font" aria-hidden="true"></span>
		</button>
		<button id="btn_txt_editor_bold" class="text_editor_component">
			<span class="glyphicon glyphicon-bold" aria-hidden="true"></span>
		</button>
		<button id="btn_txt_editor_italic" class="text_editor_component">
			<span class="glyphicon glyphicon-italic" aria-hidden="true"></span>
		</button>
		<button id="btn_txt_editor_left_align" class="text_editor_component">
			<span class="glyphicon glyphicon-align-left" aria-hidden="true"></span>
		</button>
		<button id="btn_txt_editor_center_align" class="text_editor_component">
			<span class="glyphicon glyphicon-align-center" aria-hidden="true"></span>
		</button>
		<button id="btn_txt_editor_right_align" class="text_editor_component">
			<span class="glyphicon glyphicon-align-right" aria-hidden="true"></span>
		</button>
		<button id="btn_txt_editor_close" class="text_editor_component">
			<span class=" 	glyphicon glyphicon-remove" aria-hidden="true"></span>
		</button>
	</div>
	
	<div id="resize_dialog" class="dialog">
		<label>Height :</label>
		<textarea id = "txt_height_resize_dialog" style="resize: none; height: 25px; width: 50px;"></textarea>
		<label>Width :</label>
		<textarea id = "txt_width_resize_dialog" style="resize: none; height: 25px; width: 50px;"></textarea>
		
		<button id = "btn_resize_apply" class="text_editor_component">
			<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
		</button>
		
		<button id = "btn_resize_close" class="text_editor_component">
			<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
		</button>
	</div>
	
	<div id="group_edit_dialog" class="dialog">
		<button id = "btn_group_edit_add_label" class="text_editor_component">
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Add Label
		</button>
		
		<button id = "btn_group_edit_add_input_text" class="text_editor_component" style="display: none;">
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Add Text Input
		</button>
		
		<button id = "btn_group_edit_background" class="text_editor_component">
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Edit Background
		</button>
		
		<button id = "btn_group_edit_panel_close" class="text_editor_component">
			<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
		</button>
	</div>
	
	<div id="form_edit_dialog" class="dialog">
		<button id = "btn_form_edit_background" class="text_editor_component">
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Edit Background
		</button>
		
		<button id = "btn_form_edit_panel_close" class="text_editor_component">
			<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
		</button>
	</div>
	

	<div id="image_edit_dialog" class="dialog">
		<p style="font-weight: lighter; font-size: small;">Add Images To your
			Website. Make them stunning with dazzling Effects</p>
		<div
			style="height: 300px; border: 1px solid lightgrey; border-radius: 8px; padding: 5px">

			<input id="file_picker" type="file" name="files[]" single
				style="display: none">

				<button id="btn_browse_image" style="background: white">
					<span class="glyphicon glyphicon-folder-open" aria-hidden="true">
				
				</button> <input id="dialog_input_image_path" type="text"
				placeholder="Enter Image Path"
				style="width: 80%; border: .5px solid lightgrey; border-radius: 5px;">

					<!-- 
			<p style="padding-top: 5px; font-weight: lighter; font-size: small">Image
				ALT :</p>
			<input id="input_image_alt" type="text" placeholder="Enter Image ALT"
				style=" width: 50%; border: .5px solid lightgrey; border-radius: 5px;">
			
				<p style="padding-top: 5px; font-weight: lighter; font-size: small">Height : </p>
				<input id="input_image_height" type="text"
				placeholder="Enter Image height in px"
				style="width: 50%; border: .5px solid lightgrey; border-radius: 5px;">
				<p style="padding-top: 5px; font-weight: lighter; font-size: small"> px</p>
				
				<p style="padding-top: 5px; font-weight: lighter; font-size: small">Width : </p>
				<input id="input_image_width" type="text"
				placeholder="Enter Image width in px"
				style="width: 50%; border: .5px solid lightgrey; border-radius: 5px;">
				<p style="padding-top: 5px; font-weight: lighter; font-size: small"> px</p>
		
		 -->
		
		</div>
		<hr></hr>
		<button id="btn_image_effect_chooser"
			style="width: 100%; border-radius: 5px; background: #6cc8f9;">
			<font size="4px" color="white" weight="bold">Choose Effect</font>
		</button>

		<hr></hr>
		<button id="btn_image_dialog_cancel"
			style="border-radius: 5px; float: right; margin: 5px; background: white">
			Cancel</button>
		<button id="btn_imgage_dialog_save"
			style="border-radius: 5px; float: right; margin: 5px; background: white">
			Save</button>
	</div>
		
	<div id="imageslider_edit_dialog" class="dialog" style="">
		<p style="font-weight: lighter; font-size: small;">Add Image Slider To your
			Website. Make them stunning with dazzling Effects</p>
		<div
			style="height: 200px; border: 1px solid lightgrey; border-radius: 8px; padding: 5px; overflow: scroll;">

			<input id="file_picker_imageslider" type="file" name="files[]" single
				style="display: none">
				
				<button id="btn_browse_imageslider" class="btn" style="background: white; width: 100%">
					<span class="glyphicon glyphicon-plus" aria-hidden="true">				
				</button>
				
				<ul id = "imageslider_edit_panel_thumbnail" class= "sortable grid" style="">
				</ul>

				 
				
		
		</div>
		<hr></hr>
		<div
			style="height: 120px; border: 1px solid lightgrey; border-radius: 8px; padding: 5px; overflow: hidden;">
			
			<table style="width: 100%; ">
				<tr>
					<td><label style="padding-top: 5px; font-weight: lighter; font-size: small;">Pause Time </label></td>
					<td>
						<select id="dropdown_slider_pause_time" class="text_editor_component">
							<option value="1">1 Sec</option>
							<option value="2">2 Sec</option>
							<option value="3" selected >3 Sec</option>
							<option value="4" >4 Sec</option>
							<option value="5">5 Sec</option>
			    		</select>	
					</td>
				</tr>
				<tr>
					<td><label style="padding-top: 5px; font-weight: lighter; font-size: small;">Animation Speed </label></td>
					<td>
						<select id="dropdown_slider_animation_speed" class="text_editor_component">
							<option value="1" selected>1 Sec</option>
							<option value="2">2 Sec</option>
							<option value="3">3 Sec</option>
			    		</select>	
					</td>
				</tr>
				<tr>
					<td><label style="padding-top: 5px; font-weight: lighter; font-size: small;">Visible Item </label></td>
					<td>
						<select id="dropdown_slider_visible_item" class="text_editor_component">
							<option value="1" selected>1 Item</option>
							<option value="2">2 Items</option>
							<option value="3">3 Items</option>
							<option value="4">4 Items</option>
							<option value="5">5 Items</option>
							<option value="6">6 Items</option>
							<option value="7">7 Items</option>
			    		</select>	
					</td>
				</tr>
			</table>
				
		
		</div>
		
		<hr></hr>
		
		<button
			style="width: 100%; border-radius: 5px; background: #6cc8f9;">
			<font size="4px" color="white" weight="bold">Choose Effect</font>
		</button>

		<hr></hr>
		<button id="btn_imageslider_dialog_cancel"
			style="border-radius: 5px; float: right; margin: 5px; background: white">
			Cancel</button>
		<button id="btn_imgageslider_dialog_save"
			style="border-radius: 5px; float: right; margin: 5px; background: white">
			Save</button>
	</div>
	
	

	
	<div id="dropdown_edit_dialog" class="dialog">
		<p style="font-weight: lighter; font-size: small;">Edit your Dropdown
			Menue, Add or Delete options</p>
		<div
			style="height: 150px; border: 1px solid lightgrey; border-radius: 8px; padding: 5px">
			<p style="padding-top: 5px; font-weight: lighter; font-size: small;">Dropdown
				Options</p>
			<textarea id="dropdown_option_txt"
				style="width: 100%; height: 90px; resize: none; border: .5px solid lightgrey; border-radius: 5px;"></textarea>
		</div>
		<hr></hr>
		</button>

		<hr></hr>
		<button id="btn_dropdown_dialog_cancel"
			style="border-radius: 5px; float: right; margin: 5px; background: white">
			Cancel</button>
		<button id="btn_dropdown_dialog_save"
			style="border-radius: 5px; float: right; margin: 5px; background: white">
			Save</button>
	</div>




	<!-- -------------------------------------- Control Templates ----------------------------------------------- -->

	<div id="text_box_template" name="textarea"
		class="text_template_non_editable" style="display: none; position: absolute;">
		<h1>
			Title. Edit me<br />
		</h1>
		<p>I am a paragraph. Edit me. I am a paragraph. Edit me. I am a
			paragraph. Edit me. I am a paragraph. Edit me.</p>
		<br />
		<p>I am a paragraph. Edit me. I am a paragraph. Edit me. I am a
			paragraph. Edit me. I am a paragraph. Edit me. I am a paragraph.</p>
		<br />
		<p>Edit me. I am a paragraph. Edit me. I am a paragraph. Edit me. I am
			a paragraph. Edit me.</p>

	</div>

	
		<h1 id="title_template" name="textarea"
		class="title_template_non_editable" style="display: none; position: absolute;">
			Title. Edit me<br />
		</h1>

	<div  id="image_template" name="image" class="image_template_non_editable" style="display: none; position: absolute;" data-id="container_imageT">
		<img src="../../images/image_template.png" alt="Image Template" />
	</div>

	<div id="image_slider_template" name="imageslider" data-id="container_imageS"
		class="slider_template_non_editable" data-pause="3000" data-speed="1000" style="display: none; position: absolute;">
		<ul data-pause_time="3000" data-animation_speed="1000" data-visible_items="1" data-total_item="3">
			<li><img src="../../images/slider1.jpg" class="slide" alt="Image1"></li>
			<li><img src="../../images/slider2.jpg" class="slide" alt="Image2"></li>
			<li><img src="../../images/slider3.jpg" class="slide" alt="Image3"></li>
		</ul>
	</div>


	<button id="button_template" name="button"
		class="button_template_non_editable btn btn-primary btn-lg"
		style="display: none; position: absolute;">Click Me</button>

	<select id="dropdown_template" name="dropdown"
		class="drop_down_template_non_editable" style="display: none; position: absolute;">
		<option value="Option1">Option 1</option>
		<option value="Option2">Option 2</option>
		<option value="Option3">Option 3</option>
	</select>

	<div id="radiobutton_template" name="radiobutton"
		style="display: none; position: absolute; width: 200px"></div>

	<div id="form_template_feedback" name="group" data-id="container_feedbackform-1" data-is_form="yes"
		style="display: none; position: absolute; width: 400px; height: auto; border: 1px solid lightgrey; border-radius: 5px; padding: 10px; background: lightgray;">
		<div id="container_feedbackform-1_div-1">
			<h3 name="group_textarea" style="">User Feedback</h3>
			<hr name="group_separator"></hr>
			<label name="group_textarea" class="form_label">Name : </label> 
			<input id="feedback_user_name" name="group_textinput" type="text" placeholder="Your Name" class="form_input"
				style="width: 100%; border: .5px solid lightgrey; border-radius: 5px;">
	
				<label name="group_textarea" class="form_label">Email : </label> 
				<input id="feedback_user_email" name="group_textinput" type="text" placeholder="Your Email" class="form_input"
				style="width: 100%; border: .5px solid lightgrey; border-radius: 5px;">
	
					<label name="group_textarea" class="form_label">Comment : </label> 
					<textarea id="feedback_user_comment"
						name="group_textinput" value="Fill in your Comment"
						style="resize: none; width: 100%; height: 150px; border: .5px solid lightgrey; border-radius: 5px;">
				</textarea>
					<hr name="group_separator"></hr>
	
					<button name="group_button" class="btn btn-success btn-lg" style="float: right;">Submit</button>
		</div>
	</div>
	
	<div id="form_template_contact" name="group" data-id="container_contactform-1" data-is_form="yes"
		style="display: none; position: absolute; width: 600px; height: auto; border: 1px solid lightgrey; border-radius: 5px; padding: 10px; background: lightgreen;">
		<div id="container_contactform-1_div-1">
			<h3 name="group_textarea" style="">Contact Form</h3>
			<hr name="group_separator"></hr>
			<label name="group_textarea" class="form_label">First Name : </label> 
			<input id="contact_user_name" name="group_textinput" type="text" placeholder="Your First Name" class="form_input"
				style="width: 100%; border: .5px solid lightgrey; border-radius: 5px;">
			<label name="group_textarea" class="form_label">Last Name : </label> 
			<input id="contact_user_name" name="group_textinput" type="text" placeholder="Your Last Name" class="form_input"
				style="width: 100%; border: .5px solid lightgrey; border-radius: 5px;">
	
				<label name="group_textarea" class="form_label">Email : </label> 
				<input id="contact_user_email" name="group_textinput" type="text" placeholder="Your Email" class="form_input"
				style="width: 100%; border: .5px solid lightgrey; border-radius: 5px;">
	
			<label name="group_textarea" class="form_label">Subject : </label> 
			<input id="contact_user_name" name="group_textinput" type="text" placeholder="Subject" class="form_input"
				style="width: 100%; border: .5px solid lightgrey; border-radius: 5px;">
				
					<label name="group_textarea" class="form_label">Comment : </label> 
					<textarea id="contact_user_comment"
						name="group_textinput" value="Fill in your Comment"
						style="resize: none; width: 100%; height: 150px; border: .5px solid lightgrey; border-radius: 5px;">
				</textarea>
					<hr name="group_separator"></hr>
	
					<button name="group_button" class="btn btn-success btn-lg" style="float: right;">Submit</button>
		</div>
	</div>
	
	<div id="form_template_leavemsg" name="group" data-id="container_leavemsgform-1" data-is_form="yes"
		style="display: none; position: absolute; width: 300px; height: auto; border: 1px solid lightgrey; border-radius: 5px; padding: 10px; background: lightblue;">
		<div id="container_leavemsgform-1_div-1">
			<h3 name="group_textarea" style="">Leave Message</h3>
			<hr name="group_separator"></hr>
			<label name="group_textarea" class="form_label">Name : </label> 
			<input id="leavemsg_user_name" name="group_textinput" type="text" placeholder="Your Name" class="form_input"
				style="width: 100%; border: .5px solid lightgrey; border-radius: 5px;">
	
				<label name="group_textarea" class="form_label">Email : </label> 
				<input id="leavemsg_user_email" name="group_textinput" type="text" placeholder="Your Email" class="form_input"
				style="width: 100%; border: .5px solid lightgrey; border-radius: 5px;">
	
					<label name="group_textarea" class="form_label">Message : </label> 
					<textarea id="leavemsg_user_comment"
						name="group_textinput" value="Fill in your Comment"
						style="resize: none; width: 100%; height: 150px; border: .5px solid lightgrey; border-radius: 5px;">
				</textarea>
					<hr name="group_separator"></hr>
	
					<button name="group_button" class="btn btn-success btn-lg" style="float: right;">Submit</button>
		</div>
	</div>

</body>



</html>