<?php 
global $post,$wp_query; 
get_header();
?>
<!-- Blog Header
======================================================================== -->
<div class="blog-header-wrapper">
	<?php 
		$color		= oneengine_option('header_blog_color'); 
		$img		= oneengine_option('header_blog_img', false, 'url');
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
			$bg_img = 'background-image:url('.oneengine_option('header_blog_img', false, 'url').');';
		}else $bg_img = '';
		
		$img		= ( ! empty ( $img ) ) 		? ''.$bg_img.'' : '';
		$color		= ( ! empty ( $color ) )  	? 'background-color:'. $color .';' : '';
		$repeat		= ( ! empty ( $repeat ) ) 	? ''. $bg_repeat .';' : '';
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
                                <div class="logo-img"><span>E</span></div>
                            <?php } ?>
                         </a>
                    </div>  
                </div>
                <!-- Logo / End -->
            </div>
            
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
            <div class="animation-wrapper col-md-12">
                <div class="heading-title-wrapper blog-page" style="color">
                    <h2 class="title" <?php echo $css_title_color ?>><?php echo oneengine_option('header_blog_title') ?></h2>
                    <span class="line-title" style="background-color:#cc467c"></span>
                    <span class="sub-title" <?php echo $css_sub_title_color ?>><?php echo oneengine_option('header_blog_subtitle') ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Blog Header -->
<div class="clearfix"></div>
<!-- Container
======================================================================== -->
<div class="blog-filter-container">
	<div class="row">
		<div class="col-md-12 blog-filer">
			<ul>
				<li>
					<a href="<?php if( get_option( 'show_on_front' ) == 'page' ) echo get_permalink( get_option('page_for_posts' ) );
else echo bloginfo('url'); ?>">
						<?php _e('All','oneengine') ?>
					</a>
				</li>
				<?php
					$categories = get_categories( array('hide_empty' => 0) );
					foreach ($categories as $category) {
				?>
				<li class="<?php echo get_query_var( 'cat' ) == $category->term_id ? 'active' : '' ; ?>">
					<a href="<?php echo get_category_link( $category );?>">
						<?php echo $category->name ?>
					</a>
				</li>
				<?php } ?>
			</ul>
		</div>
	</div>
</div>
<div class="site-inner">
    <div class="wrap">
    	<div class="container">
    		<div class="row">
    			<div class="blog-wrapper animation-wrapper col-md-12" style="margin:10px 0 10px">
    				<div class="row" id="posts_container">
						<?php
							$i = 0;
							if (have_posts()) :
					        	while(have_posts()) : the_post();
					    ?>    					
						<div class="col-md-6 et-blog-post animated fadeInUp" style="-webkit-animation-duration: 500ms; -moz-animation-duration: 500ms; -o-animation-duration: 500ms;animation-duration: 500ms; animation-delay: 300ms; -webkit-animation-delay:300ms; -moz-animation-delay:300ms;-o-animation-delay:300ms;">
			            	<div class="image-blog-wrapper">
								<?php the_post_thumbnail( 'full', array('class' => 'et-post-thumbnail img-responsive') ); ?>
                                <div class="et-post-data-left mobile-blog">
                                    <span class="et-post-month"><?php the_time('M');?></span>
                                    <span class="et-post-date"><?php the_time('d');?></span>
                                    <a href="#" data-id="<?php echo $post->ID; ?>" class="et-like-post <?php echo is_like_post($post->ID); ?>">
                                        <span class="et-post-heart"><i class="fa fa-heart"></i><span class="count"><?php echo get_post_meta($post->ID, 'et_like_count', true) ? get_post_meta($post->ID, 'et_like_count', true) : 0; ?></span></span>
                                    </a>
                                </div>
			                </div>
							<div class="clearfix"></div>
							<div class="et-post-data container">
								<div class="row">
									<div class="col-md-2 col-sm-2 et-post-data-left">
										<span class="et-post-month"><?php the_time('M');?></span>
										<span class="et-post-date"><?php the_time('d');?></span>
										<a href="#" data-id="<?php echo $post->ID; ?>" class="et-like-post <?php echo is_like_post($post->ID); ?>">
											<span class="et-post-heart"><i class="fa fa-heart"></i><span class="count"><?php echo get_post_meta($post->ID, 'et_like_count', true) ? get_post_meta($post->ID, 'et_like_count', true) : 0; ?></span></span>
										</a>
									</div>
									<div class="col-md-10 col-sm-10 et-post-data-right">
										<h1 class="title-blog"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
										<div class="et-post-info">
											<?php _e('Post by','oneengine'); ?> <?php the_author(); ?> | <?php the_category(); ?> | <?php comments_number( 'No Comments', 'One Comment', '% Comments' ); ?> 
										</div>
										<div class="clearfix"></div>
										<div class="et-post-excerpt">
											<?php the_excerpt() ?>
										</div>
										<div class="clearfix"></div>
										<a href="<?php the_permalink(); ?>" class="read-more"><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;<?php _e('Read more','oneengine'); ?></a>
									</div>
								</div>
							</div>
						</div>
					 	<?php 
						$i++;
						if($i % 2 == 0) echo '<div class="clearfix"></div>';
					 			endwhile;
					 		endif;
					 		wp_reset_query();
					 	?>
    				</div>
    			</div>
    			<input type="hidden" id="current_page" value="<?php echo get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1 ?>">
				<input type="hidden" id="max_page" value="<?php echo $wp_query->max_num_pages ?>">	
    		</div>
    	</div>
    </div>
</div>
<!-- Container / End -->
<?php get_footer(); ?>