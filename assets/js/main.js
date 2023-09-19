(function($) {


function IsNumeric(input) {
	var RE = /^-{0,1}\d*\.{0,1}\d+$/;
	return (RE.test(input));
}


let wps_data = wps_settings_data; //From Settings
let short_data = wps_settings_shortcode; // From shortcode

let desktopCol = (wps_data.desktop_col != "default") && (wps_data.desktop_col != undefined) && (wps_data.desktop_col != null) ? wps_data.desktop_col : 3;
let tabletCol = (wps_data.tablet_col != "default") && (wps_data.tablet_col != undefined) && (wps_data.tablet_col != null) ? wps_data.tablet_col : 2;
let mobileCol = (wps_data.mobile_col != "default") && (wps_data.mobile_col != undefined) && (wps_data.mobile_col != null) ? wps_data.mobile_col : 1;
let autoPlay = (wps_data.auto_play != false) && (wps_data.auto_play != undefined) && (wps_data.auto_play != null) ? true : false;
let autopDelay = (wps_data.autoplay_speed != undefined) && (wps_data.autoplay_speed != null) ? wps_data.autoplay_speed : 5000;


desktopCol = (short_data.desktop_col != "default") && (IsNumeric(short_data.desktop_col)) && (short_data.desktop_col <= 7) ? short_data.desktop_col : desktopCol;
tabletCol = (short_data.tablet_col != "default") && (IsNumeric(short_data.tablet_col)) && (short_data.tablet_col <= 7) ? short_data.tablet_col : tabletCol;
mobileCol = (short_data.mobile_col != "default") && (IsNumeric(short_data.mobile_col)) && (short_data.mobile_col <= 3) ? short_data.mobile_col : mobileCol;
autoPlay = (short_data.auto_play != '') && (short_data.auto_play != undefined) && (short_data.auto_play != null) ? JSON.parse(short_data.auto_play) : autoPlay;
autopDelay = (short_data.autoplay_speed != '') && (IsNumeric(short_data.autoplay_speed)) ? short_data.autoplay_speed : autopDelay;



const testimonial = new Swiper('#wps_testimonials .swiper', {
	slidesPerView: mobileCol,
	spaceBetween: 10,	
	lazy: true,
	autoplay: {
		enabled: autoPlay,
		delay: autopDelay
	},
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