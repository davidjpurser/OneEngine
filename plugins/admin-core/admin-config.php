<?php
add_filter( 'redux-backup-description', 'admin_change_default_texts' );
function admin_change_default_texts(){
	return __('You can copy/download your current options settings. This is a backup solution in case anything goes wrong.', 'oneengine');
}
/**
	ReduxFramework Sample Config File
	For full documentation, please visit http://reduxframework.com/docs/
**/


/** 
	Most of your editing will be done in this section.
	Here you can override default values, uncomment args and change their values.
	No $args are required, but they can be overridden if needed.
	
**/
$args = array();


// For use with a tab example below
$tabs = array();


// BEGIN Sample Config

// Default: true
$args['dev_mode'] = false;

// Set a custom option name. Don't forget to replace spaces with underscores!
$args['opt_name'] = 'oneengine_options';

// Theme Panel Main Display Name
$args['display_name'] 	 = __('OneEngine Theme Options Panel','oneengine');
$args['display_version'] = false;

// If you want to use Google Webfonts, you MUST define the api key.
$args['google_api_key']  = 'AIzaSyAX_2L_UzCDPEnAHTG7zhESRVpMPS4ssII';

// Define the starting tab for the option panel.
// Default: '0';
$args['last_tab'] = '0';

// Default: 'standard'
$args['admin_stylesheet'] = 'standard';

// Default: null
$args['import_icon_class'] = 'el-icon-large';

// Set a custom menu icon.
$args['menu_icon']  = get_template_directory_uri() .'/images/icons/apple-touch-icon-16x16.png';

// Set a custom title for the options page.
// Default: Options
$args['menu_title'] = __('Theme Options', 'oneengine');

// Set a custom page title for the options page.
// Default: Options
$args['page_title'] = __('Theme Options', 'oneengine');

// Set a custom page slug for options page (wp-admin/themes.php?page=***).
// Default: redux_options
$args['page_slug']  = 'oneengine_options';

// Show Default
$args['default_show'] = false;

// Default Mark
$args['default_mark'] = '';

// Set a custom page icon class (used to override the page icon next to heading)
$args['page_icon'] = 'icon-themes';

// Declare sections array
$sections = array();



// General -------------------------------------------------------------------------- >	
$sections[] = array(
	'title' => __('General', 'oneengine'),
	'header' => __('Welcome to the OneEngine Options Framework', 'oneengine'),
	'desc' => '',
	'icon_class' => 'el-icon-large',
	'icon' => 'el-icon-cog',
	'submenu' => true,
	'fields' => array(
		
		array(
			'id'=>'custom_logo',
			'url'=> true,
			'type' => 'media', 
			'title' => __('Logo', 'oneengine'),
			'default' =>'',
			'subtitle' => __('Upload custom logo to your website.', 'oneengine'),
		),
		
		array(
			'id'=>'favicon',
			'url'=> true,
			'type' => 'media', 
			'title' => __('Your Favicon', 'oneengine'),
			'default' => array( 'url' => get_template_directory_uri() .'/images/icons/favicon.png' ),
			'subtitle' => __('Upload a file( png, ico, jpg, gif or bmp ) from your computer (maximum size:1MB ).', 'oneengine'),
		),
		
		array(
			'id'=>'logo_width',
			'type' => 'text', 
			'default' => '220',
			'title' => __('Logo’s width (px)', 'oneengine'),
			'subtitle' => __('Ex:220', 'oneengine'),
		),
		
		array(
			'id'=>'logo_top',
			'type' => 'text',
			'default' => '0',
			'title' => __('Logo’s margin-top (px)', 'oneengine'),
			'subtitle' => __('Ex: 10', 'oneengine'),
		),
		
		array(
			'id'=>'logo_left',
			'type' => 'text',
			'default' => '30',
			'title' => __('Logo’s margin-left (px)', 'oneengine'),
			'subtitle' => __('Ex: 30', 'oneengine'),
		),

		array(
			'id'=>'touch_icon',
			'url'=> true,
			'type' => 'media', 
			'title' => __('Apple touch icon', 'oneengine'),
			'default' => array( 'url' => get_template_directory_uri() .'/images/icons/apple-touch-icon-16x16.png' ),
			'subtitle' => __('Upload your touch icon here.', 'oneengine'),
		),
		
		array(
			'id'=>'touch_icon_72',
			'url'=> true,
			'type' => 'media', 
			'title' => __('Apple touch icon 72x72', 'oneengine'),
			'default' => array( 'url' => get_template_directory_uri() .'/images/icons/apple-touch-icon-72x72.png' ),
			'subtitle' => __('Upload your touch icon here.', 'oneengine'),
		),
		
		array(
			'id'=>'touch_icon_144',
			'url'=> true,
			'type' => 'media', 
			'title' => __('Apple touch icon 144x144', 'oneengine'),
			'default' => array( 'url' => get_template_directory_uri() .'/images/icons/apple-touch-icon-144x144.png' ),
			'subtitle' => __('Upload your touch icon here.', 'oneengine'),
		),
		
	),
);

