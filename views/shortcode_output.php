<?php 
/*
	Testimonials Shortcode Output 
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

	include_once WPS_UT_PATH .'/inc/icons/star.php';
?>


<div id="wps_testimonials">
	<?php if ( empty($testimonials) ): ?>
		<h3>No Reviews Available!</h3>
	<?php else:

		$attributes = shortcode_atts( array(
			'desktop'		=> 'default',
			'tablet'		=> 'default',
			'mobile'		=> 'default',
			'autoplay'		=> '',
			'autoplay_speed'=> '',
			'duration'		=> '',
		), $atts );

		wp_localize_script( 'wps_main', 'wps_settings_shortcode',
			array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'desktop_col' 		=>	$attributes['desktop'],
				'tablet_col' 		=>	$attributes['tablet'],
				'mobile_col' 		=>	$attributes['mobile'],
				'auto_play' 		=>	$attributes['autoplay'],
				'autoplay_speed'	=>	$attributes['autoplay_speed'],
				'slide_duration'	=>	$attributes['duration'],
			)
		);

	 ?>
		<div class="swiper">
		  <div class="swiper-wrapper">
		  	<?php foreach ($testimonials as $testimonial): 
		  		$author = $testimonial->post_title ?? '';
		  		$content = $testimonial->post_content ?? '';
		  		$position = get_post_meta( $testimonial->ID, 'designation', true ) ?? '';
		  		$rating = !empty(get_post_meta( $testimonial->ID, 'ratings', true )) ? get_post_meta( $testimonial->ID, 'ratings', true ): 5;
				$thumbnail_url = get_the_post_thumbnail_url( $testimonial->ID,'thumbnail' );
		  	?>
			    <div class="swiper-slide wps_testimonial">
			    	<div class="wps_wrapper">
			    		<div class="wps_reviews">
			    			<?php echo reviews($rating); ?>
			    		</div>
			    		<div class="wps_content">
			    			<?= $content; ?>
			    		</div>
			    		<div class="wps_author">
			    			<div class="wps_author_pic">
			    				 <!-- Display the post thumbnail here -->
								 <img src="<?php echo $thumbnail_url; ?>" alt="<?php echo $author; ?>'s Thumbnail">
			    			</div>
			    			<div class="wps_author_bio">
			    				<h3><?= $author; ?></h3>
			    				<p><?= $position; ?></p>
			    			</div>
			    		</div>
			    	</div>
			    </div>		  		
		  	<?php endforeach; ?>	    
		  </div>

		  <div class="swiper-pagination"></div>
		</div>	
		
		<div class="swiper-button-prev"></div>
		<div class="swiper-button-next"></div>	
	<?php endif ?>

</div>