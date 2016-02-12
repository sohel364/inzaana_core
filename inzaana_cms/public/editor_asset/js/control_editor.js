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
		$("#dialog_bg_editor").dialog("close");
	});
	
	$("#btn_bg_editor_cancel").click(function(){
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
		},

	});
	
	var folder = "../../templates/"+ currentCategory + "/" + currentTemplate + "/resource/images/background/";
	
	$.ajax({
	    url : folder,
	    success: function (data) {
	        $(data).find("a").attr("href", function (i, val) {
	            if( val.match(/\.jpg|\.png|\.gif/) ) {
	                $('<li><img src="' + folder + val + '" class="bg_editor_thumbnail" alt="'
	    					+ "test" + '"></li>').appendTo('#bg_editor_sample_images_list').click(function(){
	    						setBackgroundImage(editable_bg_control , $(this).find("img").attr("src"));
	    					});
	            } 
	        });
	    }
	});
}