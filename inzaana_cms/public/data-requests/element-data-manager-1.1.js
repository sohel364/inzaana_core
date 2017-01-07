/*
 * Shows waiting icons while requesting data operation is ongoing
 */
function showSavingIcon(itemCount, message) {
    var sweetAlertWithTimout = {
        title: "Please wait!",
        text: message,
        timer: 1000 * itemCount,
        imageUrl: '/dist/img/loading40.gif',
        imageSize: '220x20',
        type: 'info',
        showConfirmButton: false
    };
    var sweetAlert = {
        title: "Please wait!",
        text: message,
        imageUrl: '/dist/img/loading40.gif',
        imageSize: '220x20',
        type: 'info',
        showConfirmButton: false
    };
    swal( itemCount > 0 ? sweetAlertWithTimout : sweetAlert );
}
/*
/*
 * Hides loading icon after finishing saving operation
 */
function hideSavingIcon() {
    swal.close();
}

function isEmpty(value) {
    return value == "none" || value == "undefined" || value == "";
}

var ElementDataManager = {
    timeout: 0,
    element: 'form',
    contexts: [{ prefix: 'products', route: '/create' }],
    ready: function(data) {},
    onSuccess: function(data) {

        ElementDataManager.ready(data);
        
        if(isEmpty(data) || ElementDataManager.isCompleted())
            hideSavingIcon();
    },
    onError: function(xhr, textStatus) {
        hideSavingIcon();
        ElementDataManager.ready(null);
    },
    request: function(req_type, context, _data) {

        var routing_url = '/' + context.prefix + context.route;

        alert(routing_url);

        showSavingIcon(this.timeout, (req_type == 'GET') ? 'We are preparing your contents ...' : 'We are sending your request ...');

        var ajaxProperties = {

            type: req_type,
            url: routing_url,
            dataType: 'json',
            data: _data,
            statusCode: {
                404: function() {
                    hideSavingIcon();
                    ElementDataManager.ready(null);
                }
            }
        };
        if(req_type == "POST")
        {    
            ajaxProperties = {
                url: routing_url,
                type: req_type,
                data: _data,
                cache: false,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false,
                statusCode: {
                    404: function() {
                        hideSavingIcon();
                        ElementDataManager.ready(null);
                    }
                }
            }
        };
        
        var req = $.ajax(ajaxProperties);

        req.done(this.onSuccess).fail(this.onError);
    },
    load: function(onReady) {

        $(this.element).ready(function() {

            ElementDataManager.ready = onReady;

            $.each(ElementDataManager.contexts, function( index, value ) {

                ElementDataManager.request("GET", value, {});
            });
        });
    },
    send: function(data, onReady) {

        alert(this.element);
        var theForm = document.getElementById(this.element);
        $(this.element).submit( function(e) {

            e.preventDefault();
            
            alert(this.element);

            var clientData = isEmpty(data) ? new FormData($(this)[0]) : data;

            ElementDataManager.ready = onReady;

            $.each(ElementDataManager.contexts, function( index, value ) {


                ElementDataManager.request("POST", value, clientData);
            });
        });
    },
    isCompleted: function() { return false; }
}