<?php
/**
 * Plugin Name: Ultimate Testimonials
 * Plugin URI: https://wpsatkhira.com/plugins/wpsc-ultimate-testimonials/
 * Description: Yet another testimonial plugins with lot's a of customization and freedom. A first project by WordPress Satkhira Community
 * Version: 1.0
 * Requires PHP: 5.6.20
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


 // WPS Ultimate Testimonital Plugin starts 

class WPS_Ultimate_Testimonials
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

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );
		add_shortcode( 'wps_ultimate_testimonials', [ $this, 'testimonails_output' ] );
	}


	function load_textdomain() {
    	load_plugin_textdomain( 'wpsc-ultimate-testimonials', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	public function plugin_action_links($actions){
		$actions[] = '<a href="'. esc_url( get_admin_url(null, 'edit.php?post_type=wps-testimonials&page=wps-testimonials-settings') ) .'">Settings</a>';
		return $actions;
	}

	public function enqueue() {
		wp_register_style( 'swiper', WPS_UT_URL . 'assets/css/swiper.min.css', [], '10.2.0' );
		wp_enqueue_style( 'swiper' );

		wp_register_style( 'style', WPS_UT_URL . 'assets/css/style.css', [], '10.2.0' );
		wp_enqueue_style( 'style' );

		wp_register_script( 'swiper', WPS_UT_URL . 'assets/js/swiper.min.js', [ 'jquery' ], '10.2.0', true );
		wp_enqueue_script( 'swiper' );

		wp_register_script( 'wps_main', WPS_UT_URL . 'assets/js/main.js', [ 'jquery', 'swiper' ], '1.0', true );
		wp_enqueue_script( 'wps_main' );
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

		add_settings_field(
			'wps_testimonials_shortcode',
			'Shortcode',
			[$this, 'shortcode_output'],
			'wps_testimonials',
			'testimonials_shortcode'
		);

		add_settings_field(
			'wps_carousel_status',
			'Carousel Status',
			[$this, 'carousel_status'],
			'wps_testimonials',
			'testimonials_shortcode'
		);

		add_settings_field(
			'wps_carousel_column',
			'Carousel Column',
			[$this, 'carousel_column'],
			'wps_testimonials',
			'testimonials_shortcode'
		);

		add_settings_field(
			'wps_carousel_performace',
			'Performance Oplimization',
			[$this, 'carousel_performace'],
			'wps_testimonials',
			'testimonials_shortcode'
		);
	}


	public function shortcode_output(){
		echo '<input type="text" value="[wps_ultimate_testimonials]" readonly>';
	}

	public function carousel_status(){
		$options = get_option( 'wps_testimonials_setting' );
		$checked = $options['carousel_status'];

		echo '<label><input type="radio" name="wps_testimonials_setting[carousel_status]" value="on"'. checked( $checked, 'on', false ) .'> Enable</label><br>';
		echo '<label><input type="radio" name="wps_testimonials_setting[carousel_status]" value="off"'. checked( $checked, 'off', false ) .'> Disable</label>';
	}

	public function carousel_column(){
		$options = get_option( 'wps_testimonials_setting' );
		$value = $options['carousel_column'];

		echo '<input type="number" name="wps_testimonials_setting[carousel_column]" min="1" max="8" step="1" value="'. $value .'">';
	}

	public function carousel_performace(){
		$options = get_option( 'wps_testimonials_setting' );
		$checked = $options['carousel_performace'];

		echo '<label><input type="radio" name="wps_testimonials_setting[carousel_performace]" value="local"'. checked( $checked, 'local', false ) .'> Enqueue own JS locally</label><br>';
		echo '<label><input type="radio" name="wps_testimonials_setting[carousel_performace]" value="cdn"'. checked( $checked, 'cdn', false ) .'> Enqueue from CDN</label>';
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

}


// Load the plugin
WPS_Ultimate_Testimonials::get_instance();







