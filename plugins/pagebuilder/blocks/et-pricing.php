<?php
/**
 * This file control pricing 1 block
 *
 * @package    OneEngine
 * @package    EngineThemes
 */
 
// PRICING BLOCK
if(!class_exists('OE_Pricing_Block')) :

class OE_pricing_Block extends AQ_Block {

	function __construct() {
		$block_options = array(
			'name' => __( 'ET Pricing', 'oneengine'),
			'size' => 'span12',
		);
		
		//create the widget
		parent::__construct('OE_Pricing_Block', $block_options);
		
		//add ajax functions
		add_action('wp_ajax_aq_block_pricing_add_new', array($this, 'add_pricing'));
		
	}
	
	function form($instance) {
		$defaults = array(
			'pricings' => array(
				1 => array(
					'title' 		=> __('Basic <span>$9</span>/month', 'oneengine'),
					'left'  		=> '0',
					'right'  		=> '0',
					'option_1'  	=> '3G Space',
					'option_2'  	=> '4 Subdomain',
					'option_3'  	=> 'Unlimited Bandwidth',
					'option_4'  	=> 'Support 24/7',
					'content_link' 	=> 'sign up',
					'type_pricing' 	=> 'none',
					'duration' 		=> '900',
					'delay' 		=> '0',
					'animation' 	=> 'None',
				)
			),
			'margin_top' 	=> 10,
			'margin_bottom' => 10,
		);
		
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		?>
		<p class="description">
			<label for="<?php echo $this->get_field_id('margin_top') ?>">
				<?php _e('Margin top','oneengine' ); ?> 
				<?php echo aq_field_input('margin_top', $block_id, $margin_top, 'min', 'number') ?> px
			</label>&nbsp;-&nbsp;
			<label for="<?php echo $this->get_field_id('margin_bottom') ?>">
				<?php _e('Margin bottom','oneengine' ); ?>
				<?php echo aq_field_input('margin_bottom', $block_id, $margin_bottom, 'min', 'number') ?> px
			</label>
		</p>
		<div class="description cf">
			<ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
				<?php
				$pricings = is_array($pricings) ? $pricings : $defaults['pricings'];
				$count = 1;
				foreach($pricings as $pricing) {	
					$this->pricing($pricing, $count);
					$count++;
				}
				?>
			</ul>
			<p></p>
			<a href="#" rel="pricing" class="aq-sortable-add-new button">Add New</a>
			<p></p>
		</div>
		<?php
	}
	function pricing($pricing = array(), $count = 0) {
		
		global $include_animation ;
		$pricing_main = array(
			'' 	=> 'None',
			'main' 	=> 'Main Pricing',
		);
		?>
		<li id="<?php echo $this->get_field_id('pricings') ?>-sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">
			
			<div class="sortable-head cf">
				<div class="sortable-title">
					<strong><?php echo $pricing['title'] ?></strong>
				</div>
				<div class="sortable-handle">
					<a href="#"><?php _e('Open / Close','oneengine' ); ?></a>
				</div>
			</div>
			
			<div class="sortable-body">
            	<p class="pricing-desc description">
                    <label for="<?php echo $this->get_field_id('pricings') ?>-<?php echo $count ?>-left">
						<?php _e('Margin Left (default: 0 px)', 'oneengine' ); ?>
                        <input type="number" id="<?php echo $this->get_field_id('pricings') ?>-<?php echo $count ?>-left" class="input-min" name="<?php echo $this->get_field_name('pricings') ?>[<?php echo $count ?>][left]" value="<?php echo $pricing['left'] ?>" />
                    </label>px
					<label for="<?php echo $this->get_field_id('pricings') ?>-<?php echo $count ?>-right">
						<?php _e('Margin Right (default: 0 px)', 'oneengine' ); ?>
                        <input type="number" id="<?php echo $this->get_field_id('pricings') ?>-<?php echo $count ?>-right" class="input-min" name="<?php echo $this->get_field_name('pricings') ?>[<?php echo $count ?>][right]" value="<?php echo $pricing['right'] ?>" />
                    </label>px
				</p>
            	<p class="pricing-desc description">
                      <label for="<?php echo $this->get_field_id('pricings') ?>-<?php echo $count ?>-type_pricing">
                          <?php _e('Type pricing style ?','oneengine' ); ?>
                          <?php echo aq_field_select_in($this->get_field_id('pricings').'-'.$count.'-type_pricing', $this->get_field_name('pricings').'['.$count.'][type_pricing]', $pricing_main, $pricing['type_pricing']) ?>
                      </label>
                </p>
				<p class="pricing-desc description">
					<label for="<?php echo $this->get_field_id('pricings') ?>-<?php echo $count ?>-title">
						<?php _e('Title','oneengine' ); ?><br/>
						<input type="text" id="<?php echo $this->get_field_id('pricings') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('pricings') ?>[<?php echo $count ?>][title]" value="<?php echo $pricing['title'] ?>" />
					</label>
				</p>
				<p class="pricing-desc description">
					<label for="<?php echo $this->get_field_id('pricings') ?>-<?php echo $count ?>-option_1">
						<?php _e('Option 1','oneengine' ); ?><br/>
						<input type="text" id="<?php echo $this->get_field_id('pricings') ?>-<?php echo $count ?>-option_1" class="input-full" name="<?php echo $this->get_field_name('pricings') ?>[<?php echo $count ?>][option_1]" value="<?php echo $pricing['option_1'] ?>" />
					</label>
				</p>
                <p class="pricing-desc description">
					<label for="<?php echo $this->get_field_id('pricings') ?>-<?php echo $count ?>-option_2">
						<?php _e('Option 2','oneengine' ); ?><br/>
						<input type="text" id="<?php echo $this->get_field_id('pricings') ?>-<?php echo $count ?>-option_2" class="input-full" name="<?php echo $this->get_field_name('pricings') ?>[<?php echo $count ?>][option_2]" value="<?php echo $pricing['option_2'] ?>" />
					</label>
				</p>
                <p class="pricing-desc description">
					<label for="<?php echo $this->get_field_id('pricings') ?>-<?php echo $count ?>-option_3">
						<?php _e('Option 3','oneengine' ); ?><br/>
						<input type="text" id="<?php echo $this->get_field_id('pricings') ?>-<?php echo $count ?>-option_3" class="input-full" name="<?php echo $this->get_field_name('pricings') ?>[<?php echo $count ?>][option_3]" value="<?php echo $pricing['option_3'] ?>" />
					</label>
				</p>
                <p class="pricing-desc description">
					<label for="<?php echo $this->get_field_id('pricings') ?>-<?php echo $count ?>-option_4">
						<?php _e('Option 4','oneengine' ); ?><br/>
						<input type="text" id="<?php echo $this->get_field_id('pricings') ?>-<?php echo $count ?>-option_4" class="input-full" name="<?php echo $this->get_field_name('pricings') ?>[<?php echo $count ?>][option_4]" value="<?php echo $pricing['option_4'] ?>" />
					</label>
				</p>
                <p class="pricing-desc description">
                    <label for="<?php echo $this->get_field_id('pricings') ?>-<?php echo $count ?>-content_link">
                        <?php _e('Text button (ex: "sign up")','oneengine' ); ?><br/>
                        <input type="text" id="<?php echo $this->get_field_id('pricings') ?>-<?php echo $count ?>-content_link" class="input-full" name="<?php echo $this->get_field_name('pricings') ?>[<?php echo $count ?>][content_link]" value="<?php echo $pricing['content_link'] ?>" />
                    </label>
                </p>
                <p class="pricing-desc description">
                      <label for="<?php echo $this->get_field_id('pricings') ?>-<?php echo $count ?>-animation">
                          <?php _e('Animation style','oneengine' ); ?>
                          <?php echo aq_field_select_in($this->get_field_id('pricings').'-'.$count.'-animation', $this->get_field_name('pricings').'['.$count.'][animation]', $include_animation, $pricing['animation']) ?>
                      </label>
                </p>
                <p class="pricing-desc description">
                      <label for="<?php echo $this->get_field_id('pricings') ?>-<?php echo $count ?>-duration">
                          <?php _e('Duration for animation','oneengine' ); ?>
                          <input type="number" id="<?php echo $this->get_field_id('pricings') ?>-<?php echo $count ?>-duration" class="input-min" name="<?php echo $this->get_field_name('pricings') ?>[<?php echo $count ?>][duration]" value="<?php echo $pricing['duration'] ?>" />
                      </label>ms(Millisecond)&nbsp;-&nbsp;   
                      <label for="<?php echo $this->get_field_id('pricings') ?>-<?php echo $count ?>-delay">
                          <?php _e('Time Delay', 'oneengine' ); ?>
                          <input type="number" id="<?php echo $this->get_field_id('pricings') ?>-<?php echo $count ?>-delay" class="input-min" name="<?php echo $this->get_field_name('pricings') ?>[<?php echo $count ?>][delay]" value="<?php echo $pricing['delay'] ?>" />
                      </label>ms(Millisecond)
                </p>
                
				<p class="pricing-desc description"><a href="#" class="sortable-delete"><?php _e('Delete','oneengine' ); ?></a></p>
			</div>
			
		</li>
		<?php
	}
	
