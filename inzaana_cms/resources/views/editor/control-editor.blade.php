
<div id="control_option_dialog" class="dialog">
		<button id="dialog_btn_edit" class="btn dialog_btn option_dlg_btn">
			<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
			Edit
		</button>
		<button id="dialog_btn_resize" class="btn dialog_btn option_dlg_btn">
			<span class="glyphicon glyphicon-resize-full" aria-hidden="true"></span>
			Resize
		</button>
		<button id="dialog_btn_delete" class="btn dialog_btn option_dlg_btn">
			<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
			Delete
		</button>
		<button id="dialog_btn_cancel" class="btn dialog_btn option_dlg_btn">
			<span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
			Cancel
		</button>

	</div>

	<div id="btn_edit_dialog" class="dialog">
		<p class="btn_edit_dlg_header">Add Text and Link
			to your Button. Chnage the style to make it look as you want</p>
		<div class="btn_edit_dlg_input_container">
			<p class="btn_edit_dlg_btn_txt_label">Button
				Text</p>
			<input id="btn_text" type="text" placeholder="Click Me"
				class="btn_edit_dlg_btn_txt_input">

				<p class="btn_edit_dlg_btn_link_label">Link
					To</p>
				<input id="btn_link" type="text" name="btn_link"
				placeholder="Fill in your URL"
				class="btn_edit_dlg_btn_link_input">
		
		</div>
		<hr></hr>
		<!-- <button id="btn_dialog_change_color" style="width: 100%; border-radius: 5px; background: #6cc8f9;"><font size= "4px" color= "white" weight="bold">Change Color</font></button>
		 -->
		<input type='text' id="color_picker" />
		<hr></hr>
		<button id="btn_dialog_cancel" class="btn_edit_dlg_btn_cancel">
			Cancel</button>
		<button id="btn_dialog_save"
			class="btn_edit_dlg_btn_save">
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
		<!-- <select id="dropdown_txt_editor_font_family" class="text_editor_component">			
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
		</button> -->
		<p>Do you want to save changes?</p>
		<br>
		<button id="btn_editor_cancel"
			style="border-radius: 5px; float: right; margin: 5px; background: white">
			Cancel</button>
		<button id="btn_editor_save"
			style="border-radius: 5px; float: right; margin: 5px; background: white">
			Save</button>

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
		<!-- <button id = "btn_group_edit_add_label" class="text_editor_component" style="display: none;">
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Add Label
		</button>
		
		<button id = "btn_group_edit_add_input_text" class="text_editor_component" style="display: none;">
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Add Text Input
		</button> -->
		
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




	
<!-- Background Editor -->

<div id="dialog_bg_editor" class="dialog">
	<div class="bg_eidtor">
		<div id="bg_editor_sample_images_section" class="bg_sample_image_palette">
			<ul id = "bg_editor_sample_images_list" class="bg_sample_image_grid">
				<?php
				$dirs=scandir("./templates/$category_name/$template_name/resource/images/background");
				for($i=2;$i<sizeof($dirs);$i++)
				{		
				?>
					<li>
						<img src='{{asset("/templates/$category_name/$template_name/resource/images/background/$dirs[$i]")}}' class="bg_editor_thumbnail" alt="test">
					</li>		
				<?php 
				}
				?>
			</ul>
		</div>
		<div id="bg_editor_section" class="section_bg_editor">
			<div class="bg_editor_box">
				<button id="btn_select_bg_image" class="btn btn-default btn-block">Select Background Image from PC</button>
				<input id="file_picker_bg_editor" type="file" name="files[]" single
							style="display: none">
				</input>
				<br />
				
				<label>Background Image Position :  </label>
				<select id="dropdown_bg_image_position" class="text_editor_component">
					<option value="left">left</option>
					<option value="right">right</option>
					<option value="center">center</option>
				</select>
				
				<label>Background Image Repeat :  </label>
				<select id="dropdown_bg_image_repeat" class="text_editor_component">
					<option value="repeat">repeat</option>
					<option value="repeat-x">repeat-x</option>
					<option value="repeat-y">repeat-y</option>
					<option value="no-repeat">no-repeat</option>
				</select>
				
				<label>Background Image Attachment :  </label>
				<select id="dropdown_bg_image_attachment" class="text_editor_component">
					<option value="scroll">scroll</option>
					<option value="fixed">fixed</option>
				</select>
				
			</div>
			
			
			<div class="bg_editor_box">
				<br />
				<div>
					<label>Background Color : </label>
					<input type='text' id="bg_color_picker" class="background_color_picker" />
				</div>
				<br />
				
				<div class="bg_editor_gradient_1">
					<label>Color 1 : </label>
					<input type='text' id="bg_color_picker_gradient_1"/>
				</div>
				<div class="bg_editor_gradient_2">
					<label>Color 2 : </label>
					<input type='text' id="bg_color_picker_gradient_2" />
				</div>
				<button id="btn_set_bg_editor_gradient" class="btn btn-default btn-block">Set Background Color Gradient</button>
				
				<ul class="gradient_option">
					<li id="linear_gradient_left" ></li>
					<li id="linear_gradient_right"></li>
					<li id="linear_gradient_top"></li>
					<li id="linear_gradient_bottom"></li>
					<li id="radial_gradient_in"></li>
					<li id="radial_gradient_out"></li>
				</ul>
			</div>
		</div>
		<button id="btn_bg_editor_cancel" class="btn btn-default bg_editor_button">Cancel</button>
		<button id="btn_bg_editor_save"class="btn btn-default bg_editor_button">Save</button>
	</div>
	
</div>


	<!-- The option Menu -->

	<div id="page_option" style="display: none; position: fixed;" class="edit_option">
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