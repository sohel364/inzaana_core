/**
 * Created by SAIF on 24/05/2015.
 */
//
//    function allowDrop(ev) {
//        ev.preventDefault();
//    }
//
//    function drag(ev) {
//        ev.dataTransfer.setData("text", ev.target.id);
//    }
//
//    function drop(ev) {
//        ev.preventDefault();
//        var data = ev.dataTransfer.getData("text");
//        ev.target.appendChild(document.getElementById(data));
//    }


$(function () {
    $('.control-component').draggable({

        helper:"clone",
        appendTo: "#body",

        drag: function(event, ui)
        {
            console.log("drag");
            //console.log(ui);
        },
        start: function(event, ui)
        {
            console.log("start");

        },
        stop: function(event, ui)
        {
            console.log("stopped");
            console.log(ui.helper);
            $(ui.helper).css('display','block');
            //$("#body").appendChild(ui.helper);
            event.preventDefault();
        }
    });

    $( "#body" ).droppable();

    $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');

    $('.tree li.parent_li > span').on('click', function (e) {
        var children = $(this).parent('li.parent_li').find(' > ul > li');
        if (children.is(":visible")) {
            children.hide('fast');
            $(this).attr('title', 'Expand this branch').find(' > i').addClass('icon-plus-sign').removeClass('icon-minus-sign');
        } else {
            children.show('fast');
            $(this).attr('title', 'Collapse this branch').find(' > i').addClass('icon-minus-sign').removeClass('icon-plus-sign');
        }
        e.stopPropagation();
    });
});

$(function(){

    // Enabling Popover Example 1 - HTML (content and title from html tags of element)
    $("[data-toggle=popover]").popover();

    // Enabling Popover Example 2 - JS (hidden content and title capturing)
    $("#popoverExampleTwo").popover({
        html : true,
        content: function() {
            return $('#popoverExampleTwoHiddenContent').html();
        },
        title: function() {
            return $('#popoverExampleTwoHiddenTitle').html();
        }
    });

});


