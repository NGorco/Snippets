<?php
abstract class baseModel
{
	private $TABLE_ID;
	private $TABLES;

	function __construct()
	{
		$this->DBH = PDOconnect();
		$this->TABLE_ID = 'id';

		$STH = $this->DBH->query('SHOW TABLES');
		$STH->execute();
		$ret = Array();			

		while($res = $STH->fetch(PDO::FETCH_ASSOC)){

			$table_name = array_shift($res);
				
			$STH1 = $this->DBH->query('SHOW COLUMNS FROM ' . $table_name);
			$STH1->execute();		
			$out = 	Array();

			while($res1 = $STH1->fetch(PDO::FETCH_ASSOC))
			{				
				if(strpos($res1['Extra'], 'auto_increment') > -1) continue; 
				$out[] = $res1['Field'];
			}
			
			$ret[$table_name] = $out;
		}

		$this->TABLES = $ret;
	}

	function getAll($query, $data)
	{
		$STH = $this->DBH->prepare($query);
		$STH->execute($data);
		$ret = array();

		while($res = $STH->fetch(PDO::FETCH_ASSOC)){
			$ret[] = $res;
		}		
		
		return $ret;	
	}

	function insert($params)
	{
		$keys = Array();
		$data = Array();

		$table_keys = $this->TABLES[$params['table']];
		$table_keys_proc = Array();

		foreach($table_keys as $key)
		{
			$table_keys_proc[] = ":" . $key;
		}

		foreach($params['fields'] as $key => $value)
		{
			$keys[] = '?';
			$data[":" . $key] = $value;
		}

		$STH = $this->DBH->prepare('INSERT INTO ' . $params['table'] . ' VALUES ("",' . implode(',',$table_keys_proc) . ')');
		$STH->execute($data);

		return $this->DBH->lastInsertId();
	}
}
?>
