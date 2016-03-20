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
		"separator", "textinput", "form", "link", "mrg_control" ]

var allawable_group_control_array = [ "group_button", "group_textarea", "group_radiobutton",
                        		"group_dropdown", "group_image", "group_imageslider", "group_header",
                        		"group_separator", "group_textinput", "group_link", "group_mrg_control" ]
var deleted_image_list = [];

var currentMousePos = {
	x : -1,
	y : -1
};

function makeTemplateComponetsEditable() {
	console.log("[INFO] Making Template Control Editable");

	$("#body").find("*").each(function() {
		var control_id = $(this).attr("id");
		var control_name = $(this).attr("name");

		//console.log(control_id + " : " + control_name);

		if (allawable_control_array.indexOf(control_name) > -1) {
			//console.log(" [Allowable Control] Control Type : " + control_name);
			if ($(this).attr("id") == null)
			{
				$(this).attr("id", $(this).attr("name") + "_dropped" + counter++);
			}
			$(this).attr("data-is_dropped","true");

			makeDroppedControlsDraggable($(this));

			$(this).click(droppedItemClickAction);
		}
		
		if (control_name == "imageslider" || control_name == "group_imageslider" )
		{
			startImageSlider($(this));
		}
		
		if ($(this).is("a")){
			$(this).attr("data-href", $(this).attr("href"));
			$(this).attr("href", null);
		}
		
		// if ($(this).is("button")){
		// 	$(this).attr("data-onclick", $(this).attr("onclick"));
		// 	$(this).attr("onclick", null);
		// }
		
	});
}

function LoadTemplateAnimations()
{
	$("#body").find("*").each(function() {
		var control_id = $(this).attr("id");
		var control_name = $(this).attr("name");

		if (allawable_control_array.indexOf(control_name) > -1) {
			if ($(this).is("button")){
				if ($(this).attr("data-onclick") != null)
				{
					$(this).click(function(){
						var url = $(this).attr("data-onclick")
						if (url.indexOf("http://") < 0)
							url = "http://" + url;
						location.href = url;	
					});
				}
			}
		}
		
		if (control_name == "imageslider" || control_name == "group_imageslider" )
		{
			startImageSlider($(this));
		}
	});
}

function makeTemplateComponetsNotEditable() {
	console.log("[INFO] Making Tempate Controls Not Editable");

	$("#body").find("*").each(function() {
		var control_id = $(this).attr("id");
		var control_name = $(this).attr("name");
		
		//console.log(control_id + " : " + control_name);

		if (allawable_control_array.indexOf(control_name) > -1) {
			//console.log(" [Allowable Control] Control Type : " + control_name);
			$(this).attr("id", $(this).attr("name") + "_dropped" + counter++);

			if ($(this).draggable("instance") != undefined)
			{
				$(this).draggable("destroy");
			}
			$(this).removeClass("droppedFields");
			$(this).removeClass("draggableField");
			$(this).removeClass("ui-draggable");
			$(this).removeClass("ui-draggable-handle");
			$(this).removeClass("ui-draggable-dragging");	

			// $(this).click(function() {
			// });
		}
		
		if ($(this).is("a")){
			$(this).attr("href", $(this).attr("data-href"));
		}


		if (control_name == "imageslider" || control_name == "group_imageslider")
		{
			var target_slider = $(this).find("ul");
			var tmp_slider_image_list = target_slider.clone();
			var count_image = parseInt(target_slider.attr("data-total_item"));
			target_slider.empty();

			tmp_slider_image_list.find('li').each(
				function(index, value) {
					if (index < count_image) {
						$(this).appendTo(target_slider);
				}
			});
		}
	});
}

