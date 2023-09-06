<?php 
/*
	Testimonials Shortcode Output 
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

	include_once WPS_UT_PATH .'/assets/icons/star.php';
?>


<div id="wps_testimonials">
	<?php if ( empty($testimonials) ): ?>
		<h3>No Reviews Available!</h3>
	<?php else: ?>
		<div class="swiper">
		  <div class="swiper-wrapper">
		  	<?php foreach ($testimonials as $testimonial): 
		  		$author = $testimonial->post_title ?? '';
		  		$content = $testimonial->post_content ?? '';
		  		$position = get_post_meta( $testimonial->ID, 'designation', true ) ?? '';
		  		$rating = !empty(get_post_meta( $testimonial->ID, 'ratings', true )) ? get_post_meta( $testimonial->ID, 'ratings', true ): 5;
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
			    				<img src="https://www.cloudways.com/wp-content/uploads/2020/01/testimonial-edward.png">
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