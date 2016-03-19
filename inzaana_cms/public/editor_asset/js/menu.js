/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Global variables

var menuContens = {}; //Global Menu Content Array(Key-value pair)
var curMenu; //Current Menu
var defaultMenuHtml; // Default body html of the current template-*+
var allImages = [];
var imageObjects = {};
var imageCounter = -1;
var imageArrayLength = 0;
var curMenuForImage;

// INFO: this array (pagesEditedCollection[]) and object pagesEdited reference is used in 
// 1. drag_drop.js:onMenuPageModified(...)
// 2. savePage.js:getMenuList()
// 3. menu.js:onUserFoundSuccess(...)
var pagesEdited = {};
var pagesEditedCollection = [];

var _user_id, _template_id;

// onload functionalities
$(document).ready(function() {
    onLoadMenus();
});

function onUserFoundSuccess(user_id, medias)
{
    var data_rows = Object.keys(medias);
    data_rows.forEach(function(data_row) {

        var media = medias[data_row];
        console.log(media.user_id + ' #### ' + user_id);

        if(media.user_id != user_id)
        {
            // TODO: Redirecting to guest home
            errorAlert(
                'You are not authenticated or session expired. Redirecting to guest home. Please log in to edit your template',
                function() {

                    window.location.href = '/';
                    hideSavingIcon();
                })
            return;
        }

        {
            var user_template_id = media.user_id + '_' + media.template_id + '_';
            var image_tree = media.media_name.replace( user_template_id ,'');
            var image_name_parsed_array = image_tree.split('_');
            var menu = image_name_parsed_array[0];

            var id_hashed = image_name_parsed_array[image_name_parsed_array.length - 1];
            var image_id = image_tree.replace(menu + '_', '').replace('_' + id_hashed, '');
            //alert('[WB-D] [image-id]: ' + image_id);

            // var src = getBaseUrl() + "/archive/" + media.media_name;
            var src = '/medias/images/' + media.media_name;

            //alert($('#' + image_id)[0].nodeName);
            var parts = image_id.split('_');
            var tagName = parts[parts.length - 1].split('-')[0];
            // Change image source
         
            if(tagName == "img")
            {
                console.log("[WB-D] PREV RESP ID:[" + image_id + "]/ SRC:" +  $('#' + image_id).attr("src"));
                // TODO: BLOB image data is special - will work on it later!!! 
                if($('#' + image_id).attr("src") != null && $('#' + image_id).attr("src").indexOf("blob") == -1)
                    $('#' + image_id).attr("src", src);
                // console.log("[WB-D] RESP ID:[" + image_id + "]/ SRC:" +  $('#' + image_id).attr("src"));
            }
            else
            {
                // TODO: BLOB image data is special - will work on it later!!! 
                if($('#' + image_id).css("background-image") != null && $('#' + image_id).css("background-image").indexOf("blob") == -1)
                    $('#' + image_id).css("background-image", "url(" + src  + ")");
                // console.log("[WB-D] RESP URL:" + $('#' + image_id).css("background-image"));
            } 
        }// end-if for user checking
    }); // end forEach
    hideSavingIcon();
}

function viewTemplateMedias(medias)
{
    findCurrentAuthenticatedUser( function(data) {
        if(!data.success)
        {
            errorAlert(
                isEmpty(data.message) ? 'Something went wrong to find the authticated user!' : data.message,
                function() {

                    hideSavingIcon();
                    window.location.href = '/';
                });
            hideSavingIcon();
            return;
        }
        _user_id = data.user.id;
        onUserFoundSuccess(_user_id, medias);

    }, function(xhr, textStatus) {

        errorAlert(
            isEmpty(xhr.responseText) ? 'Something went wrong' : xhr.responseText,
            function() {

                hideSavingIcon();
                window.location.href = '/';
            });
    }); // end findCurrentAuthenticatedUser
}

