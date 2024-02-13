<?php
/**
 * Plugin Name: WPSC Ultimate Testimonials
 * Plugin URI: https://wpsatkhira.com/plugins/wpsc-ultimate-testimonials/
 * Description: WPSC Ultimate Testimonials is the definitive testimonial management solution for WordPress users seeking to enhance their website's credibility and trustworthiness. This versatile plugin empowers you to effortlessly generate, manage, and showcase compelling testimonials from satisfied customers, clients, or users.
 * Version: 1.0.1
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


define( 'WPSCUT_FILE', __FILE__ );
define( 'WPSCUT_PATH', plugin_dir_path(__FILE__) );
define( 'WPSCUT_URL', plugin_dir_url(__FILE__) );
define( 'WPSCUT_BASE', plugin_basename( WPSCUT_FILE ) );


include_once WPSCUT_PATH .'/inc/admin/post-type.php';
include_once WPSCUT_PATH .'/inc/admin/settings.php';
include_once WPSCUT_PATH .'/inc/elementor/settings.php';


// WPSC Ultimate Testimonital Plugin starts 

class WPSCUT_Core
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
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), [$this, 'plugin_action_links'] );
		add_filter( 'plugin_row_meta', [$this, 'plugin_meta_links'], 10, 2 );

		add_action( 'wp_enqueue_scripts', [ $this, 'scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );
		add_shortcode( 'wpscut_ultimate_testimonials', [ $this, 'testimonails_output' ] );
	}


	function load_textdomain() {
    	load_plugin_textdomain( 'wpsc-ultimate-testimonials', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	public function plugin_action_links($actions){
		$actions[] = '<a href="'. esc_url( get_admin_url(null, 'edit.php?post_type=wpsc-testimonials&page=wpsc-testimonials-settings') ) .'">Settings</a>';
		return $actions;
	}

	public function plugin_meta_links( $plugin_meta, $plugin_file ){
		if ( WPSCUT_BASE === $plugin_file ) {
			$row_meta = [
				'docs' => '<a href="https://go.wpsatkhira.com/?route=docs&product=wpsc-ultimate-testimonials" aria-label="' . esc_attr( esc_html__( 'View Documentation', 'wpsc-ultimate-testimonials' ) ) . '" target="_blank">' . esc_html__( 'Docs & FAQs', 'wpsc-ultimate-testimonials' ) . '</a>',
				'source' => '<a href="https://github.com/WordPress-Satkhira-Community/wpsc-ultimate-testimonials" aria-label="' . esc_attr( esc_html__( 'View Source on Github', 'wpsc-ultimate-testimonials' ) ) . '" target="_blank">Github</a>',
			];

			$plugin_meta = array_merge( $plugin_meta, $row_meta );
		}

		return $plugin_meta;
	}

	public function admin_scripts($hook) {
		if( "wpsc-testimonials_page_wpsc-testimonials-settings" != $hook ) {
			return;
		}
		wp_enqueue_style( 'style', WPSCUT_URL . 'assets/css/admin-style.css', [], '10.2.0' );
	}

	public function scripts() {
		wp_register_style( 'swiper', WPSCUT_URL . 'assets/css/swiper.min.css', [], '10.2.0' );
		wp_enqueue_style( 'swiper' );

		wp_register_style( 'wpscut', WPSCUT_URL . 'assets/css/style.css', ['dashicons'], '1.0' );
		wp_enqueue_style( 'wpscut' );

		wp_register_script( 'swiper', WPSCUT_URL . 'assets/js/swiper.min.js', ['jquery'], '10.2.0', true );
		wp_enqueue_script( 'swiper' );

		wp_register_script( 'wpscut', WPSCUT_URL . 'assets/js/main.js', ['jquery', 'swiper'], '1.0', true );
		wp_enqueue_script( 'wpscut' );
	}


	//Shortcode Output
	public static function get_data (){
		return get_posts([
		  'numberposts' => -1,
		  'post_type'   => 'wpsc-testimonials'
		]);
	}


	public function testimonails_output( $atts, $content ) {
		$testimonials = self::get_data() ?? [];
		$slider_settings = get_option( 'wpscut_setting' );

		ob_start();

		include ( WPSCUT_PATH .'/views/shortcode_output.php' );
		
		return ob_get_clean();
	}
}


// Load the plugin
WPSCUT_PostType::get_instance();
WPSCUT_Admin_Settings::get_instance();
WPSCUT_Elementor_Settings::get_instance();
WPSCUT_Core::get_instance();







