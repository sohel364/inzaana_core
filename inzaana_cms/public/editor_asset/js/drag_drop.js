/*
 * Created By Jisan Mahmud
 */

/*
 * Global Variables
 */

var counter = 1001;
var clicked_dropped_item_id = null;
var clicked_dropped_item_name = null;
var child_item = null;
var editable_control = null;
var editable_image = null;
var SLIDER_ANIMATION_SPEED = 1000;
var SLIDER_PAUSE = 3000;
var is_group_edit_mode = false;
var editable_group = null;
var deleted_image_list = [];

var pos;
var isSaved = false;
var isResizeOn = false;
var allawable_control_array = [ "button", "textarea", "radiobutton",
		"dropdown", "image", "imageslider", "header", "group",
		"separator", "textinput", "form", "link" ]

var allawable_group_control_array = [ "group_button", "group_textarea", "group_radiobutton",
                        		"group_dropdown", "group_image", "group_imageslider", "group_header",
                        		"group_separator", "group_textinput", "group_link" ]
var deleted_image_list = [];

var currentMousePos = {
	x : -1,
	y : -1
};

function makeTemplateComponetsEditable() {
	console.log("Making Template Control Editable");

	$("#body").find("*").each(function() {
		var control_id = $(this).attr("id");
		var control_name = $(this).attr("name");

		console.log(control_id + " : " + control_name);

		if (allawable_control_array.indexOf(control_name) > -1) {
			//console.log(" [Allowable Control] Control Type : " + control_name);
			if ($(this).attr("id") == null)
			{
				$(this).attr("id", $(this).attr("name") + "_dropped" + counter++);
			}
			$(this).data("is_dropped","true");

			makeDroppedControlsDraggable($(this));

			$(this).click(droppedItemClickAction);
		}
		
		if (control_name == "imageslider" || control_name == "group_imageslider" )
		{
			startImageSlider($(this));
		}
		
		if ($(this).is("a")){
			$(this).data("href", $(this).attr("href"));
			$(this).attr("href", null);
		}
		
		if ($(this).is("button")){
			$(this).data("onclick", $(this).attr("onclick"));
			$(this).attr("onclick", null);
		}
		
	});
	
	$("#footer").find("*").each(function() {
		var control_id = $(this).attr("id");
		var control_name = $(this).attr("name");

		//console.log(control_id + " : " + control_name);

		if (allawable_control_array.indexOf(control_name) > -1) {
			console.log(" [Allowable Control] Control Type : " + control_name);
			if ($(this).attr("id") == null)
			{
				$(this).attr("id", $(this).attr("name") + "_dropped" + counter++);
			}
			$(this).data("is_dropped","true");
			
			makeDroppedControlsDraggable($(this));

			$(this).click(droppedItemClickAction);
		}
		
		if (control_name == "imageslider" || control_name == "group_imageslider" )
		{
			startImageSlider($(this));
		}
		
		if ($(this).is("a")){
			$(this).data("href", $(this).attr("href"));
			$(this).attr("href", null);
		}
		
		if ($(this).is("button")){
			$(this).data("onclick", $(this).attr("onclick"));
			$(this).attr("onclick", null);
		}
	});
}

function makeTemplateComponetsNotEditable() {
	console.log("Making Template Control Not Editable");

	$("#body").find("*").each(function() {
		var control_id = $(this).attr("id");
		var control_name = $(this).attr("name");

		console.log(control_id + " : " + control_name);

		if (allawable_control_array.indexOf(control_name) > -1) {
			console.log(" [Allowable Control] Control Type : " + control_name);
			$(this).attr("id", $(this).attr("name") + "_dropped" + counter++);

			$(this).draggable("destroy");

			$(this).click(function() {
			});
		}
		
		if ($(this).is("a")){
			$(this).attr("href", $(this).data("href"));
		}
		
		if ($(this).is("button")){
			$(this).attr("onclick", $(this).data("onclick"));
		}
	});
	
	$("#footer").find("*").each(function() {
		var control_id = $(this).attr("id");
		var control_name = $(this).attr("name");

		console.log(control_id + " : " + control_name);

		if (allawable_control_array.indexOf(control_name) > -1) {
			console.log(" [Allowable Control] Control Type : " + control_name);
			$(this).attr("id", $(this).attr("name") + "_dropped" + counter++);

			$(this).draggable("destroy");

			$(this).click(function() {
			});
		}
		
		if ($(this).is("a")){
			$(this).attr("href", $(this).data("href"));
		}
		
		if ($(this).is("button")){
			$(this).attr("onclick", $(this).data("onclick"));
		}
	});
}

function makeControlsOfPaletteDraggable() {
	$(".selectorField").draggable({
		cancel : null,
		helper : "clone",
		cursor : "move",
		stack : "div",
		revert : "invalid",
		appendTo : $("#body"),
		stop : function(event, ui) {
			pos = $(ui.helper).offset();

		}
	});
}

function makeDroppedControlsDraggable(control) {
	control.draggable({
		containment : $("#frame"),
		cursor : "move",
		cancel : false,
	});
}

function updateImageSliderThumbnail() {
	$('#imageslider_edit_panel_thumbnail').sortable({
		items : ':not(#btn_img_slider_thumbnail_add)'
	});

	$('#imageslider_edit_panel_thumbnail li').on('click', function(el) {

		// if($(this).attr("id") == "btn_img_slider_thumbnail_add"){
		// $('<li />', {html:
		// 'new'}).appendTo('#imageslider_edit_panel_thumbnail')
		// updateImageSliderThumbnail();
		// }else{
		// console.log("clicked: Normal : " + $(this).attr("id"));
		// }

		if (confirm('Remove the Image from Slider?')) {
			$(this).remove()
		} else {

		}

	});
}

function makeImageSliderThumbnailSortable() {
	updateImageSliderThumbnail();

	$('#file_picker_imageslider').change(
			function(event) {
				var tmp_file_path = URL.createObjectURL(event.target.files[0]);
				var file_name = document
						.getElementById('file_picker_imageslider').value;
				$(
						'<li><img src="' + tmp_file_path
								+ '" class="slider_thumbnail" alt="'
								+ file_name + '"></li>').appendTo(
						'#imageslider_edit_panel_thumbnail')
				updateImageSliderThumbnail();
			});

	$("#btn_browse_imageslider").click(function() {

		$("#file_picker_imageslider").trigger("click");
	});

}