$(function(){
    /**
     *
     *Load menu item in tree view. By saif , Date  08-04-2015
     */
    var treeMenu=$('#ul_tree_menu_list');

    var tempLi;
    $('#menu li').each(function(i, obj) {
        //console.log(this);
        tempLi=$('<li></li>');
        tempLi.append('<span><i class="icon-time"></i> [+]</span>');
        tempLi.append(' &ndash; ');
        tempLi.append($(obj).html());
        treeMenu.append(tempLi);

    });

    treeMenu.find('li').last().addClass('add-menu');

    /**Making it Sortable using jquery UI*/

    $( "#ul_tree_menu_list" ).sortable({

        start: function(event, ui){
            iBefore = ui.item.index();
        },
        update: function(event, ui) {
            iAfter = ui.item.index();
            evictee = $('#menu li:eq('+iAfter+')');
            evictor = $('#menu li:eq('+iBefore+')');

            evictee.replaceWith(evictor);
            if(iBefore > iAfter)
                evictor.after(evictee);
            else
                evictor.before(evictee);
        }

    });

    /*
     *Add New Menu
     * */
    $(".add-menu").on('click',function(){
        BootstrapDialog.show({
             title: 'Create new page',
            message: '<div class="form-group"><label for="pageType">Page event type:</label><select class="form-control selectpicker"><option data-icon="glyphicon-book">Academic</option><option data-icon="glyphicon-heart">Marriage</option><option data-icon="glyphicon-plane">Trip</option></select></div> <label for="pageType">Page Name:</label><input type="text" class="form-control">',
            buttons: [{
                label: 'Ok',
                cssClass: 'btn-info btn-flat',
                action: function(dialogRef) {
                    var newMenu = dialogRef.getModalBody().find('input').val();
                    addNewMenu(newMenu);
                    updateControlPaletteTabList("custom");
                    dialogRef.close();
                }
            } ,
                {
                    label: 'Cancel',
                    cssClass: 'btn-info btn-flat',
                    action: function(dialogRef) {
                        dialogRef.close();
                    }
                }
            ]
        });

    });




    $("div").on('click',function (e){

        //alert(e.target.id);
        if(e.target.id=="container_header")
        {
            BootstrapDialog.alert("Clicked on "+e.target.id);
            console.log(e.target.id);
            console.log(e.target);
            e.stopPropagation();
        }
    });



    /*
     For All close Button
     */
    $(".page_close_btn").on('click',function(){
        $(this).closest('.edit_option').hide();
    });
    /*
     Page Options
     */
    var selectedPageIndex;
    $("#ul_tree_menu_list").on('dblclick','li',function(e){
        selectedPageIndex=$(this).index();
        if(selectedPageIndex == $("#ul_tree_menu_list li").size()-1)
        {
            return;
        }
//            console.log($(this).find("a").html());
        $("#input_page_name").val($(this).find("a").html());
        $("#page_option").css("left", "40%").css("top", "40%").css("box-shadow", "0px 0px 20px #00a3d9");
        $("#page_option").toggle();

    });

    $("#page_delete_btn").on('click',function(){
        $("#ul_tree_menu_list li:eq("+selectedPageIndex+")").remove();
        $("#menu li:eq("+selectedPageIndex+")").remove();
        $("#page_option").hide();

    });
    $("#page_save_btn").on('click',function(){
        var pageName=$("#input_page_name").val();
        $("#ul_tree_menu_list li:eq("+selectedPageIndex+") a").html(pageName);
        $("#menu li:eq("+selectedPageIndex+") a").html(pageName);
        $("#page_option").hide();
    });

    /*
     Background Options
     */
    $(".color").each(function(i,obj){
        $(obj).css('background',getColor());
    });
    $("#li_background_color").on('dblclick',function(e){
        $("#background_option_color").toggle();
    });
    $("#li_background_image").on('dblclick',function(e){
        $("#background_option_image").toggle();
    });

    var colorSet=[
        ["Red Red ","FF0000","E80C7A","FF530D"],
        ["Blue as Sky","2421FF","9715FF","158DFF"],
        ["Set - 3","99FF5A","FFFC67","BFE852"],
    ];
    var textColor=[
        ["Red","FF0E08"],
        ["Blue","1310FF"],
        ["White","FFFFFF"],
        ["Black","000000"]
    ];
    var textfont=[
        "arial",
        "tahoma",
        "times new roman",
        "monospace",
        "Verdana"
    ];

    for(i=0; i< colorSet.length; i++) {
        var colorTd = $('<td class="color-set-color"> </td>');
        var cSpan = $('<span></span>');
        cSpan.css('background', '#' + colorSet[i][1]);
        $(colorTd).append(cSpan);

        cSpan = $('<span></span>');
        cSpan.css('background', '#' + colorSet[i][2]);
        $(colorTd).append(cSpan);

        cSpan = $('<span></span>');
        cSpan.css('background', '#' + colorSet[i][3]);
        $(colorTd).append(cSpan);
        colorTr=$('<tr>');
        colorTr.addClass('color-set');
        colorTr.append($('<td>' + colorSet[i][0] + '</td>'));
        colorTr.append(colorTd);
        $("#table_color_set").append(colorTr);
    }
    $(".color-set").on('click',function(){
        selected =$(this).index();
        $('#menu').css('background','#'+colorSet[selected][1]);
        $('#body').css('background','#'+colorSet[selected][2]);
        $('#footer').css('background','#'+colorSet[selected][3]);
    });


    /*
     Listenint To every Click and Setting the targetElement
     */
    var fontNColorTarget;
    $("#frame").on('click',function(e){
        console.log(e.target);
        fontNColorTarget= e.target;
    });

    for(i=0;i<textColor.length;i++)
    {
        tColor=$('<li> <span><i class="icon-time"></i> [+]</span> &ndash; </li> ');
        tColor.append($('<a  href="">'+textColor[i][0]+'</a>'));

        $("#ul_text_color").append(tColor);
    }
    $('#ul_text_color').on('click','li',function(e){
        e.preventDefault();
//        console.log($(this).index());
        e.stopPropagation();
        $(fontNColorTarget).css('color','#'+textColor[$(this).index()][1]);
    });

    for(i=0;i<textfont.length;i++)
    {
        tFont=$('<li> <span><i class="icon-time"></i> [+]</span> &ndash; </li> ');
        tFont.append($('<a  href="">'+textfont[i]+'</a>'));

        $("#ul_text_font").append(tFont);
    }

    $('#ul_text_font').on('click','li',function(e){
        e.preventDefault();
//        console.log($(this).index());
        e.stopPropagation();
        $(fontNColorTarget).css('font-family',textfont[$(this).index()]);
    });

    /*
     Control option start from here
     */



    $('#save').on('submit',function(e){
        //e.preventDefault();
        $('#f_title').val($('#title').html());
        $('#f_header').val($('#header').html());
        $('#f_menu').val($('#menu').html());
        $('#f_body').val($('#body').html());
        $('#f_footer').val($('#footer').html());

        console.log( $('#html').val() );
    });

    // $("#frame").load("<?php echo $turl ?>");


});

function getColor()
{
    return '#'+(Math.random()*0xFFFFFF<<0).toString(16);
}


function addNewMenu(menuName)
{
    tempLi=$('<li></li>');
    tempLi.append('<span><i class="icon-time"></i> [+]</span>');
    tempLi.append(' &ndash; ');
    tempLi.append('<a onclick=\"onMenuClick(this);\">'+menuName+'</a>');

    $("#ul_tree_menu_list").find('li').last().before(tempLi);

    tempLi=$('<li></li>');
    tempLi.append('<a onclick=\"onMenuClick(this);\">'+menuName+'</a>');

    $("#menu").find('li').last().before(tempLi);

    console.log(menuName);
}