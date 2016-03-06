// Global variables

var is_control_palette_open = false;
var is_cp_collasped = false;
var pos_collasp_btn;
var cp_list;
var cp_position_list;
var is_bg_fixed = false;




$(function(){	
	initializeControlPalette();
	controlPaletteHoverAction();
	updateControlPaletteTabList("general");
	
});

function updateControlPaletteTabList(category){
	if ($("#tabs").tabs("instance") == undefined)
	{
		$("#tabs").tabs();
	}

	if (isValidControlCategory(category))
	{
		var is_first = true;
		var index_first_tab = 0;
		var count_tab = 0;
		$("#tab_list li").css("display", "none");

		$("#tab_list").find("li").each(function(index, value){
			var supported_category_list = $(this).data("category");
			if (supported_category_list.indexOf(category) > -1)
			{
				$(this).css("display", "inline");
				count_tab++;
				if (is_first == true)
				{
					index_first_tab = index;
					is_first = false;
				}
			}
		})

		var container_height = $(".ui-tabs").height();
		if (container_height == null || container_height < 0)
		container_height = 540;

		$(".ui-tabs-nav li").css("height", Math.floor(container_height/count_tab) + "px");

		$("#tabs").tabs({
			active : index_first_tab
		});

		$("#tabs").tabs("refresh");
	}
}

function isValidControlCategory(category)
{
	return true; // will be implemented later
}

function initializeControlPalette(){
	
	pos_collasp_btn = $('#btn_collasp_cp').position();
	cp_list = [$('#cp_background'), $('#cp_add_control'), $('#cp_menu'), $('#cp_media')];
	cp_position_list = [$('#cp_background').position(), $('#cp_add_control').position(), $('#cp_menu').position(), $('#cp_media').position()];
	
	
	$(".cp_btn").click(function(){
		showControlPalette($(this));
	});
	
	$(".cp_holder_close_btn").click(function(){
		closeAllControlPalette();
	});
	
	$("#btn_collasp_cp").click(function(){
		closeAllControlPalette();
		collaspControlPalette()
	});
	
	initiateControls("btn_template");
	initiateControls("marriage_control_template");
//	var control = $("#btn_template_1").clone();
////	control.css('left', '100px');
////	control.css('top', '200px');
//	control.css('display', 'block');
//	control.appendTo($("#btn_template_palette"));
////	$("#btn_template_palette").append(control);
	
	$("#btn_open_bg_editor").click(function(){
		openBGEditor($("#container_background-1"));
	});
	
	
	initializeDefalutBackgroundThere();
	
}

function initializeDefalutBackgroundThere(){
	
	$("#bg_editor_default_images_list").find('li').click(function(){
		setBackgroundImage($("#container_background-1_div-1") , $(this).find("img").attr("src"));
	});

	// var folder = "/editor_asset/images/background/";

	// $.ajax({
	//     url : folder,
	//     success: function (data) {
	//     	alert("success is called");
	//         $(data).find("a").attr("href", function (i, val) {
	//         	alert("{{ asset(folder + val)}}");
	//             if( val.match(/\.jpg|\.png|\.gif/) ) {
	//                 $('<li><img src="{{ asset(folder + val)}}" class="bg_editor_thumbnail" alt="'
	//     					+ "test" + '"></li>').appendTo('#bg_editor_default_images_list').click(function(){
	//     						console.log($(this).find("img").attr("src"));
	//     						setBackgroundImage($("#container_background-1_div-1") , $(this).find("img").attr("src"));
	//     					});
	//             } 
	//         });
	//     }
	// });
}

function collaspControlPalette(){
	var start_x;
	var start_y;
	var end_x;
	var end_y;
	var bezier_params;
	var path_angle = 100;
	

	
	$.each(cp_list, function(index, cp_btn) {
		
		if (is_cp_collasped){
			start_x = pos_collasp_btn.left;
			start_y = pos_collasp_btn.top;
			end_x = cp_position_list[index].left;
			end_y = cp_position_list[index].top;
			path_angle = path_angle * (-1);
			$(".cp").show();
		}else{
			start_x = cp_position_list[index].left;
			start_y = cp_position_list[index].top;
			end_x = pos_collasp_btn.left;
			end_y = pos_collasp_btn.top;
		}
		
		bezier_params = {
			    start: { 
			      x: start_x, 
			      y: start_y, 
			      angle: path_angle
			    },  
			    end: { 
			      x:end_x,
			      y:end_y, 
			      angle: 0,
			    }
			  }

		cp_btn.animate({path : new $.path.bezier(bezier_params)}, 1000);
		
		
	});
	
	if (is_cp_collasped){
		is_cp_collasped = false;
		$("#btn_collasp_cp").text("Collasp");
	}else{
		is_cp_collasped = true;
		$("#btn_collasp_cp").text("Expand");
		$(".cp").hide(10);
	}

	
}

function initiateControls(control_name){
	var count = 1;
	var control_template = $("#" + control_name + "_" + count);
	while (control_template.data("type") != undefined) {
		var control = control_template.clone();
		control.css('display', 'block');
		control.css('left', '100px');
		control.css('top', '20px');
		control.addClass("selectorField");
		control.addClass("draggableField");
		control.appendTo($("#" + control_name + "_palette"));
		count++;
		control_template = $("#" + control_name + "_" + count);		
	}
	
	makeControlsOfPaletteDraggable();
}


function controlPaletteHoverAction(){
	
	$(".cp_btn").mouseenter(function(e){
		$(".cp_btn").animate({'opacity': 1}, 100);
		if (is_control_palette_open == false){		
			$(this).animate({'width': 150}, 300);
		}
		
		
	}).mouseleave(function(e){
		if (is_control_palette_open == false){
			$(".cp_btn").animate({'opacity': .5}, 100);
			$(this).animate({'width': 50}, 100);
		}
	});
	
}

function closeAllControlPalette(){
	is_control_palette_open = false;
	$(".pointer").hide();
	$(".cp_holder").hide();
	
}

function showControlPalette(cp){
	$(".cp_btn").animate({'width': 50}, 100);
	closeAllControlPalette();	
	is_control_palette_open = true;
	
	var top = cp.css("top");
	$("#cp_holder_pointer").css("top", top);
	$("#cp_pointer_outcurve_bottom").css("top", parseInt(top) + 35);
	
	$("#cp_pointer_outcurve_top").css("top", parseInt(top) - 35);
	
	//$(".cp_holder").show();
	
	if (cp.attr("id") == "cp_background"){
		$("#cp_holder_backgroud").show();
		
	}else if(cp.attr("id") == "cp_add_control"){
		$("#cp_holder_add_control").show();
		
	}else if(cp.attr("id") == "cp_menu"){
		$("#cp_holder_menu").show();
		
	}else if(cp.attr("id") == "cp_media"){
		$("#cp_holder_media").show();
		
	}
	
	$(".pointer").show();
	
	if(cp.data("top") != undefined){	
		$("#cp_pointer_outcurve_top").hide();
	}
	
	$('#tabs')
    .tabs()
    .addClass('ui-tabs-vertical ui-helper-clearfix');
}