$(document).ready(function () {
    $(document).on('click','#click_by_sort', function (e) {
        e.preventDefault();
        var sort = $(this).attr('data-sort');
        var order = $(this).attr('data-order');
        /*var setorder = (order == 'ASC')? 'DESC' : 'ASC';
        $(this).removeAttr('data-order').attr('data-order',setorder);*/
        var url = window.location.pathname;
        $.ajax({
            async: true,
            type: 'GET',
            url: url+'?sort='+sort+'&order='+order, // you need change it.
            processData: false, // high importance!
            success: function (data) {
                $('#subscribe_dom').html(data);
            },
            error: function(data){

            },
            timeout: 10000
        });

    });

    $(document).on('submit','#email_notification',function(e){
        e.preventDefault();
        var formData = $('#email_notification').serialize();
        $.ajax({
            async: true,
            type: 'POST',
            data: formData,
            url: '/super-admin/email-notification', // you need change it.
            processData: false, // high importance!
            success: function (data) {
            },
            error: function(data){

            },
            timeout: 10000
        });
    });

});