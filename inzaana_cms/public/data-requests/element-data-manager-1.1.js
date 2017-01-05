/*
 * Shows waiting icons while requesting data operation is ongoing
 */
function showSavingIcon(itemCount) {
    var sweetAlertWithTimout = {
        title: "Please wait!",
        text: 'Loading form information ...',
        timer: 1000 * itemCount,
        imageUrl: '/dist/img/loading40.gif',
        imageSize: '220x20',
        type: 'info',
        showConfirmButton: false
    };
    var sweetAlert = {
        title: "Please wait!",
        text: 'Loading form information ...',
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
    context: ['postcodes', 'states'],
    data: {},
    ready: function(context, data) {},
    onSuccess: function(data) {

        if(isEmpty(data))
            ElementDataManager.data = { "id": 0, "value" : "-- Select --" };
        else
            ElementDataManager.data = data;

        ElementDataManager.ready(ElementDataManager.context, ElementDataManager.data);
        
        if(ElementDataManager.isCompleted())
            hideSavingIcon();
    },
    onError: function(xhr, textStatus) {
        hideSavingIcon();
        ElementDataManager.data = { "id": 0, "value" : "-- Select --" };
        ElementDataManager.ready(ElementDataManager.context, ElementDataManager.data);
    },
    request: function(req_type, context, data) {

        var routing_url = '/' + context + '/' + data[context];

        showSavingIcon(this.timeout);
        
        var req = $.ajax({

            type: req_type,
            url: routing_url,
            dataType: 'json',
            statusCode: {
                404: function() {
                    hideSavingIcon();
                    ElementDataManager.data = { "id": 0, "value" : "-- Select --" };
                    ElementDataManager.ready(ElementDataManager.context, ElementDataManager.data);
                }
            }
        });

        req.done(this.onSuccess).fail(this.onError);
    },
    load: function(data, onReady) {

        $(this.element).ready(function() {
            ElementDataManager.ready = onReady;

            $.each(ElementDataManager.context, function( index, value ) {

                ElementDataManager.request("GET", value, data);
            });
        });
    },
    send: function(data, onReady) {

        $(this.element).ready(function() {
            ElementDataManager.ready = onReady;

            $.each(ElementDataManager.context, function( index, value ) {

                ElementDataManager.request("POST", value, data);
            });
        });
    },
    isCompleted: function() { return false; }
}