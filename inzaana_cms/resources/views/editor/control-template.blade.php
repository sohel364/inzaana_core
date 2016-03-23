<!-- -------------------------------------- Control Templates ----------------------------------------------- -->


<!--  Control Template for button -->
<button type="button" id="btn_template_1" name="button" data-type="1" class="button_template btn btn-default">Click Me</button>
<button type="button" id="btn_template_2" name="button" data-type="2" class="button_template btn btn-primary">Add</button>
<button type="button" id="btn_template_3" name="button" data-type="3" class="button_template btn btn-success">Yes</button>
<button type="button" id="btn_template_4" name="button" data-type="4" class="button_template btn btn-info">No</button>
<button type="button" id="btn_template_5" name="button" data-type="5" class="button_template btn btn-warning">Cancel</button>
<button type="button" id="btn_template_6" name="button" data-type="6" class="button_template btn btn-danger">Submit</button>

<!-- Control Template for Marriage -->

<div id="marriage_control_template_1" name="mrg_control" data-type="1" class="marriage_control_template_non_editable">
<!-- 	<h1>
		Sample Marriage Control
	</h1> -->
	<p style="text-align: right;">
			This is Mrg ctrl test
	</p>
</div>

<div id="marriage_control_template_2" name="mrg_control" data-type="2" class="marriage_control_template_non_editable">
<!-- 	<h1>
		Sample Marriage Control
	</h1> -->
	<p style="text-align: right;">
			This is Mrg ctrl test 2
	</p>
</div>


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
	<img src="{{ asset('editor_asset/images/image_template.png') }}" alt="Image Template" />
</div>

<div id="image_slider_template" name="imageslider" data-id="container_imageS"
	class="slider_template_non_editable" data-pause="3000" data-speed="1000" style="display: none; position: absolute;">
	<ul data-pause_time="3000" data-animation_speed="1000" data-visible_items="1" data-total_item="3">
		<li><img src="{{ asset('editor_asset/images/slider1.jpg') }}" class="slide" alt="Image1"></li>
		<li><img src="{{ asset('editor_asset/images/slider2.jpg') }}" class="slide" alt="Image2"></li>
		<li><img src="{{ asset('editor_asset/images/slider3.jpg') }}" class="slide" alt="Image3"></li>
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

<!-- <div id="test_template" style="display: none">
 	<div id="container_background-1" style="width: 100%; height: 900px;">
 		<div id="container_background-1_div-1">
			<div id="hint" name="textarea" style="position: absolute; width: 70%; height: 300px; border: 2px lightgray dotted; left: 15%; top: 20%;">
				<h1><span style="position: absolute; color: lightgray; left: 33%; top: 35%;">Body: Drop Items Here</span></h1>
			</div>
		</div>
	</div>
</div> -->