// Typography -------------------------------------------------------------------------- >	
$sections[] = array(
	'title' => __('Typography', 'oneengine'),
	'header' => '',
	'desc' => '',
	'icon_class' => 'el-icon-large',
    'icon' => 'el-icon-font',
    'submenu' => true,
	'fields' => array(
			
			array(
				'id'=>'body_font',
				'type' => 'typography', 
				'title' => __('Body', 'oneengine'),
				'compiler'=>false,
				'google'=>true,
				'font-backup'=>false,
				'font-style'=>true,
				'subsets'=>true,
				'font-size'=>true,
				'line-height'=>false,
				'word-spacing'=>false,
				'letter-spacing'=>false,
				'color'=>true,
				'preview'=>true,
				'output' => array('body'),
				'units'=>'px',
				'subtitle'=> __('Choose custom font options to use for the main body text.', 'oneengine'),
				'default'=> array(
					'font-family'=>'Lato', 
					'font-size'=>'14px',
					'color'=>'#5f6f81',
					'font-weight'=>'300',
				)
			),
			
			array(
				'id'=>'menu_font',
				'type' => 'typography', 
				'title' => __('Menu', 'oneengine'),
				'compiler'=>false,
				'google'=>true,
				'font-backup'=>false,
				'font-style'=>false,
				'subsets'=>false,
				'text-align'=>false,
				'font-size'=>true,
				'line-height'=>false,
				'word-spacing'=>false,
				'letter-spacing'=>false,
				'color'=>true,
				'preview'=>true,
				'output' => array('#main-menu-top .main-menu li a'),
				'units'=>'px',
				'subtitle'=> __('Choose custom font options to use for the main navigation menu.', 'oneengine'),
				'default'=> array(
					'font-family'=>'Lato', 
					'font-size'=>'14px',
					'font-weight'=>'700',
					'color'=>'#000000'
				)
			),
			
			array(
				'id'=>'headings_font',
				'type' => 'typography', 
				'title' => __('Headings', 'oneengine'),
				'compiler'=>false,
				'google'=>true,
				'font-backup'=>false,
				'font-style'=>false,
				'subsets'=>true,
				'font-size'=>false,
				'line-height'=>false,
				'word-spacing'=>false,
				'letter-spacing'=>false,
				'color'=>false,
				'preview'=>true,
				'output' => array('h1, h2, h3, h4, h5, h6'),
				'units'=>'px',
				'subtitle'=> __('Choose custom font options to use for the headings (h1, h2, h3,...)', 'oneengine'),
				'default'=> array(
					'font-family'=>'Lato', 
					'font-weight'=>'700',
					'color'=>'#000000'
				),
			),
			
			
		),
);


// Styling -------------------------------------------------------------------------- >	
$sections[] = array(
	'icon' => 'el-icon-brush',
	'icon_class' => 'el-icon-large',
	'title' => __('Styling', 'oneengine'),
	'submenu' => true,
	'fields' => array(
	
		array(
			'id'=>'main_color',
			'type' => 'color',
			'title' => __('Main Color', 'oneengine'),
			'subtitle' => __('Choose color.', 'oneengine'),
			'default' => '#e8432e',
			'transparent'=>false,
			'validate' => 'color',
		),
		
		array(
			'id'=>'link_color',
			'type' => 'color',
			'title' => __('Links Color', 'oneengine'),
			'subtitle' => __('Choose color.', 'oneengine'),
			'default' => '#e8432e',
			'transparent'=>false,
			'validate' => 'color',
		),
	)
);

