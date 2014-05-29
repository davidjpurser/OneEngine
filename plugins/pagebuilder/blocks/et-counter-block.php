<?php
/**
 * This file control counter block
 *
 * @package    OneEngine
 * @package    EngineThemes
 */
 
// 	COUNTER BLOCK
if(!class_exists('OE_Counter_Block')) :

class OE_Counter_Block extends AQ_Block {
	
	function __construct() {
		$block_options = array(
			'name' => __('ET Counter', 'oneengine'),
			'size' => 'span12',
		);
		
		//create the widget
		parent::__construct('OE_Counter_Block', $block_options);
		
		//add ajax functions
		add_action('wp_ajax_aq_block_counter_add_new', array($this, 'add_counter'));
		
	}
	
	function form($instance) {
		
		$defaults = array(
			'counters' => array(
				1 => array(
					'title' 	=> __('Add new counter', 'oneengine'), 
					'from' 		=> '0', 
					'to' 		=> '100', 
					'speed' 	=> '4000',
					'interval' 	=> '50'
				)
			),
			'column' 		=> 'three',
			'margin_top' 	=> 10,
			'margin_bottom' => 10,
		);
		
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		$counter_columns = array(
			'two' 	=> 'Two Columns',
			'three' => 'Three Columns',
			'four' 	=> 'Four Columns',
		);	
			
		?>
		<p class="description">
			<label for="<?php echo $this->get_field_id('column') ?>">
				<?php _e('Column size', 'oneengine') ?>
				<?php echo aq_field_select('column', $block_id, $counter_columns, $column) ?>
			</label>
		</p>
		<p class="description">
			<label for="<?php echo $this->get_field_id('margin_top') ?>">
				<?php _e('Margin top', 'oneengine') ?>
				<?php echo aq_field_input('margin_top', $block_id, $margin_top, 'min', 'number') ?> px
			</label>&nbsp;-&nbsp;
			<label for="<?php echo $this->get_field_id('margin_bottom') ?>">
				<?php _e('Margin bottom', 'oneengine') ?>
				<?php echo aq_field_input('margin_bottom', $block_id, $margin_bottom, 'min', 'number') ?> px
			</label>
		</p>
		<div class="description cf">
			<ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
				<?php
				$counters = is_array($counters) ? $counters : $defaults['counters'];
				$count = 1;
				foreach($counters as $counter) {	
					$this->counter($counter, $count);
					$count++;
				}
				?>
			</ul>
			<p></p>
			<a href="#" rel="counter" class="aq-sortable-add-new button"><?php _e('Add New', 'oneengine') ?></a>
			<p></p>
		</div>
		<?php
	}

	function counter($counter = array(), $count = 0) {
		?>
		<li id="<?php echo $this->get_field_id('counters') ?>-sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">
			
			<div class="sortable-head cf">
				<div class="sortable-title">
					<strong><?php echo $counter['title'] ?></strong>
				</div>
				<div class="sortable-handle">
					<a href="#"><?php _e('Open / Close', 'oneengine') ?></a>
				</div>
			</div>
			
			<div class="sortable-body">
				<p class="counters-desc description">
					<label for="<?php echo $this->get_field_id('counters') ?>-<?php echo $count ?>-from">
						<?php _e('From (number)', 'oneengine') ?>
						<input type="number" id="<?php echo $this->get_field_id('counters') ?>-<?php echo $count ?>-from" class="input-min" name="<?php echo $this->get_field_name('counters') ?>[<?php echo $count ?>][from]" value="<?php echo $counter['from'] ?>" />
					</label>  
					<label for="<?php echo $this->get_field_id('counters') ?>-<?php echo $count ?>-to">
						<?php _e('To (number)', 'oneengine') ?>
						<input type="number" id="<?php echo $this->get_field_id('counters') ?>-<?php echo $count ?>-to" class="input-min" name="<?php echo $this->get_field_name('counters') ?>[<?php echo $count ?>][to]" value="<?php echo $counter['to'] ?>" />
					</label>
				</p>
				<p class="counters-desc description">
					<label for="<?php echo $this->get_field_id('counters') ?>-<?php echo $count ?>-speed">
						<?php _e('Speed', 'oneengine') ?>
						<input type="number" id="<?php echo $this->get_field_id('counters') ?>-<?php echo $count ?>-speed" class="input-min" name="<?php echo $this->get_field_name('counters') ?>[<?php echo $count ?>][speed]" value="<?php echo $counter['speed'] ?>" />
					</label>ms(Millisecond)&nbsp;-&nbsp; 
					<label for="<?php echo $this->get_field_id('counters') ?>-<?php echo $count ?>-interval">
						<?php _e('Refresh interval', 'oneengine') ?>
						<input type="number" id="<?php echo $this->get_field_id('counters') ?>-<?php echo $count ?>-interval" class="input-min" name="<?php echo $this->get_field_name('counters') ?>[<?php echo $count ?>][interval]" value="<?php echo $counter['interval'] ?>" />
					</label>
				</p>
				<p class="counter-desc description">
					<label for="<?php echo $this->get_field_id('counters') ?>-<?php echo $count ?>-title">
						<?php _e('Title', 'oneengine') ?><br/>
						<input type="text" id="<?php echo $this->get_field_id('counters') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('counters') ?>[<?php echo $count ?>][title]" value="<?php echo $counter['title'] ?>" />
					</label>
				</p> 
				<p class="counter-desc description"><a href="#" class="sortable-delete"><?php _e('Delete', 'oneengine') ?></a></p>
			</div>
			
		</li>
		<?php
	}
	
	function block($instance) {
		extract($instance);
		$i = 1;
		$output = '';
		$span = '';
		if($column == 'three') $span = 'col-md-4'; elseif($column == 'four') $span = 'col-md-3'; elseif($column == 'two') $span = 'col-md-6'; else $span= 'col-md-12';
		$output .='<div class="counter-wrapper" style="margin:'.$margin_top.'px 0 '.$margin_bottom.'px;">';
		foreach( $counters as $counter ){
			$output .= '<div class="counter '.$span.'">
				<span class="timer" data-from="'.$counter['from'].'" data-to="'.$counter['to'].'" data-speed="'.$counter['speed'].'" data-refresh-interval="'.$counter['interval'].'"></span>
				<span class="counter-title">' .htmlspecialchars_decode($counter['title']). '</span>
			</div>';
			if($i%2 == 0 && $i != sizeof($counters) && $span == 'col-md-6') $output .= '<div class="clear"></div>';
			if($i%3 == 0 && $i != sizeof($counters) && $span == 'col-md-4') $output .= '<div class="clear"></div>';	
			if($i%4 == 0 && $i != sizeof($counters) && $span == 'col-md-3') $output .= '<div class="clear"></div>';
			$i++;
		}
		$output .='</div>';
		echo $output;
	}
	
	/* AJAX add counter */
	function add_counter() {
		$nonce = $_POST['security'];	
		if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
		
		$count = isset($_POST['count']) ? absint($_POST['count']) : false;
		$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
		
		//default key/value for the counter
		$counter = array(
			'title' 	=> __('Add new counter','oneengine'), 
			'from' 		=> '0', 
			'to' 		=> '100', 
			'speed' 	=> '4000',
			'interval' 	=> '50'
		);
		
		if($count) {
			$this->counter($counter, $count);
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
		return;
	}

	function after_block($instance) {
 		extract($instance);
 		return;
	}
 	
}
aq_register_block( 'OE_Counter_Block' );
endif;