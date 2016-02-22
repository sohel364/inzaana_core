/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// onload functionalities
$(document).ready(function() {
    hideSavingIcon();
});


function executeBeforeSend() {
    if(isUserLoggedIn === null || isUserLoggedIn === "0") {
        alert("Please sign in to save the template");
        var redirectURL = getBaseUrl();
        window.location.href = redirectURL;
        return;
    }
    saveCurrentMenuText();
    saveCurrentPageImages();
    var menuList = getMenuList();
    
    if (typeof menuList.length !== 'undefined' && menuList.length > 1) {
        showSavingIcon();
        var savedName; 
        if(!isEdit) {
            var url = getPageSaverUrl();
            savedName = prompt("Enter webpage name : ", "Enter page name");
            //insertPage(url, menuList, savedName);
        } else {
            var url = getPageUpdaterUrl();
            if(typeof template_saved_name !== 'undefined' && template_saved_name.length>0) {
                savedName = prompt("Enter webpage name : ", template_saved_name);
            } else {
                savedName = prompt("Enter webpage name : ", "Enter page name");
            }
            //updatePage(url, menuList, savedName);
        }
    }
}

/*
 * Finds the base url of the current page
 * @returns {String}
 */
function getBaseUrl() {
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    return baseUrl;
}

/*
 * Generates the page saver url with concatenating the base url
 * @returns {String}
 */
function getPageSaverUrl() {
    return getBaseUrl()+'/views/content_views/pageSaver.php';
}


/*
 * Generates the page 0updater url with concatenating the base url
 * @returns {String}
 */
function getPageUpdaterUrl() {
    return getBaseUrl()+'/views/content_views/pageUpdater.php';
}
/*
 * Find all the menus created by user
 * @returns {Array|getMenuList.menuList}
 */
function getMenuList() {
    $ul = $('#menu');
    $lis = $ul.find('li'); /* Finds all sub li under menu ul(find all menus) */

    var menuList = [];
    $lis.each(function () {
        var menu = {};
        $curLi = $(this);
        $curUls = $curLi.find('ul');/* Finds all sub ul under li(find all submenus) */
        var len = $curUls.length;
        if (len !== 0) {
            alert('Found Submenu');
            // TODO need to add codes for handling submenus
        }
        $curA = $curLi.find('a');
        var a_href = $curA.attr('href');
        var menu_text = $curA.text();
        /*if(a_href === 'undefined'){
         
         }*/
        menu['menuTitle'] = menu_text;
        menu['aHref'] = a_href;
        menuList.push(menu);
    });
    return menuList;
}

