<?php 
/*
	Testimonials Shortcode Output 
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<div class="wpscut_testimonials">
	<?php if ( empty($testimonials) ): ?>
		<h3>No Reviews Available!</h3>
	<?php else: ?>
		<div class="wpscut_testimonial-wrap" data-setting='<?php echo wp_json_encode($slider_settings); ?>'>
			<div class="swiper">
			  <div class="swiper-wrapper">
			  	<?php foreach ($testimonials as $testimonial): 
			  		$author 		= $testimonial->post_title ?? '';
			  		$content 		= $testimonial->post_content ?? '';
			  		$position 		= get_post_meta( $testimonial->ID, 'designation', true ) ?: '';
			  		$rating 		= get_post_meta( $testimonial->ID, 'ratings', true ) ?: 5;
					$thumbnail_url 	= get_the_post_thumbnail_url( $testimonial->ID, 'thumbnail' ) ?: '';
			  	?>
				    <div class="swiper-slide wpscut_testimonial">
				    	<div class="wpscut_wrapper">
				    		<div class="wpscut_reviews">
				    			<?php
								var_dump($rating);

								$floor = floor($rating);
								for ($i = 1; $i <= 5; $i++) {
									if ( $i <= $floor ) {
										echo '<span class="dashicons dashicons-star-filled"></span>';
									} elseif ( $i == $floor + 1 && fmod($rating, 1) != 0 ) {
										echo '<span class="dashicons dashicons-star-half"></span>';
									} else {
										echo '<span class="dashicons dashicons-star-empty"></span>';
									}
								}

				    			?>
				    		</div>
				    		<div class="wpscut_content">
				    			<?php echo wp_kses_post( $content ); ?>
				    		</div>
				    		<div class="wpscut_author">
				    			<div class="wpscut_author_pic">
				    				<img src="<?php echo esc_url( $thumbnail_url ); ?>" alt="<?php printf( '%s\'s Thumbnail', esc_html($author) ); ?>">
				    			</div>
				    			<div class="wpscut_author_bio">
				    				<h3><?php echo esc_html( $author ); ?></h3>
				    				<p><?php echo esc_html( $position ); ?></p>
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