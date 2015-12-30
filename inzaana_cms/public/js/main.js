

if (document.getElementById('t1').checked) {
 		 rate_value = '/inzaanahomepage'
		//document.getElementById('t1').value;
}

else if (document.getElementById('t2').checked) {
  		rate_value = '/inzaana';
	//document.getElementById('t2').value;
}
	


function myFunction() {
	//var rate_value='';
     //window.location = '/player_detail?username=' + name;

	 alert(rate_value);
	 
	 window.location = rate_value;
}