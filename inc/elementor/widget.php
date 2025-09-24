<?php

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;

class WPSCUT_Testimonials_Widget extends \Elementor\Widget_Base {

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
		return [ 'swiper', 'wpscut' ]; 
	}

	public function get_style_depends() {
		return [ 'swiper', 'wpscut' ];
	}

	public function get_testimonials() {
		$eTestimonials = [];
		$testimonials = get_posts([
			'post_type' => 'wpsc-testimonials'			
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
				'render_type' => 'ui',
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
				'render_type' => 'ui', 
			]
		);


		$slides_per_view = range( 1, 10 );
		$slides_per_view = array_combine( $slides_per_view, $slides_per_view );

		$this->add_responsive_control(
			'slides_per_view',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__( 'Slides Per View', 'wpsc-ultimate-testimonials' ),
				'options' => [ 3 => esc_html__( 'Default', 'wpsc-ultimate-testimonials' ) ] + $slides_per_view,
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
				'default' => 'no',
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

		/**
		 * -------------------------
		 * Slide Wrapper / Background
		 * -------------------------
		 */
		$this->start_controls_section(
			'section_slide_wrapper',
			[
				'label' => esc_html__( 'Slide Wrapper', 'wpsc-ultimate-testimonials' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'background_color',
			[
				'label' => esc_html__( 'Background Color', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpscut_wrapper' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * -------------------------
		 * Reviewer Image
		 * -------------------------
		 */
		$this->start_controls_section(
			'section_review_image',
			[
				'label' => esc_html__( 'Reviewer Image', 'wpsc-ultimate-testimonials' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'review_image_size',
			[
				'label' => esc_html__( 'Image Size', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => ['min' => 30, 'max' => 200],
					'%'  => ['min' => 10, 'max' => 100],
				],
				'default' => ['unit' => 'px', 'size' => 60],
				'selectors' => [
					'{{WRAPPER}} .wpscut_author_pic img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; object-fit: cover;',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * -------------------------
		 * Name
		 * -------------------------
		 */
		$this->start_controls_section(
			'section_name',
			[
				'label' => esc_html__( 'Name', 'wpsc-ultimate-testimonials' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'name_color',
			[
				'label' => esc_html__( 'Color', 'wpsc-ultimate-testimonials' ),
				'type'  => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpscut_author_bio h3' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'name_typography',
				'label'    => esc_html__( 'Typography', 'wpsc-ultimate-testimonials' ),
				'selector' => '{{WRAPPER}} .wpscut_author_bio h3',
			]
		);

		$this->end_controls_section();

		/**
		 * -------------------------
		 * Designation
		 * -------------------------
		 */
		$this->start_controls_section(
			'section_designation',
			[
				'label' => esc_html__( 'Designation', 'wpsc-ultimate-testimonials' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'designation_color',
			[
				'label' => esc_html__( 'Color', 'wpsc-ultimate-testimonials' ),
				'type'  => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpscut_author_bio p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'designation_typography',
				'label'    => esc_html__( 'Typography', 'wpsc-ultimate-testimonials' ),
				'selector' => '{{WRAPPER}} .wpscut_author_bio p',
			]
		);

		$this->end_controls_section();

		/**
		 * -------------------------
		 * Review Text
		 * -------------------------
		 */
		$this->start_controls_section(
			'section_review_text',
			[
				'label' => esc_html__( 'Review Text', 'wpsc-ultimate-testimonials' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'review_color',
			[
				'label' => esc_html__( 'Color', 'wpsc-ultimate-testimonials' ),
				'type'  => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpscut_content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'review_typography',
				'label'    => esc_html__( 'Typography', 'wpsc-ultimate-testimonials' ),
				'selector' => '{{WRAPPER}} .wpscut_content',
			]
		);

		$this->end_controls_section();

		/**
		 * -------------------------
		 * Rating Stars
		 * -------------------------
		 */
		$this->start_controls_section(
			'section_rating_stars',
			[
				'label' => esc_html__( 'Rating Stars', 'wpsc-ultimate-testimonials' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'rating_color',
			[
				'label' => esc_html__( 'Color', 'wpsc-ultimate-testimonials' ),
				'type'  => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpscut_reviews .dashicons' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'rating_size',
			[
				'label' => esc_html__( 'Size', 'wpsc-ultimate-testimonials' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem'],
				'range' => ['px' => ['min' => 12, 'max' => 40]],
				'selectors' => [
					'{{WRAPPER}} .wpscut_reviews .dashicons' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rating_spacing',
			[
				'label' => esc_html__( 'Spacing', 'wpsc-ultimate-testimonials' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem'],
				'range' => ['px' => ['min' => 0, 'max' => 50]],
				'selectors' => [
					'{{WRAPPER}} .wpscut_reviews .dashicons' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_pagination_style',
			[
				'label' => esc_html__( 'Pagination', 'wpsc-ultimate-testimonials' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		/**
		* -------------------------
		* Bullets
		* -------------------------
		*/
		$this->add_control(
			'pagination_bullet_color',
			[
				'label' => esc_html__( 'Bullet Color', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pagination_bullet_active_color',
			[
				'label' => esc_html__( 'Active Bullet Color', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'pagination_bullet_size',
			[
				'label' => esc_html__( 'Bullet Size', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::SLIDER,
				'range' => ['px' => ['min' => 4, 'max' => 30]],
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'condition' => ['pagination' => 'bullets'],
			]
		);

		$this->add_responsive_control(
			'pagination_bullet_spacing',
			[
				'label' => esc_html__( 'Bullet Spacing', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::SLIDER,
				'range' => ['px' => ['min' => 0, 'max' => 50]],
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'condition' => ['pagination' => 'bullets'],
			]
		);


		/**
		* -------------------------
		* Fraction
		* -------------------------
		*/
		$this->add_control(
			'pagination_fraction_color',
			[
				'label' => esc_html__( 'Fraction Color', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-current, {{WRAPPER}} .swiper-pagination-total' => 'color: {{VALUE}};',
				],
				'condition' => ['pagination' => 'fraction'],
			]
		);

		$this->add_control(
			'pagination_fraction_active_color',
			[
				'label' => esc_html__( 'Fraction Active Number Color', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-current' => 'color: {{VALUE}};',
				],
				'condition' => ['pagination' => 'fraction'],
			]
		);

		/**
		* -------------------------
		* Progressbar
		* -------------------------
		*/
		$this->add_control(
			'pagination_progress_color',
			[
				'label' => esc_html__( 'Progressbar Fill Color', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-progressbar-fill' => 'background-color: {{VALUE}};',
				],
				'condition' => ['pagination' => 'progressbar'],
			]
		);
		$this->add_control(
			'pagination_progress_bg_color',
			[
				'label' => esc_html__( 'Progressbar Background Color', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-progressbar' => 'background-color: {{VALUE}};',
				],
				'condition' => ['pagination' => 'progressbar'],
			]
		);


		$this->add_responsive_control(
			'pagination_spacing',
			[
				'label' => esc_html__( 'Pagination Spacing', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px','%','em','rem'],
				'range' => [
					'px' => ['min' => 0, 'max' => 100],
					'%'  => ['min' => 0, 'max' => 50],
					'em' => ['min' => 0, 'max' => 10],
					'rem' => ['min' => 0, 'max' => 10],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();

		/**
		* -------------------------
		* Navigation Arrows
		* -------------------------
		*/

		$this->start_controls_section(
			'section_navigation_arrows_style',
			[
				'label' => esc_html__( 'Navigation Arrows', 'wpsc-ultimate-testimonials' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		/**
		* -------------------------
		* Arrow Button Size
		* -------------------------
		*/
		$this->add_responsive_control(
			'arrow_size',
			[
				'label' => esc_html__( 'Arrow Button Size', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', '%'],
				'range' => ['px' => ['min' => 20, 'max' => 100]],
				'default' => ['unit' => 'px', 'size' => 40],
				'selectors' => [
					'{{WRAPPER}} .swiper-button-prev, {{WRAPPER}} .swiper-button-next' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		/**
		* -------------------------
		* Arrow Icon Size
		* -------------------------
		*/
		$this->add_responsive_control(
			'arrow_icon_size',
			[
				'label' => esc_html__( 'Arrow Icon Size', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', '%'],
				'range' => ['px' => ['min' => 10, 'max' => 50]],
				'default' => ['unit' => 'px', 'size' => 16],
				'selectors' => [
					'{{WRAPPER}} .swiper-button-prev::after, {{WRAPPER}} .swiper-button-next::after' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		/**
		* -------------------------
		* Arrow Colors
		* -------------------------
		*/
		$this->add_control(
			'arrow_color',
			[
				'label' => esc_html__( 'Color', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-button-prev:not(.swiper-button-disabled)::after, {{WRAPPER}} .swiper-button-next:not(.swiper-button-disabled)::after' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrow_color_hover',
			[
				'label' => esc_html__( 'Color: Hover', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-button-prev:hover:not(.swiper-button-disabled)::after, {{WRAPPER}} .swiper-button-next:hover:not(.swiper-button-disabled)::after' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrow_color_disabled',
			[
				'label' => esc_html__( 'Color: Disabled', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-button-prev.swiper-button-disabled::after, {{WRAPPER}} .swiper-button-next.swiper-button-disabled::after' => 'color: {{VALUE}};',
				],
			]
		);

		/**
		* -------------------------
		* Arrow Background
		* -------------------------
		*/
		$this->add_control(
			'arrow_bg',
			[
				'label' => esc_html__( 'Background Color', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-button-prev:not(.swiper-button-disabled), {{WRAPPER}} .swiper-button-next:not(.swiper-button-disabled)' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrow_bg_hover',
			[
				'label' => esc_html__( 'Background Color: Hover', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-button-prev:hover:not(.swiper-button-disabled), {{WRAPPER}} .swiper-button-next:hover:not(.swiper-button-disabled)' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrow_bg_disabled',
			[
				'label' => esc_html__( 'Background Color: Disabled', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-button-prev.swiper-button-disabled, {{WRAPPER}} .swiper-button-next.swiper-button-disabled' => 'background-color: {{VALUE}};',
				],
			]
		);

		/**
		* -------------------------
		* Border
		* -------------------------
		*/
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'arrow_border',
				'label' => esc_html__( 'Border', 'wpsc-ultimate-testimonials' ),
				'selector' => '{{WRAPPER}} .swiper-button-prev:not(.swiper-button-disabled), {{WRAPPER}} .swiper-button-next:not(.swiper-button-disabled)',
			]
		);

		$this->add_control(
			'arrow_border_hover',
			[
				'label' => esc_html__( 'Border Color: Hover', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-button-prev:hover:not(.swiper-button-disabled), {{WRAPPER}} .swiper-button-next:hover:not(.swiper-button-disabled)' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrow_border_disabled',
			[
				'label' => esc_html__( 'Border Color: Disabled', 'wpsc-ultimate-testimonials' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-button-prev.swiper-button-disabled, {{WRAPPER}} .swiper-button-next.swiper-button-disabled' => 'border-color: {{VALUE}};',
				],
			]
		);

		/**
		* -------------------------
		* Box Shadow
		* -------------------------
		*/
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'arrow_shadow',
				'label' => esc_html__( 'Shadow', 'wpsc-ultimate-testimonials' ),
				'selector' => '{{WRAPPER}} .swiper-button-prev:not(.swiper-button-disabled), {{WRAPPER}} .swiper-button-next:not(.swiper-button-disabled)',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'arrow_shadow_hover',
				'label' => esc_html__( 'Shadow: Hover', 'wpsc-ultimate-testimonials' ),
				'selector' => '{{WRAPPER}} .swiper-button-prev:hover:not(.swiper-button-disabled), {{WRAPPER}} .swiper-button-next:hover:not(.swiper-button-disabled)',
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
			'slides_per_view_tablet' => $settings['slides_per_view_tablet'] ?? 2,
			'slides_per_view_mobile' => $settings['slides_per_view_mobile'] ?? 1,
			'slides_to_scroll' => $settings['slides_to_scroll'] ?? 3,
			'slides_to_scroll_tablet' => $settings['slides_to_scroll_tablet'] ?? 2,
			'slides_to_scroll_mobile' => $settings['slides_to_scroll_mobile'] ?? 1,
			'space_between_desktop' => 30,
			'space_between_tablet' => 20,
			'space_between_mobile' => 10,
		];


		if ( $settings['source'] == 'post_type' ) {
			$testimonials = WPSCUT_Core::get_data();
		} elseif ( $settings['source'] == 'manual' ) {
			$testimonials = $settings['testimonials_list'];
		}
?>


<div class="wpscut_testimonials" role="region" aria-label="Customer Testimonials">
    <?php 
    $testimonials = $settings['testimonials_list'] ?? [];

    if ( empty($testimonials) ): ?>
        <h3><?php esc_html_e( 'No Reviews Available!', 'wpscut' ); ?></h3>
    <?php else: 
        $slider_data = esc_attr( wp_json_encode( $slider_settings ) );
    ?>
        <div class="wpscut_testimonial-wrap" data-setting="<?php echo $slider_data; ?>">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <?php foreach ( $testimonials as $testimonial ): 
                        $author = $testimonial['name'] ?? 'Anonymous';
                        $content = $testimonial['review'] ?? '';
                        $position = $testimonial['designation'] ?? '';
                        $rating = !empty($testimonial['rating']) ? (float) $testimonial['rating'] : 5;
                        $thumbnail_url = $testimonial['review-image']['url'] ?? \Elementor\Utils::get_placeholder_image_src();

                        // Generate stars
                        $full_stars = floor( $rating );
                        $half_star = ($rating - $full_stars) >= 0.5 ? true : false;
                        $empty_stars = 5 - $full_stars - ($half_star ? 1 : 0);
                    ?>
                        <div class="swiper-slide wpscut_testimonial">
                            <div class="wpscut_wrapper">
                                <div class="wpscut_reviews">
                                    <?php 
                                        for ( $i = 0; $i < $full_stars; $i++ ) {
                                            echo '<span class="dashicons dashicons-star-filled"></span>';
                                        }
                                        if ( $half_star ) {
                                            echo '<span class="dashicons dashicons-star-half"></span>';
                                        }
                                        for ( $i = 0; $i < $empty_stars; $i++ ) {
                                            echo '<span class="dashicons dashicons-star-empty"></span>';
                                        }
                                    ?>
                                </div>

                                <div class="wpscut_content"><?php echo wp_kses_post( $content ); ?></div>

                                <div class="wpscut_author">
                                    <div class="wpscut_author_pic">
                                        <img src="<?php echo esc_url( $thumbnail_url ); ?>" 
                                             alt="<?php echo esc_attr( $author . '\'s Thumbnail' ); ?>" 
                                             loading="lazy">
                                    </div>
                                    <div class="wpscut_author_bio">
                                        <h3><?php echo esc_html( $author ); ?></h3>
                                        <p><?php echo esc_html( $position ); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if ( !empty($slider_settings['pagination']) ): ?>
                    <div class="swiper-pagination"></div>
                <?php endif; ?>
            </div>

            <?php if ( !empty($slider_settings['arrow']) && $slider_settings['arrow'] === 'yes' ): ?>
                <div class="swiper-button-prev" aria-label="Previous Slide"></div>
                <div class="swiper-button-next" aria-label="Next Slide"></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>


<?php 
	}

}