$(function()
{
	$("ul.subscribes li").click(function()
	{
		var chk = $(this).find("input");

		if(chk[0].checked)
		{
			$(this).removeClass('selected');
			chk[0].checked = false;
		}else{
			$(this).addClass('selected');
			chk[0].checked = true;
		}
	});

	$("#user-avatar").change(function()
	{
        var reader = new FileReader();	

        reader.onload = function(e)
        {
        	$("#avatar_preview").attr('src', e.target.result);
		};

        reader.readAsDataURL(this.files[0]);
	});
});