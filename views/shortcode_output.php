<?php 
/*
	Testimonials Shortcode Output 
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<div class="wps_testimonials">
	<?php if ( empty($testimonials) ): ?>
		<h3>No Reviews Available!</h3>
	<?php else: ?>
		<div class="wps_testimonial-wrap" data-setting='<?php echo json_encode($slider_settings); ?>'>
			<div class="swiper">
			  <div class="swiper-wrapper">
			  	<?php foreach ($testimonials as $testimonial): 
			  		$author 		= $testimonial->post_title ?? '';
			  		$content 		= $testimonial->post_content ?? '';
			  		$position 		= get_post_meta( $testimonial->ID, 'designation', true ) ?? '';
			  		$rating 		= get_post_meta( $testimonial->ID, 'ratings', true ) ?? 5;
					$thumbnail_url 	= get_the_post_thumbnail_url( $testimonial->ID, 'thumbnail' ) ?? '';
			  	?>
				    <div class="swiper-slide wps_testimonial">
				    	<div class="wps_wrapper">
				    		<div class="wps_reviews">
				    			<?php 
				    			$floor = round($rating);

				    			for ($i = 1; $i <= 5; $i++) {
				    				if ( $i == $floor && fmod($rating, 1) ) {
				    					echo '<span class="dashicons dashicons-star-half"></span>';
				    				} else {
					    				if ( $i <= $floor ) {
					    					echo '<span class="dashicons dashicons-star-filled"></span>';
					    				} else {
					    					echo '<span class="dashicons dashicons-star-empty"></span>';
					    				}
				    				}
				    			}

				    			?>
				    		</div>
				    		<div class="wps_content">
				    			<?php echo wp_kses_post( $content ); ?>
				    		</div>
				    		<div class="wps_author">
				    			<div class="wps_author_pic">
				    				<img src="<?php echo esc_url( $thumbnail_url ); ?>" alt="<?php esc_attr_e( $author ); ?>'s Thumbnail">
				    			</div>
				    			<div class="wps_author_bio">
				    				<h3><?php esc_attr_e( $author ); ?></h3>
				    				<p><?php esc_attr_e( $position ); ?></p>
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
		</div>

	<?php endif ?>

</div>