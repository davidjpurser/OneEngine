jQuery(window).load(function() {
	if(document.getElementById("all_click"))
		document.getElementById("all_click").click();
	jQuery('.mask-color').fadeOut('slow');
	if (window.location.hash ) {
		setTimeout(function(){
			jQuery.scrollTo( window.location.hash, 0, {offset:-jQuery(".sticky-wrapper").height()});
		}, 1);
		
	
	}
});

jQuery(document).ready(function($) {
	
	// MENU RESPONSIVE
	$('#menu-res').slicknav({
		prependTo:'.menu-responsive'
	});
	
	// POPUP
	$('.popup-video').magnificPopup({
          disableOn: 700,
          type: 'iframe',
          mainClass: 'mfp-fade',
          removalDelay: 160,
          preloader: false,
          fixedContentPos: false
    });
	
	// SCROLL TO
	$('#main-menu-top .current-menu-item a,ul.slicknav_nav .current-menu-item a').click(function(event){
		if (typeof (this.hash) === "undefined" || this.hash == "") {
			return;
		}
		event.stopPropagation();
		event.preventDefault();
		if($(this).hasClass('active'))
			return;
		
		$('#main-menu-top a').removeClass('active').css('border-bottom-color', 'none');
		$(this).addClass('active');

		if(this.hash == "#home")
			$.scrollTo(0,0);
		else
			$.scrollTo( this.hash, 0, {offset:-$(".sticky-wrapper").height()});

		var bgcolor = $(this.hash).find('span.line-title').css('backgroundColor');
		$(this).css('border-bottom-color', bgcolor);
		
		$('.slicknav_nav').hide('normal', function() {
			$(this).addClass('slicknav_hidden');
		});
		$('a.slicknav_btn').removeClass('slicknav_open').addClass('slicknav_collapsed');

		return false;
	});

	$("a#scroll_to").click(function(event) {
		$.scrollTo("#header", 800);
	});
	// PARALLAX EFFECT	
	$('.parallax').height($(this).parent().outerHeight());
	
	// ANIMATION EFFECT	
	$('.animation-wrapper').waypoint(function() {
		$(this).find('.animated').addClass("running");
	}, { offset: '85%'});
	
	// FIX BOOTSTRAP 3 
	$('.span12').removeClass('span12').addClass('col-md-12');
	$('.span11').removeClass('span11').addClass('col-md-11');
	$('.span10').removeClass('span10').addClass('col-md-10');
	$('.span9').removeClass('span9').addClass('col-md-9');
	$('.span8').removeClass('span8').addClass('col-md-8');
	$('.span7').removeClass('span7').addClass('col-md-7');
	$('.span6').removeClass('span6').addClass('col-md-6');
	$('.span5').removeClass('span5').addClass('col-md-5');
	$('.span4').removeClass('span4').addClass('col-md-4');
	$('.span3').removeClass('span3').addClass('col-md-3');
	$('.span2').removeClass('span2').addClass('col-md-2');
	$('.span1').removeClass('span1').addClass('col-md-1');

	// PORTFOLIO
	$('.close-port').click(function(){
		$.scrollTo(".portfolio-wrapper", 900, {easing:'easeOutExpo',onAfter:function(){
			$('#portfolio_content').fadeOut(500);
		}});
	});
	
	var container = $('#portfolio_list').isotope({
		animationEngine : 'best-available',
	  	animationOptions: {
	     	duration: 500,
	     	queue: false
	   	},
		layoutMode: 'fitRows'
	});;	

	$('#portfolio_filter a').click(function(){
		$('#portfolio_filter a').removeClass('active');
		$(this).addClass('active');
		var selector = $(this).attr('data-filter');
	  	container.isotope({ filter: selector });
        setProjects();		
	  	return false;
	});
		
		
	function splitColumns() { 
		var winWidth = $(window).width(), 
			columnNumb = 1;
		
		if (winWidth > 1024) {
			columnNumb = 6;
		} else if (winWidth > 900) {
			columnNumb = 4;
		} else if (winWidth > 479) {
			columnNumb = 3;
		} else if (winWidth < 479) {
			columnNumb = 2;
		}
		
		return columnNumb;
	}		
	
	function setColumns() { 
		var winWidth = $(window).width(), 
			columnNumb = splitColumns(), 
			postWidth = Math.floor(winWidth / columnNumb);
		
		container.find('.item').each(function () { 
			$(this).css( { 
				width : postWidth + 'px' 
			});
		});
	}		
	
	function setProjects() { 
		setColumns();
		$('#portfolio_list').isotope('reLayout');
	}		
	$(window).bind('resize', function () { 
		setProjects();			
	});
	
	/* ==================== HOVER PORTFOLIO ==================== */
	$(' #portfolio_list > .item ').each( function() { 
		$(this).hoverdir({
			hoverDelay : 75
		}); 
	} );
	/* ==================== HOVER PORTFOLIO ==================== */

	/* ==================== PIECHART + COUNTER ==================== */
	$('.pie-wrapper').each(function (e) {
		$(".chart").waypoint(function() {
			var data_easing = $(this).attr('data-easing'),
				data_animate = $(this).attr('data-animate'),
				data_lineCap = $(this).attr('data-line-cap'),
				data_lineWidth = $(this).attr('data-line-width'),
				data_bar_color = $(this).attr('data-bar-color'),
				data_track_color = $(this).attr('data-track-color');
				//data_sise = $(this).attr('data-size');
			$(this).easyPieChart({
					easing: data_easing,
					animate: data_animate,
					lineCap: data_lineCap, //butt, round and square.
					lineWidth: data_lineWidth,
					barColor: data_bar_color,	
					trackColor:	data_track_color,
					scaleColor: false,
					size: 150,
					onStep: function(from, to, percent) {
						$(this.el).find('.percent-chart').text(Math.round(percent));
					}
				});
		}, { offset: '85%', triggerOnce:true});
	});
	$('.counter').each(function (e) {
		$(".timer").waypoint(function() {
			$('.timer').countTo();
		}, { offset: '85%', triggerOnce:true});
	});	
	/* ==================== PIECHART + COUNTER ==================== */

	/* ==================== HEADER SLIDER ==================== */
	function random(owlSelector){
	  owlSelector.children().sort(function(){
		  return Math.round(Math.random()) - 0.5;
	  }).each(function(){
		$(this).appendTo(owlSelector);
	  });
	}
	$("#header_slider").owlCarousel({
		navigation : true, // Show next and prev buttons
		navigationText: [
		  "<span class='arrow-left-slider'></span>",
		  "<span class='arrow-right-slider'></span>"
		  ],
		slideSpeed : 300,
		paginationSpeed : 400,
		singleItem : true,
		autoHeight : true,
		transitionStyle:"fade",
		// Responsive 
		responsive: true,
		items : 1,
		pagination : false,
		addClassActive:true,
		beforeInit : function(elem){
		  //Parameter elem pointing to $("#owl-demo")
		  random(elem);
		},
		beforeMove:beforeMove,
	});
	function beforeMove(){
	 
	}
	/* ==================== HEADER SLIDER ==================== */

	/* ==================== OWL CAROUSEL ==================== */
	$('.carousel-play').each(function (e) {
		var data_slide_speed = $(this).attr('data-slide-speed'),
				data_pagination_speed = $(this).attr('data-pagination-speed'),
				data_auto = $(this).data('auto'),
				data_navigation = $(this).data('navigation'),
				data_pagination = $(this).data('pagination'),
				data_pagination_numbers = $(this).data('numbers'),
				data_items = $(this).attr('data-items'),
				data_desktop = $(this).attr('data-desktop'),
				data_desktop_small = $(this).attr('data-desktop-small'),
				data_tablet = $(this).attr('data-tablet'),
				data_mobile = $(this).attr('data-mobile');
		$(".carousel-play").owlCarousel({
				//Basic Speeds
				slideSpeed : data_slide_speed,
				paginationSpeed : data_pagination_speed,
			 
				//Autoplay
				autoPlay : data_auto,
				goToFirst : true,
				goToFirstSpeed : 1000,
			 
				// Navigation
				navigation : data_navigation,
				navigationText : ["prev","next"],
				pagination : data_pagination,
				paginationNumbers: data_pagination_numbers,
			 
				// Responsive 
				responsive: true,
				items : data_items,
				itemsDesktop : [1199,data_desktop_small],
				itemsDesktopSmall : [979,data_desktop_small],
				itemsTablet: [768,data_tablet],
				itemsMobile : [479,data_mobile]
		});
	});
	/* ==================== OWL CAROUSEL ==================== */

	/* ==================== OWL CAROUSEL SYNC ==================== */
	  var sync1 = $("#test_content");
	  var sync2 = $("#test_avatar");
	  
	  sync1.owlCarousel({
		  singleItem : true,
		  slideSpeed : 1000,
		  navigation: false,
		  pagination:false,
		  afterAction : syncPosition,
		  transitionStyle : "fade",
	  });
	  sync2.each(function (e) {
		  var   data_slide_speed = $(this).attr('data-slide-speed'),
				data_pagination_speed = $(this).attr('data-pagination-speed'),
				data_auto = $(this).data('auto'),
				data_navigation = $(this).data('navigation'),
				data_pagination = $(this).data('pagination'),
				data_pagination_numbers = $(this).data('numbers'),
				data_items = $(this).attr('data-items'),
				data_desktop = $(this).attr('data-desktop'),
				data_desktop_small = $(this).attr('data-desktop-small'),
				data_tablet = $(this).attr('data-tablet'),
				data_mobile = $(this).attr('data-mobile');
		  sync2.owlCarousel({
			  //Basic Speeds
			  slideSpeed : data_slide_speed,
			  paginationSpeed : data_pagination_speed,
			  
			  
			  //Autoplay
			  autoPlay : data_auto,
			  goToFirst : true,
			  goToFirstSpeed : 1000,
		   
			  // Navigation
			  navigation : data_navigation,
			  navigationText : ["prev","next"],
			  pagination : data_pagination,
			  paginationNumbers: data_pagination_numbers,
			  addClassActive:true,
		   
			  // Responsive 
			  responsive: true,
			  items : data_items,
			  itemsDesktop : [1199,data_desktop_small],
			  itemsDesktopSmall : [979,data_desktop_small],
			  itemsTablet: [768,data_tablet],
			  itemsMobile : [479,data_mobile],
			  afterInit : function(el){
				el.find(".owl-item").eq(0).addClass("synced");
			  }
		  });
	  });
	  
	 
	  $("#test_avatar").on("click", ".owl-item", function(e){
	    e.preventDefault();
	    var number = $(this).data("owlItem");
	    sync1.trigger("owl.goTo",number);
	  });
	 
	  function center(number){
	    var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
	    var num = number;
	    var found = false;
	    for(var i in sync2visible){
	      if(num === sync2visible[i]){
	        var found = true;
	      }
	    }
	 
	    if(found === false){
	      if(num>sync2visible[sync2visible.length-1]){
	        sync2.trigger("owl.goTo", num - sync2visible.length+2)
	      }else{
	        if(num - 1 === -1){
	          num = 0;
	        }
	        sync2.trigger("owl.goTo", num);
	      }
	    } else if(num === sync2visible[sync2visible.length-1]){
	      sync2.trigger("owl.goTo", sync2visible[1])
	    } else if(num === sync2visible[0]){
	      sync2.trigger("owl.goTo", num-1)
	    }
	    
	  }
	function syncPosition(el){
		var current = this.currentItem;
		jQuery("#test_avatar")
			.find(".owl-item")
			.removeClass("synced")
			.eq(current)
			.addClass("synced")
		if(jQuery("#test_avatar").data("owlCarousel") !== undefined){
			center(current)
		}
	}
	/* ==================== OWL CAROUSEL SYNC ==================== */
	/* ==================== STICKY HEADER ==================== */
	$('#header').waypoint('sticky', {
	  wrapper: '<div class="sticky-wrapper" />',
	  stuckClass: 'stuck-sticky'
	});
	/* ==================== STICKY HEADER ==================== */
	

});

