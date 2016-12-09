
var auth = {
  logout: function() {
        window.location.href = '/logout';
  },
  check: function() {
      // new hotness
      (function loopsiloop(){
         setTimeout(function(){
             $.ajax({
                 url: '/who-am-i',
                 success: function( response ){
                     // do something with the response
                    if(response)
                    {
                        loopsiloop(); // recurse
                    } 
                    else                     
                      auth.logout();
                 },
                 error: function(){
                    auth.logout();
                 }
             });
         }, 5000);
      })();
  }
}

$(document).ready(function () {
    auth.check();
});

$( window ).unload(function() {
    // alert("Handler for .unload() called.");
});