function onMediaFoundSuccess(data)
{
    if(data.success)
    {
        viewTemplateMedias(data.medias);
        return;
    }
    errorAlert(data.message, function() {});
}

function handleReceivedImageData(xhr) {
    //alert( "replied:: " + xhr.readyState + "/"+ xhr.status);
    if (xhr.readyState == 4  && xhr.status == 200)
    {
        var dataset = JSON.parse(xhr.responseText);
        //alert("replied->:" + dataset);
        viewTemplateMedias(data);
    }
}

function loadMediasOfPages() {
    var xhr = createXHR();
    if (xhr)
    {
        var url = getBaseUrl() + "/views/content_views/media_info_loader.php";
        // alert(template_id);
        var payload = "template_id=" + template_id;
        xhr.open("POST",url,true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded ');
        xhr.setRequestHeader("Content-length", payload.length);
        xhr.setRequestHeader("Connection", "close");
        xhr.onreadystatechange = function()
        {
            handleReceivedImageData(xhr);
        };
        xhr.send(payload);
    }
}

function findCurrentAuthenticatedUser(onSuccess, onError)
{
    var routing_url = '/who-am-i';

    var request = $.ajax({

        type: "GET",
        url: routing_url,
        dataType: 'json',
        statusCode: {
            404: function() {
                swal( "Sorry!" , "Your requested user is not found!", 'error');
                window.location.href = '/';
            }
        }
    });

    request.done(onSuccess).fail(onError);
}

function findMediasOfTemplate(id, onSuccess, onError)
{
    var routing_url = '/medias/template/' + id;

    var request = $.ajax({

        type: "GET",
        url: routing_url,
        dataType: 'json',
        statusCode: {
            404: function() {
                swal( "Sorry!" , "Your requested page is not found!", 'error');
            }
        }
    });

    request.done(onSuccess).fail(onError);
}

function loadContents()
{
    console.log("[DEBUG] loadContents");
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    var isEdit = $('#hidden-div-is-edit').text();
    var template_id = $('#hidden-div-template-current').text();

    if(isInEditor /* Is in editor or viewer */ && !isEdit /* Is template editor in edit mode or save mode */)
    {
        makeTemplateComponetsEditable();
        return;
    }
    $.ajax({
        type: "POST",
        url: '/html-view-menus/' + template_id,
        dataType: 'json',
        data: {
            _is_edit: isEdit,
            _default_content: defaultMenuHtml,
            _token: CSRF_TOKEN
        },
        success: function (data) {
            if(data.success)
            {
                console.log(data.message);
                if(data.menuContents == null)
                {
                    resetMenuContent();
                    return;
                }
                menuContens = data.menuContents;
                setBodyHtmlString(menuContens[curMenu]);

                setPagesEdited(curMenu, false);

                return;
            }
            console.log(data.message);
            errorAlert(data.message, function() {

                window.location.href = '/templates/saved'; 
            });
        },
        error: function(xhr, status, error) {
            console.log("[DEBUG] ajax error");
            var err =  xhr.responseText;
            console.log(err);
            errorAlert(err, function() {

                resetMenuContent();
            });
        }
    });
}

/*
 * Sets the initial menu contents to menu array and initialize the global variables
 */
function onLoadMenus() {
    // makeTemplateComponetsEditable();
    console.log("[DEBUG] onLoadMenus called");
    var isViewer = $('#hidden-div-is-view').text();
    isView = isViewer;
    var isEdit = $('#hidden-div-is-edit').text();
    var template_id = $('#hidden-div-template-current').text();

    $ul = $('#menu');
    $lis = $ul.find('li'); /* Finds all sub li under menu ul(find all menus) */
    var curLi = $lis[0];
    $ahref = $(curLi).find('a');
    curMenu = $ahref.text();

    // loadMediasOfPages();
    showPreparingIcon();

    if (typeof isEdit !== 'undefined' && isEdit) {
        // update mode
        // getSavedMenuContents();
        // alert('In edit mode in editor');
    }
    else if(typeof isView !== 'undefined' && isView)
    {
        // alert('In viewer mode');
    }
    else 
    {
        // insert mode
        // alert('In saving mode in editor');
        menuContens[curMenu] = getBodyHtmlString();
    }
    defaultMenuHtml = getBodyHtmlString();
    // for laravel implementation
    loadContents();

    if(isInEditor /* Is in editor or viewer */ && !isEdit /* Is template editor in edit mode or save mode */)
    {
        hideSavingIcon();
        return;
    }

    findMediasOfTemplate(
        template_id,
        onMediaFoundSuccess,
    function(xhr, status) {

        swal(status, 'Template medias loading failed: ' + xhr.responseText, 'error');
    });
}

/*
 * Save current menu context while switching to another menu
 */
function saveCurrentMenuText() {
    console.log("Saving Current menu Text: ");
    if (isInEditor)
    {
        console.log("In Editor");
        closeAllEditDialogPanel();
        makeTemplateComponetsNotEditable();
    }
    menuContens[curMenu] = getBodyHtmlString();
}

/*
 * Get the body html string
 * @returns {String}
 */
function getBodyHtmlString() {
    var bodyHtml = $('#body').html();
    return bodyHtml;
}

/*
 * Set the html content of menu body
 * @param {type} bodyHtml
 */
function setBodyHtmlString(bodyHtml) {
    $('#body').html(bodyHtml);
    if(!isInEditor)
    {
        makeTemplateComponetsNotEditable();
        LoadTemplateAnimations();
    }
    else
    {
        makeTemplateComponetsEditable();
    }
}

/*
 * Reset the menu contents while initializing a menu
 */
function resetMenuContent() {
    setBodyHtmlString(defaultMenuHtml);
    menuContens[curMenu] = defaultMenuHtml;
}

function setDefaultMenuContent(menuText)
{
    console.log("[DEBUG] setDefaultMenuContent");
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        type: "POST",
        url: '/html-view-menus/content-default/' + template_id,
        dataType: 'json',
        data: {
            _menu_title: menuText,
            _token: CSRF_TOKEN
        },
        success: function (data) {
            if(data.success)
            {
                defaultMenuHtml = data.defaultMenuContent;
            }
            // alert(data.message);
        },
        error: function(xhr, status, error) {
            var err =  xhr.responseText;
            // alert(err);
        }        
    });
}

