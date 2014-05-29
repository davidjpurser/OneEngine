<?php
/**
 * This file control clear block
 *
 * @package    OneEngine
 * @package    EngineThemes
 */

// CLEAR BLOCK
if( ! class_exists( 'OE_Clear_Block' ) ) :

class OE_Clear_Block extends AQ_Block {

	function __construct() {
		$block_options = array(
			'name' => __( 'ET Clear', 'oneengine'),
			'size' => 'span12',
		);
		
		//create the block
		parent::__construct('OE_Clear_Block', $block_options);
	}

 	function form($instance) {
		
		$defaults = array(
			'height' => '0',
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		?>
        <p class="description">
			<?php _e('* Note: height of Clear Block is equal to 0 when viewing on smart phone.', 'oneengine'); ?>
		</p>
		<p class="description">
			<label for="<?php echo $this->get_field_id('height') ?>">
				<?php _e('Height', 'oneengine'); ?>
				<?php echo aq_field_input('height', $block_id, $height, 'min', 'number') ?> px
			</label>
		</p>
        				
		<?php
	}

	function block($instance) {
		extract($instance);
		echo '<div class="clearfix" style="height:'.$height.'px"></div>';
		
	}
	
 	function before_block($instance) {
		extract($instance);
		return;
	}

	function after_block($instance) {
 		extract($instance);
 		return;
	}

}

aq_register_block( 'OE_Clear_Block' );
endif;