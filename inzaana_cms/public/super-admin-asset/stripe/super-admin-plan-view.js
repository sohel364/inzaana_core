$('#plan-status').submit(function(e) {
    e.preventDefault();
    if($(this).data("id") != '') {
        var url = window.location.href.replace('#','');
        var form = document.forms.namedItem("plan-status"); // high importance!, here you need change "yourformname" with the name of your form
        var formdata = new FormData(form); // high importance!
        $.ajax({
            async: true,
            type: 'POST',
            data: formdata,
            dataType: "json", // or html if you want...
            contentType: false, // high importance!
            url: url+'/ajax/update', // you need change it.
            processData: false, // high importance!
            success: function (data) {
                $('#update_button').html('');
                if(data['id'])
                {
                    $('#update_button').append('<input type="hidden" name="status_id" value="'+data['id']+'">');
                    $('#update_button').append('<input type="submit" class="btn btn-warning btn-xs" value="Hide">');
                }
                else
                {
                    $('#update_button').append('<input type="hidden" name="status_id" value="'+data['id']+'">');
                    $('#update_button').append('<input type="submit" class="btn btn-success btn-xs" value="Show">');
                }
            },
            error: function(data){

            },
            timeout: 10000
        });
    }else{

        /*---Form Data Reset---*/
    }
});