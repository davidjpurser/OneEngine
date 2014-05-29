<?php
/**
 * This file control blog block
 *
 * @package    OneEngine
 * @package    EngineThemes
 */

// CLEAR BLOCK
if( ! class_exists( 'OE_Blog_Block' ) ) :

class OE_Blog_Block extends AQ_Block {

	function __construct() {
		$block_options = array(
			'name' => __( 'ET Blog', 'oneengine'),
			'size' => 'span12',
		);
		
		//create the block
		parent::__construct('OE_Blog_Block', $block_options);
	}

 	function form($instance) {
		
		$defaults = array(
			'quantity' 		=> '2',
			'margin_top' 	=> 10,
			'margin_bottom' => 10,
			'animation' 	=> 'none',
			'animation' 	=> 'None',
			'duration' 		=> '900',
			'delay' 		=> '0',
			'show' 			=> '1',
			'link'			=> '#'
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		global $include_animation ;
		?>
        <p class="description">
			<?php _e('* Note: This block will display 2 latest posts every row','oneengine'); ?>
		</p>		
        <p class="description">
            <label for="<?php echo $this->get_field_id('margin_top') ?>">
                <?php _e('Margin top', 'oneengine');?> 
                <?php echo aq_field_input('margin_top', $block_id, $margin_top, 'min', 'number') ?> px
            </label>&nbsp;-&nbsp;
            <label for="<?php echo $this->get_field_id('margin_bottom') ?>">
                <?php _e('Margin bottom', 'oneengine');?>
                <?php echo aq_field_input('margin_bottom', $block_id, $margin_bottom, 'min', 'number') ?> px
            </label>&nbsp;-&nbsp;
            <label for="<?php echo $this->get_field_id('quantity') ?>">
				<?php _e('Quantity of post','oneengine'); ?>
				<?php echo aq_field_input('quantity', $block_id, $quantity, 'min', 'number') ?>
			</label>
        </p>
        <p class="description">
			<label for="<?php echo $this->get_field_id('show') ?>">
				<?php _e( 'Show button "View all Blog" ?', 'oneengine');?>
				<?php echo aq_field_checkbox('show', $block_id, $show) ?>
			</label>
		</p>
        <p class="description">
			<label for="<?php echo $this->get_field_id('link') ?>">
				<?php _e( 'Link to blog of button "View all Blog"', 'oneengine');?>
				<?php echo aq_field_input('link', $block_id, $link, $size = 'large') ?>
			</label>
		</p>
        <p class="description">
            <label for="<?php echo $this->get_field_id('animation') ?>">
                <?php _e( 'Animation style', 'oneengine');?><br/>
                <?php echo aq_field_select('animation', $block_id, $include_animation , $animation) ?>
            </label>
        </p>
        <p class="description">
            <label for="<?php echo $this->get_field_id('duration') ?>">
                <?php _e( 'Duration for Animation (Ex : 300ms)', 'oneengine');?>
                <?php echo aq_field_input('duration', $block_id, $duration, 'min', 'number') ?> ms
            </label>&nbsp;&nbsp; - &nbsp;
            <label for="<?php echo $this->get_field_id('delay') ?>">
                <?php _e( 'Time Delay (Ex : 900ms)', 'oneengine');?>
                <?php echo aq_field_input('delay', $block_id, $delay, 'min', 'number') ?> ms
            </label>
        </p>
		<?php
	}

	function block($instance) {
		extract($instance);
		$query = new WP_Query(array(
			'post_type' 	 => 'post',
			'posts_per_page' => $quantity
		));
		$i = 0;
		global $post;
		if($query->have_posts()){
			while($query->have_posts()){
				$query->the_post();
			
			$animation_effect 	='';
			$duration_effect  	='';
			if($animation) $animation_effect = 'animated '.$animation.'';
			if($duration != '' && $animation != '') $duration_effect = 'style="-webkit-animation-duration: '.$duration.'ms; -moz-animation-duration: '.$duration.'ms; -o-animation-duration: '.$duration.'ms;animation-duration: '.$duration.'ms; animation-delay:'.$delay * $i.'ms; -webkit-animation-delay:'.$delay * $i.'ms; -moz-animation-delay:'.$delay * $i.'ms;-o-animation-delay:'.$delay * $i.'ms;"';	
		?>
			<div class="col-md-6 et-blog-post  <?php echo $animation_effect ?>" <?php echo $duration_effect ?>>
            	<div class="image-blog-wrapper">
					<?php the_post_thumbnail( 'full', array('class' => 'et-post-thumbnail img-responsive') ); ?>
                    <div class="et-post-data-left mobile-blog">
                        <span class="et-post-month"><?php the_time('M');?></span>
                        <span class="et-post-date"><?php the_time('d');?></span>
                        <a href="#" data-id="<?php echo $post->ID; ?>" class="et-like-post <?php echo is_like_post($post->ID); ?>">
                            <span class="et-post-heart"><i class="fa fa-heart"></i><span class="count"><?php echo get_post_meta($post->ID, 'et_like_count', true) ? get_post_meta($post->ID, 'et_like_count', true) : 0; ?></span></span>
                        </a>
                    </div>
                </div>
				<div class="clearfix"></div>
				<div class="et-post-data container">
					<div class="row">
						<div class="col-md-2 col-sm-2 et-post-data-left">
							<span class="et-post-month"><?php the_time('M');?></span>
							<span class="et-post-date"><?php the_time('d');?></span>
							<a href="#" data-id="<?php echo $post->ID; ?>" class="et-like-post <?php echo is_like_post($post->ID); ?>">
								<span class="et-post-heart"><i class="fa fa-heart"></i><span class="count"><?php echo get_post_meta($post->ID, 'et_like_count', true) ? get_post_meta($post->ID, 'et_like_count', true) : 0; ?></span></span>
							</a>
						</div>
						<div class="col-md-10 col-sm-10 et-post-data-right">
							<h1 class="title-blog"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
							<div class="et-post-info">
								<?php _e('Post by','oneengine'); ?> <?php the_author(); ?> | <?php the_category(); ?> | <?php comments_number( 'No Comments', 'One Comment', '% Comments' ); ?> 
							</div>
							<div class="clearfix"></div>
							<div class="et-post-excerpt">
								<?php the_excerpt() ?>
							</div>
							<div class="clearfix"></div>
							<a href="<?php the_permalink(); ?>" class="read-more"><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;Read more</a>
						</div>
					</div>
				</div>
			</div>
		<?php
			$i++;
			if($i % 2 == 0) echo '<div class="clearfix"></div>';
			}
		}
		wp_reset_query();
	}
 	function before_block($instance) {
		extract($instance);
		echo 	'<div class="blog-wrapper animation-wrapper '.$size.'" style="margin:'.$margin_top.'px 0 '.$margin_bottom.'px">';
		echo 		'<div class="row">';
	}

	function after_block($instance) {
 		extract($instance);
		$show_btn='';
		if($show == 1 || $show == 'true') $show_btn = '<div class="view-all-blog-wrapper"><a href="'.$link.'" class="view-all-blog"><span><i class="fa fa-plus"></i></span>View All Blog</a></div>';
		echo 		'<div class="clearfix"></div>';
		echo 		$show_btn;
 		echo 		'</div>';
 		echo '</div><!-- END ET-BLOG-BLOCK-->';
	}

}

aq_register_block( 'OE_Blog_Block' );
endif;