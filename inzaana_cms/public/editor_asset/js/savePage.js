/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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

function setPagesEdited(menuTitle, isEdited)
{
    if(pagesEditedCollection.length == 0)
    {
        pagesEdited[menuTitle] = isEdited;
        pagesEditedCollection.push(pagesEdited);
        console.log('Menu added (' + menuTitle + '): edited:' + pagesEdited[menuTitle]);
        return;  
    }
    $.each(pagesEditedCollection, function( index, value ) {
        console.log(value);
        if(value[menuTitle] === null || typeof value[menuTitle] === 'undefined')
        {
            pagesEdited[menuTitle] = isEdited;
            console.log('Menu added (' + menuTitle + '): edited:' + pagesEdited[menuTitle]);   
            pagesEditedCollection.push(pagesEdited);
        }
        else
        {
            value[menuTitle] = isEdited;
            console.log('Menu edited (' + menuTitle + '): edited:' + value[menuTitle]);   
        }
    });
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
        
        if(menu['menuTitle'] != '+')
        {
            menuList.push(menu);
            setPagesEdited(menu['menuTitle'], false);
        }
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

                if ( tagName != 'img' || $('#' + element.id)[0].nodeName != 'IMG') // $('#' + element.id)[0].nodeName
                {
                    //console.log('[WB][container-parts [child]: ' + parts + '][' + $('#' + element.id)[0].nodeName + ']');
                    //console.log('[WB][container-parts [child][style:background(url)]: ' + $('#' + element.id).attr("style") + ']'); //$("#stylediv").attr('style')
                    if ($('#' + element.id).css("background-image") == "none"
                        || $('#' + element.id).css("background-image") == "undefined"
                        || $('#' + element.id).css("background-image") === "") {
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
                        // console.log('[WB] image id ' + element.id);
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
                            + '", "tag": "' + ($('#' + element.id)[0].nodeName == null ? tagName : $('#' + element.id)[0].nodeName)
                            + '" }';

                        if(!isImageExists(element.id, curMenu))
                        {
                            containers.push(containerObj);
                        }
                        // console.log('[WB][container-json]: ' + containerObj);
                    }
                }
                else
                {
                    // console.log('[WB][container-parts [child]: ' + parts + '][' + $('#' + element.id)[0].nodeName + ']');
                    if ($('#' + element.id).attr("src") == "undefined" 
                        || $('#' + element.id).attr("src") == "none" 
                        || $('#' + element.id).attr("src") === "") {
                        //console.log('[WB][container-parts [child][index]: ' + index + ']');
                        //console.log('[WB][container-parts [child][style:src]: ' + $('#' + element.id).attr("src") + ']'); //$("#stylediv").attr('src')
                    }
                    else {

                        var binary = getBase64ImageForImageElement($('#' + element.id), "hidden-canvas");
                        var url = $('#' + element.id).attr("src");
                        // console.log('[WB] image id ' + element.id);
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
                            + '", "tag": "' + ($('#' + element.id)[0].nodeName == null ? tagName : $('#' + element.id)[0].nodeName)
                            + '" }';

                        if(!isImageExists(element.id, curMenu))
                        {
                            containers.push(containerObj);
                        }
                        // console.log('[WB][container-json]: ' + containerObj);
                    }
                }
            }
        });
        allImages[curMenu] = containers;
        // console.log('[WB-D][container-curMenuImage-count: ' + allImages[curMenu].length + ']');
    });
}

/*
 * Calls ajax to save the page contents(menu, submenu, contents etc)
 * @returns {undefined}
 */
