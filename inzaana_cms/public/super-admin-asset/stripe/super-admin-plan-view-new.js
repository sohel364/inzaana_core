/**
 * Created by sk on 11/6/2016.
 */

    function setFormActionOnChange(e)
    {
        var value = $('option:selected', e).text();
        var plan_id = $('option:selected', e).val();
        var action = 'view-plan/ajax/update';
        switch (value){
            case "Active":
            case "Inactive":
                action = 'view-plan/ajax/update';
                $(e).closest('form').removeClass('delete').removeClass('edit').addClass('change_status');
                break;
            case "Edit":
                action = 'edit-feature';
                $("#submit-"+plan_id).attr('data-target', "#myModals");
                $(e).closest('form').removeClass('delete').removeClass('change_status').addClass('edit');
                break;
            case "Delete":
                action = 'delete-plan';
                $(e).closest('form').removeClass('edit').removeClass('change_status').addClass('delete');
                break;
        }
        $(e).closest('form').attr('action', action);
    }

    $(document).on('submit','.edit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var id = $(this).attr('id');
        var url = $(this).attr('action');
        $.ajax({
            async: true,
            type: 'GET',
            data: formData,
            url: '/super-admin/'+url+'/'+id, // you need change it.
            processData: false, // high importance!
            success: function (data) {
                $('#modal_container').html(data);
                $('#myModal').modal('show');
            },
            error: function(data){

            },
            timeout: 10000
        });
    });

$( "#discount" ).live( "click", function (e) {
    var len = $( "#discount:checked" ).length;
    if(len){
        $('#discount_block').css('display','block');
    }else{
        $('#discount_block').css('display','none');
    }
});

    $('#modal_submit').live('click', function (e) {
        e.preventDefault();
        var formData = $('#plan_update').serialize();
        var url = $(this).attr('action');
        $.ajax({
            async: true,
            type: 'POST',
            data: formData,
            url: '/super-admin/edit-feature', // you need change it.
            processData: false, // high importance!
            success: function (data) {
                $('#myModal').modal('hide');
                $('#plan-area').html(data); // refresh dom
            },
            error: function(data){

            },
            timeout: 10000
        });


    });

$('#plan_edit_form').submit(function (e) {
    e.preventDefault();
    alert("here");
});

    $(document).on('submit','.delete', function (e) {
        e.preventDefault();
        var c = confirm("Are you sure want to delete this plan?");
        if(c)
        {
            var formData = $(this).serialize();
            var url = $(this).attr('action');
            $.ajax({
                async: true,
                type: 'POST',
                data: formData,
                url: '/super-admin/delete-plan', // you need change it.
                processData: false, // high importance!
                success: function (data) {
                    $('#plan-area').html(data);
                    //TODO: Refresh view
                },
                error: function(data){

                },
                timeout: 10000
            });
        }
    });

    $(document).on('submit','.change_status', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var url = $(this).attr('action');
        $.ajax({
            async: true,
            type: 'POST',
            data: formData,
            url: '/super-admin/'+url, // you need change it.
            processData: false, // high importance!
            success: function (data) {
                if(data['confirm'] == 1)
                {
                    $('#'+data['plan_id']).removeClass('label-warning').addClass('label-success');
                    $('#'+data['plan_id']).text('Active');
                }
                if(data['confirm'] == 0)
                {
                    $('#'+data['plan_id']).removeClass('label-success').addClass('label-warning');
                    $('#'+data['plan_id']).text('Inactive');
                }
            },
            error: function(data){

            },
            timeout: 10000
        });
    });

    $(document).on('click','#click_by_sort', function (e) {
        e.preventDefault();
        var sort = $(this).attr('data-sort');
        var order = $(this).attr('data-order');
        var url = window.location.pathname;
        $.ajax({
            async: true,
            type: 'GET',
            url: url+'?sort='+sort+'&order='+order, // you need change it.
            processData: false, // high importance!
            success: function (data) {
                $('#plan-area').html(data);
            },
            error: function(data){

            },
            timeout: 10000
        });

    });


    //$('#tblLoading').ajaxStart(function() { $(this).show(); });
    //$('#tblLoading').ajaxComplete(function() { $(this).hide(); });