function traverseImages() {
    var containers = [];
    $(document).ready(function () {

        console.log('[WB-D][container-id: logging]');

        var allElements = $("body").find("*[id^='container_']").each(function (index, element)
        {
            var parts = element.id.split('_');
            //if(parts.length == 2){
            //    console.log('[WB-EXP][container-parts [parent]: ' + parts + ']');
            //    console.log('[WB-EXP][container-parts [parent][style]: ' + $('#' + element.id).attr("style") + ']'); //$("#stylediv").attr('style')
            //}
            var isChildContainer = parts.length > 2;
            if (parts.length > 2) {

                var tagName = parts[parts.length - 1].split('-')[0];

                if ( tagName != 'img') // $('#' + element.id)[0].nodeName
                {
                    //console.log('[WB][container-parts [child]: ' + parts + '][' + $('#' + element.id)[0].nodeName + ']');
                    //console.log('[WB][container-parts [child][style:background(url)]: ' + $('#' + element.id).attr("style") + ']'); //$("#stylediv").attr('style')
                    if ($('#' + element.id).css("background-image") == "none" || $('#' + element.id).css("background-image") == "undefined") {
                        //console.log('[WB][container-parts [child][index]: ' + index + ']');
                        //console.log('[WB][container-parts [child][style:background(url)]: ' + $('#' + element.id).css("background-image") + ']');//img.attr("src").split('.').pop()
                    }
                    else {
                        //console.log('[WB][container-parts [child][index]: ' + index + ']');
                        //console.log('[WB][container-parts [child][style:background(url)]: ' + $('#' + element.id).css("background-image") + ']');
                        //console.log('[WB][container-parts [child][image:type]: ' + $('#' + element.id).css("background-image").split('.').pop() + ']');
                        //console.log('[WB][container-parts [child][image:size]: ' + $('#' + element.id).css("width") + 'x' + $('#' + element.id).css("height") + ']');
                        //console.log('[WB][container-parts [child][image:url]: ' + $("#" + element.id).css("background-image").replace("url", "").replace("(", "").replace(")", "").replace("\"", "").replace("\"", "").trim() + ']');

                        var binary = getBase64Image($('#' + element.id), "hidden-canvas");
                        var url = $('#' + element.id).css("background-image").replace("url", "").replace("(","").replace(")","").replace("\"","").replace("\"","").trim();
                        var imgType = (url.split('.').pop() == "jpg") ? "jpeg" : url.split('.').pop();
                        //console.log('[WB-D][image-type]: ' + imgType);
                        // TODO: Image Type is set after above line is executed [getBase64Image(images[i], "hidden-canvas");]
                        var parent_id = parts[0] + '_' + parts[1];
                        var containerObj = '{ "src": "' + url
                            + '", "index": ' + index
                            + ', "type": "' + imageType //url.split('.').pop() == "jpg" ? "jpeg" : url.split('.').pop()
                            + '", "id": "' + element.id
                            + '", "data": "' + binary
                            + '", "menu": "' + curMenu
                            + '", "tag": "' + $('#' + element.id)[0].nodeName
                            + '" }';

                        if(!isImageExists(element.id, curMenu))
                        {
                            containers.push(containerObj);
                        }
                        //console.log('[WB][container-json]: ' + containerObj);
                    }
                }
                else
                {
                    //console.log('[WB][container-parts [child]: ' + parts + '][' + $('#' + element.id)[0].nodeName + ']');
                    if ($('#' + element.id).attr("src") == "undefined" || $('#' + element.id).attr("src") == "none") {
                        //console.log('[WB][container-parts [child][index]: ' + index + ']');
                        //console.log('[WB][container-parts [child][style:src]: ' + $('#' + element.id).attr("src") + ']'); //$("#stylediv").attr('src')
                    }
                    else {

                        var binary = getBase64ImageForImageElement($('#' + element.id), "hidden-canvas");
                        var url = $('#' + element.id).attr("src");
                        var imgType = (url.split('.').pop() == "jpg") ? "jpeg" : url.split('.').pop();
                        //console.log('[WB-D][image-type]: ' + imgType);

                        //console.log('[WB][container-parts [child][index]: ' + index + ']');
                        //console.log('[WB][container-parts [child][style:src]: ' + $('#' + element.id).attr("src") + ']'); //$("#stylediv").attr('src')
                        //console.log('[WB][container-parts [child][image:type]: ' + $('#' + element.id).attr("src").split('.').pop() + ']'); //$("#stylediv").attr('src')

                        // TODO: Image Type is set after above line is executed [getBase64Image(images[i], "hidden-canvas");]
                        var parent_id = parts[0] + '_' + parts[1];
                        var containerObj = '{ "src": "' + url
                            + '", "index": ' + index
                            + ', "type": "' + imageType //(url.split('.').pop() == "jpg") ? "jpeg" : url.split('.').pop()
                            + '", "id": "' + element.id
                            + '", "data": "' + binary
                            + '", "menu": "' + curMenu
                            + '", "tag": "' + $('#' + element.id)[0].nodeName
                            + '" }';

                        if(!isImageExists(element.id, curMenu))
                        {
                            containers.push(containerObj);
                        }
                        //console.log('[WB][container-json]: ' + containerObj);
                    }
                }
            }
        });
        console.log('[WB-D][container-count: ' + allElements.length + ']');
    });
    allImages[curMenu] = containers;
}

/*
 * Calls ajax to save the page contents(menu, submenu, contents etc)
 * @returns {undefined}
 */
