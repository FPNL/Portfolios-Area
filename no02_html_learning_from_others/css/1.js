$(document).ready(function() {


$('#bar_btn').on('click', function(event) {
	event.preventDefault();
	
	$('#mobile_nav_ul_bar').slideToggle("fast");
});


});