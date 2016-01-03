var aBatch = function(config)
{
	if(!config.url)
	{
		throw "Request URL required!";
	}

	var instance = {};	
	var priv = {};
	priv.batchRows = []; // array
	priv.processOn = true; // bool
	priv.processCallback = config.clbk || function(){};
	priv.counter;
	priv.jsonInput;
	priv.rowsPerR = config.rowsPerR || 20;
	priv.url = config.url;

	instance.getBatchCount = function()
	{
		return priv.batchRows.length;
	}

	priv.createControls = function()
	{
		priv.jsonInput = $("<input>")
		.attr("type",'file')
		.change(function(evt)
		{
			var files = evt.target.files; // FileList object

            // Loop through the FileList
            for (var i = 0, f; f = files[i]; i++)
            {
                var reader = new FileReader();
               
                reader.onload = (function(theFile)
                {                    
                    return function(e)
                    {
                    	try{
                    		var json = JSON.parse(reader.result);	
                    	}catch(e)
                    	{
                    		throw "Invalid JSON file!";;
                    	}

                    	if(config.prepareData)
                    	{
                    		json = json.map(config.prepareData);
                    	}
                    	
                    	priv.batchRows = json;
                        priv.processBatchItem();
                    };
                })(f);

                reader.readAsText(f);
            }
        });

        priv.counter = $("<div>")
        .attr("id","ajaxBatchCounter");

        priv.stop = $("<button>")
        .html("Stop process")
        .click(function()
        {
        	instance.stopProcess();
        });

        $("body")
        	.append(priv.jsonInput)
        	.append(priv.stop)
        	.append(priv.counter);
	}

	priv.processBatchItem = function()
	{
		if(priv.processOn)
		{
			var calls = [];

			for(var gk = 0; gk < priv.rowsPerR; gk++)
			{
				calls.push($.post(config.url, {batchRows: batch}, function(data)
				{						
					console.info('ajaxBatch Request complete');
				}));
			}			

	        return $.when.apply(this, calls).then(function() // Делаем одновременные запросы
	        {    
	            var loadedData = arguments;

	            priv.processCallback(loadedData);
	            priv.processBatchItem();
				console.info('ajaxBatch Request complete');
       		}); 		
		}
	}

	instance.stopProcess = function()
	{
		priv.processOn = false;
	}

	instance.continueProcess = function()
	{
		priv.processOn = true;
		priv.processBatchItem();
	}

	priv.createControls();

	return instance;
};