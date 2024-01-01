<?php 

//Avoiding Direct File Access

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class WPSC_Testimonials_PostType 
{
	
	private static $instance;

	public static function get_instance(){
		if (null === self::$instance) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct(){
		add_action( 'add_meta_boxes', [$this, 'meta_boxes'] );
		add_action( 'save_post', [$this, 'save_meta'] );
		register_activation_hook( __FILE__, [$this, 'rewrite_flush'] );		
		add_action( 'init', [$this, 'post_types'] );
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
		wp_nonce_field( basename(__FILE__), 'designation_nonce' );

		printf(
			'<input class="widefat" type="text" name="designation" value="%s">',
			get_post_meta( $post->ID, 'designation', true )
		);
	}


	public function ratings_box( $post ){
		wp_nonce_field( basename(__FILE__), 'ratings_nonce' );

		printf(
			'<input type="number" name="ratings" value="%s" min="1" max="5" step="0.5">',
			get_post_meta( $post->ID, 'ratings', true )
		);
	}


	public function save_meta( $post_id ){
		if ( ! isset( $_POST['designation_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['designation_nonce'] ) ), basename(__FILE__) ) ){
			update_post_meta( $post_id, 'designation', sanitize_text_field( $_POST['designation'] ) );
		}

		if ( ! isset( $_POST['ratings_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ratings_nonce'] ) ), basename(__FILE__) ) ){
			update_post_meta( $post_id, 'ratings', sanitize_text_field( $_POST['ratings'] ) );
		}
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
}

