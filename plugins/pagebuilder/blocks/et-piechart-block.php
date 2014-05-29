<?php
/**
 * This file control piechart block
 *
 * @package    OneEngine
 * @package    EngineThemes
 */
 
// PIECHART BLOCK
if(!class_exists('OE_Piechart_Block')) :

class OE_Piechart_Block extends AQ_Block {
	
	function __construct() {
		$block_options = array(
			'name' => __('ET Piechart', 'oneengine'),
			'size' => 'span12',
		);
		
		//create the widget
		parent::__construct('OE_Piechart_Block', $block_options);
		
		//add ajax functions
		add_action('wp_ajax_aq_block_piechart_add_new', array($this, 'add_piechart'));
		
	}
	
	function form($instance) {
		
		$defaults = array(
			'piecharts' => array(
				1 => array(
					'title' 	=> 'Add new piechart',
					'percent' 	=> '100', 
					'easing' 	=> 'easeOutExpo', 
					'animate' 	=> '4000', 
					'cap' 		=> 'square',
					'width' 	=> '5', 
					'track' 	=> '#ecf0f1', 
					'bar' 		=> '#5ac3bc', 
				)
			),
			'column' 		=> 'three',
			'margin_top' 	=> 10,
			'margin_bottom' => 10,
		);
		
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		$pie_columns = array(
			'two' 	=> 'Two Columns',
			'three' => 'Three Columns',
			'four' 	=> 'Four Columns',
		);	
			
		?>
		<p class="description">
			<label for="<?php echo $this->get_field_id('column') ?>">
				<?php _e('Column size', 'oneengine');?> 
				<?php echo aq_field_select('column', $block_id, $pie_columns, $column) ?>
			</label>
		</p>
		<p class="description">
			<label for="<?php echo $this->get_field_id('margin_top') ?>">
				<?php _e('Margin top', 'oneengine');?>  
				<?php echo aq_field_input('margin_top', $block_id, $margin_top, 'min', 'number') ?> px
			</label>&nbsp;-&nbsp;
			<label for="<?php echo $this->get_field_id('margin_bottom') ?>">
				<?php _e('Margin bottom', 'oneengine');?> 
				<?php echo aq_field_input('margin_bottom', $block_id, $margin_bottom, 'min', 'number') ?> px
			</label>
		</p>
		<div class="description cf">
			<ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
				<?php
				$piecharts = is_array($piecharts) ? $piecharts : $defaults['piecharts'];
				$count = 1;
				foreach($piecharts as $piechart) {	
					$this->piechart($piechart, $count);
					$count++;
				}
				?>
			</ul>
			<p></p>
			<a href="#" rel="piechart" class="aq-sortable-add-new button">Add New</a>
			<p></p>
		</div>
		<?php
	}

