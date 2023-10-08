<?php
/**
 * Plugin Name: Ultimate Testimonials
 * Plugin URI: https://wpsatkhira.com/plugins/wpsc-ultimate-testimonials/
 * Description: WPSC Ultimate Testimonials is the definitive testimonial management solution for WordPress users seeking to enhance their website's credibility and trustworthiness. This versatile plugin empowers you to effortlessly generate, manage, and showcase compelling testimonials from satisfied customers, clients, or users.
 * Version: 1.0
 * Requires at least: 5.7
 * Requires PHP: 7.2
 * Author: WordPress Satkhira Community
 * Author URI: https://wpsatkhira.com/
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wpsc-ultimate-testimonials
 * Domain Path: /languages
 */


//Avoiding Direct File Access

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define('WPS_UT_PATH', plugin_dir_path(__FILE__));
define('WPS_UT_URL', plugin_dir_url(__FILE__));


include_once WPS_UT_PATH .'/inc/admin/post-type.php';
include_once WPS_UT_PATH .'/inc/admin/settings.php';
include_once WPS_UT_PATH .'/inc/elementor/settings.php';

 // WPSC Ultimate Testimonital Plugin starts 

class WPSC_Ultimate_Testimonials
{
	
	private static $instance;

	public static function get_instance(){
		if (null === self::$instance) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct(){
		add_action( 'plugins_loaded', [$this, 'load_textdomain'] );

		// register_deactivation_hook( __FILE__, [$this, 'rewrite_flush'] );

		

		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), [$this, 'plugin_action_links'] );

		add_action( 'wp_enqueue_scripts', [ $this, 'scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );
		add_shortcode( 'wps_ultimate_testimonials', [ $this, 'testimonails_output' ] );
	}


	function load_textdomain() {
    	load_plugin_textdomain( 'wpsc-ultimate-testimonials', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	public function plugin_action_links($actions){
		$actions[] = '<a href="'. esc_url( get_admin_url(null, 'edit.php?post_type=wps-testimonials&page=wps-testimonials-settings') ) .'">Settings</a>';
		return $actions;
	}

	public function admin_scripts($hook) {
		if( "wps-testimonials_page_wps-testimonials-settings" != $hook ) {
			return;
		}
		wp_enqueue_style( 'style', WPS_UT_URL . 'assets/css/admin-style.css', [], '10.2.0' );
	}

	public function scripts() {
		wp_register_style( 'swiper', WPS_UT_URL . 'assets/css/swiper.min.css', [], '10.2.0' );
		wp_enqueue_style( 'swiper' );

		wp_register_style( 'style', WPS_UT_URL . 'assets/css/style.css', [], '10.2.0' );
		wp_enqueue_style( 'style' );

		wp_register_script( 'swiper', WPS_UT_URL . 'assets/js/swiper.min.js', [ 'jquery' ], '10.2.0', true );
		wp_enqueue_script( 'swiper' );

		wp_register_script( 'wps_main', WPS_UT_URL . 'assets/js/main.js', [ 'jquery', 'swiper' ], '1.0', true );
		wp_enqueue_script( 'wps_main' );
	}

	//Shortcode Output
	public static function get_data (){
		return get_posts([
		  'numberposts' => -1,
		  'post_type'   => 'wps-testimonials'
		]);
	}


	public function testimonails_output( $atts, $content ) {
		$testimonials = self::get_data() ?? [];
		$settings = get_option( 'wps_testimonials_setting' );
		// $slider_settings = '';
		
		// if ( !empty($settings) ) {
		// 	$slider_settings = [
		// 		'arrow' => $settings['show_arrows'] ?? '',
		// 		'pagination' => $settings['pagination'] ?? '',
		// 		'speed' => $settings['speed'] ?? '',
		// 		'autoplay' => $settings['autoplay'] ?? '',
		// 		'autoplay_speed' => $settings['autoplay_speed'] ?? '',
		// 		'loop' => $settings['loop'] ?? '',
		// 		'pause_on_hover' => $settings['pause_on_hover'] ?? '',
		// 		'pause_on_interaction' => $settings['pause_on_interaction'] ?? '',
		// 		'slides_per_view' => $settings['slides_per_view'] ?? 3,
		// 		'slides_per_view_tablet' => $settings['slides_per_view_tablet'] ?? 2,
		// 		'slides_per_view_mobile' => $settings['slides_per_view_mobile'] ?? 1,
		// 		'slides_to_scroll' => $settings['slides_to_scroll'] ?? 3,
		// 		'slides_to_scroll_tablet' => $settings['slides_to_scroll_tablet'] ?? 2,
		// 		'slides_to_scroll_mobile' => $settings['slides_to_scroll_mobile'] ?? 1,
		// 	];
		// }



		echo "<pre>";
		var_dump($settings);
		echo "</pre>";

		ob_start();

		include ( WPS_UT_PATH .'/views/shortcode_output.php' );
		
		return ob_get_clean();
	}
}


// Load the plugin
WPSC_Testimonials_PostType::get_instance();
WPSC_Admin_Settings::get_instance();
WPSC_Elementor_Settings::get_instance();
WPSC_Ultimate_Testimonials::get_instance();







