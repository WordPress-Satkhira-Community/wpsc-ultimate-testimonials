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


	private $settings;

	public function __construct(){
		$this->settings = get_option( 'wps_testimonials_setting' );

		add_action( 'admin_menu', [$this, 'admin_menu'] );
		add_action( 'admin_init', [$this, 'admin_settings'] );
		register_activation_hook( WPS_FILE, [$this, 'default_settings'] );
	}	

	public function default_settings() {
		if ( !empty(get_option( 'wps_testimonials_setting' )) ) {
			return;
		}
		$default_settings = [
			'show_arrows' => 'yes',
			'pagination' => 'Dots',
			'speed' => "500",
			'autoplay' => 'yes',
			'autoplay_speed' => "5000",
			'loop' => 'yes',
			'pause_on_hover' => 'yes',
			'pause_on_interaction' => 'yes',
			'carousel_performance' => "cdn",
			'slides_per_view' => "3",
			'slides_per_view_tablet' => "2",
			'slides_per_view_mobile' => "1"
		];

		update_option( 'wps_testimonials_setting', $default_settings);

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
			add_settings_error( 'wps_testimonials_messages', 'wps_testimonials_message', __( 'Settings Saved', 'wpsc-ultimate-testimonials' ), 'updated' );
		}

		settings_errors( 'wps_testimonials_messages' );

		?>
		<style type="text/css">
			.wpsc_settings select {
				min-width: 100px;
			}
			.wpsc_settings label {
				display: block;
				margin-bottom: 8px;
			}
		</style>
		<div class="wrap">
			<div class="wpsc_settings">
				
				<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

				<form action="options.php" method="post">
					<?php

					settings_fields('wps_testimonials');

					do_settings_sections('wps_testimonials');

					submit_button( 'Save Changes' );

					?>
				</form>
			</div>
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
			__('Shortcode', 'wpsc-ultimate-testimonials'),
			[$this, 'shortcode_output'],
			'wps_testimonials',
			'testimonials_shortcode'
		);

		add_settings_field(
			'wps_carousel_autoplay',
			__('Carousel Autoplay', 'wpsc-ultimate-testimonials'),
			[$this, 'wpsc_settings_field'],
			'wps_testimonials',
			'testimonials_shortcode',
			[
				'type' => 'checkbox',
				'name' => 'autoplay'
			]
		);

		add_settings_field( 
			'wps_carousel_arrows',
			__('Arrows', 'wpsc-ultimate-testimonials'),
			[$this, 'wpsc_settings_field'],
			'wps_testimonials',
			'testimonials_shortcode',
			[
				'type' => 'checkbox',
				'name' => 'show_arrows'				
			]
		);


		add_settings_field(
			'wps_carousel_loop',
			__('Infinite Loop', 'wpsc-ultimate-testimonials'),
			[$this, 'wpsc_settings_field'],
			'wps_testimonials',
			'testimonials_shortcode',
			[
				'type' => 'checkbox',
				'name' => 'loop'
			]
		);

		add_settings_field(
			'wps_carousel_hover_pouse',
			__('Pause on Hover', 'wpsc-ultimate-testimonials'),
			[$this, 'wpsc_settings_field'],
			'wps_testimonials',
			'testimonials_shortcode',
			[
				'type' => 'checkbox',
				'name' => 'pause_on_hover'
			]
		);


		add_settings_field(
			'wps_carousel_interaction_pouse',
			__('Pause on Interaction', 'wpsc-ultimate-testimonials'),
			[$this, 'wpsc_settings_field'],
			'wps_testimonials',
			'testimonials_shortcode',
			[
				'type' => 'checkbox',
				'name' => 'pause_on_interaction'
			]
		);


		add_settings_field(
			'wps_carousel_pagination',
			__('Pagination', 'wpsc-ultimate-testimonials'),
			[$this, 'wpsc_settings_field'],
			'wps_testimonials',
			'testimonials_shortcode',
			[
				'type' => 'select',
				'name' => 'pagination',
				'option' => [
					__( 'None', 'wpsc-ultimate-testimonials' ),
					__( 'Dots', 'wpsc-ultimate-testimonials' ),
					__( 'Fraction', 'wpsc-ultimate-testimonials' ),
					__( 'Progress', 'wpsc-ultimate-testimonials' )
				]
			]
		);

		add_settings_field(
			'wps_autoplay_speed',
			__('Autoplay Speed', 'wpsc-ultimate-testimonials'),
			[$this, 'wpsc_settings_field'],
			'wps_testimonials',
			'testimonials_shortcode',
			[
				'type' => 'number',
				'name' => 'autoplay_speed'
			]
		);

		add_settings_field(
			'wps_transition_duration',
			__('Transition Duration', 'wpsc-ultimate-testimonials'),
			[$this, 'wpsc_settings_field'],
			'wps_testimonials',
			'testimonials_shortcode',
			[
				'type' => 'number',
				'name' => 'speed'
			]
		);


		add_settings_field(
			'wps_carousel_performance',
			__('Performance Oplimization', 'wpsc-ultimate-testimonials'),
			[$this, 'wpsc_settings_field'],
			'wps_testimonials',
			'testimonials_shortcode',
			[
				'type' => 'radio',
				'name' => 'carousel_performance',
				'option' => [
					'local' => __( 'Enqueue own JS locally', 'wpsc-ultimate-testimonials' ),
					'cdn' => __( 'Enqueue from CDN', 'wpsc-ultimate-testimonials' )
				]
			]
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
			[$this, 'wpsc_settings_field'],
			'wps_testimonials',
			'testimonials_responsive',
			[
				'type' => 'select',
				'name' => 'slides_per_view',
				'option' => range(1, 8)
			]
		);


		add_settings_field(
			'wps_carousel_tablet_column',
			__('Tablet Column', 'wpsc-ultimate-testimonials'),
			[$this, 'wpsc_settings_field'],
			'wps_testimonials',
			'testimonials_responsive',
			[
				'type' => 'select',
				'name' => 'slides_per_view_tablet',
				'option' => range(1, 8)
			]			
		);


		add_settings_field(
			'wps_carousel_mobile_column',
			__('Mobile Column', 'wpsc-ultimate-testimonials'),
			[$this, 'wpsc_settings_field'],
			'wps_testimonials',
			'testimonials_responsive',
			[
				'type' => 'select',
				'name' => 'slides_per_view_mobile',
				'option' => range(1, 8)
			]				
		);
		

	}	


	public function shortcode_output(){
		echo '<input type="text" value="[wps_ultimate_testimonials]" readonly class="regular-text">';
	}

	public function wpsc_settings_field( $args ) {
		$options = $this->settings;

		if ( $args['type'] == 'checkbox' ){ ?>

			<label class="wps_switch">
			  <input class="wps_input" type="checkbox" name="wps_testimonials_setting[<?php echo esc_attr($args['name']); ?>]" value="yes" <?php checked( 'yes', $options[$args['name']] ); ?>>
			  <span class="wps_toggle"></span>
			</label>

		<?php } elseif( $args['type'] == 'select' ){ ?>

			<select name="wps_testimonials_setting[<?php echo esc_attr( $args['name'] ); ?>]">
				<?php foreach ($args['option'] as $item){ ?>
					<option value="<?php echo esc_attr($item); ?>" <?php selected( $item, $options[$args['name']] ); ?>><?php printf( esc_html__( '%s', 'wpsc-ultimate-testimonials' ), esc_html($item) ); ?></option>
				<?php } ?>
			</select>

		<?php } elseif( $args['type'] == 'number' ){ ?>
			
			<input class="auto-play" type="number" name="wps_testimonials_setting[<?php echo esc_attr($args['name']); ?>]" value="<?php echo esc_attr($options[$args['name']]); ?>">

		<?php } elseif( $args['type'] == 'radio' ){ ?>
			
			<?php foreach ($args['option'] as $key => $val){ ?>
				<label>
					<input type="radio" name="wps_testimonials_setting[<?php echo esc_attr($args['name']); ?>]" value="<?php echo esc_attr( $key ); ?>" <?php checked( $options[$args['name']], $key ); ?>><?php printf( esc_html__( '%s', 'wpsc-ultimate-testimonials' ), esc_html($val) ); ?>
				</label>
			<?php } ?>

		<?php }

	}

}