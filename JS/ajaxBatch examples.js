var batch;
$(function()
{
	batch = new aBatch(
	{
		url: "/",
		clbk: function(data)
		{
			console.log(data);				
		}, 
		reqPerSend: 1,
		startFrom: 900,
		prepareData: function(item)
		{
			return {
				id: item.id,
				src : item.guid					
			}
		}
	})
});

// Отправляем данные на сервер