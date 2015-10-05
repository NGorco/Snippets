jQuery(function($)
{
	$("#mq_voting .like").not(".voted").click(function()
	{
		var self = this;

		$.post('/wp-admin/admin-ajax.php', {action: 'vote_mq_voting', vote: 'like', post_id: $(this).data('post-id')}, function(data)
		{
			if(data.status == 'success')
			{	
				$(self).addClass('clicked');
				$(self).parent().find('.counter').html(parseInt(data.rating));
			}
		}, 'json');
	});

	$("#mq_voting .dislike").not(".voted").click(function()
	{
		var self = this;

		$.post('/wp-admin/admin-ajax.php', {action: 'vote_mq_voting', vote: 'dislike', post_id: $(this).data('post-id')}, function(data)
		{
			if(data.status == 'success')
			{	
				$(self).addClass('clicked');
				$(self).parent().find('.counter').html(parseInt(data.rating));
			}
		}, 'json');
	});
})