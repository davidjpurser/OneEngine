<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package OneEngine
 */
?>

	</div><!-- #content -->
	<div class="clearfix"></div>
	<footer id="contact" class="site-footer template-wrap" role="contentinfo">
		<?php 
			$color		= oneengine_option('footer_blog_color'); 
			$img		= oneengine_option('footer_blog_img', false, 'url');
			$repeat		= oneengine_option('footer_blog_repeat');
			$parallax	= oneengine_option('footer_blog_parallax');
			$cover		= oneengine_option('footer_blog_cover'); 
			
			$bg_repeat  = '';
			if( $repeat == 1 || $repeat == true){
				$bg_repeat = 'background-repeat:no-repeat;';
			}else $bg_repeat = 'background-repeat:repeat;';
			
			$bg_cover = '';
			if( $cover == 1 || $cover == true){
				$bg_cover = 'background-size:cover;';
			}else $bg_cover = '';
			
			$bg_img = '';
			if( $img ){
				$bg_img = 'background-image:url('.$img.');';
			}else $bg_img = '';
			
			$img		= ( ! empty ( $img ) ) 		? ''.$bg_img.'' : '';
			$color		= ( ! empty ( $color ) )  	? 'background-color:'. $color .';' : '';
			$repeat		= ( ! empty ( $repeat ) ) 	? ''. $bg_repeat .'' : '';
			$cover		= ( ! empty ( $cover ) ) 	? ''. $bg_cover .'' : '';
			$parallax 	= ( ! empty ( $parallax ) ) ? 'background-attachment: fixed;': '';
			
			
			/** Style Container */
			$style = ( 
				! empty( $img ) ||
				! empty( $color ) || 
				! empty( $repeat ) ||
				! empty( $cover ) ||
				! empty( $parallax ) ) ? 
					sprintf( '%s %s %s %s %s', $img, $color, $repeat, $cover, $parallax ) : '';
			$css = '';
			if ( ! empty( $style ) ) {			
				$css = 'style="'. $style .'" ';
			}
        ?>
        <div class="footer-img" <?php echo $css ?>></div>
    	<?php if(is_front_page()){ ?>

    	<div class="container">
            <div class="row">
				<?php 
                    $color_title		= oneengine_option('footer_blog_title_color'); 
                    $color_sub_title	= oneengine_option('footer_blog_subtitle_color');
                        
                    $color_title		= ( ! empty ( $color_title ) ) 		? 'color:'. $color_title .';' : '';
                    $color_sub_title	= ( ! empty ( $color_sub_title ) )  ? 'color:'. $color_sub_title .';' : '';
                    
                    /** Style Container */
                    $title_color = ( 
                        ! empty( $color_title ) ) ? 
                            sprintf( '%s', $color_title) : '';
                    $css_title_color = '';
                    if ( ! empty( $title_color ) ) {			
                        $css_title_color = 'style="'. $title_color .'" ';
                    }
                    
                    $sub_title_color = ( 
                        ! empty( $color_sub_title ) ) ? 
                            sprintf( '%s', $color_sub_title) : '';
                    $css_sub_title_color = '';
                    if ( ! empty( $sub_title_color ) ) {			
                        $css_sub_title_color = 'style="'. $sub_title_color .'" ';
                    }
                ?>
                <div class="col-md-12">
                    <div class="heading-title-wrapper" style="color">
                        <h2 class="title" <?php echo $css_title_color ?>><?php echo oneengine_option('footer_blog_title') ?></h2>
                        <span class="line-title" style="background-color:#fff"></span>
                        <span class="sub-title" <?php echo $css_sub_title_color ?>><?php echo oneengine_option('footer_blog_subtitle') ?></span>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="list-contact-wrapper">
					<?php if(oneengine_option('address_footer') != '') {?>
                    <div class="col-md-4">
                        <div class="contact-wrapper">
                            <span class="icon"><i class="fa fa-map-marker"></i></span>
                            <p><?php echo nl2br(oneengine_option('address_footer')); ?></p>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(oneengine_option('phone_footer') != '') {?>
                    <div class="col-md-4">
                        <div class="contact-wrapper">
                            <span class="icon"><i class="fa fa-phone"></i></span>
                            <p><?php echo nl2br(oneengine_option('phone_footer')); ?></p>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(oneengine_option('email_footer') != '') {?>
                    <div class="col-md-4">
                        <div class="contact-wrapper">
                            <span class="icon"><i class="fa fa-envelope"></i></span>
                            <p><?php echo nl2br(oneengine_option('email_footer')); ?></p>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="clearfix"></div>
                <?php if(oneengine_option('contact_form') != '' && is_front_page()) {?>
                <div class="contact-form-wrapper">
                	<h2 class="contact-title"><?php echo __('Get In Touch', 'oneengine')?></h2>
                	<?php echo do_shortcode( oneengine_option('contact_form') ); ?>
                </div>
                <?php } ?>
            </div>
        </div>
		<div class="site-info">
			<ul class="social-footer">
				<?php if(oneengine_option('facebook') != '') {?>
				<li><a href="<?php echo oneengine_option('facebook'); ?>"><i class="fa fa-facebook"></i></a></li>
				<?php } ?>
				<?php if(oneengine_option('twitter') != '') {?>
				<li><a href="<?php echo oneengine_option('twitter'); ?>"><i class="fa fa-twitter"></i></a></li>
				<?php } ?>
				<?php if(oneengine_option('dribbble') != '') {?>
				<li><a href="<?php echo oneengine_option('dribbble'); ?>"><i class="fa fa-dribbble"></i></a></li>
				<?php } ?>
                <?php if(oneengine_option('google_plus') != '') {?>
				<li><a href="<?php echo oneengine_option('google_plus'); ?>"><i class="fa fa-google-plus"></i></a></li>
				<?php } ?>
                <?php if(oneengine_option('pinterest') != '') {?>
				<li><a href="<?php echo oneengine_option('pinterest'); ?>"><i class="fa fa-google-plus"></i></a></li>
				<?php } ?>
                <?php if(oneengine_option('flickr') != '') {?>
				<li><a href="<?php echo oneengine_option('flickr'); ?>"><i class="fa fa-google-plus"></i></a></li>
				<?php } ?>
                <?php if(oneengine_option('linkedin') != '') {?>
				<li><a href="<?php echo oneengine_option('linkedin'); ?>"><i class="fa fa-google-plus"></i></a></li>
				<?php } ?>
			</ul>
			<div class="copyright">
				<?php echo nl2br(oneengine_option('copyright')); ?>
				<br>
			</div>			
		</div><!-- .site-info -->
        <?php } ?>
	</footer><!-- #colophon -->
	
</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>
