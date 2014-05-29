<?php
/**
 * This file control blog block
 *
 * @package    OneEngine
 * @package    EngineThemes
 */

// CLEAR BLOCK
if( ! class_exists( 'OE_Testimonial_Block' ) ) :

class OE_Testimonial_Block extends AQ_Block {

	function __construct() {
		$block_options = array(
			'name' => __( 'ET Testimonials', 'oneengine'),
			'size' => 'span12',
		);
		
		//create the block
		parent::__construct('OE_Testimonial_Block', $block_options);
	}

 	function form($instance) {
		
		$defaults = array(
			'quantity' 				=> '2',
			'margin_top' 			=> 10,
			'margin_bottom' 		=> 10,
			'animation' 			=> 'None',
			'duration' 				=> '900',
			'delay' 				=> '0',
			'slide_speed' 			=> '800', 
			'pagination_speed' 		=> '800', 
			'auto_play' 			=> 'true', 
			'navigation' 			=> 'true', 
			'pagination' 			=> 'false', 
			'pagination_numbers'	=> 'false', 
			'items' 				=> '4', 
			'items_desktop' 		=> '3', 
			'items_desktop_small' 	=> '3', 
			'items_tablet' 			=> '2', 
			'items_mobile' 			=> '1'
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		$auto_play_type = array(
			'true' 	=> 'True',
			'false' => 'False',
		);
		$navigation_type = array(
			'true' 	=> 'True',
			'false' => 'False',
		);
		$pagination_type = array(
			'true' 	=> 'True',
			'false' => 'False',
		);
		$pagination_numbers_type = array(
			'true' 	=> 'True',
			'false' => 'False',
		);
		global $include_animation ;
		?>		
        <p class="description">
            <label for="<?php echo $this->get_field_id('margin_top') ?>">
                Margin top 
                <?php echo aq_field_input('margin_top', $block_id, $margin_top, 'min', 'number') ?> px
            </label>&nbsp;-&nbsp;
            <label for="<?php echo $this->get_field_id('margin_bottom') ?>">
                Margin bottom
                <?php echo aq_field_input('margin_bottom', $block_id, $margin_bottom, 'min', 'number') ?> px
            </label>&nbsp;-&nbsp;
        </p>
        <p class="description">
			<label for="<?php echo $this->get_field_id('quantity') ?>">
				Quantity ( * Note : with the value '-1', all item will be displayed ! )&nbsp;&nbsp;
				<?php echo aq_field_input('quantity', $block_id, $quantity, 'min', 'number') ?>
			</label>
		</p> 
        <p class="description">
			<label for="<?php echo $this->get_field_id('slide_speed') ?>">
                Slide speed in milliseconds
                <?php echo aq_field_input('slide_speed', $block_id, $slide_speed, 'min', 'number') ?> ms
            </label>&nbsp;-&nbsp;
            <label for="<?php echo $this->get_field_id('pagination_speed') ?>">
                Pagination speed in milliseconds
                <?php echo aq_field_input('pagination_speed', $block_id, $pagination_speed, 'min', 'number') ?> ms
            </label>
		</p>
        <p class="description">
            <label for="<?php echo $this->get_field_id('auto_play') ?>">
                Auto play per slide. ( Change to any integrer for example "Pagination Speed : 8000" to play every 8 seconds )<br/>
                <?php echo aq_field_select('auto_play', $block_id, $auto_play_type , $auto_play) ?>
            </label>
        </p>
        <p class="description">
            <label for="<?php echo $this->get_field_id('navigation') ?>">
                Display "next" and "prev" buttons.<br/>
                <?php echo aq_field_select('navigation', $block_id, $navigation_type , $navigation) ?>
            </label>
        </p>
        <p class="description">
            <label for="<?php echo $this->get_field_id('pagination') ?>">
                Show pagination.<br/>
                <?php echo aq_field_select('pagination', $block_id, $pagination_type , $pagination) ?>
            </label>
        </p>
        <p class="description">
            <label for="<?php echo $this->get_field_id('pagination_numbers') ?>">
                Show numbers inside pagination buttons<br/>
                <?php echo aq_field_select('pagination_numbers', $block_id, $pagination_numbers_type , $pagination_numbers) ?>
            </label>
        </p>
        <p class="description">
			<label for="<?php echo $this->get_field_id('items') ?>">
				Items ( This variable allows you to set the maximum amount of items displayed at a time with the widest browser width )<br/>
				<?php echo aq_field_input('items', $block_id, $items, 'min', 'number') ?>
			</label>
		</p>
        <p class="description">
			<label for="<?php echo $this->get_field_id('items_desktop') ?>">
				Items Desktop [ window <= 1199px ]( *Note : This variable allows you to set the maximum amount of items displayed at a time with the widest browser width. For example : "4" means that if(window<=1199){ show 4 slides per page} )<br/>
				<?php echo aq_field_input('items_desktop', $block_id, $items_desktop, 'min', 'number') ?>
			</label>
		</p>
        <p class="description">
			<label for="<?php echo $this->get_field_id('items_desktop_small') ?>">
				Items Desktop Small [ window <= 979px ] ( *Note : As above.)
				<?php echo aq_field_input('items_desktop_small', $block_id, $items_desktop_small, 'min', 'number') ?>
			</label>
		</p>
        <p class="description">
			<label for="<?php echo $this->get_field_id('items_tablet') ?>">
				Items Tablet [ window <= 768px]	( *Note : As above.)
				<?php echo aq_field_input('items_tablet', $block_id, $items_tablet, 'min', 'number') ?>
			</label>
		</p>
        <p class="description">
			<label for="<?php echo $this->get_field_id('items_mobile') ?>">
				Items Mobile [ window <= 479px ] ( *Note : As above.)
				<?php echo aq_field_input('items_mobile', $block_id, $items_mobile, 'min', 'number') ?>
			</label>
		</p>
		<?php
	}

	function block($instance) {
		extract($instance);
		$query = new WP_Query(array(
			'post_type' 	 => 'testimonial',
			'posts_per_page' => $quantity,
		));
		global $post;
		$contents = array();
		if($query->have_posts()){
			echo '<div class="avatar-wrapper"><div id="test_avatar" class="owl-carousel" data-slide-speed="'.$slide_speed.'" data-pagination-speed="'.$pagination_speed.'" data-auto="'.$auto_play.'" data-navigation="'.$navigation.'" data-pagination="'.$pagination.'" data-numbers="'.$pagination_numbers.'" data-items="'.$items.'" data-desktop="'.$items_desktop.'" data-desktop-small="'.$items_desktop_small.'" data-tablet="'.$items_tablet.'" data-mobile="'.$items_mobile.'">';
			while($query->have_posts()){
				$query->the_post();
				$contents[] =  array ( 'content' => get_the_content() , 'title' => get_the_title() );
			
			// $animation_effect 	='';
			// $duration_effect  	='';
			// if($animation) $animation_effect = 'animated '.$animation.'';
			// if($duration != '' && $animation != '') $duration_effect = 'style="-webkit-animation-duration: '.$duration.'ms; -moz-animation-duration: '.$duration.'ms; -o-animation-duration: '.$duration.'ms;animation-duration: '.$duration.'ms; animation-delay:'.$delay * $i.'ms; -webkit-animation-delay:'.$delay * $i.'ms; -moz-animation-delay:'.$delay * $i.'ms;-o-animation-delay:'.$delay * $i.'ms;"';	
		?>
			<div class="item">
            	<div class="image-testimonial-wrapper">
					<a href="#">
						<?php the_post_thumbnail( 'full', array('class' => 'et-post-thumbnail img-responsive','title'=> get_the_title()) ); ?>
					</a>
                </div>
			</div>
		<?php
			}//end while;
			echo '</div></div><!-- END AVATAR LIST -->';
			echo '<span class="quote-charater"></span>';
			echo '<div id="test_content" class="owl-carousel">';
			foreach ($contents as $value) {
				?>	
					<div class="item">
                    	
						<p><?php echo $value['content']; ?></p>
                        <span class="name-client"><?php echo $value['title']; ?></span>
					</div>
				<?php
			}
			echo '</div><!-- END CONTENT LIST -->';
		}
		wp_reset_query();
	}
 	function before_block($instance) {
		extract($instance);
		echo '<div class="testimonial-wrapper animation-wrapper '.$size.'" style="margin:'.$margin_top.'px 0 '.$margin_bottom.'px">';
	}

	function after_block($instance) {
 		extract($instance);
 		echo '</div><!-- END ET-BLOG-BLOCK-->';
	}

}

aq_register_block( 'OE_Testimonial_Block' );
endif;