// Blog -------------------------------------------------------------------------- >	
$sections[] = array(
	'icon' => 'el-icon-blogger',
	'icon_class' => 'el-icon-large',
	'title' => __('Blog Setting', 'oneengine'),
	'submenu' => true,
	'fields' => array(

		array(
			'id'=>'header_blog_title',
			'type' => 'text', 
			'default' => 'Blog',
			'title' => __('Type your title', 'oneengine'),
			//'subtitle' => __('Ex:560(px)', 'oneengine'),
		),
		array(
			'id'=>'header_blog_title_color',
			'type' => 'color',
			'title' => __('Color of Title', 'oneengine'),
			'subtitle' => __('Choose color for the title.', 'oneengine'),
			'default' => '#000000',
			'transparent'=>false,
			'validate' => 'color',
		),
		array(
			'id'=>'header_blog_subtitle',
			'type' => 'textarea', 
			'default' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo. ',
			'title' => __('Type your sub title', 'oneengine'),
			//'subtitle' => __('Ex:560(px)', 'oneengine'),
		),
		array(
			'id'=>'header_blog_subtitle_color',
			'type' => 'color',
			'title' => __('Choose color for the sub-title', 'oneengine'),
			'subtitle' => __('Select your font color for Sub Title.', 'oneengine'),
			'default' => '#ffffff',
			'transparent'=>false,
			'validate' => 'color',
		),
		array(
			'id'=>'header_blog_color',
			'type' => 'color',
			'title' => __('Color header background', 'oneengine'),
			'subtitle' => __('Choose the color for the header backgrounds.', 'oneengine'),
			'default' => '#cccccc',
			'transparent'=>false,
			'validate' => 'color',
		),
		
		array(
			'id'=>'header_blog_img',
			'url'=> true,
			'type' => 'media', 
			'title' => __('Background  header image', 'oneengine'),
			'default' =>'',
			'subtitle' => __('Upload an image for the background header.', 'oneengine'),
		),
		array(
			'id'       => 'header_blog_repeat',
			'type'     => 'button_set',
			'title'    => __('Background Image Repeat', 'oneengine'),
			'subtitle' => __('Select your preferred background style', 'oneengine'),
			//Must provide key => value pairs for options
			'options' => array('no-repeat' => __('No Repeat','oneengine'), 'repeat' => __('Repeat','oneengine')),
			'default' => '1'
		),
		
		array(
			'id'=>'header_blog_parallax',
			'type' => 'switch', 
			'title' => __('Parallax header background', 'oneengine'),
			'subtitle'=> __('Enable this option to replace the header image with animated parallax effect.', 'oneengine'),
			'default' => '1',
			'on' => __('On', 'oneengine' ),
			'off' => __('Off', 'oneengine' ),
		),
		array(
			'id'=>'header_blog_cover',
			'type' => 'switch', 
			'title' => __('Background Header Cover', 'oneengine'),
			'subtitle'=> __('Enable this option to cover the header blog’s images.', 'oneengine'),
			'default' => '1',
			'on' => __('On', 'oneengine' ),
			'off' => __('Off', 'oneengine' ),
		),
		array(
			'id'=>'social_share_blog',
			'type' => 'checkbox',
			'title' => __('Social Sharing Links', 'oneengine'), 
			'subtitle' => __('Select the social sharing links to share your content across a range of social networks.', 'oneengine' ),
			'options' => array(
				'twitter' => 'Twitter',
				'facebook' => 'Facebook',
				'google_plus' => 'Google Plus',
			),
			'default' => array(
				'twitter' => '1',
				'facebook' => '1',
				'google_plus' => '1',
			)
		),
	)
);

// Portfolio -------------------------------------------------------------------------- >	
$sections[] = array(
	'icon' => 'el-icon-website',
	'icon_class' => 'el-icon-large',
	'title' => __('Portfolio Setting', 'oneengine'),
	'submenu' => true,
	'fields' => array(
	
		array(
			'id'=>'btn_port_getintouch',
			'type' => 'switch', 
			'title' => __('Show / Hide button Get In Touch', 'oneengine'),
			'subtitle'=> __('Enable this,“Get in touch” button will be displayed at the end of every portfolio posts.', 'oneengine'),
			'default' => '1',
			'on' => __('On', 'oneengine' ),
			'off' => __('Off', 'oneengine' ),
		),
		array(
			'id'=>'btn_port_getintouch_link',
			'type' => 'text', 
			'title' => __('Link button Get in Touch', 'oneengine'),
			'subtitle' => __('', 'oneengine'),
			'default' => ''
		),
		array(
			'id'=>'social_share_port',
			'type' => 'checkbox',
			'title' => __('Social Sharing Links', 'oneengine'), 
			'subtitle' => __('Select the social sharing links to share your content across a range of social networks.', 'oneengine' ),
			'options' => array(
				'twitter' => 'Twitter',
				'facebook' => 'Facebook',
				'google_plus' => 'Google Plus',
			),
			'default' => array(
				'twitter' => '1',
				'facebook' => '1',
				'google_plus' => '1',
			)
		),
		
	)
);