function isSameIDExistsInImageSliderList(image_id, image_slider_list){
	var is_found = false;
	
	$.each(image_slider_list, function(index, value) {
		if(value.ID == image_id) is_found = true;
	});
	return is_found;
}

function getImageIdFromSliderList(image_src, image_slider_list){
	var image_id = null;
	$.each(image_slider_list, function(index, value) {
		if(value.SRC == image_src) image_id = value.ID;
	});
	
	return image_id;
}

function getAvaiableImageIDList(imageSliderImageList, tmp_img_list){
	var available_id_list = [];
	$.each(tmp_img_list, function(index, value){
		if (imageSliderImageList.indexOf(value.SRC) < 0){
			available_id_list.push(value.ID);
		}
	});
	
	return available_id_list;
}


function createImageSlider(imageSliderImageList) {
	var target_slider = editable_control.find('ul');
	var file_name = "test_image";

	var tmp_img_list = [];
	target_slider.find("li").each(function(index, value){
		var tmp_id = $(this).find("img").attr("id");
		var tmp_src = $(this).find("img").attr("src");
		
		if(!isSameIDExistsInImageSliderList(tmp_id, tmp_img_list)){
			var tmpObj = {};
			tmpObj["ID"] = tmp_id;
			tmpObj["SRC"] = tmp_src;
			tmp_img_list.push(tmpObj);
		}	
	});
	//console.log("[TMP_IMAGE_LIST]: " + tmp_img_list);
	var available_id_list = getAvaiableImageIDList(imageSliderImageList, tmp_img_list);
	//console.log("[AVAILABLE_IMAGE_LIST]: " + tmp_img_list);
	
	target_slider.empty();

	$.each(imageSliderImageList, function(index, value) {
		var tmp_id = getImageIdFromSliderList(value, tmp_img_list);
		if(tmp_id == null){
			tmp_id = available_id_list.pop();
			if (tmp_id == undefined)
				{
					tmp_id = editable_control.attr("id") + "_img-" + (counter++);
				}
		}
		
		$(	
			'<li ><img src="' + value + '"  alt="' + file_name
					+ '"' + ' id=' + tmp_id + '></li>').appendTo(target_slider)
	});
	
	target_slider.data("total_item", imageSliderImageList.length);

	startImageSlider(editable_control);
	
//	animateImageSlider(editable_control, editable_control.width(),
//			editable_control.data("speed"), editable_control.data("pause"));

}

function startMonitoringMousePosition() {
	$("#body").mousemove(function(event) {
		currentMousePos.x = event.pageX;
		currentMousePos.y = event.pageY;
	});
}

function makeBodyDroppable() {
	$("#body").droppable(
			{
				activeClass : "activeDroppable",
				hoverClass : "hoverDroppable",
				/*
				 * accept : ":not(.ui-sortable-helper #control_option_dialog)",
				 */
				accept : ".draggableField",
				drop : function(event, ui) {
					var droppable_id = ui.helper.attr('id');
					var droppable_name = ui.helper.attr("name");
					console.log("Dropped Item name : " + droppable_name);
					var draggable = null;
					var is_radio_button = false;
					var is_image_slider = false;
					var is_group_builder = false;

					if (droppable_name == "button") {
						draggable = $("#button_template");

					} else if (droppable_name == "textarea") {
						draggable = $("#text_box_template");

					} else if (droppable_name == "dropdown") {
						draggable = $("#dropdown_template");

					} else if (droppable_name == "radiobutton") {
						draggable = $("#radiobutton_template");
						is_radio_button = true;

					} else if (droppable_name == "header") {
						draggable = $("#title_template");
					} else if (droppable_name == "image") {
						draggable = $("#image_template");
					} else if (droppable_name == "imageslider") {
						draggable = $("#image_slider_template");
						is_image_slider = true;
					} else if (droppable_name == "group") {
						if (ui.helper.data("form_type") == "feedback"){
							draggable = $("#form_template_feedback");
						}else if (ui.helper.data("form_type") == "contact"){
							draggable = $("#form_template_contact");
						}else if (ui.helper.data("form_type") == "leavemsg"){
							draggable = $("#form_template_leavemsg");
						}
						is_group_builder = true;
					} else if (droppable_name == "space") {
						$('<div style="height:200px"></div>').appendTo($("#body"));
						return;
					}
					
					if (draggable.data("is_dropped") == null
							|| draggable.data("is_dropped") == "false") {

						draggable = draggable.clone();
						draggable.css('left', currentMousePos.x + 'px');
						draggable.css('top', currentMousePos.y + 'px');

						draggable.removeClass("selectorField");
						draggable.addClass("droppedFields");

						if (draggable.data("id") == null){
							draggable[0].id = droppable_name + "_dropped_" + (counter++);
						}else{
							if (draggable.attr("name") == "image"){
								draggable[0].id = draggable.data("id") + "-" + (counter++);
								draggable.find("img").attr("id", draggable[0].id + "_img-" + (counter++));
							}else if (draggable.attr("name") == "imageslider"){
								draggable[0].id = draggable.data("id") + "-" + (counter++);
								draggable.find("ul").find('li').find("img").each(
										function(index, value) {
											$(this).attr("id", draggable[0].id + "_img-" + (counter++))
										});
							}
							else{
							draggable[0].id = draggable.data("id");
							}
						}
						
						
						draggable.data("is_dropped","true");

						if (is_radio_button) {
							var radio_btn_template_array = [ {
								"Id" : (draggable.attr("id") + 0),
								"Name" : draggable.attr("id"),
								"Text" : "Option 1"
							}, {
								"Id" : (draggable.attr("id") + 1),
								"Name" : draggable.attr("id"),
								"Text" : "Option 2"
							} ];
							createRadioButtonTemplate(draggable,
									radio_btn_template_array);
						}

						

						makeDroppedControlsDraggable(draggable);
						makeControlsOfPaletteDraggable();

						draggable.click(droppedItemClickAction);

						draggable.show(500);
						draggable.appendTo(this);
						draggable.css("z-index", "100");
						
						if (is_image_slider) {
							
							startImageSlider(draggable);
						}

						var pos = draggable.position();
					}

				}
			});
}



