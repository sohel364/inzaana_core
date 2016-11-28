/*
 * Shows loading icons while saving operation is ongoing
 */
function showSavingIcon(itemCount) {
    var sweetAlert = {
        title: "Please wait!",
        text: 'Loading form information ...',
        timer: 1000 * itemCount,
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

function isEmpty(value) {
    return value == "none" || value == "undefined" || value == "";
}

var ElementDataManager = {
    timeout: 100,
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
    },
    onError: function(xhr, textStatus) {
        ElementDataManager.data = { "id": 0, "value" : "-- Select --" };
        ElementDataManager.ready(ElementDataManager.context, ElementDataManager.data);
    },
    request: function(context, data) {

        var routing_url = '/dashboard/' + context + '/country/' + data;

        showSavingIcon(this.timeout);
        
        var req = $.ajax({

            type: "GET",
            url: routing_url,
            dataType: 'json',
            statusCode: {
                404: function() {
                    ElementDataManager.data = { "id": 0, "value" : "-- Select --" };
                    ElementDataManager.ready(this.context, this.data);
                }
            }
        });

        req.done(this.onSuccess).fail(this.onError);
    },
    load: function(data, onReady) {
        $(this.element).ready(function() {
            ElementDataManager.ready = onReady;

            $.each(ElementDataManager.context, function( index, value ) {

                ElementDataManager.request(value, data);
            });
        });
    }
}