function onMenuPageModified(menu_name, content_name, action)
{
    console.log('Menu:[' + menu_name + ']/ Content:[' + content_name + ']/ Action:[' + action + ']');   

	if(pagesEditedCollection.length == 0)
	{
		pagesEdited[menu_name] = true;
		pagesEditedCollection.push(pagesEdited);
		return;
	}

	$.each(pagesEditedCollection, function( index, value ) {
		if(typeof value[menu_name] === 'undefined')
		{
			pagesEdited[menu_name] = true;
			pagesEditedCollection.push(pagesEdited);	
            console.log('Menu added (' + menu_name + '): edited:' + pagesEdited[menu_name]);   
		}
		else
		{
			value[menu_name] = true;
            console.log('Menu edited (' + menu_name + '): edited:' + pagesEdited[menu_name]);   
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

var tmp_z_index = 0;

function makeDroppedControlsDraggable(control) {
	control.draggable({
		containment : $("#frame"),
		cursor : "move",
		cancel : false,
		start : function(){
			onMenuPageModified(curMenu, $(this).attr("id"), "DRAG");
			tmp_z_index = $(this).css("z-index");
			//$(this).css("z-index", "1000");
		},
		stop : function(){
			//$(this).css("z-index", tmp_z_index);
		},
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
	
	target_slider.attr("data-total_item", imageSliderImageList.length);

	startImageSlider(editable_control);
	
//	animateImageSlider(editable_control, editable_control.width(),
//			editable_control.attr("data-speed"), editable_control.attr("data-pause"));

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
						//draggable = $("#button_template");
						draggable = ui.helper;
					} else if (droppable_name == "textarea") {
						draggable = $("#text_box_template"); // preview

					} else if (droppable_name == "dropdown") {
						draggable = $("#dropdown_template"); // preview

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
						if (ui.helper.attr("data-form_type") == "feedback"){
							draggable = $("#form_template_feedback");
						}else if (ui.helper.attr("data-form_type") == "contact"){
							draggable = $("#form_template_contact");
						}else if (ui.helper.attr("data-form_type") == "leavemsg"){
							draggable = $("#form_template_leavemsg");
						}
						is_group_builder = true;
					} else if (droppable_name == "space") {
						$('<div style="height:200px"></div>').appendTo($("#body"));
						return;
					} else if (droppable_name == "mrg_control") {
						draggable = ui.helper;
					}
					

					if (draggable.attr("data-is_dropped") == null
							|| draggable.attr("data-is_dropped") == "false") {

						draggable = draggable.clone();
						draggable.css('left', currentMousePos.x + 'px');
						draggable.css('top', currentMousePos.y + 'px');

						draggable.removeClass("selectorField");
						draggable.addClass("droppedFields");

						if (draggable.attr("data-id") == null){
							draggable[0].id = droppable_name + "_dropped_" + (counter++);
						}else{
							if (draggable.attr("name") == "image"){
								draggable[0].id = draggable.attr("data-id") + "-" + (counter++);
								draggable.find("img").attr("id", draggable[0].id + "_img-" + (counter++));
							}else if (draggable.attr("name") == "imageslider"){
								draggable[0].id = draggable.attr("data-id") + "-" + (counter++);
								draggable.find("ul").find('li').find("img").each(
										function(index, value) {
											$(this).attr("id", draggable[0].id + "_img-" + (counter++))
										});
							}
							else{
							draggable[0].id = draggable.attr("data-id");
							}
						}
						
						
						draggable.attr("data-is_dropped","true");

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

						onMenuPageModified(curMenu, draggable[0].id, "DROP");
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
	
	console.log("Speed : " + animation_speed + " : " + control.attr("data-speed"));
	console.log("Pause : " + pause + " : " + control.attr("data-pause"));
	
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
	
	control.attr("data-interval", interval);
}

function stopSlider(control) {
	console.log("Stop Slider : " + control.attr("id") + " : " + control.attr("data-interval") );
	
	if(control.attr("data-interval") != undefined)
	{
		clearInterval(control.attr("data-interval"));
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
	var visible_items = parseInt(slider.attr("data-visible_items"));
	var animation_speed = parseInt(slider.attr("data-animation_speed"));
	var pause_time = parseInt(slider.attr("data-pause_time"));
	
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
				start : function(){
					onMenuPageModified(curMenu, $(this).attr("id"), "DRAG");
				},
				stop : function(){

				}
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
	} else if (editable_control_name.indexOf("mrg_control") >= 0) {
		showTextEditPanel();
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
			|| $("#"+clicked_dropped_item_id).attr('name').indexOf("header") >= 0
			|| $("#"+clicked_dropped_item_id).attr('name').indexOf("mrg_control") >= 0) {
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
	} else if (clicked_dropped_item_name.indexOf("mrg_control") >= 0) {
		title = "MARRIAGE CONTROL ..."; 
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
	 * Button Initialization for Common Dialog buttons
	 */

	 $("#btn_editor_cancel").click(function(){
	 	$(this).parent().dialog("close");
	 });

	 $("#btn_editor_save").click(function(){
	 	isSaved = true;
	 	$(this).parent().dialog("close");
	 });
	 

	/*
	 * Button Initialization for Option Dialog Panel
	 */

	$("#dialog_btn_delete").click(function() {
		onMenuPageModified(curMenu, clicked_dropped_item_id, "DELETE");		
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
			var count_image = parseInt(target_slider.attr("data-total_item"));
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

		if (editable_control.attr("data-isbold") == null) {
			editable_control.attr("data-isbold", "false");
		}

		if (editable_control.attr("data-isbold") == "false") {
			editable_control.css('font-weight', 'bold');
			editable_control.attr("data-isbold", "true");

		} else {
			editable_control.css('font-weight', 'normal');
			editable_control.attr("data-isbold", "false");
		}

	});

	$("#btn_txt_editor_italic").click(function() {

		if (editable_control.attr("data-isitalic") == null) {
			editable_control.attr("data-isitalic", "false");
		}

		if (editable_control.attr("data-isitalic") == "false") {
			editable_control.css('font-style', 'italic');
			editable_control.attr("data-isitalic", "true");

		} else {
			editable_control.css('font-style', 'normal');
			editable_control.attr("data-isitalic", "false");
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
		$("#image_edit_dialog").dialog("close");
	});

	/*
	 * Button Initialization for Drop Down Edit Panel
	 */

	$("#btn_dropdown_dialog_cancel").click(function() {

		$("#dropdown_edit_dialog").dialog("close");
	});

	$("#btn_dropdown_dialog_save").click(function() {
		isSaved = true;
		$("#dropdown_edit_dialog").dialog("close");
	});

	/*
	 * Button Initialization for Image Slider
	 */
	$("#btn_imgageslider_dialog_save").click(function() {
		isSaved = true;
		$("#imageslider_edit_dialog").dialog("close");
	});

	$("#btn_imageslider_dialog_cancel").click(function() {
		$("#imageslider_edit_dialog").dialog("close");
	});
	
	$("#dropdown_slider_pause_time").on("change", function() {
		var new_pause = this.value*1000;
		editable_control.find('ul').attr("data-pause_time", new_pause);
	});

	$("#dropdown_slider_animation_speed").on("change", function() {
		var new_speed = this.value*1000;
		editable_control.find('ul').attr("data-animation_speed", new_speed);
	});
	
	$("#dropdown_slider_visible_item").on("change", function() {
		var visible_item = this.value;
		editable_control.find('ul').attr("data-visible_items", visible_item);
	});

	/*
	 * Button Initialization for Resize Option panel
	 */

	$("#btn_resize_close").click(function() {
		$("#resize_dialog").dialog("close");
	});

	$("#btn_resize_apply").click(function() {
		onMenuPageModified(curMenu, editable_control.attr("id"), "RESIZE");
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
		onMenuPageModified(curMenu, new_label.attr("id"), "PROP-MODIFY");
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
		onMenuPageModified(curMenu, new_text_input.attr("id"), "PROP-MODIFY");
	});

} 

$(function() {
    var isViewer = $('#hidden-div-is-view').text();
    isView = isViewer;
	
	if (typeof isInEditor !== 'undefined' && isInEditor) {
		console.log("[DEBUG] Is In Editor");
        makeControlsOfPaletteDraggable();
        startMonitoringMousePosition();
		makeBodyDroppable();
		makeImageSliderThumbnailSortable();
		initializeAllDialogButton();
    } else if(typeof isView !== 'undefined' && isView){
    	console.log("[DEBUG] Is In Viewer");
    } else {
    	alert("Can't recognize Whether it is editor or viewer");
    }
});