/*
 * Function executes while clicking any menu
 * @param {type} menu
 */
function onMenuClick(menu) {
    console.log("[DEBUG] onMenuClick");

    var isEdit = $('#hidden-div-is-edit').text();
    var isView = !isInEditor;

    saveCurrentMenuText();
    traverseImages();

    var menuText = $(menu).text();

    curMenu = menuText;

    if(menuContens[menuText] === null || typeof menuContens[menuText] === 'undefined') {
        // resetMenuContent();
        setDefaultMenuContent(menuText);
        // alert("RESETTING MENU CONTENT!!! ALERT!!" + defaultMenuHtml);
    } else {
        //alert("SAVING PREVIOUS MENU CONTENT!!! -> " + menuText + "###" + menuContens[menuText]);
        setBodyHtmlString(menuContens[menuText]);
    }
    setPagesEdited(menuText, false);
}


function getSavedMenuContents() {

    menuContens = user_menu_content_array;
    setBodyHtmlString(menuContens[curMenu]);
}

var imageType = "png";
var _callbackFn = null;

function uploadImage(images, i, srcList) {

    sendRequest(binary, i);

    //console.log("[WB]Saving ...###" + images[i].src + "###");
}

function isEmpty(value) {
    return value == "none" || value == "undefined" || value == "";
}

function loadImages(user_id, template_id, callbackFunc)
{
    _user_id = user_id;
    _template_id  = template_id;
    _callbackFn = callbackFunc;
}