	function piechart($piechart = array(), $count = 0) {
			global $include_easing;
			$pie_type = array(
				'square' => 'Square',
				'butt' => 'Butt',
				'round' => 'Round',
			);
		?>
		<li id="<?php echo $this->get_field_id('piecharts') ?>-sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">
			
			<div class="sortable-head cf">
				<div class="sortable-title">
					<strong><?php echo $piechart['title'] ?></strong>
				</div>
				<div class="sortable-handle">
					<a href="#"><?php _e('Open / Close', 'oneengine');?> </a>
				</div>
			</div>
			
			<div class="sortable-body">
				<p class="piecharts-desc description">
					<label for="<?php echo $this->get_field_id('piecharts') ?>-<?php echo $count ?>-animate">
						<?php _e('Duration', 'oneengine');?> 
						<input type="number" id="<?php echo $this->get_field_id('piecharts') ?>-<?php echo $count ?>-animate" class="input-min" name="<?php echo $this->get_field_name('piecharts') ?>[<?php echo $count ?>][animate]" value="<?php echo $piechart['animate'] ?>" />
					</label>ms(Millisecond)&nbsp;-&nbsp;   
					<label for="<?php echo $this->get_field_id('piecharts') ?>-<?php echo $count ?>-percent">
						<?php _e('Percent (maximum is 100%)', 'oneengine');?> 
						<input type="number" id="<?php echo $this->get_field_id('piecharts') ?>-<?php echo $count ?>-percent" class="input-min" name="<?php echo $this->get_field_name('piecharts') ?>[<?php echo $count ?>][percent]" value="<?php echo $piechart['percent'] ?>" />
					</label>(%)
				</p>
				<p class="piecharts-desc description">
					<label for="<?php echo $this->get_field_id('piecharts') ?>-<?php echo $count ?>-width">
						<?php _e('Line Width', 'oneengine');?> 
						<input type="number" id="<?php echo $this->get_field_id('piecharts') ?>-<?php echo $count ?>-width" class="input-min" name="<?php echo $this->get_field_name('piecharts') ?>[<?php echo $count ?>][width]" value="<?php echo $piechart['width'] ?>" />
					</label>px(pixel)&nbsp;-&nbsp;   
				</p>
				<p class="piecharts-desc description">
					<label for="<?php echo $this->get_field_id('piecharts') ?>-<?php echo $count ?>-cap">
						<?php _e('Type chart', 'oneengine');?> 
						<?php echo aq_field_select_in($this->get_field_id('piecharts').'-'.$count.'-cap', $this->get_field_name('piecharts').'['.$count.'][cap]', $pie_type, $piechart['cap']) ?>
					</label>
				</p>
				<p class="piecharts-desc description">
					<label for="<?php echo $this->get_field_id('piecharts') ?>-<?php echo $count ?>-easing">
						<?php _e('Animation style', 'oneengine');?> 
						<?php echo aq_field_select_in($this->get_field_id('piecharts').'-'.$count.'-easing', $this->get_field_name('piecharts').'['.$count.'][easing]', $include_easing, $piechart['easing']) ?>
					</label>
				</p>
				<p class="piecharts-desc description">
					<label for="<?php echo $this->get_field_id('piecharts') ?>-<?php echo $count ?>-bar">
						<?php _e('Bar color', 'oneengine');?> 
						<div class="aqpb-color-picker">
							<input type="text" id="<?php echo $this->get_field_id('piecharts') ?>-<?php echo $count ?>-bar" class="input-color-picker" value="<?php echo $piechart['bar'] ?>" name="<?php echo $this->get_field_name('piecharts') ?>[<?php echo $count ?>][bar]" data-default-color="<?php echo $piechart['bar'] ?>"/>
						</div>
					</label>
				</p>
				<p class="piecharts-desc description">
					<label for="<?php echo $this->get_field_id('piecharts') ?>-<?php echo $count ?>-track">
						<?php _e('Track color', 'oneengine');?> 
						<div class="aqpb-color-picker">
							<input type="text" id="<?php echo $this->get_field_id('piecharts') ?>-<?php echo $count ?>-track" class="input-color-picker" value="<?php echo $piechart['track'] ?>" name="<?php echo $this->get_field_name('piecharts') ?>[<?php echo $count ?>][track]" data-default-color="<?php echo $piechart['track'] ?>"/>
						</div>
					</label>
				</p>
				<p class="piechart-desc description">
					<label for="<?php echo $this->get_field_id('piecharts') ?>-<?php echo $count ?>-title">
						<?php _e('Title', 'oneengine');?> <br/>
						<input type="text" id="<?php echo $this->get_field_id('piecharts') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('piecharts') ?>[<?php echo $count ?>][title]" value="<?php echo $piechart['title'] ?>" />
					</label>
				</p>
				
				<p class="piechart-desc description"><a href="#" class="sortable-delete"><?php _e('Delete', 'oneengine');?></a></p>
			</div>
			
		</li>
		<?php
	}
	
	function block($instance) {
		extract($instance);
		$i = 1;
		$output = '';
		foreach( $piecharts as $piechart ){
			$span = '';
			if($column == 'three') $span = 'col-md-4'; elseif($column == 'four') $span = 'col-md-3'; elseif($column == 'two') $span = 'col-md-6'; else $span= 'col-md-12';
			$output .= '<div class="pie-column '.$span.'">
	<span class="chart" data-percent="'.$piechart['percent'].'" data-easing="'.$piechart['easing'].'" data-animate="'.$piechart['animate'].'" data-line-cap="'.$piechart['cap'].'" data-line-width="'.$piechart['width'].'" data-track-color="'.$piechart['track'].'" data-bar-color="'.$piechart['bar'].'" style="width:150px;height:150px">
					<span class="percent-chart" style="line-height:150px;"></span></span>
					<div class="pie-content">
						<h2>' .htmlspecialchars_decode($piechart['title']). '</h2>
					</div>
			</div>';
			if($i%3 == 0 && $i != sizeof($piecharts) && $span == 'col-md-4') $output .= '<div class="clear"></div>';	
			if($i%4 == 0 && $i != sizeof($piecharts) && $span == 'col-md-3') $output .= '<div class="clear"></div>';
			if($i%6 == 0 && $i != sizeof($piecharts) && $span == 'col-md-2') $output .= '<div class="clear"></div>';
			$i++;
		}
		echo $output;
	}
	
	/* AJAX add piechart */
	function add_piechart() {
		$nonce = $_POST['security'];	
		if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
		
		$count = isset($_POST['count']) ? absint($_POST['count']) : false;
		$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
		
		//default key/value for the piechart
		$piechart = array(
			'title' 	=> 'Add new piechart',
			'percent' 	=> '100', 
			'easing' 	=> 'easeOutExpo', 
			'animate' 	=> '4000', 
			'cap' 		=> 'square',
			'width' 	=> '5', 
			'track' 	=> '#ecf0f1', 
			'bar' 		=> '#5ac3bc', 
		);
		
		if($count) {
			$this->piechart($piechart, $count);
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
		echo '<div class="pie-wrapper" style="margin:'.$margin_top.'px 0 '.$margin_bottom.'px;">';
	}

	function after_block($instance) {
 		extract($instance);
 		echo '</div>';
	}
 	
}

aq_register_block( 'OE_Piechart_Block' );

endif;