// Footer -------------------------------------------------------------------------- >	
$sections[] = array(
	'icon' => 'el-icon-bookmark',
	'icon_class' => 'el-icon-large',
    'title' => __('Footer', 'oneengine'),
	'submenu' => true,
	'fields' => array(
		
		
		array(
			'id'=>'contact_form',
			'type' => 'text', 
			'title' => __('Contact 7 form shortcode', 'oneengine'),
			'subtitle' => __('*NOTE : Make sure the code doesn\'t contain double quotes. Replace double quotes with single quote. <br /> Ex: [contact-form-7 id=\'1\' title=\'Contact form 1\']', 'oneengine'),
			'default' => ''
		),
		array(
			'id'=>'copyright',
			'type' => 'textarea', 
			'title' => __('Copyright', 'oneengine'),
			'subtitle' => __('Type your website copyright.', 'oneengine'),
			'default' => "2014 OneEngine. All right reserve."
		),
		array(
			'id'=>'address_footer',
			'type' => 'text', 
			'default' => '173A Nguyen Van Troi, Phu Nhuan, HCMC',
			'title' => __('Type your address', 'oneengine'),
		),
		array(
			'id'=>'phone_footer',
			'type' => 'text', 
			'default' => '0988 11 22 33',
			'title' => __('Type your phone', 'oneengine'),
		),
		array(
			'id'=>'email_footer',
			'type' => 'text', 
			'default' => 'info@enginethemes.com',
			'title' => __('Type your email', 'oneengine'),
		),
		array(
			'id'=>'footer_blog_title',
			'type' => 'text', 
			'default' => 'Contact Us',
			'title' => __('Type your title', 'oneengine'),
		),
		array(
			'id'=>'footer_blog_title_color',
			'type' => 'color',
			'title' => __('Color of Title', 'oneengine'),
			'subtitle' => __('Choose color for the title.', 'oneengine'),
			'default' => '#ffffff',
			'transparent'=>false,
			'validate' => 'color',
		),
		array(
			'id'=>'footer_blog_subtitle',
			'type' => 'textarea', 
			'default' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo. ',
			'title' => __('Type your sub title', 'oneengine'),
		),
		array(
			'id'=>'footer_blog_subtitle_color',
			'type' => 'color',
			'title' => __('Color of Sub Title', 'oneengine'),
			'subtitle' => __('Choose color for the sub-title.', 'oneengine'),
			'default' => '#ffffff',
			'transparent'=>false,
			'validate' => 'color',
		),
		array(
			'id'=>'footer_blog_color',
			'type' => 'color',
			'title' => __('Background Color for Footer', 'oneengine'),
			'subtitle' => __('Choose background color for blog header.', 'oneengine'),
			'default' => '#cccccc',
			'transparent'=>false,
			'validate' => 'color',
		),
		array(
			'id'=>'footer_blog_img',
			'url'=> true,
			'type' => 'media', 
			'title' => __('Footer Background', 'oneengine'),
			'default' => '',
			'subtitle' => __('Upload an image for footer background.', 'oneengine'),
			'default' => ""
		),
		array(
			'id'       => 'footer_blog_repeat',
			'type'     => 'button_set',
			'title'    => __('Background Image Repeat', 'oneengine'),
			'subtitle' => __('Select your preferred background style', 'oneengine'),
			//Must provide key => value pairs for options
			'options' => array('no-repeat' => __('No Repeat','oneengine'), 'repeat' => __('Repeat','oneengine')),
			'default' => '1'
		),
		
		array(
			'id'=>'footer_blog_parallax',
			'type' => 'switch', 
			'title' => __('Parallax Background Footer', 'oneengine'),
			'subtitle'=> __('Enable this option to replace the header image with animated parallax effect.', 'oneengine'),
			'default' => '1',
			'on' => __('On', 'oneengine' ),
			'off' => __('Off', 'oneengine' ),
		),
		array(
			'id'=>'footer_blog_cover',
			'type' => 'switch', 
			'title' => __('Background Footer Cover', 'oneengine'),
			'subtitle'=> __('Enable this option to cover the footer background images.', 'oneengine'),
			'default' => '1',
			'on' => __('On', 'oneengine' ),
			'off' => __('Off', 'oneengine' ),
		),		
		
	)
);
// Custom CSS -------------------------------------------------------------------------- >
$sections[] = array(
	'icon' => 'el-icon-css',
	'icon_class' => 'el-icon-large',
    'title' => __('Custom CSS', 'oneengine'),
	'submenu' => true,
	'fields' => array(
		array(
			'id'=>'custom_css',
			'type' => 'ace_editor',
			'title' => __('CSS Code', 'redux-framework-demo'), 
			'subtitle' => __('Paste your custom CSS code here.', 'oneengine'),
			'mode' => 'css',
            'theme' => 'monokai',
			'desc' => 'Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.',
            'default' => "#test{\nmargin: 0 auto;\n}"
		),
	)
);
// SEO -------------------------------------------------------------------------- >	
$sections[] = array(
	'icon' => 'el-icon-asterisk',
	'icon_class' => 'el-icon-large',
    'title' => __('SEO', 'oneengine'),
	'submenu' => true,
	'fields' => array(
	
		array(
			'id'=>'meta_author',
			'type' => 'textarea',      
			'title' => __('Meta Author', 'oneengine'), 
			'subtitle' => __('Type your meta author.', 'oneengine'),
			'desc' => "",
			'default' => ""
		),		
		array(
			'id'=>'meta_description',
			'type' => 'textarea',      
			'title' => __('Meta Description', 'oneengine'), 
			'subtitle' => __('Type your meta description.', 'oneengine'),
			'desc' => "",
			'default' => ""
		),		
		array(
			'id'=>'meta_keyword',
			'type' => 'textarea',      
			'title' => __('Meta Keyword', 'oneengine'), 
			'subtitle' => __('Type your meta keyword.', 'oneengine'),
			'desc' => "",
			'default' => ""
		),
		array(
			'id'=>'google_analytics',
			'type' => 'textarea',      
			'title' => __('Google Analytics Code', 'oneengine'), 
			'subtitle' => __('Paste your Google Analytics javascript or other tracking code here. This code will be added before the closing <head> tag.', 'oneengine'),
			'desc' => "",
			'default' => ""
		)				
	)
	
);