function saveCurrentPageImages(isEdit, imageObj) {

    if(!isEdit) {
        // sendRequest(imageObj);
        sendImageUploadRequest(imageObj);
        if(imageObj.src.indexOf("blob") != -1)
        {
            console.log("[WB-BLOB] on insert image-menu: " + imageObj.src);
        }
    }
    else
    {
        // if(isEmpty(imageObj.src))
        //    alert("[WB] on update empty image-src: \"" + imageObj.src + "\"");
        // if(imageObj.src.indexOf("/medias/images/") == -1)
        {
            // sendRequest(imageObj);
            sendImageUploadRequest(imageObj);
            //console.log("[WB] on update image-menu: " + imageObj.src);
            // alert("[WB] on update image-menu: " + imageObj.src);
        }
    }
}

function isImageExists(id, menu_item)
{
    if(allImages[menu_item] == null) return false;
    var image_items = Object.keys(allImages[menu_item]);
    image_items.forEach(function(image){

        var imageObj = JSON.parse(allImages[menu_item][image]);
        if(id == imageObj.id) return true;

    });
    return false;
}

function saveImages(user_id, template_id, onUploadSuccess) {

    var imageCount = 0;
    var isEdit = $('#hidden-div-is-edit').text();

    console.log("[WB-D] saveImages: " + user_id + "$##$" + template_id);

    loadImages(user_id, template_id, function(imageObj){

        // console.log("[WB-D] [REPLIED] image-src: " + imageObj.src_arch );

        console.log('[ ' + imageObj.image_index + ' ] [ ' + imageObj.image_name);
        console.log('[ ' + imageCounter + ' ] [ ' + imageCount);
        if(imageCounter == imageCount)
        {
            onUploadSuccess(imageCount);
            imageCounter = imageCount = 0;
        }
    });

    var menu_items = Object.keys(allImages);
    //menu_items.sort(); // sort the array of keys
    menu_items.forEach(function(menu_item) {
        var image_items = Object.keys(allImages[menu_item]);
        //items.sort();
        image_items.forEach(function(image){

            //console.log('[WB-D] json: ' + allImages[menu_item][image]);

            var imageObj = JSON.parse(allImages[menu_item][image]);

            //console.log("[WB-D] info: " + user_id + "#" + template_id + "#" + imageObj.id + " SAVING...");

            saveCurrentPageImages(isEdit, imageObj);

            //console.log("[WB-D] info: " + user_id + "#" + template_id + "#" + imageObj.id + " SAVED!!!");
        });
        imageCount += image_items.length;
        //alert("images count: " + image_items.length);
    });
    // alert("menu count: " + menu_items.length);
    // onUploadSuccess(imageCount);
}

function test_upload_image(){
    var image = document.getElementsByTagName("img");
    if(image.src.indexOf("localhost") > -1 )
    {
        var binary = getBase64Image(image, "hidden-canvas");

        //sendRequest(binary, 0);
    }

}

/* @param img, image tag <IMG> HTML element
 * @param id, a hidden HTML canvas element id where the image is rendered
 */
function getBase64ImageForImageElement(img, id) {

    // Create an empty canvas element
    var canvas = document.getElementById(id);

    //console.log('[WB][size]:' + canvas.width + 'x' + canvas.height);
    //console.log('[WB][size]:' + img.attr("width") + 'x' + img.attr("height"));

    var imageData = document.getElementById(img.attr("id"));
    //console.log('[WB][object]:' + imageData.id);
    //console.log('[WB][id]:' +  img.attr("id"));
    //console.log('[WB][src]:' +  imageData.src);
    //console.log('[WB][width]:' +  imageData.width);
    //console.log('[WB][height]:' +  imageData.height);

    canvas.width = imageData.width;
    canvas.height = imageData.height;

    // Copy the image contents to the canvas
    var ctx = canvas.getContext("2d");
    ctx.drawImage(imageData, 0, 0);

    // Get the data-URL formatted image
    // Firefox supports PNG and JPEG. You could check img.src to
    // guess the original format, but be aware the using "image/jpg"
    // will re-encode the image.

    var s = img.attr("src").split('.').pop();
    //console.log('[WB][type]:' + s);

    if(s.indexOf("png")>-1){
        var dataURL = canvas.toDataURL("image/png");
        imageType = "png";
        return dataURL;
    }

    if(s.indexOf("jpg")>-1 || s.indexOf("jpeg")>-1){
        var dataURL = canvas.toDataURL("image/jpeg");
        imageType = "jpeg";
        return dataURL;
    }
    return null;
}

