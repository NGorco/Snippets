<?php

class usrModel extends baseModel{

	public $DBH;
	public function registerUsr($regInfo){
		
        if($regInfo['mail']=='') return "hollow";
        $STH = $this->DBH->prepare("SELECT * FROM `qdesk_usrs` WHERE `email`=?");
        $STH->execute(array($regInfo['mail']));
		
        if(count($STH->fetch(PDO::FETCH_ASSOC))>1){
           return array("email_already_registered");
		   
        }
	
		$psw = md5(mt_rand(0,100));
		
		$key = md5(mt_rand(0,1000));
		$STH = $this->DBH->prepare("INSERT INTO `qdesk_usrs` VALUES ('','',?,?,?,9)");
			$STH->bindParam(1,$regInfo['mail']);
            $STH->bindParam(2,md5($psw));
			$STH->bindParam(3,$key);
		$STH->execute();
	       
		return array($key,$psw);
	}		
	
	function __construct(){
		$this->DBH = PDOconnect();
	}
	
	public function getUsr($id){
		$STH = $this->DBH->prepare('SELECT * FROM qdesk_usrs WHERE id=? LIMIT 1');
			$STH->bindParam(1,$id);
			
		$STH->setFetchMode(PDO::FETCH_ASSOC);
		return $STH->fetch();
	}
	
	public function chPass($mail){
		
		$STH = $this->DBH->prepare("SELECT * FROM qdesk_usrs WHERE email=?");
        $STH->execute(array($mail));
		$usr = $STH->fetch(PDO::FETCH_ASSOC);
		$key = md5(mt_rand(0,1000));
		if(isset($usr['id'])){
			$STH_1 = $this->DBH->prepare("UPDATE qdesk_usrs SET `key`=? WHERE `id`=?");
            $STH_1->execute(array($key,$usr['id']));
			$content = "Ссылка для восстановления пароля учетной записи на сервисе QuickDesk.\n\nhttp://diplom.massique.com/usr/activate/".$key."/recover\n\n";
			mail($usr['email'],"Восстановление пароля в сервисе QuickDesk",$content,mail_headers() );
			echo json_encode(array("status"=>"mail_sent"));
		}else{
            echo json_encode(array("status"=>"error"));
		}
	}
	
    public function loginUsr($loginInfo){
        if(isset($loginInfo['email'])&&isset($loginInfo['psw'])){
            $STH = $this->DBH->prepare("SELECT * FROM `qdesk_usrs` WHERE `psw`=? AND `email`=?");
            $STH->execute(array(md5($loginInfo['psw']), $loginInfo['email']));
            
            $usr = $STH->fetch(PDO::FETCH_ASSOC);
            if(isset($usr['id'])){                
                return $usr;
            }
        }
    }
    
	public function actUsr($key, $type=''){
		$STH = $this->DBH->prepare("SELECT * FROM `qdesk_usrs` WHERE `key`=?");		
        $STH->execute(array($key));
        
		$usr = $STH->fetch(PDO::FETCH_ASSOC);
     
		if(isset($usr['id'])&& $type == 'recover'){	
            $psw = substr(md5(mt_rand(1,1000)),0,8);
			$STH = $this->DBH->prepare("UPDATE qdesk_usrs SET `psw`='".md5($psw)."',`key`='' WHERE `id`=".$usr['id']);
			$STH->execute();		
			mail($usr['email'],"Сервис QuickDesk","Пароль сменён. \n\nВаш новый пароль: $psw. Вы можете сменить его в Вашем личном кабинете.", mail_headers());
		}
        elseif(isset($usr['id'])){
		  		
			$STH = $this->DBH->query('UPDATE qdesk_usrs SET `key`="" WHERE `id`='.$usr['id']);
			$STH->execute();		
			mail($usr['email'],"Сервис QuickDesk","Поздравляем! \n\nВаша учетная запись активирована.\n\nМы будем информировать Вас о дальнейшем развитии проекта и изменениях на сайте.", mail_headers());
			
		}
	}
}

?>