function savePage(user_id, template_id, isEdit) {
    //var user_id = 'id', template_id = '87349q64';
    //return;


    // INFO: BELOW PART IS CHECKED FROM VIEWS AND TEMPLATE CONTROLLER
    // if(isUserLoggedIn === null || isUserLoggedIn === "0") {
    //     alert("Please sign in to save the template");
    //     var redirectURL = getBaseUrl();
    //     window.location.href = redirectURL;
    //     return;
    // }

    console.log("[WB-D] savePage: " + user_id + "$##$" + template_id);
    traverseImages();
    console.log("[WB-D] savePage: " + user_id + "$##$" + template_id);

    makeTemplateComponetsNotEditable();
    saveCurrentMenuText();

    //var images = [];
    //var imagesCurList = allImages[curMenu];
    //images = allImages;
    var menuList = getMenuList();
    
    if (typeof menuList.length !== 'undefined' && menuList.length > 1) {
        showSavingIcon();
        var savedName; 
        if(!isEdit) {
            var url = getPageSaverUrl();
            savedName = prompt("Enter webpage name : ", "Enter page name");

            insertPage(url, menuList, template_id, user_id, savedName);

        } else {
            var url = getPageUpdaterUrl();
            if(typeof template_saved_name !== 'undefined' && template_saved_name.length > 0) {
                savedName = prompt("Enter webpage name : ", template_saved_name);
            } else {
                savedName = prompt("Update webpage name : ", "Enter page name");
            }

            saveImages(user_id, template_id);

            allImages = [];

            updatePage(url, menuList, template_id, savedName);
        }
    }
    
    var x = 0;
    x++;
}

function testBodyHTML() {
    console.log('[WB-DRAG] loggin');
    var data_rows = Object.keys(menuContens);
    data_rows.forEach(function (data_row) {
        //console.log('[WB-DRAG]' + menuContens[data_row]);

        //var parser = new DOMParser();
        //var doc = parser.parseFromString(menuContens[data_row], "text/html");
        var html = $.parseHTML(menuContens[data_row]), nodeNames = [];
        $.each(html, function (i, el) {
            //nodeNames[ i ] = "<li>" + el.nodeName + "</li>";
            if ($("*[id*='dropped']") != null)
                console.log("[WB-DRAG]" + el.id);
        });
        //console.log("[WB-DRAG]" + nodeNames.join( "" ));
        //doc.find("img").each(function (index, element) {
        //   console.log('[WB-DRAG]' + element.id);
        //});

    });
}

function insertPage(url, menuList, template_id, user_id, savedName) {

    //testBodyHTML();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
            type: "POST",
            url: '/template_view/create', //url,
            dataType: 'json',
            // contentType: 'application/json; charset=utf-8',
            data: {
                menulists: menuList,
                // menucontentlist: menuContens, 
                templateid: template_id, //template_id,
                savedname: savedName,
                // templatename:currentTemplate,
                _token: CSRF_TOKEN
            },
            success: function (data) {
                // hideSavingIcon();
                
                alert('Saved Successfully!!!' + data.templateid);
                // var savedTemplateID = obj.savedTemplateId;
                // var redirectURL = getBaseUrl()+'/views/content_views/template_editor.php?category='+currentCategory+'&template='+currentTemplate+'&templateid='+savedTemplateID;

                // TODO: Image upload before page template create
                // saveImages(user_id, savedTemplateID);

                window.location.href = '/editor/' + '{{ $category }}' + '/' + data.templateid;//redirectURL;
            },
            error: function(xhr, status, error) {
                hideSavingIcon();
                var err =  xhr.responseText;
                alert(err);
            }
        });
}

function updatePage(url, menuList, template_id, savedName) {

    //testBodyHTML();

    $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: {menulists: menuList, menucontentlist: menuContens, templateid: template_id, savedname: savedName, categoryname:currentCategory, templatename:currentTemplate, menuidlist:user_menu_id_array},
            success: function (obj, textstatus) {
                //console.log("[WB]" + textstatus + "%%%####");
                hideSavingIcon();
                //alert("[DEBUG] SUCCESS MSG: " + obj.saveUserTemplate);
                if (!('error' in obj)) {
                    if(obj.saveUserTemplate === '1') {
                        alert('Updated Successfully!!!');
                        ///views/content_views/template_editor.php?category=uncategorized&template=part1&templateid=uncategorized_part1_1_2015_08_13_04_56_32_pm
                        var redirectURL = getBaseUrl()+'/views/content_views/template_editor.php?category='+currentCategory+'&template='+currentTemplate+'&templateid='+template_id;
                        window.location.href = redirectURL;
                    } else {
                        alert('Error occured during saving!!!');
                    }
                    
                }
                else {
                    alert('Error: ' + obj.error);
                }
            },
            error: function(xhr, status, error) {
                hideSavingIcon();
                var err =  xhr.responseText;
                alert(err);
            }
        });
}
/*
 * Shows loading icons while saving operation is ongoing
 */
function showSavingIcon() {
    $('#showsaveicon').show();
}
/*
 * Hides loading icon after finishing saving operation
 */
function hideSavingIcon() {
    $('#showsaveicon').hide();
}