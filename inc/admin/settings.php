<?php 

//Avoiding Direct File Access

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class WPSC_Admin_Settings 
{
	
	private static $instance;

	public static function get_instance(){
		if (null === self::$instance) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct(){
		add_action( 'admin_menu', [$this, 'admin_menu'] );
		add_action( 'admin_init', [$this, 'admin_settings'] );
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
			__('Shortcode', 'wpsc-ultimate-testimonials'),
			[$this, 'shortcode_output'],
			'wps_testimonials',
			'testimonials_shortcode'
		);
		add_settings_field(
			'wps_carousel_autoplay',
			__('Carousel Autoplay', 'wpsc-ultimate-testimonials'),
			[$this, 'carousel_autoplay'],
			'wps_testimonials',
			'testimonials_shortcode'
		);
		add_settings_field( 
			'wps_carousel_arrows',
			__('Arrows', 'wpsc-ultimate-testimonials'),
			[$this, 'carousel_arrows'],
			'wps_testimonials',
			'testimonials_shortcode'
		);
		add_settings_field(
			'wps_carousel_loop',
			__('Infinite Loop', 'wpsc-ultimate-testimonials'),
			[$this, 'carousel_infinity_loop'],
			'wps_testimonials',
			'testimonials_shortcode'
		);
		add_settings_field(
			'wps_carousel_hover_pouse',
			__('Pause on Hover', 'wpsc-ultimate-testimonials'),
			[$this, 'carousel_hover_pouse'],
			'wps_testimonials',
			'testimonials_shortcode'
		);
		add_settings_field(
			'wps_carousel_interaction_pouse',
			__('Pause on Interaction', 'wpsc-ultimate-testimonials'),
			[$this, 'carousel_interaction_pouse'],
			'wps_testimonials',
			'testimonials_shortcode'
		);
		add_settings_field(
			'wps_carousel_pagination',
			__('Pagination', 'wpsc-ultimate-testimonials'),
			[$this, 'carousel_pagination'],
			'wps_testimonials',
			'testimonials_shortcode'
		);
		add_settings_field(
			'wps_autoplay_speed',
			__('Autoplay Speed', 'wpsc-ultimate-testimonials'),
			[$this, 'autoplay_speed'],
			'wps_testimonials',
			'testimonials_shortcode'
		);
		add_settings_field(
			'wps_transition_duration',
			__('Transition Duration', 'wpsc-ultimate-testimonials'),
			[$this, 'transition_duration'],
			'wps_testimonials',
			'testimonials_shortcode'
		);
		add_settings_field(
			'wps_carousel_performance',
			__('Performance Oplimization', 'wpsc-ultimate-testimonials'),
			[$this, 'carousel_performance'],
			'wps_testimonials',
			'testimonials_shortcode'
		);
	}	


	public function shortcode_output(){
		echo '<input type="text" value="[wps_ultimate_testimonials]" readonly class="regular-text">';
	}


	public function carousel_autoplay(){
		$options = get_option( 'wps_testimonials_setting' );
		
		// Check if $options is an array before accessing its elements
		if (is_array($options)) {
			$checked = !empty($options['carousel_autoplay']) ? $options['carousel_autoplay'] : false;
		} else {
			// Set a default value if $options is not an array
			$checked = true;
		}


		echo'<label class="wps_switch">
		  <input class="wps_input" type="checkbox" name="wps_testimonials_setting[carousel_autoplay]" '. checked( $checked, true, false ) .'>
		  <span class="wps_toggle"></span>
		</label>';
	}

	public function carousel_arrows(){
		$options = get_option( 'wps_testimonials_setting' );
		
		// Check if $options is an array before accessing its elements
		if (is_array($options)) {
			$checked = isset($options['carousel_arrows']) ? $options['carousel_arrows'] : 'no';
		} else {
			// Set a default value if $options is not an array
			$checked = 'yes';
		}

		echo'<label class="wps_switch">
		  <input class="wps_input" type="checkbox" name="wps_testimonials_setting[carousel_arrows]" '. checked( $checked, 'yes', false ) .'>
		  <span class="wps_toggle"></span>
		</label>';
	}

	public function carousel_infinity_loop(){
		$options = get_option( 'wps_testimonials_setting' );
		
		// Check if $options is an array before accessing its elements
		if (is_array($options)) {
			$checked = isset($options['carousel_loop']) ? 'yes' : 'no';
		} else {
			// Set a default value if $options is not an array
			$checked = 'yes';
		}

		echo'<label class="wps_switch">
		  <input class="wps_input" type="checkbox" name="wps_testimonials_setting[carousel_loop]" '. checked( $checked, 'yes', false ) .'>
		  <span class="wps_toggle"></span>
		</label>';
	}

	public function carousel_hover_pouse(){
		$options = get_option( 'wps_testimonials_setting' );
		
		// Check if $options is an array before accessing its elements
		if (is_array($options)) {
			$checked = isset($options['carousel_hover_pouse']) ? 'yes' : 'no';
		} else {
			// Set a default value if $options is not an array
			$checked = 'yes';
		}

		echo'<label class="wps_switch">
		  <input class="wps_input" type="checkbox" name="wps_testimonials_setting[carousel_hover_pouse]" '. checked( $checked, 'yes', false ) .'>
		  <span class="wps_toggle"></span>
		</label>';
	}

	public function carousel_interaction_pouse(){
		$options = get_option( 'wps_testimonials_setting' );
		
		// Check if $options is an array before accessing its elements
		if (is_array($options)) {
			$checked = isset($options['carousel_interaction_pouse']) ? 'yes' : 'no';
		} else {
			// Set a default value if $options is not an array
			$checked = 'yes';
		}

		echo'<label class="wps_switch">
		  <input class="wps_input" type="checkbox" name="wps_testimonials_setting[carousel_interaction_pouse]" '. checked( $checked, 'yes', false ) .'>
		  <span class="wps_toggle"></span>
		</label>';
	}

	public function carousel_pagination(){
		$options = get_option( 'wps_testimonials_setting' );
		if (is_array($options)){
			$value = isset($options['carousel_pagination']) ? $options['carousel_pagination'] : 'dots';
		}else{
			// Set a default value if $options is not an array
			$value = 'dots';
		}

		$pageOptions = [ "None"=>"none" , "Dots"=>"dots", "Fraction"=>"fraction", "Progress"=>"progress" ];

		echo '<select name="wps_testimonials_setting[carousel_pagination]">';
			foreach ($pageOptions as $pageOption => $pageValue) {
			  echo '<option value="'. $pageValue .'"' . selected( $value, $pageValue, false ).'>'.$pageOption.'</option>';
			}
		echo '</select>';
	}

	public function autoplay_speed() {
		$options = get_option( 'wps_testimonials_setting' );
		if (is_array($options)) {
			$speed = isset($options['autoplay_speed']) ? $options['autoplay_speed'] : 5000;
		}else{
			$speed = 5000;
		}
		echo'<input class="auto-play" type="number" name="wps_testimonials_setting[autoplay_speed]" value="'. $speed .'">';
	}

	public function transition_duration() {
		$options = get_option( 'wps_testimonials_setting' );
		if (is_array($options)) {
			$duration = isset($options['transition_duration']) ? $options['transition_duration'] : 500;
		}else{
			$duration = 500;
		}
		echo'<input class="auto-play" type="number" name="wps_testimonials_setting[transition_duration]" value="'. $duration .'">';
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

}