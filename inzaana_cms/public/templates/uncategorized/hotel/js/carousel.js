// $(function() {
	
// /* Demo Scripts for Bootstrap Carousel and Animate.css */

// (function( $ ) {

// 	//Function to animate slider captions 
// 	function doAnimations( elems ) {
// 		//Cache the animationend event in a variable
// 		var animEndEv = 'webkitAnimationEnd animationend';
		
// 		elems.each(function () {
// 			var $this = $(this),
// 				$animationType = $this.data('animation');
// 			   $this.addClass($animationType).one(animEndEv, function () {
// 				$this.removeClass($animationType);
// 			});
// 		});
// 	}
	
// 	//Variables on page load 
// 	var $myCarousel = $('#main-slider'),
// 		$firstAnimatingElems = $myCarousel.find('.item:first').find("[data-animation ^= 'animated']");
		
// 	//Initialize carousel 
// 	$myCarousel.carousel();
	
// 	//Animate captions in first slide on page load 
// 	doAnimations($firstAnimatingElems);
	
// 	//Pause carousel  
// 	$myCarousel.carousel('pause');
	
	
// 	//Other slides to be animated on carousel slide event 
// 	$myCarousel.on('slide.bs.carousel', function (e) {
// 		var $animatingElems = $(e.relatedTarget).find("[data-animation ^= 'animated']");
// 		doAnimations($animatingElems);
// 	});  
	
// })(jQuery);	
	
// /* Accordion Js */
// 	$('.collapse').on('shown.bs.collapse', function() {$(this).parent().find(".fa-chevron-circle-right").removeClass("fa-chevron-circle-right").addClass("fa-chevron-circle-down");}).on('hidden.bs.collapse', function(){$(this).parent().find(".fa-chevron-circle-down").removeClass("fa-chevron-down").addClass("fa-chevron-circle-right");});
		
// });	
		
		
		
		
		
		
		
	
		
		
// 		