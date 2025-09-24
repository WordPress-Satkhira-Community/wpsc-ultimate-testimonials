(function($){
    /* store observers to avoid duplicates */
    var observers = new WeakMap();

    function debounce(fn, wait) {
        var timer;
        return function() {
            var ctx = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function() {
                fn.apply(ctx, args);
            }, wait || 150);
        };
    }

    /* Initialize single wrapper */
    function initSingle($wrap){
        if (!$wrap || !$wrap.length) return;
        var element = $wrap.find('.swiper')[0];
        if (!element) return;

        if (typeof Swiper === 'undefined') {
            console.warn('Swiper library is not loaded.');
            return;
        }

        /* destroy previous instance if exists */
        if (element.swiper) {
            try {
                element.swiper.destroy(true, true);
            } catch (e) {
                console.warn('Error destroying swiper:', e);
            }
        }

        var settings = $wrap.data('setting') || {};
        var nextEl = $wrap.find('.swiper-button-next')[0];
        var prevEl = $wrap.find('.swiper-button-prev')[0];
        var elPagination = $wrap.find('.swiper-pagination')[0];

        console.info('Initializing Swiper with settings:', settings);

        new Swiper(element, {
            slidesPerView: parseInt(settings.slides_per_view_mobile, 10) || 1,
            spaceBetween: parseInt(settings.space_between_mobile, 10) || 10,
            lazy: true,
            loop: settings.loop === 'yes',
            autoplay: settings.autoplay === 'yes' ? {
                delay: parseInt(settings.autoplay_speed, 10) || 5000,
                pauseOnMouseEnter: settings.pause_on_hover === 'yes',
                disableOnInteraction: settings.pause_on_interaction === 'yes'
            } : false,
            speed: parseInt(settings.speed, 10) || 400,
            navigation: { nextEl: nextEl || null, prevEl: prevEl || null },
            pagination: elPagination ? { el: elPagination, clickable: true, type: settings.pagination || 'bullets' } : {},
            observer: true,
            observeParents: true,
            breakpoints: {
                640: {
                    slidesPerView: parseInt(settings.slides_per_view_tablet, 10) || 1,
                    spaceBetween: parseInt(settings.space_between_tablet, 10) || 20,
                },
                1024: {
                    slidesPerView: parseInt(settings.slides_per_view, 10) || 1,
                    spaceBetween: parseInt(settings.space_between_desktop, 10) || 30,
                },
            }
        });
    }

    /* Observe changes to wrapper (data-setting attribute or children) */
    function observeWrap($wrap){
        var node = $wrap.get(0);
        if (!node) return;

        if (observers.has(node)) return;

        var onChange = debounce(function(muts){
            console.info('wpscut: change detected, reinitializing swiper for', node);
            initSingle($wrap);
        }, 180);

        var mo = new MutationObserver(function(mutations){
            var shouldTrigger = mutations.some(function(m){
                if (m.type === 'attributes' && m.attributeName === 'data-setting') return true;
                if (m.type === 'childList') return true;
                return false;
            });
            if (shouldTrigger) onChange(mutations);
        });

        mo.observe(node, {
            attributes: true,
            attributeFilter: ['data-setting'],
            childList: true,
            subtree: false
        });

        observers.set(node, mo);
    }

    /* Main initializer */
    function initTestimonials($scope){
        $scope = $($scope || document);
        $scope.find('.wpscut_testimonial-wrap').each(function(_, wrap){
            var $wrap = $(wrap);
            initSingle($wrap);
            observeWrap($wrap);
        });
    }

    /* Run on normal pages */
    $(document).ready(function() {
        initTestimonials($('body'));
    });

    /* Elementor frontend + editor hooks */
    $(window).on('elementor/frontend/init', function() {
        if (typeof elementorFrontend !== 'undefined') {
            elementorFrontend.hooks.addAction(
                'frontend/element_ready/wpsc_ultimate_testimonials.default',
                initTestimonials
            );
        }

        /* Elementor: listen for setting changes as fallback */
        if (typeof elementor !== 'undefined' && elementor.channels && elementor.channels.editor) {
            elementor.channels.editor.on('change', function(panel, view) {
                try {
                    if (view && view.$el && view.$el.find('.wpscut_testimonial-wrap').length) {
                        initTestimonials(view.$el);
                    }
                } catch (e) {
                    /* swallow */
                }
            });
        }
    });

})(jQuery);
