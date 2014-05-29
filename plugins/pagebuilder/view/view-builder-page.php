<?php
/** 
 * Builder Page
 *
 * @description Main admin UI settings page
 * @package Aqua Page Builder
 *
 */
 
// Debugging
if(isset($_POST) && $this->args['debug'] == true) {
	echo '<pre>';
	print_r($_POST);
	echo '</pre>';
}

// Permissions Check
if ( ! current_user_can('edit_theme_options') )
	wp_die( __( 'Cheatin&#8217; uh?','oneengine') );
	
$messages = array();

// Get selected template id
$selected_template_id = isset($_REQUEST['template']) ? (int) $_REQUEST['template'] : 0;

// Actions
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'edit';
$template = isset($_REQUEST['template']) ? $_REQUEST['template'] : 0;

// DEBUG
//echo '<pre>';
//print_r($_POST);
//echo '</pre>';

// Template title & layout
$template_name = isset($_REQUEST['template-name']) && !empty($_REQUEST['template-name']) ? htmlspecialchars($_REQUEST['template-name']) : 'No Title';

// Get all templates
$templates = $this->get_templates();

// Get recently edited template
$recently_edited_template = (int) get_user_option( 'recently_edited_template' );

if( ! isset( $_REQUEST['template'] ) && $recently_edited_template && $this->is_template( $recently_edited_template )) {
	$selected_template_id = $recently_edited_template;
} elseif ( ! isset( $_REQUEST['template'] ) && $selected_template_id == 0 && !empty($templates)) {
	$selected_template_id = $templates[0]->ID;
}

//define selected template object
$selected_template_object = get_post($selected_template_id);

// saving action
switch($action) {

	case 'create' :
		
		$new_id = $this->create_template($template_name);
		
		if(!is_wp_error($new_id)) {
			$selected_template_id = $new_id;
		
			//refresh templates var
			$templates = $this->get_templates();
			$selected_template_object = get_post($selected_template_id);
			
			$messages[] = '<div id="message" class="updated"><p>' . __('The ', 'oneengine') . '<strong>' . $template_name . '</strong>' . __(' page template has been successfully created', 'oneengine') . '</p></div>';
		} else {
			$errors = '<ul>';
			foreach( $new_id->get_error_messages() as $error ) {
				$errors .= '<li><strong>'. $error . '</strong></li>';
			}
			$errors .= '</ul>';
			
			$messages[] = '<div id="message" class="error"><p>' . __('Sorry, the operation was unsuccessful for the following reason(s): ', 'oneengine') . '</p>' . $errors . '</div>';
		}
		
		break;
		
	case 'update' :
	
		$blocks = isset($_REQUEST['aq_blocks']) ? $_REQUEST['aq_blocks'] : '';
		
		$this->update_template($selected_template_id, $blocks, $template_name);
		
		//refresh templates var
		$templates = $this->get_templates();
		$selected_template_object = get_post($selected_template_id);
		
		$messages[] = '<div id="message" class="updated"><p>' . __('The ', 'oneengine') . '<strong>' . $template_name . '</strong>' . __(' page template has been updated', 'oneengine') . '</p></div>';
		break;
		
	case 'delete' :
		
		$this->delete_template($selected_template_id);
		
		//refresh templates var
		$templates = $this->get_templates();
		$selected_template_id =	!empty($templates) ? $templates[0]->ID : 0;
		$selected_template_object = get_post($selected_template_id);
		
		$messages[] = '<div id="message" class="updated"><p>' . __('The template has been successfully deleted', 'oneengine') . '</p></div>';
		break;
}

global $current_user;
update_user_option($current_user->ID, 'recently_edited_template', $selected_template_id);

//display admin notices & messages
if(!empty($messages)) foreach($messages as $message) { echo $message; }

//disable blocks archive if no template
$disabled = $selected_template_id === 0 ? 'metabox-holder-disabled' : '';

?>

