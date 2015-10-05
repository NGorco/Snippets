jQuery(function($)
{
	var curr_page = 1;

	$(".show-more").click(function()
	{
		var url = window.location.host + window.location.pathname + '/page/' + (curr_page+1);
		var temp = $("#temporary-ajax");

		temp.load(url + " #archive-page .articles", function()
		{
			$("#archive-page .articles").append($(this).find(".articles article"));
			temp.html("");
		});		

		if(curr_page + 1 < Data.max_num_pages)
		{
			curr_page++;
		}else{
			$(this).fadeOut();
		}

		return false;
	});
});