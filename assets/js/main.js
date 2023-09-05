(function($) {

const testimonial = new Swiper('#wps_testimonials .swiper', {
	slidesPerView: 1,
	spaceBetween: 10,	
	lazy: true,
	navigation: {
		nextEl: ".swiper-button-next",
		prevEl: ".swiper-button-prev",
	},	
	pagination: {
		el: ".swiper-pagination",
		clickable: true,
	},
	breakpoints: {
		640: {
		  slidesPerView: 2,
		  spaceBetween: 30,
		},
		1024: {
		  slidesPerView: 3,
		  spaceBetween: 30,
		},	
	}
});

})(jQuery);