function startSlider(control, width, animation_speed, pause) {
	
	console.log("Speed : " + animation_speed + " : " + control.data("speed"));
	console.log("Pause : " + pause + " : " + control.data("pause"));
	
	var current_slide = 1;
	var $slider_container = control.children('ul');
	var $slides = $slider_container.children('li');
	
	$slider_container.css('margin-left', 0);
		
	var interval = setInterval(function() {
		$slider_container.animate({
			'margin-left' : '-=' + width
		}, animation_speed, function() {
			current_slide++;
			if (current_slide == $slides.length) {
				current_slide = 1;
				$slider_container.css('margin-left', 0);
			}
		});
		//console.log("Slider Time : " + new Date($.now()));
		
	}, pause);
	
	control.data("interval", interval);
}

function stopSlider(control) {
	console.log("Stop Slider : " + control.attr("id") + " : " + control.data("interval") );
	
	if(control.data("interval") != undefined)
	{
		clearInterval(control.data("interval"));
	}	
}

function animateImageSlider(control, width, animation_speed, pause) {


//	stopSlider(control);
//	startSlider(control, width, animation_speed, pause);

//	control.on('mouseenter', stopSlider(control)).on('mouseleave', startSlider(control, width, animation_speed, pause));

}

function startImageSlider(control){
//	console.log("inside function, ID: " + slider_id);
//	
//	var control = $("#" + slider_id);
//	
//	console.log("ID: " + control.attr("id"));
	
	var slider = control.find("ul");
	var visible_items = slider.data("visible_items");
	var animation_speed = slider.data("animation_speed");
	var pause_time = slider.data("pause_time");
	
	slider.flexisel({
        visibleItems: visible_items,
        animationSpeed: animation_speed,
        autoPlay: true,
        autoPlaySpeed: pause_time,            
        pauseOnHover: true,
        enableResponsiveBreakpoints: true,
        responsiveBreakpoints: { 
            portrait: { 
                changePoint:480,
                visibleItems: 1
            }, 
            landscape: { 
                changePoint:640,
                visibleItems: 2
            },
            tablet: { 
                changePoint:768,
                visibleItems: 3
            }
        }
    });
}

function createRadioButtonTemplate(control, radio_btn_list) {
	console.log(radio_btn_list);

	$.each(radio_btn_list, function() {
		console.log(this);

		control.append($('<input />', {
			type : 'radio',
			name : this.Name,
			id : this.Id,
			value : this.Id
		}));
		control.append($('<label />', {
			'style' : "text-indent: 2em;",
			'text' : this.Text,
			'for' : this.Id,
		}));
		control.append('<br />');
	});
}

function showRadioButtonEditPanel() {

	var count = 0;
	var option_txt = "";
	var old_radio_btn_array = [];

	function restoreInitialState() {
		// If cancel button is pressed, this function will be called
		createRadioButtonTemplate(editable_control, old_radio_btn_array);

		isSaved = false;
	}

	$("#" + editable_control.attr("id") + " :input").each(
			function() {

				var radio_id = $(this).attr("id");
				var radio_name = $(this).attr("name");
				var radio_txt = $('label[for=' + $(this).attr("id") + ']')
						.text();

				var radio_btn_info_array = [];
				radio_btn_info_array["Id"] = radio_id;
				radio_btn_info_array["Name"] = radio_name;
				radio_btn_info_array["Text"] = radio_txt;

				old_radio_btn_array[count++] = radio_btn_info_array;

				console.log("Info For Radio Button : " + radio_id + " : "
						+ radio_name + " : " + radio_txt);
			});

	$.each(old_radio_btn_array, function(index, value) {
		option_txt += old_radio_btn_array[index]["Text"];
		if (index != (old_radio_btn_array.length - 1)) {
			option_txt += "\n";
		}
	});

	$("#radio_btn_option_txt").val(option_txt);

	$("#radio_btn_edit_dialog").dialog({
		dialogClass : "no-close",
		resizable : false,
		draggable : true,
		closeOnEscape : true,
		title : "Button Edit Panel",
		width : 250,
		show : {
			effect : "slide",
			duration : 200,
			direction : "up"
		},
		beforeClose : function(event, ui) {
			makeControlNonEditable(editable_control);
			if (!isSaved) {
				restoreInitialState();
			}
		},

	});
}

function showButtonEditPanel() {

	var old_btn_text = editable_control.text();
	var old_color = editable_control.css('backgroundColor');

	$("#btn_text").val(old_btn_text);
	$("#btn_link").val('');

	function restoreInitialState() {
		// If cancel button is pressed, this function will be called
		isSaved = false;
		editable_control.html(old_btn_text);
		editable_control.css("background", old_color);
	}

	$("#btn_edit_dialog").dialog({
		dialogClass : "no-close",
		resizable : false,
		draggable : true,
		closeOnEscape : true,
		title : "Button Edit Panel",
		width : 250,
		show : {
			effect : "slide",
			duration : 200,
			direction : "up"
		},
		beforeClose : function(event, ui) {
			console.log("beforeClose called");

			makeControlNonEditable(editable_control);
			if (isSaved == false) {
				restoreInitialState();
			}
		},

	});

	$("#color_picker").spectrum(
			{
				color : "#6cc8f9",
				flat : false,
				showInput : false,
				containerClassName : 'color_picker_container',
				replacerClassName : 'color_picker_icon',
				showInitial : true,
				showPalette : true,
				showSelectionPalette : true,
				maxPaletteSize : 5,
				preferredFormat : "hex",
				localStorageKey : "spectrum.demo",
				move : function(color) {

				},
				show : function() {

				},
				beforeShow : function() {
				},
				hide : function() {
				},
				change : function(color) {
					editable_control.css("background", color);
				},
				palette : [
						[ "rgb(0, 0, 0)", "rgb(67, 67, 67)",
								"rgb(102, 102, 102)", "rgb(204, 204, 204)",
								"rgb(217, 217, 217)", "rgb(255, 255, 255)" ],
						[ "rgb(152, 0, 0)", "rgb(255, 0, 0)",
								"rgb(255, 153, 0)", "rgb(255, 255, 0)",
								"rgb(0, 255, 0)", "rgb(0, 255, 255)",
								"rgb(74, 134, 232)", "rgb(0, 0, 255)",
								"rgb(153, 0, 255)", "rgb(255, 0, 255)" ],
						[ "rgb(230, 184, 175)", "rgb(244, 204, 204)",
								"rgb(252, 229, 205)", "rgb(255, 242, 204)",
								"rgb(217, 234, 211)", "rgb(208, 224, 227)",
								"rgb(201, 218, 248)", "rgb(207, 226, 243)",
								"rgb(217, 210, 233)", "rgb(234, 209, 220)",
								"rgb(221, 126, 107)", "rgb(234, 153, 153)",
								"rgb(249, 203, 156)", "rgb(255, 229, 153)",
								"rgb(182, 215, 168)", "rgb(162, 196, 201)",
								"rgb(164, 194, 244)", "rgb(159, 197, 232)",
								"rgb(180, 167, 214)", "rgb(213, 166, 189)",
								"rgb(204, 65, 37)", "rgb(224, 102, 102)",
								"rgb(246, 178, 107)", "rgb(255, 217, 102)",
								"rgb(147, 196, 125)", "rgb(118, 165, 175)",
								"rgb(109, 158, 235)", "rgb(111, 168, 220)",
								"rgb(142, 124, 195)", "rgb(194, 123, 160)",
								"rgb(166, 28, 0)", "rgb(204, 0, 0)",
								"rgb(230, 145, 56)", "rgb(241, 194, 50)",
								"rgb(106, 168, 79)", "rgb(69, 129, 142)",
								"rgb(60, 120, 216)", "rgb(61, 133, 198)",
								"rgb(103, 78, 167)", "rgb(166, 77, 121)",
								"rgb(91, 15, 0)", "rgb(102, 0, 0)",
								"rgb(120, 63, 4)", "rgb(127, 96, 0)",
								"rgb(39, 78, 19)", "rgb(12, 52, 61)",
								"rgb(28, 69, 135)", "rgb(7, 55, 99)",
								"rgb(32, 18, 77)", "rgb(76, 17, 48)" ] ]
			});

}

