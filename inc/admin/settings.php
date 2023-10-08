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
				'name' => 'carousel_autoplay'
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
				'name' => 'carousel_arrows'				
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
				'name' => 'carousel_loop'
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
				'name' => 'carousel_hover_pouse'
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
				'name' => 'carousel_interaction_pouse'
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
				'name' => 'carousel_pagination',
				'option' => [ 'None', 'Dots', 'Fraction', 'Progress' ]
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
				'name' => 'transition_duration'
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
					'local' => 'Enqueue own JS locally',
					'cdn' => 'Enqueue from CDN'
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
				'name' => 'desktop_column',
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
				'name' => 'tablet_column',
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
				'name' => 'mobile_column',
				'option' => range(1, 8)
			]				
		);
		

	}	


	public function shortcode_output(){
		echo '<input type="text" value="[wps_ultimate_testimonials]" readonly class="regular-text">';
	}

	public function wpsc_settings_field( $args ) {
		$options = $this->settings;
		
		if ( $args['type'] == 'checkbox' ): ?>

			<label class="wps_switch">
			  <input class="wps_input" type="checkbox" name="wps_testimonials_setting[<?= $args["name"]; ?>]" value="yes" <?= checked( 'yes', $options[$args["name"]], false ); ?>>
			  <span class="wps_toggle"></span>
			</label>

		<?php elseif( $args['type'] == 'select' ): ?>

			<select name="wps_testimonials_setting[<?= $args['name']; ?>]">
				<?php foreach ($args['option'] as $item): ?>
					<option value="<?= $item; ?>" <?= selected( $item, $options[$args["name"]], false ); ?>><?= $item; ?></option>
				<?php endforeach ?>
			</select>

		<?php elseif( $args['type'] == 'number' ): ?>
			<input class="auto-play" type="number" name="wps_testimonials_setting[<?= $args['name']; ?>]" value="<?= $options[$args["name"]]; ?>">

		<?php elseif( $args['type'] == 'radio' ): ?>
			<?php foreach ($args['option'] as $key => $val): ?>
				<label>
					<input type="radio" name="wps_testimonials_setting[<?= $args['name']; ?>]" value="<?= $key; ?>" <?= checked( $options[$args["name"]], $key, false ); ?>><?= $val; ?>
				</label>
			<?php endforeach ?>

		<?php endif; 

	}

}