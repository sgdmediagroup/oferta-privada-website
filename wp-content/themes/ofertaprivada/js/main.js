function topFunction() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}

jQuery(".btns-planes .btn").click(function() {
    jQuery('.btns-planes .btn').toggleClass('btn-default')
	jQuery('.plan').toggleClass('anual')
});

jQuery("#toggle-menu").click(function() {
    jQuery('#nav-mobile').toggleClass('d-none');
    jQuery('#nav-mobile').toggleClass('d-block');
});

jQuery("#nav-mobile a").click(function() {
    jQuery('#nav-mobile').removeClass('d-none')
    jQuery('#nav-mobile').addClass('d-block')
});


jQuery(".active-contacto").click(function() {
    jQuery('#contacto').removeClass('d-none');
    jQuery('html, body').animate({
        scrollTop: jQuery("#contacto").offset().top
    }, 1000);
});

jQuery(function () {
  jQuery('[data-toggle="tooltip"]').tooltip();
})

jQuery(".contact-plan").click(function() {
	var option = jQuery(this).data("plan");
    jQuery('#contacto').removeClass('d-none');
    jQuery('select#plan').val(option);
    jQuery('html, body').animate({
        scrollTop: jQuery("#contacto").offset().top
    }, 1000);
});

jQuery(".toggle-element").click(function() {
	var element = jQuery(this).data("toggle-element");
	var clase = jQuery(this).data("toggle-class");
    jQuery(element).toggleClass(clase);
});

jQuery( document ).ready(function() {
	jQuery('.menu a').css("cursor","pointer");
});

jQuery(".active-lightbox").click(function() {
	var lightbox = jQuery(this).data("lightbox");
	jQuery('.video-'+lightbox).toggleClass('d-none');
	jQuery('.video-'+lightbox+' iframe')[0].src += "&autoplay=1";
	console.log('.video-'+lightbox);
});
jQuery("#lightbox-video button").click(function() {
	jQuery('#lightbox-video').toggleClass('d-none');
});