function showTextEditPanel() {

	// $(".ui-dialog-titlebar-close").css("display", true);

	$("#text_edit_dialog").dialog({
		dialogClass : "no-close",
		resizable : false,
		draggable : true,
		closeOnEscape : true,
		title : "Text Editor",
		height : 100,
		width : 550,
		show : {
			effect : "slide",
			duration : 200,
			direction : "up"
		},
		position : {
			my : "center bottom",
			at : "center top-50",
			of : editable_control
		},
		beforeClose : function(event, ui) {
			makeControlNonEditable(editable_control);
		},

	});

	// $("#text_edit_dialog").addClass("ui-dialog-titlebar-close");

	// var dialog_titlebar = this.uiDialog.find( ".ui-dialog-titlebar" );

}

function showImageEditPanel() {

	editable_image = findImage();
	var old_image_path = editable_image.attr("src");
	var old_image_height = "";
	var old_image_width = "";
	
	if (editable_image.attr("id") == null){
		editable_image.attr("id", "image_" + counter++);
	}

	function restoreInitialState() {
		// If cancel button is pressed, this function will be called
		isSaved = false;
		setImage(old_image_path);
	}

	$("#dialog_input_image_path").val(old_image_path);

	$("#image_edit_dialog").dialog({
		dialogClass : "no-close",
		resizable : false,
		draggable : true,
		closeOnEscape : true,
		title : "Image Editor",
		width : 250,
		show : {
			effect : "slide",
			duration : 200,
			direction : "up"
		},

		beforeClose : function(event, ui) {
			makeControlNonEditable(editable_control);
			if (isSaved == false) {
				console.log("Restoring Initial State");
				restoreInitialState();
			}
		},

	});
}

function findImage(){
	if (editable_control.is("img")){
		return editable_control;
	}else if(editable_control.is("figure")){
		return editable_control.find("img");
	}else{
		return editable_control.find("img");
	}
}

function setImage(image_url){
	console.log("Image URL: " + image_url);
	var h = editable_image.height();
	var w = editable_image.width();
	editable_image.attr("src", image_url);
	editable_image.height(h);
	editable_image.width(w);
}

function showImageSliderEditPanel() {

	var slider_old_image_list = [];
	$("#imageslider_edit_panel_thumbnail").empty();
	var target_slider = editable_control.find("ul");
	var file_name = "test_image";

	console.log(target_slider.find('li').length);
	var count_image = target_slider.data("total_item");
	
	var pause_time = target_slider.data("pause_time")/1000;
	var animation_speed = target_slider.data("animation_speed")/1000;
	
	$("select#dropdown_slider_pause_time").val(pause_time);
	$("select#dropdown_slider_animation_speed").val(animation_speed);
	$("select#dropdown_slider_visible_item").val(target_slider.data("visible_items"));

	target_slider.find('li').each(
			function(index, value) {
				var image_url = $(this).children("img").attr("src");
				slider_old_image_list[index] = image_url;

//				if (index < (target_slider.find('li').length - 1)) {
				if (index < count_image) {
					$(
							'<li><img src="' + image_url
									+ '" class="slider_thumbnail" alt="'
									+ file_name + '"></li>').appendTo(
							"#imageslider_edit_panel_thumbnail");
				}
			});

	updateImageSliderThumbnail();
	
//	if(editable_control.data("pause") != undefined){
//	}else{
//		editable_control.data("pause", SLIDER_PAUSE);
//	}
//	
//	if(editable_control.data("speed") != undefined){
//	}else{
//		editable_control.data("speed", SLIDER_ANIMATION_SPEED);
//	}

	function restoreInitialState() {
		// If cancel button is pressed, this function will be called
		isSaved = false;
	}

	$("#imageslider_edit_dialog").dialog({
		dialogClass : "no-close",
		resizable : false,
		draggable : true,
		closeOnEscape : true,
		title : "Image Slider Editor",
		width : 250,
		show : {
			effect : "slide",
			duration : 200,
			direction : "up"
		},

		beforeClose : function(event, ui) {
			makeControlNonEditable(editable_control);
			if (isSaved == false) {
				console.log("Restoring Initial State");
				restoreInitialState();
			}
		},

	});
}

