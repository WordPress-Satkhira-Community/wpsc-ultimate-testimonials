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


	protected function register_controls() {
		parent::register_controls();

		/*$this->start_injection( [
			'of' => 'slides',
		] );

		$this->add_control(
			'skin',
			[
				'label' => esc_html__( 'Skin', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Default', 'elementor-pro' ),
					'dark' => esc_html__( 'dark', 'elementor-pro' ),
					'light' => esc_html__( 'light', 'elementor-pro' ),
				],
				'prefix_class' => 'wpsc-ut-',
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'column',
			[
				'label' => esc_html__( 'Column', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Default', 'elementor-pro' ),
					'dark' => esc_html__( 'dark', 'elementor-pro' ),
					'light' => esc_html__( 'light', 'elementor-pro' ),
				],
				'prefix_class' => 'wpsc-ut-',
				'render_type' => 'template',
			]
		);*/

		$this->start_controls_section(
			'section_skin_style',
			[
				'label' => esc_html__( 'Bubble', 'elementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'skin' => 'bubble',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label' => esc_html__( 'Background Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'alpha' => false,
				'selectors' => [
					'{{WRAPPER}} .elementor-testimonial__content, {{WRAPPER}} .elementor-testimonial__content:after' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		// $this->end_injection();
	}


	protected function render(){
		echo do_shortcode( '[wps_ultimate_testimonials]' );
	}
}