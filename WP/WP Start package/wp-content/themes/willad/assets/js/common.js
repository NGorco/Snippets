var CInit = function()
{	
	var $ = jQuery || $;
	var instance = this;

	instance.beforeLoad = function()
	{		
		// On start adding home icon to menu, cuz WP not allow HTML additions 
		$("ul#menu-main > .home a").append('<span class="glyphicon glyphicon-home"></span>');
		$("#foot-menu ul > .home a").append('<span class="glyphicon glyphicon-home"></span>');
	}();
	
	return instance;
}();



jQuery(function($)
{
	//CInit.afterLoad();	

	$("#qsearch").focus(function()
	{
		$(this).parent().addClass("focus");
	});

	$("#qsearch").blur(function()
	{
		$(this).parent().removeClass("focus");
	});

	if (location.hash) {
	  setTimeout(function() {

		window.scrollTo(0, 0);
	  }, 1);
	}

	$(".comment-reply-link").click(function()
	{
		$("#comment_parent").val($(this).data('replyto'));
		$("#comment").focus();

		$(".reply-to-label").show();
		$(".reply-to-who").append($(this).data('arialabel'));
	});

	$(".cancel_reply").click(function()
	{
		$("#comment_parent").val(0);

		$(".reply-to-label").hide();
		$(".reply-to-who").html('');
	});

	// Owlcarousel init
	$('#agencies-catalog .owl-gallery').owlCarousel({
		items: 3
	});

	// Fancybox init
	$('#agencies-catalog .fancybox-group').fancybox({
		helpers: {
			overlay: {
				locked: false
			}
		}
	});
});

// использование Math.round() даст неравномерное распределение!
function getRandomInt(min, max)
{
  return Math.floor(Math.random() * (max - min + 1)) + min;
}
