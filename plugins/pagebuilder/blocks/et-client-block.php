<?php
/**
 * This file control list block
 *
 * @package    OneEngine
 * @package    EngineThemes
 */
 
// LIST BLOCK
if(!class_exists('OE_List_Block')) :

class OE_List_Block extends AQ_Block {
	
	function __construct() {
		$block_options = array(
			'name' => 'ET Client',
			'size' => 'span12',
		);
		
		//create the widget
		parent::__construct('OE_List_Block', $block_options);
		
		//add ajax functions
		add_action('wp_ajax_aq_block_list_item_add_new', array($this, 'add_list_item'));
		
	}
	
	function form($instance) {
		
		$defaults = array(
			'list_items' => array(
				1 => array(
					'title' 	=> 'Add Name', 
					'src_img' 	=> '',
					'duration' 	=> '900',
					'delay' 	=> '0',
					'animation' => 'None',
				)
			),
			'column' 		=> 'six',
			'margin_top' 	=> 10,
			'margin_bottom' => 10,
		);
		$client_columns = array(
			'six' 	=> 'Six Columns',
			'four'	=> 'Four Columns',
			'three' => 'Three Columns',
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
					
		?>
        <p class="description">
			<label for="<?php echo $this->get_field_id('margin_top') ?>">
				Margin top 
				<?php echo aq_field_input('margin_top', $block_id, $margin_top, 'min', 'number') ?> px
			</label>&nbsp;-&nbsp;
			<label for="<?php echo $this->get_field_id('margin_bottom') ?>">
				Margin bottom
				<?php echo aq_field_input('margin_bottom', $block_id, $margin_bottom, 'min', 'number') ?> px
			</label>
		</p>
        <p class="description">
			<label for="<?php echo $this->get_field_id('column') ?>">
				<?php _e('Column size','oneengine' ); ?>
				<?php echo aq_field_select('column', $block_id, $client_columns, $column) ?>
			</label>
		</p>
		<div class="description cf">
			<ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
				<?php
				$list_items = is_array($list_items) ? $list_items : $defaults['list_items'];
				$count = 1;
				foreach($list_items as $list_item) {	
					$this->list_item($list_item, $count);
					$count++;
				}
				?>
			</ul>
			<p></p>
			<a href="#" rel="list_item" class="aq-sortable-add-new button">Add New</a>
			<p></p>
		</div>
		<?php
	}

	function list_item($list_item = array(), $count = 0) {
			global $include_animation;
		?>
		<li id="<?php echo $this->get_field_id('list_items') ?>-sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">
			
			<div class="sortable-head cf">
				<div class="sortable-title">
					<strong><?php echo $list_item['title'] ?></strong>
				</div>
				<div class="sortable-handle">
					<a href="#">Open / Close</a>
				</div>
			</div>
			
			<div class="sortable-body">
				<p class="list_item-desc description">
					<label for="<?php echo $this->get_field_id('list_items') ?>-<?php echo $count ?>-title">
						Client name<br/>
						<input type="text" id="<?php echo $this->get_field_id('list_items') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('list_items') ?>[<?php echo $count ?>][title]" value="<?php echo $list_item['title'] ?>" />
					</label>
				</p>
				<p class="list_item-desc  description">
					<label for="<?php echo $this->get_field_id('list_items') ?>-<?php echo $count ?>-src_img">
						Images
                        <input type="text" id="<?php echo $this->get_field_id('list_items') ?>-<?php echo $count ?>-src_img" class="input-full input-upload" value="<?php echo $list_item['src_img'] ?>" name="<?php echo $this->get_field_name('list_items') ?>[<?php echo $count ?>][src_img]">
						<a href="#" class="aq_upload_button button" rel="image">Upload</a><p></p>
					</label>
				</p>
				<p class="list_items-desc description">
					<label for="<?php echo $this->get_field_id('list_items') ?>-<?php echo $count ?>-animation">
						Animation style
						<?php echo aq_field_select_in($this->get_field_id('list_items').'-'.$count.'-animation', $this->get_field_name('list_items').'['.$count.'][animation]', $include_animation, $list_item['animation']) ?>
					</label>
			  </p>
			  <p class="list_items-desc description">
					<label for="<?php echo $this->get_field_id('list_items') ?>-<?php echo $count ?>-duration">
						Duration for animation
						<input type="number" id="<?php echo $this->get_field_id('list_items') ?>-<?php echo $count ?>-duration" class="input-min" name="<?php echo $this->get_field_name('list_items') ?>[<?php echo $count ?>][duration]" value="<?php echo $list_item['duration'] ?>" />
					</label>ms(Millisecond)&nbsp;-&nbsp;   
					<label for="<?php echo $this->get_field_id('list_items') ?>-<?php echo $count ?>-delay">
						Time Delay
						<input type="number" id="<?php echo $this->get_field_id('list_items') ?>-<?php echo $count ?>-delay" class="input-min" name="<?php echo $this->get_field_name('list_items') ?>[<?php echo $count ?>][delay]" value="<?php echo $list_item['delay'] ?>" />
					</label>ms(Millisecond)
				</p>
				<p class="list_item-desc description"><a href="#" class="sortable-delete">Delete</a></p>
			</div>
			
		</li>
		<?php
	}
	
	function block($instance) {
		extract($instance);
		$i = 1;
		$output = '';
		$span = '';
		if($column == 'three') $span = 'col-md-4'; elseif($column == 'four') $span = 'col-md-3'; elseif($column == 'six') $span = 'col-md-2'; else $span= 'span12';
		$output = '<div class="client-wrapper animation-wrapper" style="margin-top:'.$margin_top.'px; margin-bottom:'.$margin_bottom.'px;">';
		foreach( $list_items as $list_item ){
			$animation_effect ='';
			$duration_effect  ='';
			if($list_item['animation']) $animation_effect = 'animated '.$list_item['animation'].'';
			if($list_item['duration'] != '' && $list_item['animation'] != '') $duration_effect = 'style="-webkit-animation-duration: '.$list_item['duration'].'ms; -moz-animation-duration: '.$list_item['duration'].'ms; -o-animation-duration: '.$list_item['duration'].'ms;animation-duration: '.$list_item['duration'].'ms; animation-delay:'.$list_item['delay'].'ms; -webkit-animation-delay:'.$list_item['delay'].'ms; -moz-animation-delay:'.$list_item['delay'].'ms;-o-animation-delay:'.$list_item['delay'].'ms;"';
			$output .= '
				<div class="client-img '.$span.' '.$animation_effect.'" '.$duration_effect.'>
					<img src="'.$list_item['src_img'].'" alt="'.$list_item['title'].'">
				</div>
			';
			if($i%6 == 0 && $i != sizeof($list_items) && $span == 'col-md-2') $output .= '<div class="clear"></div>';
			if($i%3 == 0 && $i != sizeof($list_items) && $span == 'col-md-4') $output .= '<div class="clear"></div>';	
			if($i%4 == 0 && $i != sizeof($list_items) && $span == 'col-md-3') $output .= '<div class="clear"></div>';
			$i++;
		}
		$output .='</div>';
		echo $output;
	}
	
	/* AJAX add list_item */
	function add_list_item() {
		$nonce = $_POST['security'];	
		if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
		
		$count = isset($_POST['count']) ? absint($_POST['count']) : false;
		$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
		
		//default key/value for the list_item
		$list_item = array(
			'title' 	=> 'Add Name', 
			'src_img' 	=> '',
			'duration' 	=> '900',
			'delay' 	=> '0',
			'animation' => 'None',
		);
		
		if($count) {
			$this->list_item($list_item, $count);
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

aq_register_block( 'OE_List_Block' );

endif;