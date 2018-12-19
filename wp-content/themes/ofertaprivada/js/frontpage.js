jQuery("a").click(function() {
	var rel = jQuery(this).prop('rel');
	if(rel) {
		jQuery('html, body').animate({
			scrollTop: jQuery("#"+rel).offset().top
		}, 1000);
	}
});