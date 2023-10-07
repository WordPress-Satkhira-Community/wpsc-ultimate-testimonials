<?php

use \Elementor\Controls_Manager;

class WPSC_Ultimate_Testimonials_Widget extends \Elementor\Widget_Base {

	public function get_name(){
		return 'wpsc_ultimate_testimonials';
	}


	public function get_title(){
		return esc_html__( 'Ultimate Testimonials', 'wpsc-ultimate-testimonials' );
	}


	public function get_icon(){
		return 'eicon-review';
	}


	public function get_custom_help_url() {
		return 'https://docs.wpsatkhira.com/plugins/wpsc-ultimate-testimonials';
	}


	public function get_categories() {
		return [ 'basic', 'wpsc-plugins' ];
	}


	public function get_keywords() {
		return [ 'testimonial', 'carousel', 'reviews', 'rating' ];
	}


	public function get_script_depends() {
		return [ 'swiper' ];
	}


	public function get_style_depends() {
		return [ 'swiper' ];
	}

	public function get_testimonials() {
		$eTestimonials = [];
		$testimonials = get_posts([
			'post_type' => 'wps-testimonials'			
		]);

		foreach ($testimonials as $item) {
			$eTestimonials[$item->ID] = $item->post_title;
		}

		return $eTestimonials;
	}

