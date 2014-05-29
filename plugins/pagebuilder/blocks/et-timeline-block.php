<?php
/**
 * This file control timeline block
 *
 * @package    OneEngine
 * @package    EngineThemes
 */
 
// TIMELINE BLOCK
if(!class_exists('OE_Timeline_Block')) :

class OE_Timeline_Block extends AQ_Block {

	function __construct() {
		$block_options = array(
			'name' => __( 'ET About', 'oneengine'),
			'size' => 'span12',
		);
		
		//create the widget
		parent::__construct('OE_Timeline_Block', $block_options);
		
		//add ajax functions
		add_action('wp_ajax_aq_block_timeline_add_new', array($this, 'add_timeline'));
		
	}
	
	function form($instance) {
		
		$defaults = array(
			'timelines' => array(
				1 => array(
					'title' 	=> 'Add New',
					'src_img' 	=> '',
					'year' 		=> '2013',
					'content'	=> '',
					'duration' 	=> '900',
					'delay' 	=> '0',
					'animation' => 'None',
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
				Margin top 
				<?php echo aq_field_input('margin_top', $block_id, $margin_top, 'min', 'number') ?> px
			</label>&nbsp;-&nbsp;
			<label for="<?php echo $this->get_field_id('margin_bottom') ?>">
				Margin bottom
				<?php echo aq_field_input('margin_bottom', $block_id, $margin_bottom, 'min', 'number') ?> px
			</label>
		</p>
		<div class="description cf">
			<ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
				<?php
				$timelines = is_array($timelines) ? $timelines : $defaults['timelines'];
				$count = 1;
				foreach($timelines as $timeline) {	
					$this->timeline($timeline, $count);
					$count++;
				}
				?>
			</ul>
			<p></p>
			<a href="#" rel="timeline" class="aq-sortable-add-new button">Add New</a>
			<p></p>
		</div>
		<?php
	}

	function timeline($timeline = array(), $count = 0) {		
		global $include_animation ;
		?>
		<li id="<?php echo $this->get_field_id('timelines') ?>-sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">
			
			<div class="sortable-head cf">
				<div class="sortable-title">
					<strong><?php echo $timeline['title'] ?></strong>
				</div>
				<div class="sortable-handle">
					<a href="#">Open / Close</a>
				</div>
			</div>
			
			<div class="sortable-body">
				<p class="timeline-desc description">
					<label for="<?php echo $this->get_field_id('timelines') ?>-<?php echo $count ?>-year">
						Year
						<input type="number" id="<?php echo $this->get_field_id('timelines') ?>-<?php echo $count ?>-year" class="input-min" name="<?php echo $this->get_field_name('timelines') ?>[<?php echo $count ?>][year]" value="<?php echo $timeline['year'] ?>" />
					</label>
				</p>
                <p class="timeline-desc description">
					<label for="<?php echo $this->get_field_id('timelines') ?>-<?php echo $count ?>-src_img">
						Images
                        <input type="text" id="<?php echo $this->get_field_id('timelines') ?>-<?php echo $count ?>-src_img" class="input-full input-upload" value="<?php echo $timeline['src_img'] ?>" name="<?php echo $this->get_field_name('timelines') ?>[<?php echo $count ?>][src_img]">
						<a href="#" class="aq_upload_button button" rel="image">Upload</a><p></p>
					</label>
				</p>
				<p class="timeline-desc description">
					<label for="<?php echo $this->get_field_id('timelines') ?>-<?php echo $count ?>-title">
						Title<br/>
						<input type="text" id="<?php echo $this->get_field_id('timelines') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('timelines') ?>[<?php echo $count ?>][title]" value="<?php echo $timeline['title'] ?>" />
					</label>
				</p>
				<p class="timeline-desc description">
					<label for="<?php echo $this->get_field_id('timelines') ?>-<?php echo $count ?>-content">
						Content<br/>
						<textarea id="<?php echo $this->get_field_id('timelines') ?>-<?php echo $count ?>-content" class="textarea-full" name="<?php echo $this->get_field_name('timelines') ?>[<?php echo $count ?>][content]" rows="5"><?php echo $timeline['content'] ?></textarea>
					</label>
				</p>
				<p class="timeline-desc description">
                      <label for="<?php echo $this->get_field_id('timelines') ?>-<?php echo $count ?>-animation">
                          Animation style
                          <?php echo aq_field_select_in($this->get_field_id('timelines').'-'.$count.'-animation', $this->get_field_name('timelines').'['.$count.'][animation]', $include_animation, $timeline['animation']) ?>
                      </label>
                </p>
                <p class="timeline-desc description">
                      <label for="<?php echo $this->get_field_id('timelines') ?>-<?php echo $count ?>-duration">
                          Duration for animation
                          <input type="number" id="<?php echo $this->get_field_id('timelines') ?>-<?php echo $count ?>-duration" class="input-min" name="<?php echo $this->get_field_name('timelines') ?>[<?php echo $count ?>][duration]" value="<?php echo $timeline['duration'] ?>" />
                      </label>ms(Millisecond)&nbsp;-&nbsp;   
                      <label for="<?php echo $this->get_field_id('timelines') ?>-<?php echo $count ?>-delay">
                          Time Delay
                          <input type="number" id="<?php echo $this->get_field_id('timelines') ?>-<?php echo $count ?>-delay" class="input-min" name="<?php echo $this->get_field_name('timelines') ?>[<?php echo $count ?>][delay]" value="<?php echo $timeline['delay'] ?>" />
                      </label>ms(Millisecond)
                </p>
				<p class="timeline-desc description"><a href="#" class="sortable-delete">Delete</a></p>
			</div>
			
		</li>
		<?php
	}
	
	function block($instance) {
		extract($instance);
		$output = '<ul class="timeline-wrapper" style="margin-top:'.$margin_top.'px; margin-bottom:'.$margin_bottom.'px;">';
		foreach( $timelines as $timeline ){
			$link_img = '';
			$color_white ='';
			$maks_black = '';
			if($timeline['src_img']){
				$link_img 	 = 'style="background: url('.$timeline['src_img'].') no-repeat center center; width:100%; height:365px; background-size:cover;padding-top: 90px;"';
				$color_white = 'class="time-line-color-white"';
				$maks_black  = '<div class="maks-black"></div>';
			}
			
			$animation_effect ='';
			$duration_effect  ='';
			if($timeline['animation']) $animation_effect = 'animated '.$timeline['animation'].'';
			if($timeline['duration'] != '' && $timeline['animation'] != '') $duration_effect = 'style="-webkit-animation-duration: '.$timeline['duration'].'ms; -moz-animation-duration: '.$timeline['duration'].'ms; -o-animation-duration: '.$timeline['duration'].'ms;animation-duration: '.$timeline['duration'].'ms; animation-delay:'.$timeline['delay'].'ms; -webkit-animation-delay:'.$timeline['delay'].'ms; -moz-animation-delay:'.$timeline['delay'].'ms;-o-animation-delay:'.$timeline['delay'].'ms;"';
			
			$output  .= '
				<li>
					<div class="detail-warpper '.$animation_effect.'" '.$duration_effect.'>
						<div class="line-wrapper">
							<span class="line-horizal"></span>
							<span class="line-vertical"></span>
							<span class="line-circle">'.$timeline['year'].'</span>
						</div>
						<div class="text-wrapper" '.$link_img.'>
							<div class="detail">
								<h2 '.$color_white.'>'.$timeline['title'].'</h2>
								<p '.$color_white.'>'.$timeline['content'].'</p>
							</div>
							'.$maks_black.'
						</div>
					</div>
				</li>
			';
		}
		$output .= '</ul>';
		echo $output;
	}
	
	/* AJAX add timeline */
	function add_timeline() {
		$nonce = $_POST['security'];	
		if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
		
		$count = isset($_POST['count']) ? absint($_POST['count']) : false;
		$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
		
		//default key/value for the timeline
		$timeline = array(
			'title' 	=> 'Add New',
			'src_img' 	=> '',
			'year' 		=> '2013',
			'content'	=> '',
			'duration' 	=> '900',
			'delay' 	=> '0',
			'animation' => 'None'
		);
		
		if($count) {
			$this->timeline($timeline, $count);
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
		echo '<div class="animation-wrapper col-md-12" style="margin:'.$margin_top.'px 0 '.$margin_bottom.'px;" >';	
	}

	function after_block($instance) {
 		extract($instance);
 		echo'</div>';
	}
 	
}

aq_register_block( 'OE_Timeline_Block' );

endif;