jQuery(function($){
    var sections = {},
    	header_height = $("#header").height(),
        i        = -1;
    
    // Grab positions of our sections 
    $('.template-wrap').each(function(){
        sections[this.id] = $(this).offset().top;
    });

    $(document).scroll(function(){
        var $this = $(this),
            pos   = $this.scrollTop();
        console.log(sections);
        for(i in sections){
            var bgcolor = $('#'+i).find('span.line-title').css('backgroundColor');  

			$('#'+i).waypoint(function() {
                $('#menu-res li a').removeClass('active').css('border-bottom-color', 'none');
                $('#menu-res li a[href="#'+i+'"]')
		                .addClass('active')
		                .css('border-bottom-color', bgcolor);	
			}, { offset: '25%' });
        }
        if (pos > header_height) {
        	$('#header').addClass('see-through');
        } else {
        	$('#header').removeClass('see-through');
        }
    });
});

function createCookie(name, value, days) {
    var expires;

    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }
    document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
}
function hexc(colorval) {
    var parts = colorval.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    delete(parts[0]);
    for (var i = 1; i <= 3; ++i) {
        parts[i] = parseInt(parts[i]).toString(16);
        if (parts[i].length == 1) parts[i] = '0' + parts[i];
    }
    return '#' + parts.join('');
}