function savePage(category_name, template_name, isEdit) 
{
    // console.log("[WB-D] savePage: " + category_name + "$##$" + template_name);
    traverseImages();
    // console.log("[WB-D] savePage: " + category_name + "$##$" + template_name);

    saveCurrentMenuText();

    var menuList = getMenuList();      
    
    if (typeof menuList.length !== 'undefined' && menuList.length >= 1) 
    {
        var savedName; 
        if(!isEdit)
        {
            var inputWriter = {  title: "Save your template",
                    text: "Enter webpage name : ",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    animation: "slide-from-top",
                    inputPlaceholder: "Enter page name" };

            swal( inputWriter, 

            function(inputValue){   
                if (inputValue === false) return false;
                if (inputValue === "") {
                    swal.showInputError('You need to write something! Enter a valid page name. Page is not saved.');
                    // window.location.href = '/editor/' + category_name + '/' + template_name;
                    return false;  
                }
                showSavingIcon();
                insertPage(menuList, template_name, category_name, inputValue);
            });
        } 
        else 
        {
            var template_id = template_name;

            $.ajax({

                type: "GET",
                url: '/templates/info/' + template_id,
                dataType: 'json',
                success: function (data) {

                    // alert('msg: ' + data.message );
                    var inputWriter = {  title: "Save your template",
                            text: "Enter webpage name : ",
                            type: "input",
                            showCancelButton: true,
                            closeOnConfirm: false,
                            animation: "slide-from-top",
                            inputPlaceholder: "Enter page name" };

                    if(data.success)
                    {
                        inputWriter.inputValue = data.template.saved_name;
                    }
                    else
                    {
                        inputWriter.inputPlaceholder = "Enter page name";
                    }

                    swal( inputWriter, 

                    function(inputValue){   
                        if (inputValue === false) return false;
                        if (inputValue === "") {
                            swal.showInputError('You need to write something! Enter a valid page name. Page is not saved.');
                            // window.location.href = '/editor/' + data.template.category_name + '/' + data.template.template_name + '/' + data.template.id;
                            return false;  
                        }
                        showSavingIcon();
                        updatePage(menuList, data.template, category_name, inputValue);
                    });
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
                _default_content: defaultMenuHtml,
                _token: CSRF_TOKEN
            },
            success: function (data) {

                // TODO: Image upload before page template create
                var nextUrl = '/editor/' + data.template.category_name + '/' + data.template.template_name + '/' + data.template.id;
                if(data.success)
                {
                    var message = [];
                    message['template'] = data.message;
                    saveViewMenus(data.template.id, menuList, menuContens, nextUrl, message);
                    return;
                }
                errorAlert(data.message, function() {

                    window.location.href = '/editor/' + category_name + '/' + template_name; 
                });
            },
            error: function(xhr, status, error) {
                var err =  xhr.responseText;
                
                errorAlert(data.message, function() {

                    window.location.href = nextUrl;
                });
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
                _default_content: defaultMenuHtml,
                _token: CSRF_TOKEN
            },
            success: function (data) {
                // TODO: Image upload before page template create
                var nextUrl = '/editor/' + data.template.category_name + '/' + data.template.template_name + '/' + data.template.id;
                if(data.success)
                {
                    var message = [];
                    message['template'] = data.message;
                    saveViewMenus(template.id, menuList, menuContens, nextUrl, message);
                    return;
                }
                errorAlert(data.message, function() {

                    window.location.href = '/templates/gallery';
                });
            },
            error: function(xhr, status, error) {
                var err =  xhr.responseText;

                errorAlert(data.message, function() {

                    window.location.href = nextUrl;
                });
            }
        });
}


function saveViewMenus(template_id, viewMenus, menuContents, nextUrl, message)
{
    console.log('Menu edited container:' + pagesEditedCollection.length);

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: "POST",
        url: '/html-view-menus/create/' + template_id,
        dataType: 'json',
        data: {
            _menus: viewMenus,
            _menu_contents: menuContents,
            _menu_contents_edited: pagesEditedCollection,
            _token: CSRF_TOKEN
        },
        success: function (data) {
            // TODO: Image upload before page template create
            if(data.success)
            {
                console.log(data.message);
                message['menu'] = data.message;

                makeTemplateComponetsEditable();

                saveContents(template_id, viewMenus, menuContents, nextUrl, message);
                return;
            }
            console.log(data.message);
            errorAlert(data.message, function() {

                swal('Reloading ...');
                window.location.href = nextUrl;
            });
        },
        error: function(xhr, status, error) {
            var err =  xhr.responseText;

            errorAlert(err, function() {

                swal('Reloading ...');
                window.location.href = nextUrl; 
            });     
        }
    });
}