<div class="wrap">
	<div id="fa fa-themes" class="icon32"><br/></div>
	<h2><?php echo $this->args['page_title'] ?></h2>
	
	<div id="page-builder-frame">
		
        <!-- Dialog
   		======================================================================== -->
        <div id="overlay" class="web_dialog_overlay"></div>
    
        <div id="dialog" class="web_dialog">
           <table style="width: 100%; border: 0px;" cellpadding="3" cellspacing="0">
              <tr>
                 <td class="web_dialog_title">List Icon</td>
                 <td class="web_dialog_title align_right">
                    <a href="#" id="btnClose">Close</a>
                 </td>
              </tr>
              <tr>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
              </tr>
              <tr>
                 <td colspan="2" style="padding-left: 15px;">
                    <b>Choose your icon? </b>
                 </td>
              </tr>
              <tr>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
              </tr>
              <tr>
                 <td colspan="2" style="padding-left: 15px;">
                    <div id="brands">
                    	<div class="brands-icon">
                        	N/A
                            <input id="brand" name="brand-name" checked="checked" type="radio" value="">
                        </div>
                    	<div class="brands-icon">
                            <i class="fa fa-glass"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-glass">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-music"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-music">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-search"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-search">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-envelope-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-envelope-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-heart"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-heart">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-star"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-star">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-star-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-star-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-user"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-user">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-film"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-film">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-th-large"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-th-large">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-th"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-th">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-th-list"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-th-list">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-check"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-check">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-times"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-times">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-search-plus"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-search-plus">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-search-minus"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-search-minus">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-power-off"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-power-off">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-signal"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-signal">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-gear"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-gear">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-cog"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-cog">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-trash-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-trash-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-home"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-home">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-file-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-file-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-clock-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-clock-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-road"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-road">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-download"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-download">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-arrow-circle-o-down"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-arrow-circle-o-down">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-arrow-circle-o-up"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-arrow-circle-o-up">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-inbox"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-inbox">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-play-circle-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-play-circle-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-rotate-right"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-rotate-right">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-repeat"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-repeat">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-refresh"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-refresh">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-list-alt"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-list-alt">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-lock"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-lock">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-flag"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-flag">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-headphones"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-headphones">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-volume-off"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-volume-off">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-volume-down"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-volume-down">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-volume-up"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-volume-up">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-qrcode"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-qrcode">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-barcode"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-barcode">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-tag"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-tag">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-tags"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-tags">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-book"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-book">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-bookmark"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-bookmark">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-print"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-print">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-camera"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-camera">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-font"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-font">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-bold"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-bold">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-italic"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-italic">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-text-height"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-text-height">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-text-width"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-text-width">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-align-left"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-align-left">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-align-center"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-align-center">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-align-right"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-align-right">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-align-justify"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-align-justify">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-list"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-list">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-dedent"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-dedent">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-outdent"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-outdent">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-indent"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-indent">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-video-camera"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-video-camera">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-picture-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-picture-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-pencil"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-pencil">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-map-marker"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-map-marker">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-adjust"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-adjust">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-tint"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-tint">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-edit"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-edit">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-pencil-square-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-pencil-square-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-share-square-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-share-square-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-check-square-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-check-square-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-arrows"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-arrows">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-step-backward"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-step-backward">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-fast-backward"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-fast-backward">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-backward"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-backward">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-play"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-play">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-pause"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-pause">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-stop"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-stop">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-forward"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-forward">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-fast-forward"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-fast-forward">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-step-forward"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-step-forward">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-eject"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-eject">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-chevron-left"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-chevron-left">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-chevron-right"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-chevron-right">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-plus-circle"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-plus-circle">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-minus-circle"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-minus-circle">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-times-circle"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-times-circle">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-check-circle"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-check-circle">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-question-circle"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-question-circle">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-info-circle"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-info-circle">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-crosshairs"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-crosshairs">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-times-circle-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-times-circle-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-check-circle-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-check-circle-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-ban"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-ban">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-arrow-left"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-arrow-left">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-arrow-right"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-arrow-right">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-arrow-up"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-arrow-up">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-arrow-down"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-arrow-down">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-mail-forward"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-mail-forward">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-share"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-share">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-expand"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-expand">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-compress"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-compress">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-plus"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-plus">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-minus"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-minus">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-asterisk"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-asterisk">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-exclamation-circle"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-exclamation-circle">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-gift"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-gift">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-leaf"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-leaf">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-fire"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-fire">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-eye"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-eye">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-eye-slash"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-eye-slash">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-warning"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-warning">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-exclamation-triangle"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-exclamation-triangle">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-plane"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-plane">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-calendar"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-calendar">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-random"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-random">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-comment"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-comment">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-magnet"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-magnet">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-chevron-up"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-chevron-up">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-chevron-down"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-chevron-down">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-retweet"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-retweet">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-shopping-cart"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-shopping-cart">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-folder"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-folder">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-folder-open"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-folder-open">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-arrows-v"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-arrows-v">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-arrows-h"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-arrows-h">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-bar-chart-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-bar-chart-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-twitter-square"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-twitter-square">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-facebook-square"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-facebook-square">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-camera-retro"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-camera-retro">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-key"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-key">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-gears"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-gears">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-cogs"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-cogs">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-comments"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-comments">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-thumbs-o-up"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-thumbs-o-up">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-thumbs-o-down"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-thumbs-o-down">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-star-half"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-star-half">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-heart-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-heart-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-sign-out"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-sign-out">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-linkedin-square"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-linkedin-square">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-thumb-tack"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-thumb-tack">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-external-link"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-external-link">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-sign-in"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-sign-in">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-trophy"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-trophy">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-github-square"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-github-square">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-upload"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-upload">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-lemon-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-lemon-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-phone"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-phone">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-square-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-square-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-bookmark-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-bookmark-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-phone-square"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-phone-square">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-twitter"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-twitter">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-facebook"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-facebook">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-github"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-github">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-unlock"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-unlock">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-credit-card"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-credit-card">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-rss"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-rss">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-hdd-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-hdd-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-bullhorn"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-bullhorn">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-bell"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-bell">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-certificate"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-certificate">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-hand-o-right"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-hand-o-right">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-hand-o-left"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-hand-o-left">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-hand-o-up"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-hand-o-up">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-hand-o-down"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-hand-o-down">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-arrow-circle-left"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-arrow-circle-left">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-arrow-circle-right"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-arrow-circle-right">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-arrow-circle-up"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-arrow-circle-up">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-arrow-circle-down"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-arrow-circle-down">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-globe"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-globe">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-wrench"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-wrench">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-tasks"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-tasks">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-filter"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-filter">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-briefcase"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-briefcase">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-arrows-alt"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-arrows-alt">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-group"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-group">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-users"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-users">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-chain"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-chain">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-link"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-link">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-cloud"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-cloud">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-flask"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-flask">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-cut"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-cut">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-scissors"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-scissors">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-copy"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-copy">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-files-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-files-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-paperclip"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-paperclip">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-save"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-save">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-floppy-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-floppy-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-square"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-square">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-bars"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-bars">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-list-ul"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-list-ul">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-list-ol"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-list-ol">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-strikethrough"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-strikethrough">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-underline"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-underline">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-table"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-table">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-magic"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-magic">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-truck"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-truck">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-pinterest"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-pinterest">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-pinterest-square"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-pinterest-square">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-google-plus-square"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-google-plus-square">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-google-plus"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-google-plus">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-money"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-money">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-caret-down"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-caret-down">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-caret-up"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-caret-up">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-caret-left"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-caret-left">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-caret-right"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-caret-right">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-columns"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-columns">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-unsorted"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-unsorted">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-sort"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-sort">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-sort-down"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-sort-down">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-sort-asc"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-sort-asc">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-sort-up"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-sort-up">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-sort-desc"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-sort-desc">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-envelope"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-envelope">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-linkedin"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-linkedin">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-rotate-left"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-rotate-left">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-undo"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-undo">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-legal"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-legal">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-gavel"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-gavel">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-dashboard"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-dashboard">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-tachometer"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-tachometer">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-comment-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-comment-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-comments-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-comments-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-flash"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-flash">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-bolt"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-bolt">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-sitemap"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-sitemap">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-umbrella"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-umbrella">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-paste"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-paste">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-clipboard"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-clipboard">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-lightbulb-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-lightbulb-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-exchange"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-exchange">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-cloud-download"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-cloud-download">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-cloud-upload"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-cloud-upload">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-user-md"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-user-md">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-stethoscope"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-stethoscope">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-suitcase"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-suitcase">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-bell-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-bell-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-coffee"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-coffee">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-cutlery"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-cutlery">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-file-text-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-file-text-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-building-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-building-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-hospital-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-hospital-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-ambulance"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-ambulance">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-medkit"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-medkit">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-fighter-jet"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-fighter-jet">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-beer"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-beer">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-h-square"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-h-square">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-plus-square"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-plus-square">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-angle-double-left"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-angle-double-left">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-angle-double-right"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-angle-double-right">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-angle-double-up"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-angle-double-up">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-angle-double-down"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-angle-double-down">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-angle-left"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-angle-left">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-angle-right"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-angle-right">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-angle-up"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-angle-up">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-angle-down"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-angle-down">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-desktop"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-desktop">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-laptop"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-laptop">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-tablet"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-tablet">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-mobile-phone"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-mobile-phone">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-mobile"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-mobile">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-circle-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-circle-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-quote-left"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-quote-left">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-quote-right"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-quote-right">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-spinner"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-spinner">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-circle"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-circle">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-mail-reply"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-mail-reply">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-reply"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-reply">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-github-alt"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-github-alt">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-folder-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-folder-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-folder-open-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-folder-open-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-smile-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-smile-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-frown-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-frown-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-meh-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-meh-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-gamepad"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-gamepad">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-keyboard-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-keyboard-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-flag-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-flag-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-flag-checkered"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-flag-checkered">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-terminal"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-terminal">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-code"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-code">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-reply-all"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-reply-all">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-mail-reply-all"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-mail-reply-all">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-star-half-empty"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-star-half-empty">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-star-half-full"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-star-half-full">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-star-half-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-star-half-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-location-arrow"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-location-arrow">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-crop"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-crop">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-code-fork"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-code-fork">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-unlink"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-unlink">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-chain-broken"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-chain-broken">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-question"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-question">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-info"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-info">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-exclamation"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-exclamation">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-superscript"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-superscript">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-subscript"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-subscript">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-eraser"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-eraser">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-puzzle-piece"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-puzzle-piece">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-microphone"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-microphone">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-microphone-slash"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-microphone-slash">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-shield"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-shield">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-calendar-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-calendar-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-fire-extinguisher"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-fire-extinguisher">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-rocket"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-rocket">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-maxcdn"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-maxcdn">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-chevron-circle-left"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-chevron-circle-left">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-chevron-circle-right"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-chevron-circle-right">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-chevron-circle-up"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-chevron-circle-up">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-chevron-circle-down"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-chevron-circle-down">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-html5"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-html5">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-css3"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-css3">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-anchor"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-anchor">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-unlock-alt"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-unlock-alt">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-bullseye"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-bullseye">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-ellipsis-h"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-ellipsis-h">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-ellipsis-v"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-ellipsis-v">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-rss-square"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-rss-square">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-play-circle"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-play-circle">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-ticket"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-ticket">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-minus-square"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-minus-square">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-minus-square-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-minus-square-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-level-up"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-level-up">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-level-down"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-level-down">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-check-square"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-check-square">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-pencil-square"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-pencil-square">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-external-link-square"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-external-link-square">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-share-square"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-share-square">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-compass"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-compass">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-toggle-down"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-toggle-down">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-caret-square-o-down"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-caret-square-o-down">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-toggle-up"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-toggle-up">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-caret-square-o-up"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-caret-square-o-up">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-toggle-right"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-toggle-right">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-caret-square-o-right"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-caret-square-o-right">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-euro"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-euro">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-eur"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-eur">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-gbp"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-gbp">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-dollar"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-dollar">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-usd"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-usd">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-rupee"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-rupee">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-inr"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-inr">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-cny"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-cny">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-rmb"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-rmb">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-yen"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-yen">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-jpy"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-jpy">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-ruble"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-ruble">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-rouble"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-rouble">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-rub"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-rub">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-won"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-won">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-krw"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-krw">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-bitcoin"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-bitcoin">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-btc"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-btc">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-file"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-file">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-file-text"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-file-text">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-sort-alpha-asc"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-sort-alpha-asc">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-sort-alpha-desc"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-sort-alpha-desc">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-sort-amount-asc"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-sort-amount-asc">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-sort-amount-desc"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-sort-amount-desc">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-sort-numeric-asc"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-sort-numeric-asc">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-sort-numeric-desc"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-sort-numeric-desc">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-thumbs-up"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-thumbs-up">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-thumbs-down"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-thumbs-down">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-youtube-square"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-youtube-square">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-youtube"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-youtube">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-xing"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-xing">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-xing-square"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-xing-square">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-youtube-play"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-youtube-play">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-dropbox"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-dropbox">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-stack-overflow"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-stack-overflow">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-instagram"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-instagram">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-flickr"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-flickr">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-adn"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-adn">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-bitbucket"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-bitbucket">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-bitbucket-square"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-bitbucket-square">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-tumblr"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-tumblr">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-tumblr-square"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-tumblr-square">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-long-arrow-down"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-long-arrow-down">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-long-arrow-up"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-long-arrow-up">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-long-arrow-left"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-long-arrow-left">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-long-arrow-right"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-long-arrow-right">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-apple"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-apple">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-windows"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-windows">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-android"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-android">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-linux"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-linux">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-dribbble"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-dribbble">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-skype"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-skype">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-foursquare"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-foursquare">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-trello"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-trello">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-female"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-female">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-male"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-male">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-gittip"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-gittip">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-sun-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-sun-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-moon-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-moon-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-archive"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-archive">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-bug"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-bug">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-vk"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-vk">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-weibo"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-weibo">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-renren"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-renren">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-pagelines"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-pagelines">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-stack-exchange"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-stack-exchange">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-arrow-circle-o-right"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-arrow-circle-o-right">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-arrow-circle-o-left"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-arrow-circle-o-left">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-toggle-left"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-toggle-left">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-caret-square-o-left"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-caret-square-o-left">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-dot-circle-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-dot-circle-o">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-wheelchair"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-wheelchair">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-vimeo-square"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-vimeo-square">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-turkish-lira"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-turkish-lira">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-try"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-try">
                        </div>
                        <div class="brands-icon">
                            <i class="fa fa-plus-square-o"></i>
                            <input id="brand" name="brand-name" type="radio" value="fa-plus-square-o">
                        </div>
                    </div>
                 </td>
              </tr>
              <tr>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
              </tr>
              <tr>
                 <td colspan="2" style="text-align: center;">
                    <input id="btnSubmit" type="button" value="Submit" />
                 </td>
              </tr>
           </table>
        </div>
        <!-- Dialog / End -->
        
		<div id="page-builder-column" class="metabox-holder <?php echo $disabled ?>">
			<div id="page-builder-archive" class="postbox">
				<h3 class="hndle"><span><?php _e('List Blocks', 'oneengine') ?></span><span id="removing-block"><?php _e('Deleting', 'oneengine') ?></span></h3>
				<div class="inside">
					<ul id="blocks-archive" class="cf">
						<?php $this->blocks_archive() ?>
					</ul>
					<p><?php _e('Need help? Use the Help tab in the upper right of your screen.', 'oneengine') ?></p>
				</div>
			</div>
		</div>
	
		<div id="page-builder-fixed">
			<div id="page-builder">
				<div class="aqpb-tabs-nav">
				
					<div class="aqpb-tabs-arrow aqpb-tabs-arrow-left">
						<a>&laquo;</a>
					</div>
					
					<div class="aqpb-tabs-wrapper">
						<div class="aqpb-tabs">
							
							<?php
							foreach ( (array) $templates as $template ) {
								if($selected_template_id == $template->ID) {
									echo '<span class="aqpb-tab aqpb-tab-active aqpb-tab-sortable">'. htmlspecialchars($template->post_title) .'</span>';
								} else {
									echo '<a class="aqpb-tab aqpb-tab-sortable" data-template_id="'.$template->ID.'" href="' . esc_url(add_query_arg(
										array(
											'page' => $this->args['page_slug'], 
											'action' => 'edit',
											'template' => $template->ID,
										),
										admin_url( 'themes.php' )
									)) . '">'. htmlspecialchars($template->post_title) .'</a>';
								}
							}
							?>
							
							<!--add new template button-->
							<?php if($selected_template_id == 0) { ?>
							<span class="aqpb-tab aqpb-tab-add aqpb-tab-active"><abbr title="Add Template">+</abbr></span>
							<?php } else { ?>
							<a class="aqpb-tab aqpb-tab-add" href="<?php
								echo esc_url(add_query_arg(
									array(
										'page' => $this->args['page_slug'], 
										'action' => 'edit',
										'template' => 0,
									),
									admin_url( 'themes.php' )
								));
							?>">
								<abbr title="Add Template">+</abbr>
							</a>
							<?php } ?>
							
						</div>
					</div>
					
					<div class="aqpb-tabs-arrow aqpb-tabs-arrow-right">
						<a>&raquo;</a>
					</div>
					
				</div>
				<div class="aqpb-wrap aqpbdiv">
					<form id="update-page-template" action="<?php echo $this->args['page_url'] ?>" method="post" enctype="multipart/form-data">
						<div id="aqpb-header">
							
								<div id="submitpost" class="submitbox">
									<div class="major-publishing-actions cf">
									
										<label class="open-label" for="template-name">
											<span><?php _e('Template Name', 'oneengine') ?></span>
											<input name="template-name" id="template-name" type="text" class="template-name regular-text" title="Enter template name here" placeholder="Enter template name here" value="<?php echo is_object($selected_template_object) ? $selected_template_object->post_title : ''; ?>">
										</label>
										
										<div id="template-shortcode">
											<input type="text" readonly value='[template id="<?php echo $selected_template_id ?>"]' onclick="select()"/>
										</div>
										
										<div class="publishing-action">
											<?php submit_button( empty( $selected_template_id ) ? __( 'Create Template', 'framework' ) : __( 'Save Template', 'framework' ), 'button-primary ', 'save_template', false, array( 'id' => 'save_template_header' ) ); ?>
										</div><!-- END .publishing-action -->
										
										<?php if(!empty($selected_template_id)) { ?>
										<div class="delete-action">
											<?php 
											echo '<a class="submitdelete deletion template-delete" href="' . esc_url(add_query_arg(
												array(
													'page' => $this->args['page_slug'], 
													'action' => 'delete',
													'template' => $selected_template_id,
													'_wpnonce' => wp_create_nonce('delete-template'),
												),
												admin_url( 'themes.php' )
											)) . '">'. __('Delete Template', 'oneengine') .'</a>';
											?>
										</div><!-- END .delete-action -->
										<?php } ?>
										
									</div><!-- END .major-publishing-actions -->
								</div><!-- END #submitpost .submitbox -->
								
								<?php 
								if($selected_template_id === 0) {
									wp_nonce_field( 'create-template', 'create-template-nonce' ); 
								} else {
									wp_nonce_field( 'update-template', 'update-template-nonce' );
								}
								?>	
								<input type="hidden" name="action" value="<?php echo empty( $selected_template_id ) ? 'create' : 'update' ?>"/>
								<input type="hidden" name="template" id="template" value="<?php echo $selected_template_id ?>"/>
								<input type="hidden" id="aqpb-nonce" name="aqpb-nonce" value="<?php echo wp_create_nonce('aqpb-settings-page-nonce') ?>"/>
							
						</div>
						
						<div id="aqpb-body">
							
							<ul class="blocks cf" id="blocks-to-edit">
								<?php 
								if($selected_template_id === 0) {
									echo '<p class="empty-template">';
									echo __('To create a custom page template, give it a name above and click Create Template. Then choose blocks like text, widgets or tabs &amp; toggles from the left column to add to this template.
									<br/><br/>
									You can drag and drop the blocks to put them in the order you want. Click on the small arrow at the corner of each block to reveal additional configuration options. You can also resize each block by clicking on either side of the block (Note that some blocks are not resizable)
									<br/><br/>
									When you have finished building your custom page template, make sure you click the Save Template button.', 'oneengine');
									echo '</p>';
									
									
								} else {
									$this->display_blocks($selected_template_id); 
								}
								?>
							</ul>
							
						</div>
						
						<div id="aqpb-footer">
							<div class="major-publishing-actions cf">
								<div class="publishing-action">
									<?php if(!empty($selected_template_id)) {
										submit_button( __( 'Save Template','oneengine'), 'button-primary ', 'save_template', false, array( 'id' => 'save_template_footer' ) ); 
									} ?>
								</div><!-- END .publishing-action -->
							</div><!-- END .major-publishing-actions -->
						</div>
						
					</div>
				</form>
			</div>
			<p style="float:left"><small>Aqua Page Builder &copy; 2012 by <a href="http://aquagraphite.com">Syamil MJ</a></small></p>
			<p style="float:right"><small>Version <?php echo AQPB_VERSION ?></small></p>
			
		</div>
		
		
	</div>
</div>