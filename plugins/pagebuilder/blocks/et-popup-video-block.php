<?php
/**
 * This file control popup video block
 *
 * @package    OneEngine
 * @package    EngineThemes
 */

// CLEAR BLOCK
if( ! class_exists( 'OE_Popup_Video_Block' ) ) :

class OE_Popup_Video_Block extends AQ_Block {

	function __construct() {
		$block_options = array(
			'name' => __( 'ET Popup Video', 'oneengine'),
			'size' => 'span12',
		);
		
		//create the block
		parent::__construct('OE_Popup_Video_Block', $block_options);
	}

 	function form($instance) {
		
		$defaults = array(
			'margin_top' 		=> '5',
			'margin_bottom' 	=> '5',
			'link' 				=> 'http://vimeo.com/92112616',
			'link_text' 		=> 'View this Video',
			'align' 			=> 'Align center',
			'animation' 		=> 'None',
			'duration' 			=> '900',
			'delay' 			=> '0',

		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		$button_align = array(
			'center'  => 'Align center',
			'left'    => 'Align left',
			'right'   => 'Align right'
		);
		
		global $include_animation;
		?>
        <p class="description">
			<label for="<?php echo $this->get_field_id('margin_top') ?>">
				<?php _e('Margin top', 'oneengine'); ?>
				<?php echo aq_field_input('margin_top', $block_id, $margin_top, 'min', 'number') ?> px
			</label>&nbsp;-&nbsp;
            <label for="<?php echo $this->get_field_id('margin_bottom') ?>">
				<?php _e('Margin bottom', 'oneengine'); ?>
				<?php echo aq_field_input('margin_bottom', $block_id, $margin_bottom, 'min', 'number') ?> px
			</label>&nbsp;-&nbsp;
		</p>
        
        <p class="description">
            <label for="<?php echo $this->get_field_id('animation') ?>">
                <?php _e('Animation style', 'oneengine'); ?><br/>
                <?php echo aq_field_select('animation', $block_id, $include_animation , $animation) ?>
            </label>
        </p>
        <p class="description">
            <label for="<?php echo $this->get_field_id('duration') ?>">
                <?php _e('Duration for Animation (Ex : 900ms)', 'oneengine'); ?>
                <?php echo aq_field_input('duration', $block_id, $duration, 'min', 'number') ?> ms
            </label>&nbsp;&nbsp; - &nbsp;
            <label for="<?php echo $this->get_field_id('delay') ?>">
               <?php _e('Time Delay (Ex : 900ms)', 'oneengine'); ?>
                <?php echo aq_field_input('delay', $block_id, $delay, 'min', 'number') ?> ms
            </label>
        </p>
        <p class="description">
            <label for="<?php echo $this->get_field_id('align') ?>">
                <?php _e('Text align', 'oneengine'); ?><br/>
                <?php echo aq_field_select('align', $block_id, $button_align, $align) ?>
            </label>
        </p>  
        <div class="sortable-body">
        	<p class="description">
                <label for="<?php echo $this->get_field_id('link_text') ?>">
                    <?php _e('Text', 'oneengine'); ?><br/>
                    <?php echo aq_field_input('link_text', $block_id, $link_text, $size = 'full') ?>
            	</label>
            </p>    
            <p class="description">
                <label for="<?php echo $this->get_field_id('link') ?>">
                    <?php _e('Link video ( support for Vimeo & Youtube )', 'oneengine'); ?><br/>
                    <?php echo aq_field_input('link', $block_id, $link, $size = 'full') ?>
                </label>
            </p>
        </div>      	
        			
		<?php
	}

	function block($instance) {
		extract($instance);
		
		$output='';
		$animation_effect ='';
		$duration_effect ='';
		if($animation) $animation_effect = 'animated '.$animation.'';
		if($duration && $animation != '') $duration_effect = 'style="-webkit-animation-duration: '.$duration.'ms; -moz-animation-duration: '.$duration.'ms; -o-animation-duration: '.$duration.'ms;animation-duration: '.$duration.'ms; animation-delay:'.$delay.'ms; -webkit-animation-delay:'.$delay.'ms; -moz-animation-delay:'.$delay.'ms;-o-animation-delay:'.$delay.'ms;"';
		
		$output .= '<p class="animation-wrapper" style="text-align:'.$align.'; margin:'.$margin_top.'px 0 '.$margin_bottom.'px"><a class="popup-video" href="'.$link.'"><span class="icon-play-video"><i class="fa fa-play"></i></span><br>'.htmlspecialchars_decode($link_text).'</a></p>';
		
		echo $output;
	}
	
 	function before_block($instance) {
		extract($instance);
		echo '<div class="'.$size.'">';
	}

	function after_block($instance) {
 		extract($instance);
 		echo '</div>';
	}


}

aq_register_block( 'OE_Popup_Video_Block' );
endif;