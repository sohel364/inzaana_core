
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
});