function saveContents(template_id, templateViewMenus, menuContents, nextUrl, message)
{
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: "POST",
        url: '/html-view-contents/create',
        dataType: 'json',
        data: {
            _menus: templateViewMenus,
            _menu_contents: menuContents,
            _default_content: defaultMenuHtml,
            _template_id: template_id,
            _menu_contents_edited: pagesEditedCollection,
            _token: CSRF_TOKEN
        },
        success: function (data) {
            // TODO: Image upload before page template create
            if(data.success)
            {
                // NOTE: for debuggin success messages
                // alert(message['menu']);
                // alert(data.message);
                // alert(message['template']);

                // find template to save its medias
                findTemplate(
                    template_id,
                function(data) {
                  onSuccessFoundTemplate(data, nextUrl, message);
                },
                function(xhr, status, error) {

                    errorAlert(xhr.responseText, function() {

                        window.location.href = nextUrl; 
                    });
                });
                return;
            }
            errorAlert(data.message, function() {

                swal('Reloading ...');
                window.location.href = '/templates/gallery';
            });
        },
        error: function(xhr, status, error) {
            var err =  xhr.responseText;
            // alert(err);
            errorAlert(err, function() {

                swal('Reloading ...');
                window.location.href = nextUrl;  
            });
        }
    });
}

// When template is found saves its medias
function onSuccessFoundTemplate(data, nextUrl, message) {

    if(data.success)
    {
        // INFO: template info is found
        saveImages(data.template.user_id, data.template.id, function(imageCount) {
            
            // alert('Image uploaded:' + imageCount);
            // hideSavingIcon();

            // TODO: when all medias are uploaded done show sucess
            var sweetAlert = {
                html: true,
                title: "Sweet!",
                text: '<div class="alert alert-success">' + message['template'] + '</div>',
                imageUrl: "/dist/img/thumbs-up.jpg"
            };

            swal( sweetAlert , function() {

                allImages = [];
                pagesEditedCollection = [];
                
                // MUST BE REDIRECTED
                swal('Reloading ...');
                window.location.href = nextUrl;
            });

        });
        return;
    }
    // alert(data.message);
    errorAlert(data.message, function() {

        swal('Reloading ...');
        window.location.href = nextUrl; 
    });
}

/*
 * Shows loading icons while saving operation is ongoing
 */
function showSavingIcon() {
    var sweetAlert = {
        title: "Please wait!",
        text: 'Your template is saving ...',
        imageUrl: '/dist/img/loading40.gif',
        imageSize: '220x20',
        type: 'info',
        showConfirmButton: false
    };
    swal( sweetAlert );
}
/*
/*
 * Hides loading icon after finishing saving operation
 */
function hideSavingIcon() {
    swal.close();
}

function errorAlert(message, callback)
{    
    var sweetAlert = {
        title: "Sorry!",
        text: 'You actions did\'t completed due to some errors!',
        type: 'error',
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, show me more!",
        cancelButtonText: "No, continue!",
        closeOnConfirm: false,
        closeOnCancel: false
    };
    swal( sweetAlert , function(isConfirm) {
        if (isConfirm)
        {
            swal({
                title: "Error!",
                type: 'error',
                text: message,
                html: true,
                customClass: 'httpError',
                confirmButtonText: "Close",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            },
            function(isClosed) {
                if(isClosed)
                {
                    callback();
                }
                return;
            });
        }
        else
        {
            hideSavingIcon();
        }
    });
}

function findTemplate(id, onSuccess, onError)
{
    $.ajax({

        type: "GET",
        url: '/templates/info/' + id,
        dataType: 'json',
        success: onSuccess,
        error: onError
    });
}