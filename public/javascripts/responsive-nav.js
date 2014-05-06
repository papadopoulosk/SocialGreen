


var ww = document.body.clientWidth;

$(document).ready(function() {

$('.mobile-nav-menu li a').click(function(){
	var link = $(this).attr('data-trigger');
	$('#'+link).trigger('click');
	$('.mobile-nav-menu').slideUp();
	return(false);
})


	$(".navi li a").each(function() {
		if ($(this).next().length > 0) {
			$(this).addClass("parent");
		};
	})
	
	$(".toggleMenu").click(function(e) {
		e.preventDefault();
		$(this).toggleClass("active");
		$(".navi").toggle();
	});
	adjustMenu();
})

$(window).bind('resize orientationchange', function() {
	ww = document.body.clientWidth;
	adjustMenu();
});

var adjustMenu = function() {
	if (ww < 768) {
		$(".toggleMenu").css("display", "inline-block");
		if (!$(".toggleMenu").hasClass("active")) {
			$(".navi").hide();
		} else {
			$(".navi").show();
		}
		$(".navi li").unbind('mouseenter mouseleave');
		$(".navi li a.parent").unbind('click').bind('click', function(e) {
			// must be attached to anchor element to prevent bubbling
			e.preventDefault();
			$(this).parent("li").toggleClass("hover");
		});
	} 
	else if (ww >= 768) {
		$(".toggleMenu").css("display", "none");
		$(".navi").show();
		$(".navi li").removeClass("hover");
		$(".navi li a").unbind('click');
		$(".navi li").unbind('mouseenter mouseleave').bind('mouseenter mouseleave', function() {
		 	// must be attached to li so that mouseleave is not triggered when hover over submenu
		 	$(this).toggleClass('hover');
		});
	}
}

