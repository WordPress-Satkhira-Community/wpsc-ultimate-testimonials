<?php 
/*
	Testimonials Shortcode Output 
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

	include_once WPS_UT_PATH .'/inc/icons/star.php';


	$setOptions = get_option( 'wps_testimonials_setting' );

	$desktop_column = $setOptions['desktop_column'] ?? 'default';
	$tablet_column = $setOptions['tablet_column'] ?? 'default';
	$mobile_column = $setOptions['mobile_column'] ?? 'default';
	$autoplay = $setOptions['carousel_autoplay'] ? 'on' : 'off';
	$autoplay_speed = '';
	$slide_duration = '';
	
	if ( $setOptions['carousel_autoplay'] ) {
		$autoplay_speed = $setOptions['autoplay_speed'] ?? 5000;
		$slide_duration = $setOptions['transition_duration'] ?? 500;
	}


?>


<div class="wps_testimonials">
	<?php if ( empty($testimonials) ): ?>
		<h3>No Reviews Available!</h3>
	<?php else: ?>
		<div class="wps_testimonial-wrap" data-desktop="<?= $desktop_column; ?>" data-tablet="<?= $tablet_column; ?>" data-mobile="<?=  $mobile_column; ?>" data-autoplay="<?= $autoplay; ?>" data-speed="<?= $autoplay_speed; ?>" data-duration="<?= $slide_duration; ?>">
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
		</div>

	<?php endif ?>

</div>