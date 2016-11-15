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
                $(e).closest('form').removeClass('delete').removeClass('change_status').addClass('edit');
                break;
            case "Delete":
                action = 'delete-plan';
                $(e).closest('form').removeClass('edit').removeClass('change_status').addClass('delete');
                break;
        }
        $(e).closest('form').attr('action', action);
    }

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


    //$('#tblLoading').ajaxStart(function() { $(this).show(); });
    //$('#tblLoading').ajaxComplete(function() { $(this).hide(); });

