$(document).on('ready', function() {
	
	// Transform every single <select> into the select2 plugin
	$('select').select2();

	// Add datepicker
	$('.datepicker').datepicker({ format: "yyyy-mm-dd" });
});