// Social -------------------------------------------------------------------------- >	
$sections[] = array(
	'icon' => 'el-icon-twitter',
	'icon_class' => 'el-icon-large',
    'title' => __('Social Networks', 'oneengine'),
	'submenu' => true,
	'fields' => array(
		
		array(
			'id'=>'facebook',
			'type' => 'text',      
			'title' => __('Facebook', 'oneengine'), 
			'subtitle' => __('Insert your Facebook fanpage here.', 'oneengine'),
			'desc' => "",
			'default' => "https://www.facebook.com/EngineThemes"
		),
		array(
			'id'=>'twitter',
			'type' => 'text',      
			'title' => __('Twitter', 'oneengine'), 
			'subtitle' => __('Insert your Twitter URL here.', 'oneengine'),
			'desc' => "",
			'default' => "https://twitter.com/enginewpthemes"
		),
		array(
			'id'=>'dribbble',
			'type' => 'text',      
			'title' => __('Dribbble', 'oneengine'), 
			'subtitle' => __('Insert your Dribbble URL here.', 'oneengine'),
			'desc' => "",
			'default' => "https://dribbble.com/enginethemes"
		),	
		array(
			'id'=>'google_plus',
			'type' => 'text',      
			'title' => __('Google Plus', 'oneengine'), 
			'subtitle' => __('Insert your Google Plus URL here.', 'oneengine'),
			'desc' => "",
			'default' => ""
		),
		array(
			'id'=>'pinterest',
			'type' => 'text',      
			'title' => __('Pinterest', 'oneengine'), 
			'subtitle' => __('Insert your Pinterest URL here.', 'oneengine'),
			'desc' => "",
			'default' => ""
		),
		array(
			'id'=>'flickr',
			'type' => 'text',      
			'title' => __('Flickr', 'oneengine'), 
			'subtitle' => __('Insert your Flickr URL here.', 'oneengine'),
			'desc' => "",
			'default' => ""
		),			
		array(
			'id'=>'linkedin',
			'type' => 'text',      
			'title' => __('Linkedin', 'oneengine'), 
			'subtitle' => __('Insert your Linkedin URL here.', 'oneengine'),
			'desc' => "",
			'default' => ""
		),
	)
	
);


global $ReduxFramework;
$ReduxFramework = new ReduxFramework($sections, $args, $tabs);

// Function used to retrieve theme option values
if ( ! function_exists('oneengine_option') ) {
	function oneengine_option($id, $fallback = false, $param = false ) {
		global $oneengine_options;
		if ( $fallback == false ) $fallback = '';
		$output = ( isset($oneengine_options[$id]) && $oneengine_options[$id] !== '' ) ? $oneengine_options[$id] : $fallback;
		if ( !empty($oneengine_options[$id]) && $param ) {
			$output = $oneengine_options[$id][$param];
		}
		return $output;
	}
}