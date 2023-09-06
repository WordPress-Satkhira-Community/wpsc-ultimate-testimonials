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
	<div class="swiper">
	  <div class="swiper-wrapper">
	    <div class="swiper-slide wps_testimonial">
	    	<div class="wps_wrapper">
	    		<div class="wps_reviews">
	    			<?php echo reviews(5); ?>
	    		</div>
	    		<div class="wps_content">
	    			<p>Cras et lectus posuere, semper libero et, mattis augue. Pellentesque abitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
	    		</div>
	    		<div class="wps_author">
	    			<div class="wps_author_pic">
	    				<img src="https://www.cloudways.com/wp-content/uploads/2020/01/testimonial-edward.png">
	    			</div>
	    			<div class="wps_author_bio">
	    				<h3>Dohn Joe</h3>
	    				<p>Managing Director</p>
	    			</div>
	    		</div>
	    	</div>
	    </div>

	    <div class="swiper-slide wps_testimonial">
	    	<div class="wps_wrapper">
	    		<div class="wps_reviews">
                    <?php echo reviews(3.5); ?>
	    		</div>
	    		<div class="wps_content">
	    			<p>Cras et lectus posuere, semper libero et, mattis augue. Pellentesque abitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
	    			<p>Cras et lectus posuere, semper libero et, mattis augue. Pellentesque abitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>	    			
	    		</div>
	    		<div class="wps_author">
	    			<div class="wps_author_pic">
	    				<img src="https://www.cloudways.com/wp-content/uploads/2020/01/testimonial-edward.png">
	    			</div>
	    			<div class="wps_author_bio">
	    				<h3>Dohn Joe</h3>
	    				<p>Managing Director</p>
	    			</div>
	    		</div>
	    	</div>
	    </div>	    
	    <div class="swiper-slide wps_testimonial">
	    	<div class="wps_wrapper">
	    		<div class="wps_reviews">
                    <?php echo reviews(2.5); ?>
	    		</div>
	    		<div class="wps_content">
	    			<p>Cras et lectus posuere, semper libero et, mattis augue. Pellentesque abitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
	    		</div>
	    		<div class="wps_author">
	    			<div class="wps_author_pic">
	    				<img src="https://www.cloudways.com/wp-content/uploads/2020/01/testimonial-edward.png">
	    			</div>
	    			<div class="wps_author_bio">
	    				<h3>Dohn Joe</h3>
	    				<p>Managing Director</p>
	    			</div>
	    		</div>
	    	</div>
	    </div>
	    <div class="swiper-slide wps_testimonial">
	    	<div class="wps_wrapper">
	    		<div class="wps_reviews">
                    <?php echo $star; ?>
	    		</div>
	    		<div class="wps_content">
	    			<p>Cras et lectus posuere, semper libero et, mattis augue. Pellentesque abitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
	    		</div>
	    		<div class="wps_author">
	    			<div class="wps_author_pic">
	    				<img src="https://www.cloudways.com/wp-content/uploads/2020/01/testimonial-edward.png">
	    			</div>
	    			<div class="wps_author_bio">
	    				<h3>Dohn Joe</h3>
	    				<p>Managing Director</p>
	    			</div>
	    		</div>
	    	</div>
	    </div>

	    
	  </div>

	  <div class="swiper-pagination"></div>
	</div>	
	
	<div class="swiper-button-prev"></div>
	<div class="swiper-button-next"></div>
</div>