	protected function register_controls() {
		parent::register_controls();

		// CONTENT TAB

		// Layout Section
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Layout', 'wpsc-ultimate-testimonials' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'skin',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__( 'Skin', 'wpsc-ultimate-testimonials' ),
				'options' => [
					'light' => esc_html__( 'Light', 'wpsc-ultimate-testimonials' ),
					'dark' => esc_html__( 'Dark', 'wpsc-ultimate-testimonials' ),
				],
				'default' => 'light',
			]
		);

		$this->add_control(
			'layout',
			[
				'label' => esc_html__( 'Layout', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'image_inline',
				'options' => [
					'image_inline' => esc_html__( 'Image Inline', 'wpsc-ultimate-testimonials' ),
					'image_stacked' => esc_html__( 'Image Stacked', 'wpsc-ultimate-testimonials' ),
					'image_above' => esc_html__( 'Image Above', 'wpsc-ultimate-testimonials' ),
					'image_left' => esc_html__( 'Image Left', 'wpsc-ultimate-testimonials' ),
					'image_right' => esc_html__( 'Image Right', 'wpsc-ultimate-testimonials' ),
				],
				'prefix_class' => 'elementor-testimonial--layout-',
				'render_type' => 'template',
			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label' => esc_html__( 'Alignment', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'wpsc-ultimate-testimonials' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'wpsc-ultimate-testimonials' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'wpsc-ultimate-testimonials' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'prefix_class' => 'elementor-testimonial-%s-align-',
			]
		);

		$slides_per_view = range( 1, 10 );
		$slides_per_view = array_combine( $slides_per_view, $slides_per_view );

		$this->add_responsive_control(
			'slides_per_view',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__( 'Slides Per View', 'wpsc-ultimate-testimonials' ),
				'options' => [ '' => esc_html__( 'Default', 'wpsc-ultimate-testimonials' ) ] + $slides_per_view,
				'inherit_placeholders' => false,
				'frontend_available' => true,			
			]
		);

		$this->add_responsive_control(
			'slides_to_scroll',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__( 'Slides to Scroll', 'wpsc-ultimate-testimonials' ),
				'description' => esc_html__( 'Set how many slides are scrolled per swipe.', 'wpsc-ultimate-testimonials' ),
				'options' => [ '' => esc_html__( 'Default', 'wpsc-ultimate-testimonials' ) ] + $slides_per_view,
				'inherit_placeholders' => false,
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Width', 'wpsc-ultimate-testimonials' ),
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1140,
					],
					'%' => [
						'min' => 50,
					],
				],
				'default' => [
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-main-swiper' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Query Section
		$this->start_controls_section(
			'query_section',
			[
				'label' => esc_html__( 'Query', 'wpsc-ultimate-testimonials' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'source',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__( 'Source', 'wpsc-ultimate-testimonials' ),
				'options' => [
					'post_type' => esc_html__( 'Testimonials', 'wpsc-ultimate-testimonials' ),
					'manual' => esc_html__( 'Manual Create', 'wpsc-ultimate-testimonials' ),
				],
				'default' => 'elementor',
			]
		);


		$this->add_control(
			'testimonials_list',
			[
				'label' => esc_html__( 'Testimonial', 'wpsc-ultimate-testimonials' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => [
					[	
						'name' => 'review-image',
						'label' => esc_html__( 'Choose Image', 'wpsc-ultimate-testimonials' ),
						'type' => \Elementor\Controls_Manager::MEDIA,
						'default' => [
							'url' => \Elementor\Utils::get_placeholder_image_src(),
						],
					],
					[
						'name' => 'name',
						'label' => esc_html__( 'Name', 'wpsc-ultimate-testimonials' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => esc_html__( 'John Doe', 'wpsc-ultimate-testimonials' ),
					],
					[
						'name' => 'review',
						'label' => esc_html__( 'Review', 'wpsc-ultimate-testimonials' ),
						'type' => \Elementor\Controls_Manager::WYSIWYG,
						'placeholder' => esc_html__( 'Write Review', 'wpsc-ultimate-testimonials' ),
					],
					[
						'name' => 'designation',
						'label' => esc_html__( 'Designation', 'wpsc-ultimate-testimonials' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => esc_html__( 'CEO', 'wpsc-ultimate-testimonials' ),
					],					
					[
						'name' => 'rating',
						'label' => esc_html__( 'Rating', 'wpsc-ultimate-testimonials' ),
						'type' => \Elementor\Controls_Manager::NUMBER,
						'min' => 1,
						'max' => 5,
						'step' => 0.5,
						'default' => 5,
					]

				],
				'default' => [
					[
						'text' => esc_html__( 'List Item #1', 'wpsc-ultimate-testimonials' ),
					],
					[
						'text' => esc_html__( 'List Item #2', 'wpsc-ultimate-testimonials' ),
					],
				],
				'title_field' => '{{{ name }}}',
				'condition' => [
					'source' => 'manual',
				],
			]
		);

		$this->add_control(
			'testimonials_posttype_list',
			[
				'label' => esc_html__( 'Testimonials', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => $this->get_testimonials(),
				'condition' => [
					'source' => 'post_type',
				]
			],
		);

		$this->end_controls_section();

		// Pagination Section
		$this->start_controls_section(
			'pagination_section',
			[
				'label' => esc_html__( 'Settings', 'wpsc-ultimate-testimonials' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_arrows',
			[
				'type' => Controls_Manager::SWITCHER,
				'label' => esc_html__( 'Arrows', 'wpsc-ultimate-testimonials' ),
				'default' => 'yes',
				'label_off' => esc_html__( 'Hide', 'wpsc-ultimate-testimonials' ),
				'label_on' => esc_html__( 'Show', 'wpsc-ultimate-testimonials' ),
				'prefix_class' => 'elementor-arrows-',
				'render_type' => 'template',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'pagination',
			[
				'label' => esc_html__( 'Pagination', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'bullets',
				'options' => [
					'' => esc_html__( 'None', 'wpsc-ultimate-testimonials' ),
					'bullets' => esc_html__( 'Dots', 'wpsc-ultimate-testimonials' ),
					'fraction' => esc_html__( 'Fraction', 'wpsc-ultimate-testimonials' ),
					'progressbar' => esc_html__( 'Progress', 'wpsc-ultimate-testimonials' ),
				],
				'prefix_class' => 'elementor-pagination-type-',
				'render_type' => 'template',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'speed',
			[
				'label' => esc_html__( 'Transition Duration', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 500,
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => esc_html__( 'Autoplay', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before',
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label' => esc_html__( 'Autoplay Speed', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 5000,
				'condition' => [
					'autoplay' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'loop',
			[
				'label' => esc_html__( 'Infinite Loop', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label' => esc_html__( 'Pause on Hover', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'autoplay' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'pause_on_interaction',
			[
				'label' => esc_html__( 'Pause on Interaction', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'autoplay' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$this->end_controls_section();
		// END CONTENT TAB


		// STYLE TAB
		$this->start_controls_section(
			'section_skin_style',
			[
				'label' => esc_html__( 'Slides', 'wpsc-ultimate-testimonials' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'background_color',
			[
				'label' => esc_html__( 'Background Color', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::COLOR,
				'alpha' => false,
				'selectors' => [
					'{{WRAPPER}} .elementor-testimonial__content, {{WRAPPER}} .elementor-testimonial__content:after' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
		// END STYLE TAB

	}


	protected function render(){
		$settings = $this->get_settings_for_display();

		$slider_settings = [
			'arrow' => $settings['show_arrows'] ?? '',
			'pagination' => $settings['pagination'] ?? '',
			'speed' => $settings['speed'] ?? '',
			'autoplay' => $settings['autoplay'] ?? '',
			'autoplay_speed' => $settings['autoplay_speed'] ?? '',
			'loop' => $settings['loop'] ?? '',
			'pause_on_hover' => $settings['pause_on_hover'] ?? '',
			'pause_on_interaction' => $settings['pause_on_interaction'] ?? '',
			'slides_per_view' => $settings['slides_per_view'] ?? 3,
			'slides_to_scroll' => $settings['slides_to_scroll'] ?? 3,
		];

		if ( $settings['source'] == 'post_type' ) {
			$testimonials = WPSC_Ultimate_Testimonials::get_data();
		} elseif ( $settings['source'] == 'manual' ) {
			$testimonials = $settings['testimonials_list'];
		}
?>


<div class="wps_testimonials">
	<?php if ( empty($settings['testimonials_list']) ): ?>
		<h3>No Reviews Available!</h3>
	<?php else:
	 ?>
		 <div class="wps_testimonial-wrap" data-setting='<?= json_encode($slider_settings); ?>'>
			<div class="swiper">
				<div class="swiper-wrapper">
					<?php foreach ($testimonials as $testimonial): 
						$author = $testimonial['name'] ?? '';
						$content = $testimonial['review'] ?? '';
						$position = $testimonial['designation'] ?? '';
						$rating = !empty($testimonial['rating']) ? $testimonial['rating']: 5;
						$thumbnail_url = !empty($testimonial['review-image']) ? $testimonial['review-image']['url'] : '';

					?>
				    <div class="swiper-slide wps_testimonial">
				    	<div class="wps_wrapper">
				    		<div class="wps_reviews">
				    			<?php echo $this->reviews($rating); ?>
				    		</div>
				    		<div class="wps_content">
				    			<?= $content; ?>
				    		</div>
				    		<div class="wps_author">
				    			<div class="wps_author_pic">
				    				 <!-- Display the post thumbnail here -->
									 <img src="<?php echo $thumbnail_url; ?>" alt="<?php echo $author; ?>'s Thumbnail">
				    			</div>
				    			<div class="wps_author_bio">
				    				<h3><?= $author; ?></h3>
				    				<p><?= $position; ?></p>
				    			</div>
				    		</div>
				    	</div>
				    </div>		  		
					<?php endforeach; ?>	    
				</div>
				<?php if ( $slider_settings['pagination'] != '' ): ?>
					<div class="swiper-pagination"></div>
				<?php endif ?>				
			</div>	
			
			<?php if ( $slider_settings['arrow'] == 'yes' ): ?>
				<div class="swiper-button-prev"></div>
				<div class="swiper-button-next"></div>				
			<?php endif ?>			
		</div>
	<?php endif ?>

</div>

<?php 
	}

	public function reviews( $reviews ) {
	    return '<div class="black-star"><svg width="120px" height="100%" viewBox="0 0 881 130" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
	            <g transform="matrix(1,0,0,1,-634.728,-382.568)">
	                <path d="M702.68,382.568L718.721,431.938L770.632,431.938L728.635,462.45L744.677,511.82L702.68,481.308L660.683,511.82L676.724,462.45L634.728,431.938L686.639,431.938L702.68,382.568Z" style="fill:rgb(255, 255, 255);"/>
	            </g>
	            <g transform="matrix(1,0,0,1,-447.914,-382.568)">
	                <path d="M702.68,382.568L718.721,431.938L770.632,431.938L728.635,462.45L744.677,511.82L702.68,481.308L660.683,511.82L676.724,462.45L634.728,431.938L686.639,431.938L702.68,382.568Z" style="fill:rgb(255, 255, 255);"/>
	            </g>
	            <g transform="matrix(1,0,0,1,-261.961,-382.568)">
	                <path d="M702.68,382.568L718.721,431.938L770.632,431.938L728.635,462.45L744.677,511.82L702.68,481.308L660.683,511.82L676.724,462.45L634.728,431.938L686.639,431.938L702.68,382.568Z" style="fill:rgb(255, 255, 255);"/>
	            </g>
	            <g transform="matrix(1,0,0,1,-76.0238,-382.568)">
	                <path d="M702.68,382.568L718.721,431.938L770.632,431.938L728.635,462.45L744.677,511.82L702.68,481.308L660.683,511.82L676.724,462.45L634.728,431.938L686.639,431.938L702.68,382.568Z" style="fill:rgb(255, 255, 255);"/>
	            </g>
	            <g transform="matrix(1,0,0,1,109.853,-382.568)">
	                <path d="M702.68,382.568L718.721,431.938L770.632,431.938L728.635,462.45L744.677,511.82L702.68,481.308L660.683,511.82L676.724,462.45L634.728,431.938L686.639,431.938L702.68,382.568Z" style="fill:rgb(255, 255, 255);"/>
	            </g>
	        </svg></div>
	        <div class="yellow-star" style="width: '. 24 * $reviews .'px;"><svg width="120px" height="100%" viewBox="0 0 881 130" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
	            <g transform="matrix(1,0,0,1,-634.728,-382.568)">
	                <path d="M702.68,382.568L718.721,431.938L770.632,431.938L728.635,462.45L744.677,511.82L702.68,481.308L660.683,511.82L676.724,462.45L634.728,431.938L686.639,431.938L702.68,382.568Z" style="fill:#FFC436;"/>
	            </g>
	            <g transform="matrix(1,0,0,1,-447.914,-382.568)">
	                <path d="M702.68,382.568L718.721,431.938L770.632,431.938L728.635,462.45L744.677,511.82L702.68,481.308L660.683,511.82L676.724,462.45L634.728,431.938L686.639,431.938L702.68,382.568Z" style="fill:#FFC436;"/>
	            </g>
	            <g transform="matrix(1,0,0,1,-261.961,-382.568)">
	                <path d="M702.68,382.568L718.721,431.938L770.632,431.938L728.635,462.45L744.677,511.82L702.68,481.308L660.683,511.82L676.724,462.45L634.728,431.938L686.639,431.938L702.68,382.568Z" style="fill:#FFC436;"/>
	            </g>
	            <g transform="matrix(1,0,0,1,-76.0238,-382.568)">
	                <path d="M702.68,382.568L718.721,431.938L770.632,431.938L728.635,462.45L744.677,511.82L702.68,481.308L660.683,511.82L676.724,462.45L634.728,431.938L686.639,431.938L702.68,382.568Z" style="fill:#FFC436;"/>
	            </g>
	            <g transform="matrix(1,0,0,1,109.853,-382.568)">
	                <path d="M702.68,382.568L718.721,431.938L770.632,431.938L728.635,462.45L744.677,511.82L702.68,481.308L660.683,511.82L676.724,462.45L634.728,431.938L686.639,431.938L702.68,382.568Z" style="fill:#FFC436;"/>
	            </g>
	        </svg></div>
	        ';
	} 
}