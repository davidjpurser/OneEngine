<?php
/*-----------------------------------------------------------------------------------*/
/* TGM REQUIRE PLUGINS
/*-----------------------------------------------------------------------------------*/
require_once dirname(__FILE__) . '/includes/class-tgm-plugin-activation.php';
/*-----------------------------------------------------------------------------------*/
/* Page Builder Plugin ver 1.0.8
/*-----------------------------------------------------------------------------------*/

if(!defined('AQPB_VERSION')) define( 'AQPB_VERSION', '1.0.8' );
if(!defined('AQPB_PATH')) 	 define( 'AQPB_PATH', get_template_directory() . '/plugins/pagebuilder/' );
if(!defined('AQPB_DIR')) 	 define( 'AQPB_DIR', get_template_directory_uri() . '/plugins/pagebuilder/' );

// Required functions & classes
require_once(AQPB_PATH . 'functions/aqpb_config.php');
require_once(AQPB_PATH . 'functions/aqpb_blocks.php');
require_once(AQPB_PATH . 'classes/class-aq-page-builder.php');
require_once(AQPB_PATH . 'classes/class-aq-block.php');
require_once(AQPB_PATH . 'functions/aqpb_functions.php');

// Register blocks
require_once( get_template_directory() . '/plugins/pagebuilder/blocks/block-init.php' );

$aqpb_config 	 = aq_page_builder_config();
$aq_page_builder = new AQ_Page_Builder($aqpb_config);

if(!is_network_admin()) $aq_page_builder->init();

/*-----------------------------------------------------------------------------------*/
/* ReduxFramework Admin Panel
/*-----------------------------------------------------------------------------------*/

if ( !class_exists( 'ReduxFramework' ) ) {
 require_once( get_template_directory() . '/plugins/admin-core/framework.php' );
}

if ( !isset( $redux_demo ) ) {
 require_once( get_template_directory() . '/plugins/admin-core/admin-config.php' );
}

//include template functions:
require_once( get_template_directory() . '/includes/template.php' );



/*-----------------------------------------------------------------------------------*/
/* Declared OneEngine Class
/*-----------------------------------------------------------------------------------*/