	function block($instance) {
		extract($instance);
		$output = '';

		foreach( $pricings as $pricing ){
			$animation_effect ='';
			$duration_effect  ='';
			if($pricing['animation']) $animation_effect = 'animated '.$pricing['animation'].'';
			if($pricing['duration'] != '' && $pricing['animation'] != '') $duration_effect = 'style="-webkit-animation-duration: '.$pricing['duration'].'ms; -moz-animation-duration: '.$pricing['duration'].'ms; -o-animation-duration: '.$pricing['duration'].'ms;animation-duration: '.$pricing['duration'].'ms; animation-delay:'.$pricing['delay'].'ms; -webkit-animation-delay:'.$pricing['delay'].'ms; -moz-animation-delay:'.$pricing['delay'].'ms;-o-animation-delay:'.$pricing['delay'].'ms;"';
			
			$type = '';
			$porpular = '' ;
			if($pricing['type_pricing'] != ''){
				 $type ='main-pricing';
				 $porpular = __('<span class="popular">POPULAR</span>', 'oneengine');
			}
			
			$pricing['left']  = ( ! empty ( $pricing['left'] ) ) ? 'left:'. (int)$pricing['left'] .'px;': '';
			$pricing['right'] = ( ! empty ( $pricing['right'] ) ) ? 'right:'. (int) $pricing['right'] .'px;': '';
			
			/** Style position */
			$style_wrapper = ( 
				! empty( $pricing['left'] ) ||
				! empty( $pricing['right'] ) ) ? 
					sprintf( '%s %s', $pricing['left'], $pricing['right']) : '';
			$css_wrapper= '';
			if ( ! empty( $style_wrapper ) ) {			
				$css_wrapper= 'style="'. $style_wrapper .'" ';
			}
			
			$output .='
				<div class="col-md-4 '.$animation_effect.'" '.$duration_effect.'>
					<div class="pricing-wrapper '.$type.'" '.$css_wrapper.'>
						'.$porpular.'
						<h2 class="pricing-title">'.htmlspecialchars_decode($pricing['title']).'</h2>
						<ul class="pricing-list-option">
							<li><span>'.$pricing['option_1'].'</span></li>
							<li><span>'.$pricing['option_2'].'</span></li>
							<li><span>'.$pricing['option_3'].'</span></li>
							<li><span>'.$pricing['option_4'].'</span></li>
						</ul>
						<a href="#" class="pricing-sign-up">'.$pricing['content_link'].'</a>
					</div>
				</div>
			';
		}
		echo $output;
		echo '<div class="clearfix"></div>';
		
	}
	
