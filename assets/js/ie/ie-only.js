jQuery(function($) {

	//IE8 handle clickable divs
	$(".promo-area, .news-snippet").click(function() {
	  window.location = $(this).find("a").attr("href");
	  return false;
	});

});