class OneEngine{
	function __construct(){
		add_action( 'init', 			  array($this,'theme_init') );
		add_action( 'wp_enqueue_scripts', array($this,'frontend_scripts') );
		add_action( 'add_meta_boxes', 	  array($this,'add_meta_boxes') );
		add_action( 'save_post', 	  	  array($this,'save_meta_boxes') );
		add_action( 'after_setup_theme',  array($this,'load_text_domain') );
		add_action( 'tgmpa_register' 	, array($this,'he_register_required_plugins') );
		/* =============== ACTIONS AJAX =============== */
		add_action( 'wp_ajax_et_load_portfolio', array($this,'et_load_portfolio') );
		add_action( 'wp_ajax_nopriv_et_load_portfolio', array($this,'et_load_portfolio') );
		add_action( 'wp_ajax_et_like_post', array($this,'et_like_post') );
		add_action( 'wp_ajax_nopriv_et_like_post', array($this,'et_like_post') );
		add_action( 'wp_ajax_et_loadmore_post', array($this,'et_loadmore_post') );
		add_action( 'wp_ajax_nopriv_et_loadmore_post', array($this,'et_loadmore_post') );		
		/* =============== CUSTOM FIELDS FOR TAX =============== */		
		add_action( 'portfolio_cat_add_form_fields', array($this,'taxonomy_add_new_meta_field'), 10, 2 );
		add_action( 'portfolio_cat_edit_form_fields', array($this,'taxonomy_edit_meta_field'), 10, 2 );
		add_action( 'edited_portfolio_cat', array($this,'save_taxonomy_custom_meta'), 10, 2 );  
		add_action( 'create_portfolio_cat', array($this,'save_taxonomy_custom_meta'), 10, 2 );	
		/* =============== CUSTOM FIELDS FOR COMMENT =============== */
		add_filter('comment_form_default_fields', array($this,'modify_comment_form_fields'), 40 );
	}
	public function he_register_required_plugins() {

	    $plugins = array(
	        array(
	            'name'                  => 'Contact Form 7', 
	            'slug'                  => 'contact-form-7',
	            'required'              => true,
	        ),       	        
	    );
	 
	    // Change this to your theme text domain, used for internationalising strings
	    $theme_text_domain = 'oneengine';
	 
	    $config = array(
	        'domain'            => $theme_text_domain,
	        'default_path'      => '',                
	        'parent_menu_slug'  => 'themes.php',      
	        'parent_url_slug'   => 'themes.php',      
	        'menu'              => 'install-required-plugins',
	        'has_notices'       => true,    
	        'is_automatic'      => false,   
	        'message'           => '',      
	        'strings'           => array(
	            'page_title'                                => __( 'Install Required Plugins', $theme_text_domain ),
	            'menu_title'                                => __( 'Install Plugins', $theme_text_domain ),
	            'installing'                                => __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name
	            'oops'                                      => __( 'Something went wrong with the plugin API.', $theme_text_domain ),
	            'notice_can_install_required'               => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
	            'notice_can_install_recommended'            => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
	            'notice_cannot_install'                     => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
	            'notice_can_activate_required'              => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
	            'notice_can_activate_recommended'           => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
	            'notice_cannot_activate'                    => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
	            'notice_ask_to_update'                      => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
	            'notice_cannot_update'                      => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
	            'install_link'                              => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
	            'activate_link'                             => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
	            'return'                                    => __( 'Return to Required Plugins Installer', $theme_text_domain ),
	            'plugin_activated'                          => __( 'Plugin activated successfully.', $theme_text_domain ),
	            'complete'                                  => __( 'All plugins installed and activated successfully. %s', $theme_text_domain ) // %1$s = dashboard link
	        )
	    );
	 
	    tgmpa( $plugins, $config );
	 
	}

	public function modify_comment_form_fields($fields){

		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );	
			
		$fields['author'] = '<p class="comment-form-author">'.
	                    
		'<input id="author" name="author" type="text" placeholder="Your name *" value="' . 
						
		esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>';
						
	    $fields['email'] = '<p class="comment-form-email">' .
	    
		'<input id="email" name="email" type="text" placeholder="Your email *" value="' . 
		
		esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>';
		
		$fields['url'] = '<p class="comment-form-url">'.
	    
		'<input id="url" name="url" type="text" placeholder="Website (Optional)" value="' . 
		
		esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>';