	/* AJAX add pricing */
	function add_pricing() {
		$nonce = $_POST['security'];	
		if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
		
		$count = isset($_POST['count']) ? absint($_POST['count']) : false;
		$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
		
		//default key/value for the pricing
		$pricing = array(
			'title' 		=> __('Basic <span>$9</span>/month', 'oneengine'),
			'left'  		=> '0',
			'right'  		=> '0',
			'option_1'  	=> '3G Space',
			'option_2'  	=> '4 Subdomain',
			'option_3'  	=> 'Unlimited Bandwidth',
			'option_4'  	=> 'Support 24/7',
			'content_link' 	=> 'sign up',
			'type_pricing' 	=> 'none',
			'duration' 		=> '900',
			'delay' 		=> '0',
			'animation' 	=> 'None',
		);
		
		if($count) {
			$this->pricing($pricing, $count);
		} else {
			die(-1);
		}
		
		die();
	}
	
	function update($new_instance, $old_instance) {
		$new_instance = aq_recursive_sanitize($new_instance);
		return $new_instance;
	}

	function before_block($instance) {
		extract($instance);
		echo '<div class="list-pricings-wrapper animation-wrapper" style="margin:'.$margin_top.'px 0 '.$margin_bottom.'px;">';
	}

	function after_block($instance) {
 		extract($instance);
 		echo '</div><!-- END ET-PRICING-BLOCK -->';
	}
 	
}

aq_register_block( 'OE_pricing_Block' );

endif;