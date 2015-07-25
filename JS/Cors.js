/**
* Кросс-доменный запрос
*
* @params url адрес запроса
* @params clbk функция коллбэк
* @params notJSON JSON или нет в ответе
*/
function CORS(url, clbk, notJSON)
{
	try {
		doCallOtherDomain(url, clbk, notJSON)
	} catch (e) {
		return false;
	}

	/**
	* Выполнение запроса
	*/
	function doCallOtherDomain(url, clbk, notJSON)
	{
		if(notJSON == undefined) notJSON = false;
		if(url == '' || typeof url != 'string') return false;
		
		var XHR = window.XDomainRequest || window.XMLHttpRequest;
		var xhr = new XHR();
		
		xhr.open('GET', url, true);

		xhr.onload = function()
		{
			if(clbk != undefined)
			{  
				if(!notJSON)
				{
					try
					{
						var DATA = JSON.parse(xhr.responseText)
					}catch(e){

						throw(e)
					}
				}

				console.log("CORS successfull");
				clbk(DATA);				
			}
		}

		xhr.onerror = function() 
		{
			throw("Cross-domain request fail");
		}

		xhr.send()
	}
}