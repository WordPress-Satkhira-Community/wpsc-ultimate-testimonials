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
				'label' => esc_html__( 'Layout', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'image_inline',
				'options' => [
					'image_inline' => esc_html__( 'Image Inline', 'elementor-pro' ),
					'image_stacked' => esc_html__( 'Image Stacked', 'elementor-pro' ),
					'image_above' => esc_html__( 'Image Above', 'elementor-pro' ),
					'image_left' => esc_html__( 'Image Left', 'elementor-pro' ),
					'image_right' => esc_html__( 'Image Right', 'elementor-pro' ),
				],
				'prefix_class' => 'elementor-testimonial--layout-',
				'render_type' => 'template',
			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label' => esc_html__( 'Alignment', 'elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'elementor-pro' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'elementor-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'elementor-pro' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'prefix_class' => 'elementor-testimonial-%s-align-',
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
					'elementor' => esc_html__( 'Elementor', 'wpsc-ultimate-testimonials' ),
					'post_type' => esc_html__( 'Post Type', 'wpsc-ultimate-testimonials' ),
				],
				'default' => 'elementor',
			]
		);

		$this->end_controls_section();

		// Pagination Section
		$this->start_controls_section(
			'pagination_section',
			[
				'label' => esc_html__( 'Pagination', 'wpsc-ultimate-testimonials' ),
				'tab' => Controls_Manager::TAB_CONTENT,
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
		echo do_shortcode( '[wps_ultimate_testimonials]' );
	}
}