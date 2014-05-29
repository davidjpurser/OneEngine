jQuery(document).ready(function($) {

	OneEngine = Backbone.View.extend({		
		el: 'body',
		events: {
			'click .portfolio-list div a' : 'renderPortfolio',
			'click .port-control a' 	  : 'renderPortfolio',
			'click a.et-like-post' 	 	  : 'likePost',
		},
		initialize: function(){
			console.log('init');
		},
		likePost: function(event){
			event.preventDefault();
			var target = $(event.currentTarget);

			if(!target.hasClass('active')){
				$.ajax({
					url : oe_globals.ajaxURL,
					type : 'post',
					data : {
						action : 'et_like_post',
						content: {
							id : target.attr('data-id')
						}
					},
					beforeSend : function(){
						target.addClass('active');
					},
					error : function(request){

					},
					success : function(response){
						if(response.success){
							target.find('span.count').text(response.count);
							createCookie('et_like_'+target.attr('data-id'),1,365);
						} else {
							target.removeClass('active');
							target.find('span.count').text(response.count);
						}
					}
				});
			}

		},
		renderPortfolio: function(event){
			event.preventDefault();
			var target = $(event.currentTarget);

			if(target.attr('data-id') && ! target.hasClass('loading')){
				$.ajax({
					url : oe_globals.ajaxURL,
					type : 'post',
					data : {
						action : 'et_load_portfolio',
						content: {
							id : target.attr('data-id')
						}
					},
					beforeSend : function(){
						target.addClass('loading');
						$('.mask-color-port').fadeIn('300');
					},
					error : function(request){

					},
					success : function(response){
						$('.mask-color-port').fadeOut('300');
						var container = $("#portfolio_content .port-content"),
							control   = $("#portfolio_content .port-control");
						target.removeClass('loading');
						if(response.success){
							
							if(!target.hasClass('next') &&  !target.hasClass('prev')){
								$("#portfolio_content").fadeIn('500', function() {
									$.scrollTo("#portfolio_content", 2500, {easing:'easeOutExpo',offset:-$(".sticky-wrapper").height()});
								});
							}

							control.find('a.prev').attr('data-id',response.prev_post);
							control.find('a.next').attr('data-id',response.next_post);
							container.html(response.html);
						} else {
							alert('Error');
						}
					}
				});
			}
		}
	});
	new OneEngine();

});