function showDropDownEditPanel() {

	var old_select_option_list = [];
	var option_txt = "";

	function restoreInitialState() {
		// If cancel button is pressed, this function will be called
		createDropdownTemplate(old_select_option_list);
		isSaved = false;
	}

	$("#" + editable_control.attr("id") + " option").each(
			function(index, value) {
				old_select_option_list[index] = $(this).text();
			});

	$.each(old_select_option_list, function(index, value) {
		option_txt += old_select_option_list[index];
		if (index != (old_select_option_list.length - 1)) {
			option_txt += "\n";
		}
	});

	$("#dropdown_option_txt").val(option_txt);

	$("#dropdown_edit_dialog").dialog({
		dialogClass : "no-close",
		resizable : false,
		draggable : true,
		closeOnEscape : true,
		title : "Drop Down Editor",
		width : 250,
		show : {
			effect : "slide",
			duration : 200,
			direction : "up"
		},

		beforeClose : function(event, ui) {
			makeControlNonEditable(editable_control);
			if (isSaved == false) {
				restoreInitialState();
			}
		},

	});
}

function showResizePanel() {
	closeAllEditDialogPanel();
	editable_control = $("#" + clicked_dropped_item_id);
	makeControlEditable(editable_control);
	editable_control.prop('contenteditable', 'false');

	$("#txt_height_resize_dialog").val(editable_control.height());
	$("#txt_width_resize_dialog").val(editable_control.width());

	$("#resize_dialog").dialog({
		dialogClass : "no-close",
		resizable : false,
		draggable : true,
		closeOnEscape : true,
		title : "Resize Option Panel",
		height : 90,
		width : 350,
		show : {
			effect : "slide",
			duration : 200,
			direction : "up"
		},
		position : {
			my : "center bottom",
			at : "center top-50",
			of : editable_control
		},
		beforeClose : function(event, ui) {
			makeControlNonEditable(editable_control);
			editable_control.resizable("destroy");
		},

	});

	makeControlResizable();
}

function makeControlResizable() {
	editable_control.resizable({
		ghost : false,
		animate : false,
		autoHide : false,
		distance : 0,
		handles : "n, e, s, w, ne, se, sw, nw",
		create : function(event, ui) {
		},
		resize : function(event, ui) {
			$("#txt_height_resize_dialog").val(ui.size.height);
			$("#txt_width_resize_dialog").val(ui.size.width);

//			if (editable_control.attr("name") == "imageslider") {
//				editable_control.children("ul").children("li").each(function() {
//					$(this).height(ui.size.height);
//					$(this).width(ui.size.width);
//
//					$(this).children("img").height(ui.size.height);
//					$(this).children("img").width(ui.size.width);
//				});
//
//			}

		},
		stop : function(event, ui) {
//			animateImageSlider(editable_control, editable_control.width(),
//					editable_control.data("speed"), editable_control.data("pause"));
		},
	});
}

function showGroupEditPanel() {
	editable_group = editable_control;
	
	if (editable_control.data("is_form") != null){
		$("#btn_group_edit_add_label").css("display", "none");
	}else{
		$("#btn_group_edit_add_label").css("display", "block");
	}
	
	$("#group_edit_dialog").dialog({
		dialogClass : "no-close",
		resizable : false,
		draggable : true,
		closeOnEscape : true,
		title : "Group edit Panel",
		height : 100,
		width : 350,
		show : {
			effect : "slide",
			duration : 200,
			direction : "up"
		},
		position : {
			my : "center bottom",
			at : "center top-50",
			of : editable_group
		},
		beforeClose : function(event, ui) {
			makeControlNonEditable(editable_group);
			editable_group.resizable("destroy");
			$("#body").droppable("enable");
			is_group_edit_mode = false;
			
			editable_group.find("*").each(function() {
				var control_name = $(this).attr("name");
				if (allawable_group_control_array.indexOf(control_name) > -1) {
					$(this).draggable("destroy");
					$(this).click(function() {
					});
				}
			});

		},

	});

	makeGroupEditable();
}


function showTextInputEditPanel(){
	
	var old_hint = editable_control.attr("placeholder");
	$("#text_input_hint_text").val(old_hint);
	
	function restoreInitialState() {
		// If cancel button is pressed, this function will be called
		editable_control.attr("placeholder", old_hint);
		isSaved = false;
	}
	
	$("#text_input_edit_dialog").dialog({
		dialogClass : "no-close",
		resizable : false,
		draggable : true,
		closeOnEscape : true,
		title : "Text Input edit Panel",
		width : 350,
		show : {
			effect : "slide",
			duration : 200,
			direction : "up"
		},
		position : {
			my : "center bottom",
			at : "center top-50",
			of : editable_group
		},
		beforeClose : function(event, ui) {
			makeControlNonEditable(editable_control);
			if (isSaved == false) {
				restoreInitialState();
			}
		},

	});
}

function makeGroupEditable() {
	makeControlResizable();
	makeGroupControlDraggable();
	$("#body").droppable("disable");
}

function makeGroupControlDraggable() {
	editable_group.find("*").each(function() {
		var control_name = $(this).attr("name");
		if (allawable_group_control_array.indexOf(control_name) > -1) {
			console.log(" [Allowable Control] Control Type : " + control_name);
			$(this).draggable({
				containment : editable_group,
				cursor : "move",
				cancel : false,
			});

			$(this).attr("id", control_name + "_group_" + counter++);
			$(this).click(droppedItemClickAction);
		}
	});
}




function showEditPanel() {

	closeAllEditDialogPanel();

	editable_control = $("#" + clicked_dropped_item_id);
	var editable_control_name = editable_control.attr("name");
	
	child_item = $("#" + clicked_dropped_item_id + " :first");

	makeControlEditable(editable_control);

	if (editable_control_name.indexOf("button") >= 0) {
		showButtonEditPanel();

	} else if (editable_control_name.indexOf("textarea") >= 0) {
		showTextEditPanel();
		// makeTextAreaEditable();
	} else if (editable_control_name.indexOf("dropdown") >= 0) {
		showDropDownEditPanel();
	} else if (editable_control_name.indexOf("radiobutton") >= 0) {
		showRadioButtonEditPanel();
	} else if (editable_control_name.indexOf("header") >= 0) {
		showTextEditPanel();
	} else if (editable_control_name.indexOf("imageslider") >= 0) {
		showImageSliderEditPanel();
	} else if (editable_control_name.indexOf("image") >= 0) {
		showImageEditPanel();
	} else if (editable_control_name == 'group') {
		// ToDo
		showGroupEditPanel();
	} else if (editable_control_name.indexOf("separator") >= 0) {
		// ToDo
		alert("Under Construction");
		makeControlNonEditable(editable_control);
	} else if (editable_control_name.indexOf("textinput") >= 0) {
		showTextInputEditPanel();
	}

	/*
	 * editable_control.removeClass("text_template_non_editable");
	 * editable_control.addClass("text_template_editable");
	 * editable_control.draggable("disable"); editable_control.off("click");
	 * editable_control.attr("contentEditable", true);
	 */

}

