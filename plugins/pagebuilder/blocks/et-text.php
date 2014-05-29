<?php
/**
 * This file control clear block
 *
 * @package    OneEngine
 * @package    EngineThemes
 */

// TEXT BLOCK
if( ! class_exists( 'OE_Text_Block' ) ) :

class OE_Text_Block extends AQ_Block {

	function __construct() {
		$block_options = array(
			'name' => __( 'ET Text', 'oneengine'),
			'size' => 'span12',
		);
		
		//create the block
		parent::__construct('OE_Text_Block', $block_options);
	}

 	function form($instance) {
		
		$defaults = array(
			'text' 			=> '',
			'font_size' 	=> '18',
			'margin_top' 	=> '10',
			'margin_bottom' => '10',
			'duration' 		=> '900',
			'delay' 		=> '0',
			'animation' 	=> '',	
			'align' 		=> ''	
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		global $include_animation ;
		$text_align = array(
			'center' 	=> 'Center',
			'left' 		=> 'Left',
			'right' 	=> 'Right',
		);
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
            <label for="<?php echo $this->get_field_id('font_size') ?>">
                <?php _e('Font-size (Ex : 18px)', 'oneengine'); ?>
                <?php echo aq_field_input('font_size', $block_id, $font_size, 'min', 'number') ?> px
            </label>&nbsp;&nbsp; - &nbsp;
        </p>
        <p class="description">
            <label for="<?php echo $this->get_field_id('align') ?>">
                <?php _e('Text align', 'oneengine'); ?><br/>
                <?php echo aq_field_select('align', $block_id, $text_align , $align) ?>
            </label>
        </p>
        <div class="sortable-body">
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
        </div>
        <p class="description">
			<label for="<?php echo $this->get_field_id('text') ?>">
				<?php _e('Content', 'oneengine'); ?>
				<?php echo aq_field_textarea('text', $block_id, $text, $size = 'full') ?>
			</label>
		</p>			
		<?php
	}

	function block($instance) {
		extract($instance);
		$output='';
		$animation_effect ='';
		$duration_effect ='';
		if($animation) $animation_effect = 'animated '.$animation.'';
		if($duration && $animation != '') $duration_effect = '-webkit-animation-duration: '.$duration.'ms; -moz-animation-duration: '.$duration.'ms; -o-animation-duration: '.$duration.'ms;animation-duration: '.$duration.'ms; animation-delay:'.$delay.'ms; -webkit-animation-delay:'.$delay.'ms; -moz-animation-delay:'.$delay.'ms;-o-animation-delay:'.$delay.'ms;';
		
		$output .= '<div class="animation-wrapper">'; 
		$output .= do_shortcode(htmlspecialchars_decode('<p class="'.$animation_effect.'" style="font-size:'.$font_size.'px;margin-top:'.$margin_top.'px;margin-bottom:'.$margin_bottom.'px; text-align:'.$align.'; '.$duration_effect.'">'.$text.'</p>'));
		$output .= '</div>';
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

aq_register_block( 'OE_Text_Block' );
endif;