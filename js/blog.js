jQuery(document).ready(function($) {

	pubsub = {};
	pubsub = _.extend(pubsub, Backbone.Events);	
	//========== Infinite Scoll ==========//
	$(window).scroll(function()
	{	
		var current_page = parseInt($("input#current_page").val()),
			max_page     = parseInt($("input#max_page").val());
	    if( ($(window).scrollTop() == $(document).height() - $(window).height()) && current_page < max_page)
	    {
	    	pubsub.trigger('loadMorePosts');
		}

	});

	pubsub.on('loadMorePosts', triggerLoadmorePosts);
	function triggerLoadmorePosts(){
		OE_Blog.getPosts();
	}
	//========== Infinite Scoll ==========//

	OE_Blog_View = Backbone.View.extend({		
		el: 'body',
		events: {
		},
		initialize: function(){
			console.log('init');
		},
		getPosts: function(event){
			var $loading_wrapper = $('.loading-wrapper'),
				page = parseInt($("input#current_page").val());
			if(!$loading_wrapper.hasClass('loading')){
				$.ajax({
					url : oe_globals.ajaxURL,
					type : 'post',
					data : {
						action : 'et_loadmore_post',
						content: {
							page : page+1
						}
					},
					beforeSend : function(){
						$loading_wrapper.addClass('loading').show();
					},
					error : function(request){

					},
					success : function(response){
						$loading_wrapper.removeClass('loading').hide();
						var container = $("#posts_container");
						if(response.success){

							for (key in response.posts){
								container.append( response.posts[key].html );
							}
							$("input#current_page").val(response.current_page);
						} else {
							console.log('error');
						}
					}
				});
			}

		}
	});
	OE_Blog = new OE_Blog_View();

});