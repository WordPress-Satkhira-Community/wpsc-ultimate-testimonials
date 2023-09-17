<?php
/**
 * Plugin Name: Ultimate Testimonials
 * Plugin URI: https://wpsatkhira.com/plugins/wpsc-ultimate-testimonials/
 * Description: WPSC Ultimate Testimonials empowers your WordPress site with user-friendly testimonial submission, customizable display options, and rich media support. Boost credibility, engage visitors, and build trust effortlessly.
 * Version: 1.0
 * Requires PHP: 7.0
 * Author: WordPress Satkhira Community
 * Author URI: https://wpsatkhira.com
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wpsc-ultimate-testimonials
 */


//Avoiding Direct File Access

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define('WPS_UT_PATH', plugin_dir_path(__FILE__));
define('WPS_UT_URL', plugin_dir_url(__FILE__));


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

		add_action( 'init', [$this, 'post_types'] );
		register_activation_hook( __FILE__, [$this, 'rewrite_flush'] );
		// register_deactivation_hook( __FILE__, [$this, 'rewrite_flush'] );

		add_action( 'add_meta_boxes', [$this, 'meta_boxes'] );
		add_action( 'save_post', [$this, 'save_meta'] );
		add_action( 'admin_menu', [$this, 'admin_menu'] );
		add_action( 'admin_init', [$this, 'admin_settings'] );
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), [$this, 'plugin_action_links'] );

		add_action( 'wp_enqueue_scripts', [ $this, 'scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );
		add_shortcode( 'wps_ultimate_testimonials', [ $this, 'testimonails_output' ] );

		// Elementor Addons
		add_action( 'elementor/elements/categories_registered', [$this, 'elementor_widget_category'], 0 );
		add_action( 'elementor/widgets/register', [$this, 'elementor_widget'] );
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
		
		$setOptions = get_option( 'wps_testimonials_setting' );
		wp_localize_script( 'wps_main', 'wps_settings_data',
			array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'desktop_col' 	=>	$setOptions['desktop_column'] ?? 'default',
				'tablet_col' 	=>	$setOptions['tablet_column'] ?? 'default',
				'mobile_col' 	=>	$setOptions['mobile_column'] ?? 'default',
				'auto_play' 	=>	$setOptions['carousel_autoplay'] ?? false,
			)
		);
	}

	public function post_types(){
		$labels = [
			'name'                  => __( 'Testimonials', 'wpsc-ultimate-testimonials' ),
			'singular_name'         => __( 'Testimonial', 'wpsc-ultimate-testimonials' ),
			'menu_name'             => __( 'Testimonials', 'wpsc-ultimate-testimonials' ),
			'add_new'               => __( 'Add Testimonial', 'wpsc-ultimate-testimonials' ),
			'add_new_item'          => __( 'Add New Testimonial', 'wpsc-ultimate-testimonials' ),
			'new_item'              => __( 'New Testimonial', 'wpsc-ultimate-testimonials' ),
			'edit_item'             => __( 'Edit Testimonial', 'wpsc-ultimate-testimonials' ),
			'view_item'             => __( 'View Testimonial', 'wpsc-ultimate-testimonials' ),
			'all_items'             => __( 'All Testimonials', 'wpsc-ultimate-testimonials' ),
			'search_items'          => __( 'Search Testimonials', 'wpsc-ultimate-testimonials' ),
			'not_found'             => __( 'No testimonial found.', 'wpsc-ultimate-testimonials' ),
			'not_found_in_trash'    => __( 'No testimonial found in Trash.', 'wpsc-ultimate-testimonials' ),
		];
		
		$args = [
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'supports'			 => [ 'title', 'editor', 'thumbnail' ]
		];

		register_post_type( 'wps-testimonials', $args );
	}


	public function rewrite_flush(){
		$this->post_types();

		flush_rewrite_rules();
	}


	public function meta_boxes(){
		add_meta_box(
			'testimonial-designation',
			'Designation',
			[$this, 'designation_box'],
			'wps-testimonials'
		);

		add_meta_box(
			'testimonial-ratings',
			'Customer Ratings',
			[$this, 'ratings_box'],
			'wps-testimonials'
		);
	}


	public function designation_box( $post ){
		printf(
			'<input class="widefat" type="text" name="designation" value="%s">',
			get_post_meta( $post->ID, 'designation', true )
		);
	}


	public function ratings_box( $post ){
		printf(
			'<input type="number" name="ratings" value="%s" min="1" max="5" step="0.5">',
			get_post_meta( $post->ID, 'ratings', true )
		);
	}


	public function save_meta( $post_id ){
		if( ! empty( $_POST['designation'] ) ){
			update_post_meta( $post_id, 'designation', sanitize_text_field( $_POST['designation'] ) );
		}

		if( ! empty( $_POST['ratings'] ) ){
			update_post_meta( $post_id, 'ratings', sanitize_text_field( $_POST['ratings'] ) );
		}
	}


	public function admin_menu(){
		add_submenu_page(
			'edit.php?post_type=wps-testimonials',
			'Settings',
			'Settings',
			'manage_options',
			'wps-testimonials-settings',
			[$this, 'settings']
		);
	}


	public function settings(){
		if( ! current_user_can( 'manage_options' ) ){
			return;
		}

		if ( isset( $_GET['settings-updated'] ) ) {
			add_settings_error( 'wps_testimonials_messages', 'wps_testimonials_message', __( 'Settings Saved', 'wporg' ), 'updated' );
		}

		settings_errors( 'wps_testimonials_messages' );


		?>

		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

			<form action="options.php" method="post">
				<?php
				
				settings_fields('wps_testimonials');

				do_settings_sections('wps_testimonials');

				submit_button( 'Save Changes' );


				?>
			</form>
		</div>

		<?php
	}


	public function admin_settings(){
		register_setting( 'wps_testimonials', 'wps_testimonials_setting' );

		add_settings_section(
			'testimonials_shortcode',
			'',
			'__return_null',
			'wps_testimonials'
		);
		add_settings_section(
			'testimonials_responsive',
			'Carousel Column',
			'__return_null',
			'wps_testimonials'
		);


		add_settings_field(
			'wps_carousel_column',
			__('Desktop Column', 'wpsc-ultimate-testimonials'),
			[$this, 'desktop_carousel_column'],
			'wps_testimonials',
			'testimonials_responsive'
		);
		add_settings_field(
			'wps_carousel_tablet_column',
			__('Tablet Column', 'wpsc-ultimate-testimonials'),
			[$this, 'tablet_carousel_column'],
			'wps_testimonials',
			'testimonials_responsive'
		);
		add_settings_field(
			'wps_carousel_mobile_column',
			__('Mobile Column', 'wpsc-ultimate-testimonials'),
			[$this, 'mobile_carousel_column'],
			'wps_testimonials',
			'testimonials_responsive'
		);
		

		add_settings_field(
			'wps_testimonials_shortcode',
			'Shortcode',
			[$this, 'shortcode_output'],
			'wps_testimonials',
			'testimonials_shortcode'
		);
		add_settings_field(
			'wps_carousel_autoplay',
			'Carousel Autoplay',
			[$this, 'carousel_autoplay'],
			'wps_testimonials',
			'testimonials_shortcode'
		);
		add_settings_field(
			'wps_carousel_performance',
			'Performance Oplimization',
			[$this, 'carousel_performance'],
			'wps_testimonials',
			'testimonials_shortcode'
		);
	}


	//Shortcode Output

	public function shortcode_output(){
		echo '<input type="text" value="[wps_ultimate_testimonials]" readonly class="regular-text">';
	}


	public function carousel_autoplay(){
		$options = get_option( 'wps_testimonials_setting' );
		
		// Check if $options is an array before accessing its elements
		if (is_array($options)) {
			$checked = isset($options['carousel_autoplay']) ? true : false;
		} else {
			// Set a default value if $options is not an array
			$checked = true;
		}

		echo'<label class="wps_switch">
		  <input class="wps_input" type="checkbox" name="wps_testimonials_setting[carousel_autoplay]" '. checked( $checked, true, false ) .'>
		  <span class="wps_toggle"></span>
		</label>';
	}
	

	public function desktop_carousel_column(){
		$options = get_option( 'wps_testimonials_setting' );
		if (is_array($options)){
			$value = isset($options['desktop_column']) ? $options['desktop_column'] : 'default';
		}else{
			// Set a default value if $options is not an array
			$value = 'default';
		}

		echo '<select name="wps_testimonials_setting[desktop_column]">
			<option value="default" ' . selected( $value, 'default', false ).'>Default</option>';
			for($option = 1; $option < 8; $option++) {
			  echo '<option value="'. $option .'"' . selected( $value, $option, false ).'>'.$option.'</option>';
			}
		echo '</select>';
	}

	public function tablet_carousel_column(){
		$options = get_option( 'wps_testimonials_setting' );
		if (is_array($options)){
			$value = isset($options['tablet_column']) ? $options['tablet_column'] : 'default';
		}else{
			// Set a default value if $options is not an array
			$value = 'default';
		}

		echo '<select name="wps_testimonials_setting[tablet_column]">
			<option value="default" ' . selected( $value, 'default', false ).'>Default</option>';
			for($option = 1; $option < 8; $option++) {
			  echo '<option value="'. $option .'"' . selected( $value, $option, false ).'>'.$option.'</option>';
			}
		echo '</select>';
	}

	public function mobile_carousel_column(){
		$options = get_option( 'wps_testimonials_setting' );
		if (is_array($options)){
			$value = isset($options['mobile_column']) ? $options['mobile_column'] : 'default';
		}else{
			// Set a default value if $options is not an array
			$value = 'default';
		}

		echo '<select name="wps_testimonials_setting[mobile_column]">
			<option value="default" ' . selected( $value, 'default', false ).'>Default</option>';
			for($option = 1; $option < 4; $option++) {
			  echo '<option value="'. $option .'"' . selected( $value, $option, false ).'>'.$option.'</option>';
			}
		echo '</select>';
	}


	public function carousel_performance() {
		$options = get_option( 'wps_testimonials_setting' );
		// Check if $options is an array before accessing its elements
		if(is_array($options)){
			$checked = isset($options['carousel_performance']) ? $options['carousel_performance'] : 'cdn';
		}else{
			// Set a default value if $options is not an array
			$checked = 'cdn';
		}
	
		echo '<label><input type="radio" name="wps_testimonials_setting[carousel_performance]" value="local"'. checked( $checked, 'local', false ) .'> Enqueue own JS locally</label><br>';
		echo '<label><input type="radio" name="wps_testimonials_setting[carousel_performance]" value="cdn"'. checked( $checked, 'cdn', false ) .'> Enqueue from CDN</label>';
	}
	

	public static function get_data (){
		return get_posts([
		  'numberposts' => -1,
		  'post_type'   => 'wps-testimonials'
		]);
	}


	public function testimonails_output( $atts, $content ) {
		$testimonials = self::get_data() ?? [];

		ob_start();

		include_once ( WPS_UT_PATH .'/views/shortcode_output.php' );
		
		return ob_get_clean();
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


// Load the plugin
WPSC_Ultimate_Testimonials::get_instance();







