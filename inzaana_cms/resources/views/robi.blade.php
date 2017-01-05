<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
$(document).ready( function() {
    $("button").click( function() {
        var request = $.ajax({
        	url: "http://localhost:10001/caas/balance/query",
        	type: "POST",
        	dataType: "json",
            contentType: "application/json",
        	data: {
				"applicationId":"APP_002832",
				"password":"8f57d2e8de06e6f2d6ee5da6107d0a4f",
				"subscriberId":"tel: 8801879835935",
				"currency":"BDT",
				"accountId":"8801879835935",
				"paymentInstrumentName":"Mobile Account"
			},
        	success: function(result) {
            	$("#div1").html(result);
        	}
        });
        request.done(function( msg ) {
          $( "#log" ).html( msg );
        });
         
        request.fail(function( jqXHR, textStatus ) {
          alert( "Request failed: " + textStatus );
        });
    });
});
</script>
</head>
<body>

<div id="div1"><h2>Let jQuery AJAX Change This Text</h2></div>
<div id="log"><h2>Let jQuery AJAX Change This Log</h2></div>

<button>Get External Content</button>

</body>
</html>
