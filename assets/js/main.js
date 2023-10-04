(function($) {

let wps_data = wps_settings_data; //From Settings

let desktopCol = (wps_data.desktop_col != "default") && (wps_data.desktop_col != undefined) && (wps_data.desktop_col != null) ? wps_data.desktop_col : 3;
let tabletCol = (wps_data.tablet_col != "default") && (wps_data.tablet_col != undefined) && (wps_data.tablet_col != null) ? wps_data.tablet_col : 2;
let mobileCol = (wps_data.mobile_col != "default") && (wps_data.mobile_col != undefined) && (wps_data.mobile_col != null) ? wps_data.mobile_col : 1;
let autoPlay = (wps_data.auto_play != false) && (wps_data.auto_play != undefined) && (wps_data.auto_play != null) ? true : false;
let autopDelay = (wps_data.autoplay_speed != undefined) && (wps_data.autoplay_speed != null) ? wps_data.autoplay_speed : 5000;
let slideDuration = (wps_data.slide_duration != undefined) && (wps_data.slide_duration != null) ? wps_data.slide_duration : 500;


const testimonial = new Swiper('#wps_testimonials .swiper', {
	slidesPerView: mobileCol,
	spaceBetween: 10,	
	lazy: true,
	autoplay: {
		enabled: autoPlay,
		delay: autopDelay
	},
	speed: slideDuration,
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