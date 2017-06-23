function localDB(args) {


    if (!args.dbName) {

        throw 'No dbName specified';
    }

    var self = this;

    open();


    /**
     * Open DB
     */
    function open() {

        self.db = openDatabase(
            args.dbName,
            args.dbVer || "1.0",
            args.dbDescr || "",
            (args.size || 5) 1024 1024
        );
    }



    /**
     * Do transaction
     */
    this.doTransaction = function(transArr) {

        console.log("Transaction start");

        if (typeof transArr == 'string') {

            transArr = [
                [transArr, arguments[1]]
            ];
        }

        if (!Array.isArray(transArr)) return false;

        var mainDef = new Promise(function(resolve, reject) {

            self.db.transaction(
                function(SQLTrans) {

                    transArr.forEach(function(transaction) {

                        SQLTrans.executeSql(
                            transaction[0],
                            transaction[1] || []
                        );
                    });
                },
                function(results, SQLTrans) {

                    resolve(results, SQLTrans);
                },
                function(SQLTrans, error) {

                    reject(error, SQLTrans);
                }
            );
        });

        return mainDef;
    }
};

/**
 *
 * Examples

 var tr = new localDB({dbName: 'ty'});
 var tl = [];

   tl.push(
    ["INSERT INTO properties(id,objid, prop_id, prop_value, add_objid) VALUES (NULL,?, ?, ?,?)",
  [id, prop_id, prop_value, objid]
 ]);

OR

   tl.push("DROP TABLE IF EXISTS properties");

   tr.doTransaction(tl)
 .then(function(results){
    
 console.log(results)
 });

 * */
