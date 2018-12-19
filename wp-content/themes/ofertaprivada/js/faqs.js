jQuery( document ).ready(function() {
	jQuery(".menu a").hover(function() {
		var rel = jQuery(this).prop('rel');
		jQuery(this).attr('href', '../#'+rel);
	});
});


 
jQuery('.filterinput').on('keyup', function() {
	var searchVal = jQuery(this).val();
	var filterItems = jQuery('[data-filter-item]');
	if ( searchVal != '' ) {
		filterItems.addClass('d-none');
		jQuery('[data-filter-item][data-filter-name*="' + searchVal.toLowerCase() + '"]').removeClass('d-none');
	} else {
		filterItems.removeClass('d-none');
	}
});
  