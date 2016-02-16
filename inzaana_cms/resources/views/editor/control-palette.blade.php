
<div class="cp_box">
	<button id="cp_background"
			class="cp cp_background cp_btn btn" data-top="true"><span class="glyphicon glyphicon-modal-window cp_icon" aria-hidden="true"></span><font style="font-size: 18px"> Background</font> </button>
			
	<button id="cp_add_control"
			class="cp cp_add_control cp_btn btn"><span class="glyphicon glyphicon-plus cp_icon" aria-hidden="true"></span><font style="font-size: 18px"> Add Item</font> </button>
			
	<button id="cp_menu"
			class="cp cp_menu cp_btn btn"><span class="glyphicon glyphicon-edit cp_icon" aria-hidden="true"></span><font style="font-size: 18px"> Edit Menu</font></button>
			
	<button id="cp_media"
			class="cp cp_media cp_btn btn"><span class="glyphicon glyphicon-film cp_icon" aria-hidden="true"></span><font style="font-size: 18px"> Add Media</font></button>
</div>

<div id="cp_holder_pointer" class="cp_pointer pointer"></div>
<div id="cp_pointer_outcurve_bottom" class="cp_pointer_outcurve_bottom pointer"></div>
<div id="cp_pointer_outcurve_top" class="cp_pointer_outcurve_top pointer"></div>
		
<div id="cp_holder_add_control" class="cp_holder">
	<div class="cp_holder_title_bg_color" style="width: 100%; height: 45px; border-radius: 0 10px 0 0; ">
		<button id="btn_cp_holder_close" class="cp_holder_close_btn cp_holder_btn">X</button>
		<button id="btn_cp_holder_info" class="cp_holder_btn">?</button>
	</div>
	
	<div id="tabs">
	    <ul>
	        <li>
	            <a href="#btn_template_palette">Button</a>
	        </li>
	        <li>
	            <a href="#images">Image</a>
	        </li>
	        <li>
	            <a href="#slider">Slider</a>
	        </li>
	        <li>
	            <a href="#text">Text</a>
	        </li>
	        <li>
	            <a href="#form">Form</a>
	        </li>
	        <li>
	            <a href="#space">Space</a>
	        </li>
	    </ul>
	    <div id="btn_template_palette">
	        <!-- <button name='button' class='selectorField draggableField btn-primary btn-lg'>Click Me</button> -->
	    </div>
	    <div id="images">
	        <img name="image" class="selectorField draggableField" src="{{ asset('editor_asset/images/image_template.png') }}" alt="Image Template" style="margin-left: 20px; width: 200px; height: 200px" />
	    </div>
	    <div id="slider">
	        <img name="imageslider" class="selectorField draggableField" src="{{ asset('editor_asset/images/slider-skin.jpg') }}" alt="ImageSlider Template" style="margin-left: 20px; width: 200px; height: 100px" />
	    </div>
	    <div id="text">
	        <div name='textarea' class='selectorField draggableField'>
	        	<h1>Title, Edit me</h1>
	        	<p>I am a Paragraph, Edit me.</p>
	        	<p>I am a Paragraph, Edit me.</p>
	        </div>
	        <br />
	        <br />
	        <h1 name='header' class='selectorField draggableField'>Title, Edit me</h1>
	        <br />
	        <br />
	        <h2 name='header' class='selectorField draggableField'>Title, Edit me</h2>
	        <br />
	        <br />
	        <h3 name='header' class='selectorField draggableField'>Title, Edit me</h3>
	        
	    </div>
	    
	    <div id="form">
	    	<h1 name='group' data-form_type="feedback" class='selectorField draggableField'>Feedback Form</h1>
	    	<h1 name='group' data-form_type="contact" class='selectorField draggableField'>contact Form</h1>
	    	<h1 name='group' data-form_type="leavemsg" class='selectorField draggableField'>Leave Msg Form</h1>
	    </div>
	    <div id="space">
	    	<h1 name='space' class='selectorField draggableField'>New Space</h1>
	    </div>
	</div>
</div>

<div id="cp_holder_backgroud" class="cp_holder">
	<div class="cp_holder_title_bg_color" style="width: 100%; height: 45px; border-radius: 0 10px 0 0; ">
		<button id="btn_cp_holder_close" class="cp_holder_close_btn cp_holder_btn">X</button>
		<button id="btn_cp_holder_info" class="cp_holder_btn ">?</button>
	</div>
	<div class="backgroud_edit">
		<button id="btn_open_bg_editor" class="btn btn-default btn-block">Open Background Editor</button>
	</div>
	<div class="background_theme">
		<br />
		<ul id="bg_editor_default_images_list"></ul>
	
	</div>
</div>
<div id="cp_holder_menu" class="cp_holder">
	<div class="cp_holder_title_bg_color" style="width: 100%; height: 45px; border-radius: 0 10px 0 0; ">
		<button id="btn_cp_holder_close" class="cp_holder_close_btn cp_holder_btn">X</button>
		<button id="btn_cp_holder_info" class="cp_holder_btn">?</button>
	</div>
	<div style="float: left;" class="tree">
		<ul>

			<li><span><i class="icon-calendar"></i> Pages</span>
				<ul>
					<li><span class="badge badge-success"><i class="icon-minus-sign"></i>
							Already Added</span>
						<ul id="ul_tree_menu_list" class="pages">

						</ul></li>
				</ul></li>

		</ul>
	</div>
	
	
	
</div>
<div id="cp_holder_media" class="cp_holder">
	<div class="cp_holder_title_bg_color" style="width: 100%; height: 45px; border-radius: 0 10px 0 0; ">
		<button id="btn_cp_holder_close" class="cp_holder_close_btn cp_holder_btn">X</button>
		<button id="btn_cp_holder_info" class="cp_holder_btn">?</button>
	</div>
	<p>Add Media</p>
</div>

<button id="btn_collasp_cp" class="collasp_cp btn btn-info">Collasp</button>