function makeControlEditable(control) {
	control.addClass("editable_mode");
	control.draggable("disable");
	control.unbind("click", droppedItemClickAction);
	if ($("#"+clicked_dropped_item_id).attr('name').indexOf("textarea") >= 0
			|| $("#"+clicked_dropped_item_id).attr('name').indexOf("header") >= 0) {
		control.prop('contenteditable', 'true');
	}

}

function makeControlNonEditable(control) {
	console.log("Making Control Non Editable");
	control.removeClass("editable_mode");
	control.draggable("enable");
	control.click(droppedItemClickAction);
	if ($("#"+clicked_dropped_item_id).attr('name').indexOf("textarea") >= 0
			|| $("#"+clicked_dropped_item_id).attr('name').indexOf("header") >= 0) {
		control.prop('contenteditable', 'false');
	}
}

function closeAllEditDialogPanel() {

	if ($("#control_option_dialog").dialog("instance") != undefined) {
		$("#control_option_dialog").dialog("close");
	}
	if ($("#text_edit_dialog").dialog("instance") != undefined) {
		$("#text_edit_dialog").dialog("close");
	}
	if ($("#btn_edit_dialog").dialog("instance") != undefined) {
		$("#btn_edit_dialog").dialog("close");
	}
	if ($("#radio_btn_edit_dialog").dialog("instance") != undefined) {
		$("#radio_btn_edit_dialog").dialog("close");
	}
	if ($("#image_edit_dialog").dialog("instance") != undefined) {
		$("#image_edit_dialog").dialog("close");
	}
	if ($("#dropdown_edit_dialog").dialog("instance") != undefined) {
		$("#dropdown_edit_dialog").dialog("close");
	}
	if ($("#image_slider_edit_dialog").dialog("instance") != undefined) {
		$("#image_slider_edit_dialog").dialog("close");
	}
	if ($("#resize_dialog").dialog("instance") != undefined) {
		$("#resize_dialog").dialog("close");
	}
	if ($("#text_input_edit_dialog").dialog("instance") != undefined) {
		$("#text_input_edit_dialog").dialog("close");
	}

	if (!is_group_edit_mode) {
		if ($("#group_edit_dialog").dialog("instance") != undefined) {
			$("#group_edit_dialog").dialog("close");
		}
	}
}

function makeTextAreaEditable() {
	editable_control.addClass("jqte-test");
	editable_control.jqte({
		"status" : true
	});
}

function droppedItemClickAction() {

	clicked_dropped_item_id = $(this).attr("id");
	clicked_dropped_item_name = $(this).attr("name");
	var title = "";

	if (clicked_dropped_item_name.indexOf("button") >= 0) {
		title = "BUTTON ...";
	} else if (clicked_dropped_item_name.indexOf("textarea") >= 0) {
		title = "TEXT ...";
		console.log("Text Area Clicked");
	} else if (clicked_dropped_item_name.indexOf("dropdown") >= 0) {
		title = "DROP DOWN ...";
		// $(this).draggable("disable");
		// $("#" + clicked_dropped_item_id + " :first").focus();
		$(this).focus();
		// $(this).parent().focus();
		// $(this).draggable("enable");
	} else if (clicked_dropped_item_name.indexOf("radiobutton") >= 0) {
		title = "RADIO BUTTON ...";
	} else if (clicked_dropped_item_name.indexOf("header") >= 0) {
		title = "HEADER ...";
	} else if (clicked_dropped_item_name.indexOf("imageslider") >= 0) {
		title = "IMAGE SLIDER ...";
	} else if (clicked_dropped_item_name.indexOf("image") >= 0) {
		title = "IMAGE ...";
	} else if (clicked_dropped_item_name == 'group') {
		title = "GROUP ...";
	} else if (clicked_dropped_item_name.indexOf("separator") >= 0) {
		title = "SEPARATOR ...";
	} else if (clicked_dropped_item_name.indexOf("textinput") >= 0) {
		title = "TEXT INPUT ..."; 
	} else if (clicked_dropped_item_name.indexOf("form") >= 0) {
		title = "FORM ..."; 
	}
	
	
	if ($("#"+clicked_dropped_item_id).attr("name").indexOf("group_") >= 0) {
		is_group_edit_mode = true;
		console.log("group Control Clicked");
	} else {
		is_group_edit_mode = false;
		console.log("Normal Control Clicked");
	}

	// child_item.resizable({
	// ghost : false,
	// animate : false,
	// autoHide : true,
	// distance : 0,
	// /* handles : "n, e, s, w, ne, se, sw, nw", */
	// alsoResize : "#" + clicked_dropped_item_id
	// /*
	// * resize: function(){ $("#" +
	// * clicked_dropped_item_id).css("height",child_item.height+"px");
	// $("#" +
	// * clicked_dropped_item_id).css("width",child_item.width+"px"); }
	// */
	// });

	console.log("clicked Id: " + clicked_dropped_item_id + " Title: " + title);
	
	$("#control_option_dialog").dialog({
		dialogClass : "no-close",
		resizable : false,
		draggable : true,
		closeOnEscape : true,
		title : title,
		width : 180,
		show : {
			effect : "slide",
			duration : 200,
			direction : "up"
		},
		hide : {
			effect : "explode",
			duration : 200
		},
		position : {
			my : "center top",
			at : "center bottom",
			of : $(this)
		},
		close : function() {
		},

	});

	// $("#control_option_dialog").bind("clickoutside", function(event) {
	// $("#control_option_dialog").dialog("close");
	// $("#control_option_dialog").unbind("clickoutside");
	// });

	// addClickOutsideEvent($("#control_option_dialog"));
	//		
	// window.addEventListener('mouseup', function(event){
	// var box = $("#control_option_dialog");
	// if (event.target != box && event.target.parentNode != box){
	// box.dialog("close");
	// }
	// });
	//
	// function addClickOutsideEvent(control) {
	//			
	//			
	// var mouse_click = 0;
	// control.bind("clickoutside", function(event) {
	// if (control.dialog("isOpen")) {
	// alert("open : " + mouse_click);
	// if (mouse_click > 0) {
	// control.dialog("close");
	// mouse_click = 0;
	// } else {
	// mouse_click = 1;
	// }
	// }else{
	// alert("closed : " + mouse_click);
	// }
	// });
	// }

}

