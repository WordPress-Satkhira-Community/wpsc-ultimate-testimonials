<?php 

//Avoiding Direct File Access

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class WPSCUT_Admin_Settings 
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
		$this->settings = get_option( 'wpscut_setting' );

		add_action( 'admin_menu', [$this, 'admin_menu'] );
		add_action( 'admin_init', [$this, 'admin_settings'] );

		register_activation_hook( WPSCUT_FILE, [$this, 'default_settings'] );
	}	

	public function default_settings() {
		if ( !empty( get_option( 'wpscut_setting' ) ) ) {
			return;
		}

		$default_settings = [
			'show_arrows' => 'yes',
			'pagination' => 'Dots',
			'speed' => "500",
			'autoplay' => 'no',
			'autoplay_speed' => "5000",
			'loop' => 'no',
			'pause_on_hover' => 'yes',
			'pause_on_interaction' => 'yes',
			'carousel_performance' => "cdn",
			'slides_per_view' => "3",
			'slides_per_view_tablet' => "2",
			'slides_per_view_mobile' => "1"
		];

		update_option( 'wpscut_setting', $default_settings );
	}

	public function admin_menu(){
		add_submenu_page(
			'edit.php?post_type=wpsc-testimonials',
			'Settings',
			'Settings',
			'manage_options',
			'wpsc-testimonials-settings',
			[$this, 'settings']
		);
	}


	public function settings(){
		if( ! current_user_can( 'manage_options' ) ){
			return;
		}

		if ( isset( $_GET['settings-updated'] ) ) {
			add_settings_error( 'wpscut_testimonials_messages', 'wpscut_testimonials_message', __( 'Settings Saved', 'wpsc-ultimate-testimonials' ), 'updated' );
		}

		settings_errors( 'wpscut_testimonials_messages' );

		?>
		<style type="text/css">
			.wpscut_settings select {
				min-width: 100px;
			}
			.wpscut_settings label {
				display: block;
				margin-bottom: 8px;
			}
		</style>
		<div class="wrap">
			<div class="wpscut_settings">
				
				<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

				<form action="options.php" method="post">
					<?php

					settings_fields('wpscut_settings');

					do_settings_sections('wpscut_settings');

					submit_button( 'Save Changes' );

					?>
				</form>
			</div>
		</div>

		<?php
	}

	public function admin_settings(){
		register_setting( 'wpscut_settings', 'wpscut_setting' );

		add_settings_section(
			'testimonials_shortcode',
			'',
			'__return_null',
			'wpscut_settings'
		);

		add_settings_field(
			'wpscut_testimonials_shortcode',
			__('Shortcode', 'wpsc-ultimate-testimonials'),
			[$this, 'shortcode_output'],
			'wpscut_settings',
			'testimonials_shortcode'
		);

		add_settings_field(
			'wpscut_carousel_autoplay',
			__('Carousel Autoplay', 'wpsc-ultimate-testimonials'),
			[$this, 'field_output'],
			'wpscut_settings',
			'testimonials_shortcode',
			[
				'type' => 'checkbox',
				'name' => 'autoplay'
			]
		);

		add_settings_field( 
			'wpscut_carousel_arrows',
			__('Arrows', 'wpsc-ultimate-testimonials'),
			[$this, 'field_output'],
			'wpscut_settings',
			'testimonials_shortcode',
			[
				'type' => 'checkbox',
				'name' => 'show_arrows'				
			]
		);


		add_settings_field(
			'wpscut_carousel_loop',
			__('Infinite Loop', 'wpsc-ultimate-testimonials'),
			[$this, 'field_output'],
			'wpscut_settings',
			'testimonials_shortcode',
			[
				'type' => 'checkbox',
				'name' => 'loop'
			]
		);

		add_settings_field(
			'wpscut_carousel_hover_pouse',
			__('Pause on Hover', 'wpsc-ultimate-testimonials'),
			[$this, 'field_output'],
			'wpscut_settings',
			'testimonials_shortcode',
			[
				'type' => 'checkbox',
				'name' => 'pause_on_hover'
			]
		);


		add_settings_field(
			'wpscut_carousel_interaction_pouse',
			__('Pause on Interaction', 'wpsc-ultimate-testimonials'),
			[$this, 'field_output'],
			'wpscut_settings',
			'testimonials_shortcode',
			[
				'type' => 'checkbox',
				'name' => 'pause_on_interaction'
			]
		);


		add_settings_field(
			'wpscut_carousel_pagination',
			__('Pagination', 'wpsc-ultimate-testimonials'),
			[$this, 'field_output'],
			'wpscut_settings',
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
			'wpscut_autoplay_speed',
			__('Autoplay Speed', 'wpsc-ultimate-testimonials'),
			[$this, 'field_output'],
			'wpscut_settings',
			'testimonials_shortcode',
			[
				'type' => 'number',
				'name' => 'autoplay_speed'
			]
		);

		add_settings_field(
			'wpscut_transition_duration',
			__('Transition Duration', 'wpsc-ultimate-testimonials'),
			[$this, 'field_output'],
			'wpscut_settings',
			'testimonials_shortcode',
			[
				'type' => 'number',
				'name' => 'speed'
			]
		);


		add_settings_field(
			'wpscut_carousel_performance',
			__('Performance Oplimization', 'wpsc-ultimate-testimonials'),
			[$this, 'field_output'],
			'wpscut_settings',
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
			'wpscut_settings'
		);


		add_settings_field(
			'wpscut_carousel_column',
			__('Desktop Column', 'wpsc-ultimate-testimonials'),
			[$this, 'field_output'],
			'wpscut_settings',
			'testimonials_responsive',
			[
				'type' => 'select',
				'name' => 'slides_per_view',
				'option' => range(1, 8)
			]
		);


		add_settings_field(
			'wpscut_carousel_tablet_column',
			__('Tablet Column', 'wpsc-ultimate-testimonials'),
			[$this, 'field_output'],
			'wpscut_settings',
			'testimonials_responsive',
			[
				'type' => 'select',
				'name' => 'slides_per_view_tablet',
				'option' => range(1, 8)
			]			
		);


		add_settings_field(
			'wpscut_carousel_mobile_column',
			__('Mobile Column', 'wpsc-ultimate-testimonials'),
			[$this, 'field_output'],
			'wpscut_settings',
			'testimonials_responsive',
			[
				'type' => 'select',
				'name' => 'slides_per_view_mobile',
				'option' => range(1, 8)
			]				
		);
		

	}	


	public function shortcode_output(){
		echo '<input type="text" value="[wpscut_ultimate_testimonials]" readonly class="regular-text">';
	}

	public function field_output( $args ) {
		$options = $this->settings;

		if ( $args['type'] == 'checkbox' ){ ?>

			<label class="wpscut_switch">
			  <input class="wpscut_input" type="checkbox" name="wpscut_setting[<?php echo esc_attr($args['name']); ?>]" value="yes" <?php checked( 'yes', $options[$args['name']] ); ?>>
			  <span class="wpscut_toggle"></span>
			</label>

		<?php } elseif( $args['type'] == 'select' ){ ?>

			<select name="wpscut_setting[<?php echo esc_attr( $args['name'] ); ?>]">
				<?php foreach ($args['option'] as $item){ ?>
					<option value="<?php echo esc_attr($item); ?>" <?php selected( $item, $options[$args['name']] ); ?>><?php printf( esc_html__( '%s', 'wpsc-ultimate-testimonials' ), esc_html($item) ); ?></option>
				<?php } ?>
			</select>

		<?php } elseif( $args['type'] == 'number' ){ ?>
			
			<input class="auto-play" type="number" name="wpscut_setting[<?php echo esc_attr($args['name']); ?>]" value="<?php echo esc_attr($options[$args['name']]); ?>">

		<?php } elseif( $args['type'] == 'radio' ){ ?>
			
			<?php foreach ($args['option'] as $key => $val){ ?>
				<label>
					<input type="radio" name="wpscut_setting[<?php echo esc_attr($args['name']); ?>]" value="<?php echo esc_attr( $key ); ?>" <?php checked( $options[$args['name']], $key ); ?>><?php printf( esc_html__( '%s', 'wpsc-ultimate-testimonials' ), esc_html($val) ); ?>
				</label>
			<?php } ?>

		<?php }

	}

}