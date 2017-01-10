/* jshint devel:true */

/* Email validation */
function valid_email_address(email) {
    var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
    return pattern.test(email);
}

jQuery(document).ready(function() {
    "use strict";
    if ($('#countdown')[0]) {
      $('#countdown').countDown({
               targetDate: {
                   'day':    25,
                   'month':  6,
                   'year':   2015,
                   'hour':   11,
                   'min':    13,
                   'sec':    0
               },
               omitWeeks: true
           });   
    }
   
    // page content change
    jQuery('.mainnav li a').click(function(event) {
        jQuery('.mainnav li a').removeClass('active');
        jQuery(this).addClass("active");
        event.preventDefault();
        var traget = jQuery(this).attr('href');

        // animation list
        var animList = ['slideInUp'];
        var randomAnimIndex = Math.floor(Math.random()*animList.length);
        var randomAnimName = animList[randomAnimIndex];
        
        jQuery('.page-content').removeClass("active");
        jQuery(traget).addClass("active");

        //add effect
        jQuery(traget).addClass("animated "+animList[randomAnimIndex]);
        setTimeout(function(){
            jQuery(traget).removeClass('animated '+animList[randomAnimIndex]);
        },1500);

    });
    // Contact Form Validation
    jQuery('#contactform').submit(function(event) {
        if (!valid_email_address(jQuery('#contact-email').val()) || jQuery('#contact-name').val().length <= 2) {
            jQuery('#contactform').addClass('animated shake');
            setTimeout(function(){jQuery('#contactform').removeClass('animated shake');},1500);
            if (!valid_email_address(jQuery('#contact-email').val())) {
                jQuery('#contact-email').addClass('error');
            }
            if (jQuery('#contact-name').val().length <= 2) {
                jQuery('#contact-name').addClass('error');
            }
        } else {
            var formdata = jQuery('#contactform').serializeArray();
            jQuery.ajax({
                url: 'php/contact.php',
                type: 'POST',
                async: true,
                data: formdata,
                success: function(data) {
                    jQuery('#contact-result').html(data);
                }
            });
        }
        jQuery('#contact-email, #contact-name').focus(function() {
            jQuery('#contact-email, #contact-name').removeClass('error');
        });
        event.preventDefault();
    });
    // Subscribe Page
    jQuery('#subscribeFrom').submit(function(event) {
    	if (!valid_email_address(jQuery('#subscribeEmail').val())) {
    		jQuery('#subscribeEmail').addClass('error');
    	} else {
    		var formdata = jQuery('#subscribeFrom').serializeArray();
    		jQuery.ajax({
    			url:'php/subscribe.php',
    			data:formdata,
                async: true,
    			type:"POST",
    			success:function(data){
    				jQuery('#subscribeMsg').html(data);
    			}
    		});
    	}
    	jQuery('#subscribeEmail').focus(function(){
    		jQuery(this).removeClass('error');
    	});
        event.preventDefault();
    });
    // loader 
    jQuery(window).load(function(){
        jQuery('.page_overlay').addClass('animated fadeOut');
        setTimeout(function(){
            jQuery('.page_overlay').hide();
        },500);
    });
});