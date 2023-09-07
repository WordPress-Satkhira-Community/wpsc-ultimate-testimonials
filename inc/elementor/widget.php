<?php

class WPSC_Ultimate_Testimonials_Widget extends \Elementor\Widget_Base {

	public function get_name(){
		return 'wpsc_ultimate_testimonials';
	}


	public function get_title(){
		return esc_html__( 'Ultimate Testimonials', 'wpsc-ultimate-testimonials' );
	}


	public function get_icon(){
		return 'eicon-code';
	}


	protected function render(){
		echo do_shortcode( '[wps_ultimate_testimonials]' );
	}
}