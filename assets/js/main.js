(function($) {

    if ($('.wpscut_testimonials').length && typeof Swiper !== 'undefined') {
        $('.wpscut_testimonials').each(function(_, item) {
            var $wrap = $(item).find('.wpscut_testimonial-wrap');
            var settings = $wrap.data('setting') || {};

            var element = $wrap.find('.swiper')[0];
            if (!element) return;

            var nextEl = $wrap.find('.swiper-button-next')[0];
            var prevEl = $wrap.find('.swiper-button-prev')[0];
            var elPagination = $wrap.find('.swiper-pagination')[0];

            new Swiper(element, {
                slidesPerView: parseInt(settings.slides_per_view_mobile, 10) || 1,
                spaceBetween: parseInt(settings.space_between_mobile, 10) || 10,
                lazy: true,
                loop: settings.loop === 'yes',
                autoplay: settings.autoplay === 'yes' ? {
                    delay: parseInt(settings.autoplay_speed, 10) || 500,
                    pauseOnMouseEnter: settings.pause_on_hover === 'yes',
                    disableOnInteraction: settings.pause_on_interaction === 'yes'
                } : false,
                speed: parseInt(settings.speed, 10) || 400,
                navigation: {
                    nextEl,
                    prevEl,
                },
                pagination: {
                    el: elPagination,
                    clickable: true,
                    type: settings.pagination || 'bullets',
                },
                breakpoints: {
                    640: {
                        slidesPerView: parseInt(settings.slides_per_view_tablet, 10) || 1,
                        spaceBetween: parseInt(settings.space_between_tablet, 10) || 30,
                    },
                    1024: {
                        slidesPerView: parseInt(settings.slides_per_view, 10) || 1,
                        spaceBetween: parseInt(settings.space_between_desktop, 10) || 30,
                    },
                }
            }); 
        });
    }
})(jQuery);
