var localDB = (function DB (){
		
	var instance = {};
	
	instance.count = 0;	
	instance.id = window.location.hash.substring(1);
	instance.table_head = 0; 
	instance.DBsize = 5 * 1024 * 1024; // 5 MB

	/**
	* Открываем БД
	*/
	instance.open = function(clbk)
	{	
		instance.db = openDatabase("Reestr","1.0", "Reestr data", instance.DBsize);
		console.log("DB.open()");
	}
	
	/**
	* Выполнение транзакции из массива транзакций
	*/
	instance.transactionArr = function(tl, clbk) 
	{
		console.log("Transaction start");
		
		if(clbk == "undefined") clbk = function(){};
		
		if(tl== undefined  || tl.length < 1) return false;
		
		instance.db.transaction(function(tx)
		{			
			var cnt =  tl.length;
			var check = cnt;			

			for(var i = 0; i< cnt;i++)
			{
				if(typeof tl[i] == "string")
				{				
					tx.executeSql(tl[i],[], function(tx)
					{					
						check--;

						if(check==0)
						{
							console.log("Transaction stack is empty, transaction completed");
							clbk(tx);							
						}
					},function(tx, error){throw(error)});
				}else{
					
					tx.executeSql(tl[i][0],tl[i][1]?tl[i][1]:[], function(tx)
					{	
						check--;
						if(check == 0) {
							console.log("Transaction stack is empty, transaction completed");
							clbk(tx);
						}
					},function(tx, error){throw(error.message)});
				}
			}
		},function(){}, function(tx){});
	}
	
	/**
	* Выполнение запроса к БД
	*/
	instance.query = function(query, vars, clbk)
	{		
		if(!clbk) clbk = function(){};
		if(vars == undefined) vars = [];
		
		instance.db.transaction(function(tx)
		{		
			tx.executeSql(query,vars, function (tx, res) 
			{
				if(res) clbk(res);
			},
			function(tx, error)
			{
				throw(error.message);
			});
		});
	}

	return instance;
})();

/**
 * 
 * Examples
  
  tl.push(
  ["INSERT INTO properties(id,objid, prop_id, prop_value, add_objid) VALUES (NULL,?, ?, ?,?)",
	[id, prop_id, prop_value, objid]
	
OR
	
  tl.push("DROP TABLE IF EXISTS properties");
  
  instance.transactionArr(tl, function(){alert('ololo')});
]);

 * */