var indexOf = function(needle) {
	if (typeof Array.prototype.indexOf === 'function') {
		indexOf = Array.prototype.indexOf;
	} else {
		indexOf = function(needle) {
			var i = -1, index = -1;

			for (i = 0; i < this.length; i++) {
				if (this[i] === needle) {
					index = i;
					break;
				}
			}
			return index;
		};
	}
	return indexOf.call(this, needle);
};

function createDropdownTemplate(new_dropdown_options) {
	$("#" + editable_control.attr("id") + " option").remove();

	$.each(new_dropdown_options, function(index, values) {
		editable_control.append('<option value="' + new_dropdown_options[index]
				+ '"> ' + new_dropdown_options[index] + '</option>');
	});
}

function getAllDeletedImages(){
	return deleted_image_list;
}

function initializeAllDialogButton() {
	/*
	 * Button Initialization for Option Dialog Panel
	 */

	$("#dialog_btn_delete").click(function() {		
		if(clicked_dropped_item_name == "image" || clicked_dropped_item_name == "group_image"){
			console.log("[DELETE_IMAGE]: " + clicked_dropped_item_id);
			editable_control = $("#" + clicked_dropped_item_id);
			var deleted_img = findImage();			
			var tmp_obj = {};
			tmp_obj["ID"] = deleted_img.attr("id");
			tmp_obj["SRC"] = deleted_img.attr("src");;
			tmp_obj["MENU"] = curMenu;
			deleted_image_list.push(tmp_obj);
			
		}else if (clicked_dropped_item_name == "imageslider" || clicked_dropped_item_name == "group_imageslider"){
			console.log("[DELETE_IMAGESLIDER]: " + clicked_dropped_item_id);
			stopSlider($("#" + clicked_dropped_item_id));
			var target_slider = $("#" + clicked_dropped_item_id).find('ul');
			var count_image = target_slider.data("total_item");
			target_slider.find("li").each(function(index, value){
				if(index < count_image){
					var deleted_img = $(this).find("img");			
					var tmp_obj = {};
					tmp_obj["ID"] = deleted_img.attr("id");
					tmp_obj["SRC"] = deleted_img.attr("src");;
					tmp_obj["MENU"] = curMenu;
					deleted_image_list.push(tmp_obj);
				}
			});
		}
		console.log(deleted_image_list);
		
		$("#" + clicked_dropped_item_id).remove();
		$("#control_option_dialog").dialog("close");
		
	});

	$("#dialog_btn_edit").click(function() {
		showEditPanel();
		$("#control_option_dialog").dialog("close");
	});

	$("#dialog_btn_resize").click(function() {
		showResizePanel();

	});

	$("#dialog_btn_cancel").click(function() {
		$("#control_option_dialog").dialog("close");
	});

	/*
	 * Button Initialization for Radio button
	 */

	$("#radio_btn_dialog_cancel").click(function() {
		$("#radio_btn_edit_dialog").dialog("close");
	});

	$("#radio_btn_dialog_save").click(function() {

		editable_control.empty();

		var radio_options = $("#radio_btn_option_txt").val();
		var new_radio_options = radio_options.split('\n');

		if (new_radio_options[new_radio_options - 1] == null) {
			// To Do
			// if extra new lines are detected
		}
		var final_radio_options = [];

		$.each(new_radio_options, function(index, value) {
			var final_radio = [];
			final_radio["Id"] = editable_control.attr("id") + index;
			final_radio["Name"] = editable_control.attr("id");
			final_radio["Text"] = value;
			final_radio_options[index] = final_radio;
		});

		createRadioButtonTemplate(editable_control, final_radio_options);

		isSaved = true;

		$("#radio_btn_edit_dialog").dialog("close");
	});

	/*
	 * Button initialization for Button Edit Panel
	 */

	$("#btn_dialog_cancel").click(function() {
		$("#btn_edit_dialog").dialog("close");
	});

	$("#btn_text").keyup(function(event) {
		editable_control.html($("#btn_text").val());
	});

	$("#btn_dialog_save").click(function() {
		isSaved = true;
		$("#btn_edit_dialog").dialog("close");
	});

	/*
	 * Button Initialization for Text Edit panel
	 */

	$("#btn_txt_editor_close").click(function() {
		$("#text_edit_dialog").dialog("close");
	});

	$("#btn_txt_editor_normal").click(function() {
		editable_control.css('font-weight', 'normal');
		editable_control.css('font-style', 'normal');

	});

	$("#btn_txt_editor_bold").click(function() {

		if (editable_control.data("isbold") == null) {
			editable_control.data("isbold", "false");
		}

		if (editable_control.data("isbold") == "false") {
			editable_control.css('font-weight', 'bold');
			editable_control.data("isbold", "true");

		} else {
			editable_control.css('font-weight', 'normal');
			editable_control.data("isbold", "false");
		}

	});

	$("#btn_txt_editor_italic").click(function() {

		if (editable_control.data("isitalic") == null) {
			editable_control.data("isitalic", "false");
		}

		if (editable_control.data("isitalic") == "false") {
			editable_control.css('font-style', 'italic');
			editable_control.data("isitalic", "true");

		} else {
			editable_control.css('font-style', 'normal');
			editable_control.data("isitalic", "false");
		}

	});

	$("#btn_txt_editor_left_align").click(function() {
		editable_control.css('text-align', 'left');
	});

	$("#btn_txt_editor_center_align").click(function() {
		editable_control.css('text-align', 'center');
	});

	$("#btn_txt_editor_right_align").click(function() {
		editable_control.css('text-align', 'right');
	});

	$("#dropdown_txt_editor_font_family").on("change", function() {
		editable_control.css("font-family", this.value);
	});

	$("#dropdown_txt_editor_font_size").on("change", function() {
		editable_control.css("font-size", this.value + "px");
	});

	/*
	 * Button Initializatin for Image Edit Panel
	 */

	$("#btn_browse_image").click(function() {

		$('#file_picker').change(function(event) {
			var tmp_file_path = URL.createObjectURL(event.target.files[0]);
			var file_name = document.getElementById('file_picker').value;
			$("#dialog_input_image_path").val(file_name);
			setImage(tmp_file_path);

		});

		$("#file_picker").trigger("click");
	});

	$("#btn_image_dialog_cancel").click(function() {
		$("#image_edit_dialog").dialog("close");
	});

	$("#btn_imgage_dialog_save").click(function() {
		isSaved = true;
		console.log("Save btn Clicked : " + isSaved);

		$("#image_edit_dialog").dialog("close");
	});

	/*
	 * Button Initialization for Drop Down Edit Panel
	 */

	$("#btn_dropdown_dialog_cancel").click(function() {

		$("#dropdown_edit_dialog").dialog("close");
	});

	$("#btn_dropdown_dialog_save").click(function() {

		var dropdown_options = $("#dropdown_option_txt").val();
		var new_dropdown_options = dropdown_options.split('\n');

		if (new_dropdown_options[new_dropdown_options.length - 1] == null) {
			// To Do
			// if extra new lines are detected
		}

		createDropdownTemplate(new_dropdown_options);

		isSaved = true;
		$("#dropdown_edit_dialog").dialog("close");
	});

	/*
	 * Button Initialization for Image Slider
	 */
	$("#btn_imgageslider_dialog_save").click(
			function() {

				var slider_image_list = [];
				var first_image_url = "";

				$("#imageslider_edit_panel_thumbnail").find('li').each(
						function(index, value) {
							slider_image_list[index] = $(this).children("img")
									.attr("src");
							if (index == 0) {
								first_image_url = $(this).children("img").attr(
										"src");
							}
						});
				//slider_image_list.push(first_image_url);

				isSaved = true;
				console.log(slider_image_list);

				createImageSlider(slider_image_list);

				$("#imageslider_edit_dialog").dialog("close");
			});

	$("#btn_imageslider_dialog_cancel").click(function() {
		$("#imageslider_edit_dialog").dialog("close");
	});
	
	$("#dropdown_slider_pause_time").on("change", function() {
		var new_pause = this.value*1000;
		editable_control.find('ul').data("pause_time", new_pause);
	});

	$("#dropdown_slider_animation_speed").on("change", function() {
		var new_speed = this.value*1000;
		editable_control.find('ul').data("animation_speed", new_speed);
	});
	
	$("#dropdown_slider_visible_item").on("change", function() {
		var visible_item = this.value;
		editable_control.find('ul').data("visible_items", visible_item);
	});

	/*
	 * Button Initialization for Resize Option panel
	 */

	$("#btn_resize_close").click(function() {
		$("#resize_dialog").dialog("close");
	});

	$("#btn_resize_apply").click(function() {
		editable_control.height($("#txt_height_resize_dialog").val());
		editable_control.width($("#txt_width_resize_dialog").val());
	});

	/*
	 * Button Initialization for Group Editor
	 */
	$("#btn_group_edit_panel_close").click(function() {
		$("#group_edit_dialog").dialog("close");
	});
	
	/*
	 * Button Initialization for Text Input Editor
	 */
	$("#btn_text_input_cancel").click(function(){
		isSaved = false;
		$("#text_input_edit_dialog").dialog("close");
	});
	
	$("#btn_text_input_save").click(function(){
		isSaved = true;
		$("#text_input_edit_dialog").dialog("close");
	});
	
	$("#text_input_hint_text").keyup(function(event) {
		editable_control.attr("placeholder", $("#text_input_hint_text").val());
	});
	
	$("#btn_group_edit_add_label").click(function(){
		var new_label = $('<div><h2>Title, Edit me</h2><p>Lorem Ipsum is simply dummy text</p></div>');
		new_label.attr("id", "textarea_group_" + counter++);
		new_label.attr("name", "group_textarea");
		new_label.css("width", "300px");
		new_label.css("height", "70px");
		
		new_label.draggable({
			containment : editable_group,
			cursor : "move",
			cancel : false,
		});
		new_label.click(droppedItemClickAction);
		
		new_label.appendTo(editable_group);
	});
	
	$("#btn_group_edit_background").click(function(){
		openBGEditor(editable_control);
	});
	
	$("#btn_group_edit_add_input_text").click(function(){
		var new_text_input = $('<input name="textinput" type="text"' +
				' name="textinput" placeholder="Write Here"' +
					' style="width: 100%; border: .5px solid lightgrey; border-radius: 5px;">');
		new_text_input.attr("id", "textinput_group_" + counter++);
		new_label.attr("name", "group_textinput");
		
		new_text_input.draggable({
			containment : editable_group,
			cursor : "move",
			cancel : false,
		});
		new_text_input.click(droppedItemClickAction);
		
		new_text_input.prependTo(editable_group);
	});

} 

