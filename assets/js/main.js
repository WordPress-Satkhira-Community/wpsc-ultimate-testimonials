(function($) {

if ( $('.wps_testimonials').length > 0 ) {
	jQuery.map($('.wps_testimonials'), function(item, index){
		var settings = $(item).find('.wps_testimonial-wrap').data('setting');
		var element = $(item).find('.wps_testimonial-wrap .swiper')[0];
		var nextEl = $(item).find('.wps_testimonial-wrap .swiper-button-next')[0];
		var prevEl = $(item).find('.wps_testimonial-wrap .swiper-button-prev')[0];
		var elPagination = $(item).find('.wps_testimonial-wrap .swiper-pagination')[0];

		var slider = new Swiper(element, {
			slidesPerView: settings['slides_per_view'],
			spaceBetween: 10,	
			lazy: true,
			loop: settings['loop'] == 'yes' ? true : false,
			autoplay: {
				enabled: settings['speed'] == 'yes' ? true : false,
				delay: ( settings['speed'] == 'yes' && settings['autoplay_speed'] != '' ) ? settings['autoplay_speed'] : 500,
				pauseOnMouseEnter: settings['pause_on_hover'] == 'yes' ? true : false,
				disableOnInteraction: settings['pause_on_interaction'] == 'yes' ? true : false,
			},
			speed: settings['speed'],
			navigation: {
				nextEl: nextEl,
				prevEl: prevEl,
			},	
			pagination: {
				el: elPagination,
				clickable: true,
				type: settings['pagination'],
			},
			breakpoints: {
				640: {
				  slidesPerView: settings['slides_per_view'],
				  spaceBetween: 30,
				},
				1024: {
				  slidesPerView: settings['slides_per_view'],
				  spaceBetween: 30,
				},	
			}
		});

	});
}

})(jQuery);