<?php
/**
 * This file control SOCIAL block
 *
 * @package    OneEngine
 * @package    EngineThemes
 */

// SOCIAL BLOCK
if( ! class_exists( 'OE_Social_Block' ) ) :

class OE_Social_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => 'ET Social',
			'size' => 'span12',
		);
		
		//create the block
		parent::__construct('OE_Social_Block', $block_options);
	}
	
	function form($instance) {
		
		$defaults = array(
			'align' 			=> 1,
			'facebook_check' 	=> 1,
			'facebook_url' 		=> '#',
			'twitter_check' 	=> 1,
			'twitter_url' 		=> '#',
			'dribbble_check' 	=> 1,
			'dribbble_url' 		=> '#',
			'google_check' 		=> 1,
			'google_url' 		=> '#',
			'pinterest_check' 	=> 1,
			'pinterest_url' 	=> '#',
			'flickr_check' 		=> 1,
			'flickr_url' 		=> '#',
			'linkedin_check' 	=> 1,
			'linkedin_url' 		=> '#',
			'skype_check' 		=> 1,
			'skype_url' 		=> '#',
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		$text_align = array(
			'left' => 'Align left',
			'right' => 'Align right',
			'center' => 'Align center',
		);
		
		?>
        
		<p class="description">
            <label for="<?php echo $this->get_field_id('align') ?>">
                Text align<br/>
                <?php echo aq_field_select('align', $block_id, $text_align , $align) ?>
            </label>
        </p>
        <div class="sortable-body">
            <p class="description">
                <label for="<?php echo $this->get_field_id('facebook_check') ?>">
                    Display facebook icon ?
                    <?php echo aq_field_checkbox('facebook_check', $block_id, $facebook_check) ?>
                </label>
            </p>
        	<p class="description">
                <label for="<?php echo $this->get_field_id('facebook_url') ?>">
                    Your facebook URL
                    <?php echo aq_field_input('facebook_url', $block_id, $facebook_url, $size = 'full') ?>
            	</label>
            </p>
      	</div>
        
        <div class="sortable-body">
            <p class="description">
                <label for="<?php echo $this->get_field_id('twitter_check') ?>">
                    Display twitter icon ?
                    <?php echo aq_field_checkbox('twitter_check', $block_id, $twitter_check) ?>
                </label>
            </p>
        	<p class="description">
                <label for="<?php echo $this->get_field_id('twitter_url') ?>">
                    Your twitter URL
                    <?php echo aq_field_input('twitter_url', $block_id, $twitter_url, $size = 'full') ?>
            	</label>
            </p>
      	</div>
        
        <div class="sortable-body">
            <p class="description">
                <label for="<?php echo $this->get_field_id('google_check') ?>">
                    Display google+ icon ?
                    <?php echo aq_field_checkbox('google_check', $block_id, $google_check) ?>
                </label>
            </p>
        	<p class="description">
                <label for="<?php echo $this->get_field_id('google_url') ?>">
                    Your google URL
                    <?php echo aq_field_input('google_url', $block_id, $google_url, $size = 'full') ?>
            	</label>
            </p>
      	</div>
        
        <div class="sortable-body">
            <p class="description">
                <label for="<?php echo $this->get_field_id('pinterest_check') ?>">
                    Display pinterest icon ?
                    <?php echo aq_field_checkbox('pinterest_check', $block_id, $pinterest_check) ?>
                </label>
            </p>
        	<p class="description">
                <label for="<?php echo $this->get_field_id('pinterest_url') ?>">
                    Your pinterest URL
                    <?php echo aq_field_input('pinterest_url', $block_id, $pinterest_url, $size = 'full') ?>
            	</label>
            </p>
      	</div>
        
        <div class="sortable-body">
            <p class="description">
                <label for="<?php echo $this->get_field_id('dribbble_check') ?>">
                    Display dribbble icon ?
                    <?php echo aq_field_checkbox('dribbble_check', $block_id, $dribbble_check) ?>
                </label>
            </p>
        	<p class="description">
                <label for="<?php echo $this->get_field_id('dribbble_url') ?>">
                    Your dribbble URL
                    <?php echo aq_field_input('dribbble_url', $block_id, $dribbble_url, $size = 'full') ?>
            	</label>
            </p>
      	</div>
        
        <div class="sortable-body">
            <p class="description">
                <label for="<?php echo $this->get_field_id('flickr_check') ?>">
                    Display flickr icon ?
                    <?php echo aq_field_checkbox('flickr_check', $block_id, $flickr_check) ?>
                </label>
            </p>
        	<p class="description">
                <label for="<?php echo $this->get_field_id('flickr_url') ?>">
                    Your flickr URL
                    <?php echo aq_field_input('flickr_url', $block_id, $flickr_url, $size = 'full') ?>
            	</label>
            </p>
      	</div>
        
        <div class="sortable-body">
            <p class="description">
                <label for="<?php echo $this->get_field_id('linkedin_check') ?>">
                    Display linkedin icon ?
                    <?php echo aq_field_checkbox('linkedin_check', $block_id, $linkedin_check) ?>
                </label>
            </p>
        	<p class="description">
                <label for="<?php echo $this->get_field_id('linkedin_url') ?>">
                    Your linkedin URL
                    <?php echo aq_field_input('linkedin_url', $block_id, $linkedin_url, $size = 'full') ?>
            	</label>
            </p>
      	</div>
        				
		<?php
	}
	
	function block($instance) {
		extract($instance);
		$output = '';
		$output .= ' <ul class="social-footer">';
		if($facebook_check == '1'){
			
			$output .= '<li class="social-facebook"><a href="'.$facebook_url.'" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a></li>';
		}
		if($twitter_check == '1'){
			$output .= '<li class="social-twitter"><a href="'.$twitter_url.'" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a></li>';
		}
		if($google_check == '1'){
			$output .= '<li class="social-google"><a href="'.$google_url.'" target="_blank" title="Google Plus"><i class="fa fa-google-plus"></i></a></li>';
		}
		if($pinterest_check == '1'){
			$output .= '<li class="social-pinterest"><a href="'.$pinterest_url.'" target="_blank" title="Pinterest"><i class="fa fa-pinterest"></i></a></li>';
		}
		if($dribbble_check == '1'){
			$output .= '<li class="social-dribbble"><a href="'.$dribbble_url.'" target="_blank" title="Dribbble"><i class="fa fa-dribbble"></i></a></li>';
		}
		if($flickr_check == '1'){
			$output .= '<li class="social-flickr"><a href="'.$flickr_url.'" target="_blank" title="Flickr"><i class="fa fa-flickr"></i></a></li>';
		}
		if($linkedin_check == '1'){
			$output .= '<li class="social-linkedin"><a href="'.$linkedin_url.'" target="_blank" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>';
		}
		$output .= '</ul>';
		echo $output;
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

aq_register_block( 'OE_Social_Block' );
endif;