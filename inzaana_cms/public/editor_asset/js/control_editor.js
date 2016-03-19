var editable_bg_control = null;
var gradient_color_1 = "#000000";
var gradient_color_2 = "#FFFFFF";

var color_palette = [
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
						"rgb(32, 18, 77)", "rgb(76, 17, 48)" ] ];

$(function(){
	initializeBGEditor();
	//openBGEditor(null);
});

function initializeBGEditor(){
	initializeColorPickers();
	updateGradientPalletes();
	
	$('#file_picker_bg_editor').change(function(event) {
		var tmp_file_path = URL.createObjectURL(event.target.files[0]);
		setBackgroundImage(editable_bg_control, tmp_file_path);
		
	});
	
	$("#btn_select_bg_image").click(function(){
		$("#file_picker_bg_editor").trigger("click");
	});
	
	$("#linear_gradient_right").click(function(){
		setLinearGradientRight(editable_bg_control);
	});
	$("#linear_gradient_left").click(function(){
		setLinearGradientLeft(editable_bg_control);
	});
	$("#linear_gradient_top").click(function(){
		setLinearGradientTop(editable_bg_control);
	});
	$("#linear_gradient_bottom").click(function(){
		setLinearGradientBottom(editable_bg_control);
	});
	$("#radial_gradient_in").click(function(){
		setRadialGradientIn(editable_bg_control);
	});
	$("#radial_gradient_out").click(function(){
		setRadialGradientOut(editable_bg_control);
	});
	
	$("#dropdown_bg_image_position").on("change", function() {
		editable_bg_control.css("background-position", this.value);
	});
	
	$("#dropdown_bg_image_repeat").on("change", function() {
		editable_bg_control.css("background-repeat", this.value);
	});
	
	$("#dropdown_bg_image_attachment").on("change", function() {
		editable_bg_control.css("background-attachment", this.value);
	});
	
	$("#btn_bg_editor_save").click(function(){
		isSaved = true;
		$("#dialog_bg_editor").dialog("close");
	});
	
	$("#btn_bg_editor_cancel").click(function(){
		isSaved = false;
		$("#dialog_bg_editor").dialog("close");
	});
	
}

function setBackgroundImage(control, image_url){
	console.log(control.attr("id") + " : " + image_url );
	control.css("background-image", "url(" + image_url + ")");
}

function updateGradientPalletes(){
	setLinearGradientRight($("#linear_gradient_right"));
	setLinearGradientLeft($("#linear_gradient_left"));
	setLinearGradientTop($("#linear_gradient_top"));
	setLinearGradientBottom($("#linear_gradient_bottom"));
	setRadialGradientIn($("#radial_gradient_in"));
	setRadialGradientOut($("#radial_gradient_out"));

}

function setLinearGradientRight(control){
	control.css("background", "-webkit-linear-gradient(left,"+ gradient_color_2 + ", " + gradient_color_1 + ")" );/* For Safari 5.1 to 6.0 */
	control.css("background", "-o-linear-gradient(right,"+ gradient_color_2 + ", " + gradient_color_1 + ")" ); /* For Opera 11.1 to 12.0 */
	control.css("background", "-moz-linear-gradient(right,"+ gradient_color_2 + ", " + gradient_color_1 + ")" ); /* For Firefox 3.6 to 15 */
	control.css("background", "linear-gradient(to right,"+ gradient_color_2 + ", " + gradient_color_1 + ")" ); /* Standard syntax */
}

function setLinearGradientLeft(control){
	control.css("background", "-webkit-linear-gradient(right,"+ gradient_color_2 + ", " + gradient_color_1 + ")" );/* For Safari 5.1 to 6.0 */
	control.css("background", "-o-linear-gradient(left,"+ gradient_color_2 + ", " + gradient_color_1 + ")" ); /* For Opera 11.1 to 12.0 */
	control.css("background", "-moz-linear-gradient(left,"+ gradient_color_2 + ", " + gradient_color_1 + ")" ); /* For Firefox 3.6 to 15 */
	control.css("background", "linear-gradient(to left,"+ gradient_color_2 + ", " + gradient_color_1 + ")" ); /* Standard syntax */
}

function setLinearGradientTop(control){
	control.css("background", "-webkit-linear-gradient(bottom,"+ gradient_color_2 + ", " + gradient_color_1 + ")" );/* For Safari 5.1 to 6.0 */
	control.css("background", "-o-linear-gradient(top,"+ gradient_color_2 + ", " + gradient_color_1 + ")" ); /* For Opera 11.1 to 12.0 */
	control.css("background", "-moz-linear-gradient(top,"+ gradient_color_2 + ", " + gradient_color_1 + ")" ); /* For Firefox 3.6 to 15 */
	control.css("background", "linear-gradient(to top,"+ gradient_color_2 + ", " + gradient_color_1 + ")" ); /* Standard syntax */
}

