$(window).load(function(){
	$('.slider').fractionSlider({
		'fullWidth' : true,
		'controls' : true,
		'pager' : true,
		'responsive' : true,
		'dimensions' : "1000,400",
		'increase' : false,
		'pauseOnHover' : true,
		'slideEndAnimation' : true
	});
	//initSlider();
	onTemplateMenuLoad();
});


function onTemplateMenuLoad(){
	console.log("onTemplateMenuLoad Clicked");
}