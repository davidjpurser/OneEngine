<?php header("Content-type: text/css"); ?>
<?php
	$absolute_path = __FILE__;
	$path_to_file = explode( 'wp-content', $absolute_path );
	$path_to_wp = $path_to_file[0];
	require_once( $path_to_wp.'/wp-load.php' );
?>
<?php 
	// Color Main
	$main_color = oneengine_option('main_color');
	// Color Link
	$link_color = oneengine_option('link_color');
	// Font Bold
	$font_bold  = $oneengine_options['menu_font']['font-weight'];
	
?>
<?php echo'
/**** GENERAL ****/
a:hover, a:focus{
	color:'.$link_color.'
}
::-webkit-input-placeholder { /* WebKit browsers */
    color:    #999;
}
:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
    color:    #999;
    opacity:  1;
}
::-moz-placeholder { /* Mozilla Firefox 19+ */
    color:    #999;
    opacity:  1;
}
:-ms-input-placeholder { /* Internet Explorer 10+ */
    color:    #999;
}
/**** PRELOADING ****/
.mask-color, .social-share ul.social li:hover a, #showRightPush:hover, .slicknav_btn:hover, .slicknav_nav a:hover, .slicknav_nav .slicknav_item:hover {
	background-color:'.$main_color.';
}

.prev:hover, .next:hover, .close-port:hover i, .read-more:hover, .read-more i, .view-all-blog:hover, .view-all-blog:hover span i, a.et-like-post.active span i, .btn.get-in-touch:hover, .et-post-data-left.single-blog a.home-icon:hover i, .form-submit input[type="submit"]:hover, .social-footer li a:hover i, .contact-form-wrapper input[type="submit"]:hover, #test_content .item .name-client, h1.title-blog a:hover, .btn.btn-oe:hover{
	color:'.$main_color.';
}
.close-port:hover, .view-all-blog:hover span, .btn.get-in-touch:hover, .image-blog-wrapper, .et-post-data-left.single-blog a.home-icon:hover, .form-submit input[type="submit"]:hover, .contact-form-wrapper input[type="submit"]:hover, .btn.btn-oe:hover, .popup-video:hover .icon-play-video{
	border-color:'.$main_color.';
}
.line-wrapper .line-circle, .pie-content h2, .percent-chart, .et-post-month, .et-post-date, .title-blog, .counter .timer, .btn.get-in-touch, .title-single, .post-tags a, .oe-comments-title, .copyright, .contact-form-wrapper input[type="submit"], .text-slider, a#scroll_to, .quote-charater, #test_content .item .name-client, .slicknav_menu  .slicknav_menutxt, .slicknav_nav a, .form-submit input[type="submit"], .btn.btn-oe, .blog-filer ul li a{
	font-weight:'.$font_bold.';
}
.color-white *{
	color:#ffffff !important;
}
.color-white .popup-video:hover, .color-white .popup-video:hover .icon-play-video i{
	color:'.$main_color.' !important;
}
';

?>

<?php echo oneengine_option('custom_css'); ?>