function getBase64Image(img, id)
{
    // Create an empty canvas element
    var canvas = document.getElementById(id);

    var imageData = new Image();
    imageData.onload = function(){

        canvas.width = img.css("width").replace("px", "").trim();
        canvas.height = img.css("height").replace("px", "").trim();

        //console.log('[WB-D][size]:' + canvas.width + 'x' + canvas.height);
        //console.log('[WB-D][size]:' + img.css("width") + 'x' + img.css("height"));

        // Copy the image contents to the canvas
        var ctx = canvas.getContext("2d");
        ctx.drawImage(this, 0, 0);

        //console.log('[WB-D][src]:' + imageData.src);
        //console.log('[WB-D][size]:' + imageData.width + 'x' + imageData.height);
    };
    imageData.src = img.css("background-image").replace("url", "").replace("(","").replace(")","").replace("\"","").replace("\"","").trim();

    // Get the data-URL formatted image
    // Firefox supports PNG and JPEG. You could check img.src to
    // guess the original format, but be aware the using "image/jpg"
    // will re-encode the image.

    var s = imageData.src.split('.').pop();

    console.log('[WB-D][type]:' + s);

    if(s.indexOf("png")>-1){
        var dataURL = canvas.toDataURL("image/png", 1.0);
        imageType = "png";
        return dataURL;
    }

    if(s.indexOf("jpg")>-1 || s.indexOf("jpeg")>-1){
        var dataURL = canvas.toDataURL("image/jpeg", 1.0);
        imageType = "jpeg";
        return dataURL;
    }
    return null;
}


function createXHR()
{

    try { return new XMLHttpRequest(); } catch(e) { alert(e);}
    try { return new ActiveXObject("Msxml2.XMLHTTP.6.0"); } catch (e) {alert(e);}
    try { return new ActiveXObject("Msxml2.XMLHTTP.3.0"); } catch (e) {alert(e);}
    try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch (e) {alert(e);}
    try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch (e) {alert(e);}

    return null;
}

function sendImageUploadRequest(imageObj)
{
    imageCounter = 0;
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var request = $.ajax({
        type: "POST",
        url: '/medias/save',
        dataType: 'json',
        data: {
            image: imageObj.data,
            type: imageObj.type,
            userId: _user_id,
            templateId: _template_id,
            image_src: imageObj.src,
            tagElement: imageObj.tag,
            image_id: imageObj.id,
            image_index: imageObj.index,
            menu_id: imageObj.menu,
            _token: CSRF_TOKEN
        }
    });

    request.done( function(data) {

            // alert("[WB] RESP " + data.imageProfile);
            var imageObj = JSON.parse(data.imageProfile);
            // alert("[WB] RESP " + imageObj);

            // alert("[WB] RESP " + imageObj.image_name);
            // Change image source
            var tagElement = (imageObj.tag_element == null || imageObj.tag_element == "") ?
                            $('#' + imageObj.image_id)[0].nodeName : imageObj.tag_element;
       
            if(tagElement == "IMG" || tagElement == "img")
            {
                // $('#' + imageObj.image_id).attr("src", imageObj.src_arch);
                $('#' + imageObj.image_id).attr("src", "/medias/images/" + imageObj.image_name);
                console.log("[WB] RESP SRC:" +  $('#' + imageObj.image_id).attr("src"));
            }
            else
            {
                // $('#' + imageObj.image_id).css("background-image", "url(" + imageObj.src_arch  + ")");
                $('#' + imageObj.image_id).css("background-image", "url(/medias/images/" + imageObj.image_name + ")");
                // $('#' + imageObj.image_id).attr("style", "background-image: url(/medias/images/" + imageObj.image_name + ")");
                console.log("[WB] RESP URL:" + $('#' + imageObj.image_id).css("background-image"));
            }
            imageCounter++;
            _callbackFn(imageObj);

        }).fail( function(xhr, status) {
            var err =  xhr.responseText;
            errorAlert('Upload failed: ' + err, function() {

                hideSavingIcon();
            });
        });
}