function setLinearGradientBottom(control){
	control.css("background", "-webkit-linear-gradient(top,"+ gradient_color_2 + ", " + gradient_color_1 + ")" );/* For Safari 5.1 to 6.0 */
	control.css("background", "-o-linear-gradient(bottom,"+ gradient_color_2 + ", " + gradient_color_1 + ")" ); /* For Opera 11.1 to 12.0 */
	control.css("background", "-moz-linear-gradient(bottom,"+ gradient_color_2 + ", " + gradient_color_1 + ")" ); /* For Firefox 3.6 to 15 */
	control.css("background", "linear-gradient(to bottom,"+ gradient_color_2 + ", " + gradient_color_1 + ")" ); /* Standard syntax */
}

function setRadialGradientIn(control){
	control.css("background", "-webkit-radial-gradient("+ gradient_color_2 + ", " + gradient_color_1 + ")" );/* For Safari 5.1 to 6.0 */
	control.css("background", "-o-radial-gradient("+ gradient_color_2 + ", " + gradient_color_1 + ")" ); /* For Opera 11.1 to 12.0 */
	control.css("background", "-moz-radial-gradient("+ gradient_color_2 + ", " + gradient_color_1 + ")" ); /* For Firefox 3.6 to 15 */
	control.css("background", "radial-gradient("+ gradient_color_2 + ", " + gradient_color_1 + ")" ); /* Standard syntax */
}

function setRadialGradientOut(control){
	control.css("background", "-webkit-radial-gradient("+ gradient_color_1 + ", " + gradient_color_2 + ")" );/* For Safari 5.1 to 6.0 */
	control.css("background", "-o-radial-gradient("+ gradient_color_1 + ", " + gradient_color_2 + ")" ); /* For Opera 11.1 to 12.0 */
	control.css("background", "-moz-radial-gradient("+ gradient_color_1 + ", " + gradient_color_2 + ")" ); /* For Firefox 3.6 to 15 */
	control.css("background", "radial-gradient("+ gradient_color_1 + ", " + gradient_color_2 + ")" ); /* Standard syntax */
}

function initializeColorPickers(){
	$("#bg_color_picker").spectrum(
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
					editable_bg_control.css("background", color);
				},
				palette : color_palette
			});
	
	$("#bg_color_picker_gradient_1").spectrum(
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
					gradient_color_1 =  color;
					updateGradientPalletes();
				},
				palette : color_palette
			});
	
	$("#bg_color_picker_gradient_2").spectrum(
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
					gradient_color_2 =  color;
					updateGradientPalletes();
				},
				palette : color_palette
			});
	
	$(".sp-replacer").css("width", "80px");
}

function openBGEditor(control){
	editable_bg_control = $("#" + control.attr("id") + "_div-1");
	var old_bg_color = editable_bg_control.css("background-color");
	var old_bg_image_src = editable_bg_control.css("background-image");
	var old_bg_image_position = editable_bg_control.css("background-position");
	var old_bg_image_repeat = editable_bg_control.css("background-repeat");
	var old_bg_image_attachment = editable_bg_control.css("background-attachment");

	function restoreInitialState() {
		// If cancel button is pressed, this function will be called
		console.log("[DEBUG] old_bg_color : " + old_bg_color);
		console.log("[DEBUG] old_bg_image_src : " + old_bg_image_src);
		console.log("[DEBUG] old_bg_image_position : " + old_bg_image_position);
		console.log("[DEBUG] old_bg_image_repeat : " + old_bg_image_repeat);
		console.log("[DEBUG] old_bg_image_attachment : " + old_bg_image_attachment);
		isSaved = false;
		editable_bg_control.css("background", old_bg_color);
		editable_bg_control.css("background-image", old_bg_image_src);
		editable_bg_control.css("background-position", old_bg_image_position);
		editable_bg_control.css("background-repeat", old_bg_image_repeat);
		editable_bg_control.css("background-attachment", old_bg_image_attachment);	
	}
	
	$("#dialog_bg_editor").dialog({
		dialogClass : "no-close",
		resizable : false,
		draggable : true,
		closeOnEscape : true,
		title : "Background Edit Panel",
		width : 900,
		height : 600,
		show : {
			effect : "slide",
			duration : 200,
			direction : "up"
		},
		beforeClose : function(event, ui) {
			if (isSaved == false)
			{
				restoreInitialState();
			}
			else
			{
				onMenuPageModified(curMenu, editable_bg_control.attr("id"), "PROP-MODIFY");			
			}
		},

	});

	$("#bg_editor_sample_images_list").find('li').click(function(){
		setBackgroundImage(editable_bg_control , $(this).find("img").attr("src"));
	});
	
	// var folder = "../../templates/"+ currentCategory + "/" + currentTemplate + "/resource/images/background/";
	
	// $.ajax({
	//     url : folder,
	//     success: function (data) {
	//         $(data).find("a").attr("href", function (i, val) {
	//             if( val.match(/\.jpg|\.png|\.gif/) ) {
	//                 $('<li><img src="' + folder + val + '" class="bg_editor_thumbnail" alt="'
	//     					+ "test" + '"></li>').appendTo('#bg_editor_sample_images_list').click(function(){
	//     						setBackgroundImage(editable_bg_control , $(this).find("img").attr("src"));
	//     					});
	//             } 
	//         });
	//     }
	// });
}




