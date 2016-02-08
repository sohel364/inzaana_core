
$(function(){

    function createXHR()
    {
        try { return new XMLHttpRequest(); } catch(e) { alert(e);}
        try { return new ActiveXObject("Msxml2.XMLHTTP.6.0"); } catch (e) {alert(e);}
        try { return new ActiveXObject("Msxml2.XMLHTTP.3.0"); } catch (e) {alert(e);}
        try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch (e) {alert(e);}
        try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch (e) {alert(e);}

        return null;
    }

    function searchProducts(terms)
    {
        var xhr = createXHR();
        if (xhr)
        {
            var url = "/products/search/" + terms;
            var payload = "search_terms=" + search_terms;
            xhr.open("POST", url, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded ');
            xhr.setRequestHeader("Content-length", payload.length);
            xhr.setRequestHeader("Connection", "close");
            xhr.onreadystatechange = function()
            {
                onSuccess(xhr);
            };
            xhr.send(payload);
        }
    }  

    function onSuccess(xhr)
    {
        if (xhr.readyState == 4  && xhr.status == 200)
        {
            //
        }
    }

    /*
     * Product form events
     */
    $('#search-box').change(function(e) {
        
        //perform AJAX call

        alert($('search-box').text());
    });

    $('#product-search-btn').click(function(e) {
      
      //perform AJAX call

      alert('wkjeglkj');
    });

    ///
    $('#your-form').submit(e)
    {
        var $form = $(this);
        e.preventDefault(); //keeps the form from behaving like a normal (non-ajax) html form
        var url = $form.attr('action');
        var formData = {};
        //submit a POST request with the form data
        $form.find('input').each(function()
        {
            formData[ $(this).attr('name') ] = $(this).val();
        });

        //submits an array of key-value pairs to the form's action URL
        $.post(url, formData, function(response)
        {
            //handle successful validation
        }).fail(function(response)
        {
            //handle failed validation
            associate_errors(response['errors'], $form);
        });
    }

    function associate_errors(errors, $form)
    {
        //remove existing error classes and error messages from form groups
        $form.find('.form-group').removeClass('has-errors').find('.help-text').text('');
        errors.foreach(function(value, index)
        {
           //find each form group, which is given a unique id based on the form field's name
            var $group = $form.find('#' + index + '-group');

            //add the error class and set the error text
            $group.addClass('has-errors').find('.help-text').text(value);
        }
    }
    ////
});