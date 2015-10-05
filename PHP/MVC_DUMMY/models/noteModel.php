<?php
	class noteModel extends baseModel{
		
		public $DBH;
		
		function __construct(){
			$this->DBH = PDOconnect();
		}
		
		public function save(){
			$STH = $this->DBH->prepare("INSERT INTO qdesk_notes VALUES ('',?,?,?)");
			$STH->execute(array($_POST['data'],$_POST['title'],$_SESSION['id']));
			return $this->DBH->lastInsertId();
		}
		
		public function removeBoard($id){
			$STH = $this->DBH->prepare("DELETE FROM qdesk_notes WHERE id = ? AND author = ?");
			$STH->execute(array($id, $_SESSION['id']));
		}
		
		public function getDesk($Id){	
			$STH = $this->DBH->prepare("SELECT * FROM qdesk_notes WHERE id=? AND author=?");
			$STH->execute(array($Id, $_SESSION['id']));
			$usr = $STH->fetch(PDO::FETCH_ASSOC);		
			return $usr;			
		}
		
		public function update(){
			$STH = $this->DBH->prepare("UPDATE qdesk_notes SET title=?,desk_content=? WHERE id=? AND author=?");
			$STH->execute(array($_POST['title'],$_POST['data'],$_POST['id'], $_SESSION['id']));
			return true;
		}
		
		public function getList($Id){	
			$STH = $this->DBH->prepare("SELECT * FROM qdesk_notes WHERE author=?");
			$STH->execute(array($Id));
			$ret = array();
			while($res = $STH->fetch(PDO::FETCH_ASSOC)){
				$ret[] = $res;
			}		
			
			return $ret;			
		}
	}		
    
?>