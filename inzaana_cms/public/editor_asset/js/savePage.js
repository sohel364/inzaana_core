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
function savePage(category_name, template_name, isEdit) 
{
    console.log("[WB-D] savePage: " + category_name + "$##$" + template_name);
    traverseImages();
    console.log("[WB-D] savePage: " + category_name + "$##$" + template_name);

    // makeTemplateComponetsNotEditable();
    saveCurrentMenuText();

    var menuList = getMenuList();
    
    if (typeof menuList.length !== 'undefined' && menuList.length > 1) 
    {
        showSavingIcon();
        var savedName; 
        if(!isEdit)
        {
            savedName = prompt("Enter webpage name : ", "Enter page name");

            if(savedName == null)
            {
                alert('Enter a valid page name! Page is not saved.');
                window.location.href = '/editor/' + category_name + '/' + template_name;
            }
            insertPage(menuList, template_name, category_name, savedName);
        } 
        else 
        {
            var template_id = template_name;

            $.ajax({

                type: "GET",
                url: '/templates/info/' + template_id,
                dataType: 'json',
                success: function (data) {

                    // alert('msg: ' + data.message);
                    if(data.success)
                    {
                        savedName = prompt("Enter webpage name : ", data.template.saved_name);
                    }
                    else
                    {
                        savedName = prompt("Update webpage name : ", "Enter page name");
                    }

                    if(savedName == null)
                    {
                        alert('Enter a valid page name! Page is not saved.');
                        window.location.href = '/templates/gallery';
                    }
                    updatePage(menuList, data.template, category_name, savedName);
                },
                error: function(xhr, status, error) {

                    var err =  xhr.responseText;
                    alert(err);
                }
            });
        }
    }
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

function insertPage(menuList, template_name, category_name, savedName) {

    //testBodyHTML();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
            type: "POST",
            url: '/templates/create',
            dataType: 'json',
            data: {
                _category_name: category_name,
                _menus: menuList,
                _menu_contents: menuContens, 
                _template_name: template_name,
                _saved_name: savedName,
                _token: CSRF_TOKEN
            },
            success: function (data) {
                hideSavingIcon();

                alert(data.message);

                // TODO: Image upload before page template create
                if(data.success)
                {
                    // saveImages(category_name, savedTemplateID);
                    // show template saved edit view
                    window.location.href = '/editor/' + data.template.category_name + '/' + data.template.template_name + '/' + data.template.id;
                }
                else
                {
                    // show template sample view
                    window.location.href = '/editor/' + category_name + '/' + template_name;
                }
            },
            error: function(xhr, status, error) {
                hideSavingIcon();
                var err =  xhr.responseText;
                alert(err);
                // window.location.href = '/templates/gallery';
            }
        });
}

function updatePage(menuList, template, category_name, savedName) {

    //testBodyHTML();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
            type: "POST",
            url: '/templates/edit/' + template.id,
            dataType: 'json',
            data: {
                _menus: menuList,
                _menu_contents: menuContens,
                _template_id: template.id,
                _template_name: template.template_name,
                _saved_name: savedName,
                _category_name: category_name,
                _token: CSRF_TOKEN
            },
            success: function (data) {
                hideSavingIcon();
                // TODO: Image upload before page template create
                var nextUrl = '/editor/' + data.template.category_name + '/' + data.template.template_name + '/' + data.template.id;
                if(data.success)
                {
                    var message = [];
                    message['template'] = data.message;
                    saveViewManus(template.id, menuList, menuContens, nextUrl, message);
                    return;
                }
                alert(data.message);
                window.location.href = nextUrl;
            },
            error: function(xhr, status, error) {
                hideSavingIcon();
                var err =  xhr.responseText;
                alert(err);
                // window.location.href = '/templates/gallery';
            }
        });
}


function saveViewManus(template_id, viewMenus, menuContents, nextUrl, message)
{
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: "POST",
        url: '/html-view-menus/create/' + template_id,
        dataType: 'json',
        data: {
            _menus: viewMenus,
            _token: CSRF_TOKEN
        },
        success: function (data) {
            hideSavingIcon();
            // TODO: Image upload before page template create
            if(data.success)
            {
                message['menu'] = data.message;
                saveContents(data.templateViewMenus, menuContens, nextUrl, message);
                return;
            }
            alert('ERROR: Failed to create template menus!');
        },
        error: function(xhr, status, error) {
            hideSavingIcon();
            var err =  xhr.responseText;
            alert(err);            
        }
    });
}

function saveContents(templateViewMenus, menuContents, nextUrl, message)
{
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    // saveImages(category_name, savedTemplateID);
    allImages = [];

    alert(message['menu']);
    alert(templateViewMenus[0].menu_title);
    alert(message['template']);

    window.location.href = nextUrl;

    return true;
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