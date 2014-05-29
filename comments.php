<?php 
/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>


<div id="comments" class="oe-comments-area">
	<h2 class="oe-comments-title">
		<?php comments_number( __('Be the first to post a comment.','oneengine'), __('1 Comment on this article','oneengine') , __('% Comments on this article','oneengine') ); ?>
	</h2>
	<ul class="oe-comment-list">
		<?php 
			wp_list_comments(array(
				'type' 			=> 'comment',
				'callback' 		=> 'oe_comment_template',
				'avatar_size' 	=> 40,
				'reply_text'	=> __('<i class="fa fa-share-square-o"></i> ','oneengine').'<span class="icon" data-icon="R"></span>', 
			)) 
		?>
		<div class="comments-navigation">
		<?php 
			paginate_comments_links();
		?> 
		</div>
	</ul>
</div>


<div id="et_respond">
	<?php comment_form(array(
		'title_reply' 			=> __('Leave a Comment', 'oneengine'),
		'comment_notes_before' 	=> '<p class="before-text">'.__('Please be polite. We appreciate that.<br>Your email address will not be published and required fields are marked.', 'oneengine').'</p>',
		'comment_notes_after' 	=> '',
		'comment_field' =>  '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="'.__('Your content', 'oneengine').' *">' .
    '</textarea></p>',
	)); ?>
</div>