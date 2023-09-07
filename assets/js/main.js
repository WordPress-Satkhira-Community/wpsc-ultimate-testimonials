(function($) {

let wps_data = wps_settings_data; //from wp_localize_script

let desktopCol = (wps_data.desktop_col != "default") && (wps_data.desktop_col != undefined) && (wps_data.desktop_col != null) ? wps_data.desktop_col : 3;
let tabletCol = (wps_data.tablet_col != "default") && (wps_data.tablet_col != undefined) && (wps_data.tablet_col != null) ? wps_data.tablet_col : 2;
let mobileCol = (wps_data.mobile_col != "default") && (wps_data.mobile_col != undefined) && (wps_data.mobile_col != null) ? wps_data.mobile_col : 1;


const testimonial = new Swiper('#wps_testimonials .swiper', {
	slidesPerView: mobileCol,
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
		  slidesPerView: tabletCol,
		  spaceBetween: 30,
		},
		1024: {
		  slidesPerView: desktopCol,
		  spaceBetween: 30,
		},	
	}
});

})(jQuery);