$(function() {

	makeControlsOfPaletteDraggable();
	
	if (typeof isInEditor !== 'undefined' && isInEditor) {
        makeTemplateComponetsEditable();
        //onTemplateMenuLoad();
    } else if(typeof isView !== 'undefined' && isView){
    } else {
    	alert("Can't recognize Whether it is editor or viewer");
    }
	
	startMonitoringMousePosition();
	makeBodyDroppable();
	makeImageSliderThumbnailSortable();
	initializeAllDialogButton();
	
	

	// $(document).mouseup(function(e){
	// var clicked_item = e.target;
	//		
	// if ( editable_control != null ){
	// if (editable_control.is(clicked_item))
	// {
	// console.log("Matched");
	// }
	// }
	// });

	/*
	 * $("#frame").find("*").draggable({ containment : "#frame", // cancel :
	 * null });
	 */

	/*
	 * $("a.tab").click(function() { // switch all tabs off
	 * $(".active").removeClass("active"); // switch this tab on
	 * $(this).addClass("active"); // slide all elements with the class
	 * 'content' up $(".content").slideUp(); // Now figure out what the 'title'
	 * attribute value is and find the element with that id. Then slide that
	 * down. var content_show = $(this).attr("title"); $("#" +
	 * content_show).slideDown();
	 * 
	 * });
	 */
});