function sendRequest(imageObj)
{
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var xhr = createXHR();

    if (xhr)
    {
        // var url = "http://localhost/webbuilder/views/content_views/uploader.php";
        var url = '/medias/save';
        var payload = "image=" + imageObj.data
                    + "&type=" + imageObj.type
                    + "&userId=" + _user_id
                    + "&templateId=" + _template_id
                    + "&image_src=" + imageObj.src
                    + "&tagElement=" + imageObj.tag
                    + "&image_id=" + imageObj.id
                    + "&image_index=" + imageObj.index
                    + "&menu_id=" + imageObj.menu
                    + "&_token=" + CSRF_TOKEN;
        xhr.open("POST",url,true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded ');
        xhr.setRequestHeader("Content-length", payload.length);
        xhr.setRequestHeader("Connection", "close");
        xhr.onreadystatechange = function(){handleResponse(xhr);};
        xhr.send(payload);
    }
    else
    {
        console.log('Upload error: Something went wrong!!');
    }
}

function handleResponse(xhr)
{

    if (xhr.readyState == 4  && xhr.status == 200)
    {
        // alert(xhr.responseText);
        //console.log("[WB]" + xhr.readyState + '#' + xhr.status + '#' + _template_id);
        //var responseImage = document.getElementById("responseImage");
        //responseImage.src = (imageType == "png" ? "data:image/png;base64," : "data:image/jpeg;base64,") + xhr.responseText;
        //responseImage.style.display = "";
        //alert("[WB]Saved! " + xhr.responseText);

        var imageObj = JSON.parse(xhr.responseText);

        //console.log("[WB] RESP " + imageObj.image_id);
        // Change image source
        if($('#' + imageObj.image_id)[0].nodeName == "IMG")
        {
            // $('#' + imageObj.image_id).attr("src", imageObj.src_arch);
            $('#' + imageObj.image_id).attr("src", "/medias/images/" + imageObj.image_name);
            console.log("[WB] RESP SRC:" +  $('#' + imageObj.image_id).attr("src"));
        }
        else
        {
            // $('#' + imageObj.image_id).css("background-image", "url(" + imageObj.src_arch  + ")");
            $('#' + imageObj.image_id).css("background-image", "url(/medias/images/" + imageObj.image_name + ")");
            // $('#' + imageObj.image_id).attr("style", "background-image: url(/medias/images/" + imageObj.image_name + ")");
            console.log("[WB] RESP URL:" + $('#' + imageObj.image_id).css("background-image"));
        }
        imageCounter++;
        _callbackFn(imageObj);
    }
    else
    {
        console.log("[WB][ERROR]" + xhr.responseText);
    }
}

/*
 * Shows loading icons while saving operation is ongoing
 */
function showPreparingIcon() {
    var sweetAlert = {
        title: "Please wait ...",
        text: 'Inzaana is preparing your template.',
        imageUrl: '/dist/img/loading40.gif',
        imageSize: '220x20',
        type: 'info',
        showConfirmButton: false
    };
    swal( sweetAlert );
}