/////////////////////////////////////////////////////////////////////////////////////////

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
			else {
				onMenuPageModified(curMenu, editable_control.attr("id"), "PROP-MODIFY");
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
			}
		},

	});
}


function showButtonEditPanel() {

	var old_btn_text = editable_control.text();
	var old_color = editable_control.css('backgroundColor');
	var old_link = editable_control.attr("data-onclick");

	$("#btn_text").val(old_btn_text);
	$("#btn_link").val(old_link);

	function restoreInitialState() {
		// If cancel button is pressed, this function will be called
		isSaved = false;
		editable_control.html(old_btn_text);
		editable_control.css("background", old_color);
		editable_control.attr("data-onclick", old_link);		
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
			else
			{
				onMenuPageModified(curMenu, editable_control.attr("id"), "PROP-MODIFY");
				editable_control.attr("data-onclick", $("#btn_link").val());
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
				palette : color_palette
			});

}

function showTextEditPanel() {

	// $(".ui-dialog-titlebar-close").css("display", true);
// var text = editable_control.html();
// BootstrapDialog.show({
//                 title: 'Text Editor',
//                 message: text,
//                 buttons: [{
//                     label: 'Save',
//                     cssClass: 'btn-info btn-flat',
//                     action: function(dialogRef) {
//                         dialogRef.close();
//                     }
//                 } ,
//                     {
//                         label: 'Cancel',
//                         cssClass: 'btn-info btn-flat',
//                         action: function(dialogRef) {
//                             dialogRef.close();
//                         }
//                     }
//                 ]
//             });

// var height = parseInt(editable_control.css("height"));
// // CKEDITOR.disableAutoInline = true;
// // 		CKEDITOR.inline( editable_control.attr("id"));
// CKEDITOR.replace( editable_control.attr("id"), {
// 			extraPlugins: 'sharedspace',
// 			removePlugins: 'maximize,resize',
// 			height: height,
// 			sharedSpaces: {
// 				top: 'top',
// 				bottom: 'bottom'
// 			}
// 		} );

//////////////////////////////////////////////////////

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
			onMenuPageModified(curMenu, editable_control.attr("id"), "PROP-MODIFY");
		},

	});

/////////////////////////////////////////////////////


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
			else
			{
				onMenuPageModified(curMenu, editable_control.attr("id"), "PROP-MODIFY");
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
	var count_image = parseInt(target_slider.attr("data-total_item"));
	
	var pause_time = parseInt(target_slider.attr("data-pause_time"))/1000;
	var animation_speed = parseInt(target_slider.attr("data-animation_speed"))/1000;
	
	$("select#dropdown_slider_pause_time").val(pause_time);
	$("select#dropdown_slider_animation_speed").val(animation_speed);
	$("select#dropdown_slider_visible_item").val(target_slider.attr("data-visible_items"));

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
	
//	if(editable_control.attr("data-pause") != undefined){
//	}else{
//		editable_control.attr("data-pause", SLIDER_PAUSE);
//	}
//	
//	if(editable_control.attr("data-speed") != undefined){
//	}else{
//		editable_control.attr("data-speed", SLIDER_ANIMATION_SPEED);
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
			else
			{
				onMenuPageModified(curMenu, editable_control.attr("id"), "PROP-MODIFY");
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
			else{
				onMenuPageModified(curMenu, editable_control.attr("id"), "PROP-MODIFY");
				var dropdown_options = $("#dropdown_option_txt").val();
				var new_dropdown_options = dropdown_options.split('\n');

				if (new_dropdown_options[new_dropdown_options.length - 1] == null) {
					// To Do
					// if extra new lines are detected
				}

				createDropdownTemplate(new_dropdown_options);
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
	var background_div = null;
	if (editable_control.attr("name") == "group")
		background_div = editable_control.children();

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
		start : function(){
			onMenuPageModified(curMenu, $(this).attr("id"), "RESIZE");
		},
		stop : function(event, ui) {
			if (background_div != null)
			{
				background_div.css("height", ui.size.height);
				background_div.css("width", ui.size.width);	
			}

			if (editable_control.attr("name") == "image")
			{
				editable_control.find("img").css("height", ui.size.height);
				editable_control.find("img").css("width", ui.size.width);
			}
			
//			animateImageSlider(editable_control, editable_control.width(),
//					editable_control.attr("data-speed"), editable_control.attr("data-pause"));
		},
	});
}

function showGroupEditPanel() {
	editable_group = editable_control;
	
	if (editable_control.attr("data-is_form") != null){
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
			else
			{
				onMenuPageModified(curMenu, editable_control.attr("id"), "PROP-MODIFY");
			}
		},

	});
}
