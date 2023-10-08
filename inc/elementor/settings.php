<?php 

//Avoiding Direct File Access

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class WPSC_Elementor_Settings 
{
	
	private static $instance;

	public static function get_instance(){
		if (null === self::$instance) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct(){
		// Elementor Addons
		add_action( 'elementor/elements/categories_registered', [$this, 'elementor_widget_category'], 0 );
		add_action( 'elementor/widgets/register', [$this, 'elementor_widget'] );
	}

	public function elementor_widget_category( $elements_manager ) {
		$elements_manager->add_category(
			'wpsc-plugins',
			[
				'title' => esc_html__( 'WPSC Addons', 'wpsc-ultimate-testimonials' ),
				'icon' => 'fa fa-plug',
			]
		);
	}


	public function elementor_widget( $widgets_manager ){
		require_once( WPS_UT_PATH . '/inc/elementor/widget.php' );

		$widgets_manager->register( new \WPSC_Ultimate_Testimonials_Widget() );
	}	
}