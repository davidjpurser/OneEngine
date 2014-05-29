<?php 
global $post,$wp_query; 
get_header();
the_post();
?>     
<?php 
	// Get sharing options
		$sharing_sites  = oneengine_option('social_share_blog');
		
		$twitter_share	= '';
		$fb_share 		= '';
		$google_share 	= '';
		
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
?>
<!-- Blog Header
======================================================================== -->
<div class="blog-header-wrapper">
	<?php 
		$color		= oneengine_option('header_blog_color'); 
		$img		= has_post_thumbnail($post->ID) ? wp_get_attachment_url( get_post_thumbnail_id($post->ID) ) : oneengine_option('header_blog_img', false, 'url');
		$repeat		= oneengine_option('header_blog_repeat');
		$parallax	= oneengine_option('header_blog_parallax');
		$cover		= oneengine_option('header_blog_cover'); 
		
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
	<div class="blog-header-img" <?php echo $css ?>></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Logo
                ======================================================================== -->
                <div calss="logo-wrapper">
                    <div class="logo">
                         <a href="<?php echo home_url(); ?>">
                            <?php 
                                $top   = '' ;
                                $left  = '' ;
                                $width = '' ;
                                if( oneengine_option('logo_top') != '' )$top    = 'top:'.oneengine_option('logo_top').'px;' ;
                                if( oneengine_option('logo_left') != '' )$left  = 'left:'.oneengine_option('logo_left').'px;';
                                if( oneengine_option('logo_width') != '' )$width = 'width:'.oneengine_option('logo_width').'px;';
                                if( oneengine_option('custom_logo', false, 'url') !== '' ){
                                    echo '<div class="logo-wrapper" style="'.$width.$left.$top.'"><img src="'. oneengine_option('custom_logo', false, 'url') .'" alt="'.get_bloginfo( 'name' ).'" /></div>';
                                }else{
                            ?>
                                <div class="logo-img logo-white"><span>E</span></div>
                            <?php } ?>
                         </a>
                    </div>  
                </div>
                <!-- Logo / End -->
            </div>
        </div>
    </div>
    <div class="clearfix" style="height:115px;"></div>      
    <div class="container single-blog-mobile">
        <div class="row">
            <div class="col-md-1 col-xs-2  single-blog-mobile et-post-data-left single-blog">
                <a href="<?php echo home_url(); ?>" class="home-icon"><i class="fa fa-home"></i></a>
                <span class="et-post-month"><?php the_time('M');?></span>
                <span class="et-post-date"><?php the_time('d');?></span>
                <a href="#" data-id="<?php echo $post->ID; ?>" class="et-like-post <?php echo is_like_post($post->ID); ?>">
                    <span class="et-post-heart"><i class="fa fa-heart"></i><span class="count"><?php echo get_post_meta($post->ID, 'et_like_count', true) ? get_post_meta($post->ID, 'et_like_count', true) : 0; ?></span></span>
                </a>
            </div>
            <div class="col-md-1 col-xs-2">
                <div class="social-share single-blog-share">
                    <ul class="social">
                        <?php 
                            echo $fb_share.$twitter_share.$google_share;
                        ?> 
                    </ul>
                </div>
            </div>
         </div>
    </div>
</div>
<!-- end blog-header -->
<div class="clearfix"></div>         
<!-- Container
======================================================================== -->

<div class="container">
	<div class="row">
    	<div class="single-blog-desktop">
            <div class="col-md-1 col-sm-1 et-post-data-left single-blog">
                <a href="<?php echo home_url(); ?>" class="home-icon"><i class="fa fa-home"></i></a>
                <span class="et-post-month"><?php the_time('M');?></span>
                <span class="et-post-date"><?php the_time('d');?></span>
                <a href="#" data-id="<?php echo $post->ID; ?>" class="et-like-post <?php echo is_like_post($post->ID); ?>">
                    <span class="et-post-heart"><i class="fa fa-heart"></i><span class="count"><?php echo get_post_meta($post->ID, 'et_like_count', true) ? get_post_meta($post->ID, 'et_like_count', true) : 0; ?></span></span>
                </a>
            </div>
            <div class="col-md-1 col-sm-1">
                <div class="social-share single-blog-share">
                    <ul class="social">
                        <?php 
                            echo $fb_share.$twitter_share.$google_share;
                        ?> 
                    </ul>
                </div>
            </div>
        </div>

		<div class="col-md-10" <?php post_class(); ?>>

			<h1 class="title-single"><?php the_title(); ?></h1>
			<div class="post-content">
				<?php the_content(); ?>
			</div><!-- Content / End -->
            <?php 
				if( has_tag() ) {
					the_tags('<div class="post-tags">', ', ', '</div><!-- Tags / End -->');
				}
			?>    
			<div class="comment-wrap">
				<?php comments_template(); ?>
			</div>			
		</div>		
	</div>
</div>
<?php
	$next_post = get_next_post();
	if (empty( $next_post )){
		$post = get_posts(array(
	    		'post_type' => 'post',
	    		'order'		=> 'ASC',
	    		'posts_per_page' => 1,
	    		));
		$next_post = $post[0];
	}
?>
<?php 
	$color_title		= oneengine_option('header_blog_title_color'); 
	$color_sub_title	= oneengine_option('header_blog_subtitle_color');
		
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
<a href="<?php echo get_permalink( $next_post->ID ); ?>">
<div class="next-post-container" style="background-image:url(<?php echo has_post_thumbnail($next_post->ID) ? wp_get_attachment_url( get_post_thumbnail_id($next_post->ID) ) : oneengine_option('header_blog_img', false, 'url'); ?>)">    
    <div class="animation-wrapper col-md-12">
        <div class="heading-title-wrapper blog-page" style="color">           
            <h2 class="title" <?php echo $css_title_color ?>><?php echo $next_post->post_title ?></h2>
            <span class="line-title" style="background-color:#cc467c"></span>
            <span class="sub-title" <?php echo $css_sub_title_color ?>><?php echo $next_post->post_excerpt; ?></span>
        </div>
    </div>
</div>
</a>
<!-- Container / End -->
<?php get_footer(); ?>