	    return $fields;

	}
	public function load_text_domain(){
	    load_theme_textdomain('oneengine', get_template_directory() . '/languages');
	}	
	/*-----------------------------------------------------------------------------------*/
	/* Register New Post Types & Taxonomies
	/*-----------------------------------------------------------------------------------*/		
	public function theme_init() {
		
		/*-----------------------------------------------------------------------------------*/
		/*	Register Menus
		/*-----------------------------------------------------------------------------------*/
		register_nav_menus(
			array(
			'main_nav'=>__('Main Nav'),
			)
		);
		register_nav_menus(
			array(
			'footer_nav'=>__('Footer Nav'),
			)
		);		
		
		$s_labels = array(
			'name'               => _x( 'Sliders', 'post type general name', 'oneengine' ),
			'singular_name'      => _x( 'Slider', 'post type singular name', 'oneengine' ),
			'menu_name'          => _x( 'Sliders', 'admin menu', 'oneengine' ),
			'name_admin_bar'     => _x( 'Slider', 'add new on admin bar', 'oneengine' ),
			'add_new'            => _x( 'Add New', 'Slider', 'oneengine' ),
			'add_new_item'       => __( 'Add New Slider', 'oneengine' ),
			'new_item'           => __( 'New Slider', 'oneengine' ),
			'edit_item'          => __( 'Edit Slider', 'oneengine' ),
			'view_item'          => __( 'View Slider', 'oneengine' ),
			'all_items'          => __( 'All Sliders', 'oneengine' ),
			'search_items'       => __( 'Search Sliders', 'oneengine' ),
			'parent_item_colon'  => __( 'Parent Sliders:', 'oneengine' ),
			'not_found'          => __( 'No Sliders found.', 'oneengine' ),
			'not_found_in_trash' => __( 'No Portfolios found in Trash.', 'oneengine' ),
		);

		$s_args = array(
			'labels'             => $s_labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'slider' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
		);

		register_post_type( 'slider', $s_args );

		$p_labels = array(
			'name'               => _x( 'Portfolios', 'post type general name', 'oneengine' ),
			'singular_name'      => _x( 'Portfolio', 'post type singular name', 'oneengine' ),
			'menu_name'          => _x( 'Portfolios', 'admin menu', 'oneengine' ),
			'name_admin_bar'     => _x( 'Portfolio', 'add new on admin bar', 'oneengine' ),
			'add_new'            => _x( 'Add New', 'Portfolio', 'oneengine' ),
			'add_new_item'       => __( 'Add New Portfolio', 'oneengine' ),
			'new_item'           => __( 'New Portfolio', 'oneengine' ),
			'edit_item'          => __( 'Edit Portfolio', 'oneengine' ),
			'view_item'          => __( 'View Portfolio', 'oneengine' ),
			'all_items'          => __( 'All Portfolios', 'oneengine' ),
			'search_items'       => __( 'Search Portfolios', 'oneengine' ),
			'parent_item_colon'  => __( 'Parent Portfolios:', 'oneengine' ),
			'not_found'          => __( 'No Portfolios found.', 'oneengine' ),
			'not_found_in_trash' => __( 'No Portfolios found in Trash.', 'oneengine' ),
		);

		$p_args = array(
			'labels'             => $p_labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'portfolio' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
		);

		register_post_type( 'portfolio', $p_args );	

		$test_labels = array(
			'name'               => _x( 'Testimonials', 'post type general name', 'oneengine' ),
			'singular_name'      => _x( 'Testimonial', 'post type singular name', 'oneengine' ),
			'menu_name'          => _x( 'Testimonials', 'admin menu', 'oneengine' ),
			'name_admin_bar'     => _x( 'Testimonial', 'add new on admin bar', 'oneengine' ),
			'add_new'            => _x( 'Add New', 'Testimonial', 'oneengine' ),
			'add_new_item'       => __( 'Add New Testimonial', 'oneengine' ),
			'new_item'           => __( 'New Testimonial', 'oneengine' ),
			'edit_item'          => __( 'Edit Testimonial', 'oneengine' ),
			'view_item'          => __( 'View Testimonial', 'oneengine' ),
			'all_items'          => __( 'All Testimonials', 'oneengine' ),
			'search_items'       => __( 'Search Testimonials', 'oneengine' ),
			'parent_item_colon'  => __( 'Parent Testimonials:', 'oneengine' ),
			'not_found'          => __( 'No Testimonials found.', 'oneengine' ),
			'not_found_in_trash' => __( 'No Testimonials found in Trash.', 'oneengine' ),
		);

		$test_args = array(
			'labels'             => $test_labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'testimonial' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
		);

		register_post_type( 'testimonial', $test_args );	

		$t_labels = array(
			'name'               => _x( 'Teams', 'post type general name', 'oneengine' ),
			'singular_name'      => _x( 'Team', 'post type singular name', 'oneengine' ),
			'menu_name'          => _x( 'Teams', 'admin menu', 'oneengine' ),
			'name_admin_bar'     => _x( 'Team', 'add new on admin bar', 'oneengine' ),
			'add_new'            => _x( 'Add New', 'Team', 'oneengine' ),
			'add_new_item'       => __( 'Add New Team', 'oneengine' ),
			'new_item'           => __( 'New Team', 'oneengine' ),
			'edit_item'          => __( 'Edit Team', 'oneengine' ),
			'view_item'          => __( 'View Team', 'oneengine' ),
			'all_items'          => __( 'All Teams', 'oneengine' ),
			'search_items'       => __( 'Search Teams', 'oneengine' ),
			'parent_item_colon'  => __( 'Parent Teams:', 'oneengine' ),
			'not_found'          => __( 'No Teams found.', 'oneengine' ),
			'not_found_in_trash' => __( 'No Teams found in Trash.', 'oneengine' ),
		);

		$t_args = array(
			'labels'             => $t_labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'team' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title','thumbnail')
		);

		register_post_type( 'team', $t_args );	

		$tax_labels = array(
			'name'              => _x( 'Categories', 'taxonomy general name' ),
			'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Categories', 'oneengine' ),
			'all_items'         => __( 'All Categories', 'oneengine' ),
			'parent_item'       => __( 'Parent Category', 'oneengine' ),
			'parent_item_colon' => __( 'Parent Category:', 'oneengine' ),
			'edit_item'         => __( 'Edit Category', 'oneengine' ),
			'update_item'       => __( 'Update Category', 'oneengine' ),
			'add_new_item'      => __( 'Add New Category', 'oneengine' ),
			'new_item_name'     => __( 'New Category Name', 'oneengine' ),
			'menu_name'         => __( 'Category', 'oneengine' ),
		);

		$tax_args = array(
			'hierarchical'      => true,
			'labels'            => $tax_labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'portfolio-cat' ),
		);

		register_taxonomy( 'portfolio_cat', array( 'portfolio' ), $tax_args );	

		/*-----------------------------------------------------------------------------------*/
		/*	Register Images Size
		/*-----------------------------------------------------------------------------------*/
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_image_size( 'post-thumb', 570, 300, true );
		add_image_size( 'portfolio-thumb', 480, 480, true );
		add_image_size( 'portfolio-large', 770, 665, true );
	}	
	/*-----------------------------------------------------------------------------------*/
	/* Enqueue Js & Css
	/*-----------------------------------------------------------------------------------*/
	public function frontend_scripts() {
		/*============ Styles ============ */
		wp_enqueue_style( 'carousel-style',   get_template_directory_uri() . '/css/owl.carousel.css');
		wp_enqueue_style( 'bootstrap-style',  get_template_directory_uri() . '/css/bootstrap.css');
		wp_enqueue_style( 'animate',  		  get_template_directory_uri() . '/css/animate.css');
		wp_enqueue_style( 'font-awesome',  	  get_template_directory_uri() . '/css/font-awesome.min.css');
		wp_enqueue_style( 'magnific-popup',  	  get_template_directory_uri() . '/css/magnific-popup.css');
		wp_enqueue_style( 'main-style', 	  get_stylesheet_uri() );
		wp_enqueue_style( 'custom',  		  get_template_directory_uri() . '/css/custom-css.php');		

		/*============ Javascripts ============ */
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'backbone' );
		wp_enqueue_script( 'underscore' );
		wp_enqueue_script( 'bootstrap',  	get_template_directory_uri() . '/js/libs/bootstrap.min.js', array('jquery'), '3.1.1', true );
		wp_enqueue_script( 'modernizr',  	get_template_directory_uri() . '/js/libs/modernizr.custom.js', array('jquery'), '2.6.2', true );
		wp_enqueue_script( 'carousel', 	 	get_template_directory_uri() . '/js/libs/owl.carousel.min.js', array('jquery'), '1.0.0', true );
		wp_enqueue_script( 'slicknav', 	 	get_template_directory_uri() . '/js/libs/jquery.slicknav.min.js', array('jquery'), '1.0.0', true );
		wp_enqueue_script( 'waypoints',  	get_template_directory_uri() . '/js/libs/waypoints.min.js', array('jquery'), '2.0.3', true );
		wp_enqueue_script( 'sticky',  		get_template_directory_uri() . '/js/libs/waypoints-sticky.js', array('jquery'), '2.0.4', true );
		wp_enqueue_script( 'easypiechart',  get_template_directory_uri() . '/js/libs/jquery.easypiechart.min.js', array('jquery'), '2.1.0', true );
		wp_enqueue_script( 'counter',  		get_template_directory_uri() . '/js/libs/counter.js', array('jquery'), '1.0.0', true );
		wp_enqueue_script( 'hoverdir',  	get_template_directory_uri() . '/js/libs/jquery.hoverdir.js', array('jquery'), '1.1.0', true );
		wp_enqueue_script( 'classie',  		get_template_directory_uri() . '/js/libs/classie.js', array('jquery'), '1.1.0', true );
		wp_enqueue_script( 'easing',  		get_template_directory_uri() . '/js/libs/jquery.easing.min.js', array('jquery'), '1.0.0', true );
		wp_enqueue_script( 'scrollto',   	get_template_directory_uri() . '/js/libs/jquery.scrollTo.min.js', array('jquery'), '1.4.11', true );
		wp_enqueue_script( 'isotope',    	get_template_directory_uri() . '/js/libs/isotope.pkgd.min.js', array('jquery'), '1.4.11', true );
		wp_enqueue_script( 'magnific',    	get_template_directory_uri() . '/js/libs/jquery.magnific-popup.min.js', array('jquery'), '0.9.9', true );
		wp_enqueue_script( 'main', 	 	 	get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0.0', true );
		wp_enqueue_script( 'front', 	 	get_template_directory_uri() . '/js/front.js', array('jquery','backbone','underscore'), '1.0.0', true );
		if(is_home() || is_category()){
			wp_enqueue_script( 'blog', 	 	get_template_directory_uri() . '/js/blog.js', array('jquery','backbone','underscore'), '1.0.0', true );
		}

		//register global variables
		$variables = array(
			'ajaxURL' 			=> admin_url('/admin-ajax.php'),
			'homeURL' 			=> home_url(),
		);
		?>
		<script type="text/javascript">
			oe_globals = <?php echo json_encode($variables) ?>
		</script>
		<?php
	}
	/*-----------------------------------------------------------------------------------*/
	/* Taxonomy add meta field
	/*-----------------------------------------------------------------------------------*/
	public function taxonomy_add_new_meta_field() {
		// this will add the custom meta field to the add new term page
	?>
		<div class="form-field">
			<label for="term_meta[icon]"><?php _e( 'Portfolio Category Icon', 'oneengine' ); ?></label>
			<input type="text" name="term_meta[icon]" id="term_meta[icon]" value="">
			<p class="description"><?php _e( 'Enter a icon name for this field.( You can choose icon <a target="_blank" href="http://fortawesome.github.io/Font-Awesome/cheatsheet/">here</a>)','oneengine' ); ?></p>
		</div>
	<?php
	}
	public function taxonomy_edit_meta_field($term) {
	 
		// put the term ID into a variable
		$t_id = $term->term_id;
	 
		// retrieve the existing value(s) for this meta field. This returns an array
		$term_meta = get_option( "taxonomy_$t_id" ); ?>
		<tr class="form-field">
		<th scope="row" valign="top"><label for="term_meta[icon]"><?php _e( 'Portfolio Category Icon', 'oneengine' ); ?></label></th>
			<td>
				<input type="text" name="term_meta[icon]" id="term_meta[icon]" value="<?php echo esc_attr( $term_meta['icon'] ) ? esc_attr( $term_meta['icon'] ) : ''; ?>">
				<p class="description"><?php _e( 'Enter a value for this field.(<a target="_blank" href="http://fortawesome.github.io/Font-Awesome/cheatsheet/">Example</a>)','oneengine' ); ?></p>
			</td>
		</tr>
	<?php
	}
	public function save_taxonomy_custom_meta( $term_id ) {
		if ( isset( $_POST['term_meta'] ) ) {
			$t_id = $term_id;
			$term_meta = get_option( "taxonomy_$t_id" );
			$cat_keys = array_keys( $_POST['term_meta'] );
			foreach ( $cat_keys as $key ) {
				if ( isset ( $_POST['term_meta'][$key] ) ) {
					$term_meta[$key] = $_POST['term_meta'][$key];
				}
			}
			// Save the option array.
			update_option( "taxonomy_$t_id", $term_meta );
		}
	} 			
	/*-----------------------------------------------------------------------------------*/
	/* Add Metaboxes
	/*-----------------------------------------------------------------------------------*/	
	public function add_meta_boxes(){
		add_meta_box(
			'team_metabox',
			__( 'Team Infomation', 'oneengine' ),
			array($this,'team_meta_box_callback'),
			'team',
			'normal',
			'high'
		);
		add_meta_box(
			'slider_metabox',
			__( 'Slider Data', 'oneengine' ),
			array($this,'slider_meta_box_callback'),
			'slider',
			'normal',
			'high'
		);		
	}
	public function slider_meta_box_callback(){
		global $post;
		wp_enqueue_style( 'wp-color-picker');
		wp_enqueue_script( 'wp-color-picker');		
		wp_nonce_field( 'oe_post_nonce', 'oe_post_nonce' );
		?>
		<label class="team-lbl" for="oe_slider_bg"><?php _e('Slider Background Color:', 'oneengine') ?></label>
		<input type="text" class="input-custom-field" name="oe_slider_bg" id="oe_slider_bg" value="<?php echo get_post_meta($post->ID, 'oe_slider_bg', true) ?>"><br>
		<script type="text/javascript">
			jQuery(document).ready(function($){
			   $('#oe_slider_bg').wpColorPicker();
			});
		</script>
		<style type="text/css">
			label.team-lbl {
				margin-top: 5px;
				margin-right: 10px;
				float: left;
			}
		</style>
		<?php
	}	
	public function team_meta_box_callback(){
		global $post;
		wp_nonce_field( 'oe_post_nonce', 'oe_post_nonce' );
		?>	
		<label class="team-lbl" for="oe_team_position"><?php _e('Position:', 'oneengine') ?></label>
		<input type="text" class="input-custom-field" name="oe_team_position" id="oe_team_position" placeholder="e.g: Co-Founder Creative Director"  value="<?php echo get_post_meta($post->ID, 'oe_team_position', true) ?>"><br>

		<label class="team-lbl" for="oe_team_fb"><?php _e('Facebook:', 'oneengine') ?></label>
		<input type="url" class="input-custom-field" name="oe_team_fb" id="oe_team_fb" placeholder="http://" value="<?php echo get_post_meta($post->ID, 'oe_team_fb', true) ?>"><br>

		<label class="team-lbl" for="oe_team_tw"><?php _e('Twitter:', 'oneengine') ?></label>
		<input type="url" class="input-custom-field" name="oe_team_tw" id="oe_team_tw" placeholder="http://" value="<?php echo get_post_meta($post->ID, 'oe_team_tw', true) ?>"><br>

		<label class="team-lbl" for="oe_team_db"><?php _e('Dribble:', 'oneengine') ?></label>
		<input type="url" class="input-custom-field" name="oe_team_db" id="oe_team_db" placeholder="http://" value="<?php echo get_post_meta($post->ID, 'oe_team_db', true) ?>"><br>

		<label class="team-lbl" for="oe_team_gplus"><?php _e('Google+:', 'oneengine') ?></label>
		<input type="url" class="input-custom-field" name="oe_team_gplus" id="oe_team_gplus" placeholder="http://" value="<?php echo get_post_meta($post->ID, 'oe_team_gplus', true) ?>"><br>
		<style type="text/css">
			input.input-custom-field{width: 300px;width: 300px;margin-bottom: 15px;margin-top: 15px;}label.team-lbl{display:inline-block;min-width: 70px;}
		</style>
		<?php
	}
	public function save_meta_boxes($post_id){
		if ( get_post_type( $post_id ) ==  'team' ){

			if ( ! isset( $_POST['oe_post_nonce'] ) )
	    		return $post_id;

			if ( ! wp_verify_nonce( $_POST['oe_post_nonce'], 'oe_post_nonce' ) )
	      		return $post_id; 

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return;

			if ( ! current_user_can( 'edit_post', $post_id ) )
	        	return $post_id; 

	        if(isset($_POST['oe_team_position']))
				update_post_meta( $post_id, 'oe_team_position', $_POST['oe_team_position'] );   
	        if(isset($_POST['oe_team_fb']))
				update_post_meta( $post_id, 'oe_team_fb', $_POST['oe_team_fb'] ); 			
	        if(isset($_POST['oe_team_tw']))
				update_post_meta( $post_id, 'oe_team_tw', $_POST['oe_team_tw'] ); 
	        if(isset($_POST['oe_team_db']))
				update_post_meta( $post_id, 'oe_team_db', $_POST['oe_team_db'] ); 			
	        if(isset($_POST['oe_team_gplus']))
				update_post_meta( $post_id, 'oe_team_gplus', $_POST['oe_team_gplus'] ); 

		} 
		if ( get_post_type( $post_id ) ==  'slider' ){

			if ( ! isset( $_POST['oe_post_nonce'] ) )
	    		return $post_id;

			if ( ! wp_verify_nonce( $_POST['oe_post_nonce'], 'oe_post_nonce' ) )
	      		return $post_id; 

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return;

			if ( ! current_user_can( 'edit_post', $post_id ) )
	        	return $post_id; 

	        if(isset($_POST['oe_slider_bg']))
				update_post_meta( $post_id, 'oe_slider_bg', $_POST['oe_slider_bg'] );   

		}
		return $post_id;
	}
	/*-----------------------------------------------------------------------------------*/
	/* Ajax Like Post
	/*-----------------------------------------------------------------------------------*/	
	public function et_like_post(){
		$data = $_REQUEST['content'];
		$count = get_post_meta( $data['id'], 'et_like_count', true ) ? (int) get_post_meta( $data['id'], 'et_like_count', true ) : 0;
		$count++;
		$success = update_post_meta( $data['id'], 'et_like_count', $count );
		$response = array(
				'success' => $success,
				'count'   => get_post_meta( $data['id'], 'et_like_count', true )
			);
		wp_send_json( $response );
	}	
	/*-----------------------------------------------------------------------------------*/
	/* Ajax Portfolio
	/*-----------------------------------------------------------------------------------*/	
	public function et_load_portfolio(){
		$data = $_REQUEST['content'];
		$portfolio = get_post($data['id']);
		$cats = '';
		$terms = get_the_terms( $portfolio->ID, 'portfolio_cat' );
		foreach ($terms as $term) {
			$cats .= ' '.$term->name;
		}
		// Get sharing options & button get in touch
		$sharing_sites  	 = oneengine_option('social_share_port');
		$get_in_touch  	     = oneengine_option('btn_port_getintouch');
		$get_in_touch_link   = oneengine_option('btn_port_getintouch_link');
		
		$twitter_share	= '';
		$fb_share 		= '';
		$google_share 	= '';
		$btn_get 		= '';
		
		if( $get_in_touch == 1 || $get_in_touch == true ) $btn_get = '<a href="'.$get_in_touch_link.'" class="btn get-in-touch">'.__('Get In Touch').'</a>';
		
		foreach ( $sharing_sites as $key => $value ) {
			
			// Twitter
			if ( $key == 'twitter' && $value ) {
				$twitter_share = '<li><a class="sb-twitter" href="http://twitter.com/share?url='.home_url().'/#portfolio-page&amp;lang=en&amp;text=Check%20out%20this%20awesome%20project:&amp;" onclick="javascript:window.open(this.href,\'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=620\');return false;" data-count="none" data-via=" "><i class="fa fa-twitter"></i></a></li>';	
			}
			
			// Facebook
			if ( $key == 'facebook' && $value ) {
				$fb_share = '<li><a class="sb-facebook" href="http://www.facebook.com/sharer/sharer.php?u='.home_url().'/#portfolio-page" onclick="javascript:window.open(this.href,\'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=660\');return false;" target="_blank"><i class="fa fa-facebook"></i></a></li>';
			}
			
			// Google+
			if ( $key == 'google_plus' && $value ) {
				$google_share = '<li><a class="sb-google" href="https://plus.google.com/share?url='.home_url().'" onclick="javascript:window.open(this.href,\'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=500\');return false;"><i class="fa fa-google-plus"></i></a></li>';
			}
			
		}
		
		$html = '<div class="mask-color-port">
					<div id="preview-area">
						<div class="spinner">
						  <div class="dot1"></div>
						  <div class="dot2"></div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="title-port-wrapper col-md-12">
						<h1 class="title-port">'.$portfolio->post_title.'</h1>
						<span class="category">'.$cats.'</span>
					</div>
				</div>
				<div class="port-data">
					<div class="row">
						<div class="col-md-8 port-thumb">
							<div class="thumbnail-img">
								'.get_the_post_thumbnail( $portfolio->ID, 'full' ).'
							</div>
						</div>
						<div class="col-md-4 port-excerpt">
							'.apply_filters( 'the_content', $portfolio->post_content ).'
							<div class="clearfix"></div>
							<div class="social-share">
								'.$btn_get.'
								<ul class="social">
									'.$fb_share.'
									'.$twitter_share.'
									'.$google_share.'
								</ul>
							</div>
						</div>
					</div>
				</div>';
		$response = array(
				'success'   => true,
				'html'	    => $html,
				'prev_post' => get_next_previous_port_id($portfolio->ID, 'next'),
				'next_post' => get_next_previous_port_id($portfolio->ID, 'prev'),
			);
		wp_send_json( $response );
	}
	public function et_loadmore_post(){

		$data = $_REQUEST['content'];
		$posts = array();
		global $post;
		$query = new WP_Query(array(
				'paged' => $data['page'],
				'post_type' => 'post'
			));
		if($query->have_posts()){
			while($query->have_posts()){
				$query->the_post();

				$posts[] = $post;
				$et_like_count = get_post_meta($post->ID, 'et_like_count', true) ? get_post_meta($post->ID, 'et_like_count', true) : 0;
				$num_comments = get_comments_number(); // get_comments_number returns only a numeric value

				if ( comments_open() ) {
					if ( $num_comments == 0 ) {
						$comments = __('No Comments', 'oneengine');
					} elseif ( $num_comments > 1 ) {
						$comments = $num_comments . __(' Comments', 'oneengine');
					} else {
						$comments = __('1 Comment', 'oneengine');
					}
					$write_comments = '<a href="' . get_comments_link() .'">'. $comments.'</a>';
				} else {
					$write_comments =  __('Comments are off for this post.', 'oneengine');
				}			
				$post->html = '
					<div class="col-md-6 et-blog-post">
		            	<div class="image-blog-wrapper">
							'.get_the_post_thumbnail( $post->ID, 'full', array('class' => 'et-post-thumbnail img-responsive') ).'
		                </div>
						<div class="clearfix"></div>
						<div class="et-post-data container">
							<div class="row">
								<div class="col-md-2 et-post-data-left">
									<span class="et-post-month">'.get_the_time('M').'</span>
									<span class="et-post-date">'.get_the_time('d').'</span>
									<a href="#" data-id="'.$post->ID.'" class="et-like-post '.is_like_post($post->ID).'">
										<span class="et-post-heart"><i class="fa fa-heart"></i><span class="count">'.$et_like_count.'</span></span>
									</a>
								</div>
								<div class="col-md-10 et-post-data-right">
									<h1 class="title-blog">'.get_the_title().'</h1>
									<div class="et-post-info">
										'.__('Post by','oneengine').get_the_author().' | '.get_the_category_list().' | '.$write_comments.'
									</div>
									<div class="clearfix"></div>
									<div class="et-post-excerpt">
										'.get_the_excerpt().'
									</div>
									<div class="clearfix"></div>
									<a href="'.get_permalink().'" class="read-more"><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;'.__('Read more','oneengine').'</a>
								</div>
							</div>
						</div>
					</div>			
						';
			}
			$response = array(
					'success'   	=> true,
					'posts'	    	=> $posts,
					'current_page'  => $data['page'],
				);
		} else {
			$response = array(
					'success'   => false,
				);	
		}
		wp_send_json( $response );
	}		
}

new OneEngine();
?>