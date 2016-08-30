$(document).on('click','#update_status',function() {
    if($(this).data("id") != '') {
        var plan_id = $(this).data('id')
        var status = $(this).data('status')
        var json_data = {plan_id:plan_id, status:status}
        $.ajax({
            async: true,
            type: 'POST',
            data: JSON.stringify(json_data),
            dataType: "json", // or html if you want...
            contentType: false, // high importance!
            url: '/super-admin/view-plan/ajax/update', // you need change it.
            processData: false, // high importance!
            success: function (data) {
                $('#update_button'+data['plan_id'].replace(':','_')+'').html('');
                if(data['id']==1)
                {
                    $('#update_button'+data['plan_id'].replace(':','_')+'').append('<input type="submit" class="btn btn-warning btn-xs" data-status="0" id="update_status" data-id="'+data['plan_id']+'" value="Hide">');
                }
                else
                {
                    $('#update_button'+data['plan_id'].replace(':','_')+'').append('<input type="submit" class="btn btn-success btn-xs" data-status="1" id="update_status" data-id="'+data['plan_id']+'" value="Show">');
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