<?php

class usrController extends baseController {

	public $usrInfo = "";
	
	public function index(){header("Location:/");}
	
    public function logout(){$_SESSION = array();}    
    
	public function io(){
		
		if(isset($_POST)&& isset($_POST["type"])){
			switch($_POST["type"]){
				case "login":$this->loginUsr();break;
				case "register":$this->addUsr(); break;
				case "recover": $this->chPass(); break;
                
			}
		}
       
	}
	
    public function loginUsr(){
        if(isset($_POST['loginInfo'])){
            $this->load->model('usr');
			$usr = $this->usr->loginUsr($_POST['loginInfo']);
			if(isset($usr['id'])){
				$_SESSION['loggedin']=true;
				$_SESSION['id'] = $usr['id'];
				$_SESSION['user_type'] = $usr['type'];
				echo json_encode( array("logged" => true));
            }
        }
    }
    
	public function addUsr(){
		if(isset($_POST["regUsr"])){
            $regInfo = $_POST["regUsr"];
		
			$this->load->model('usr');
			
            $arr = $this->usr->registerUsr($regInfo);
			$key = $arr[0];
            switch($key){
                case"":echo json_encode(array("status"=>"error"));exit();break;
                case"email_already_registered":echo json_encode(array("status"=>"email_exist"));exit();break;
                case"hollow":echo json_encode(array("status"=>"hollow"));exit();break;
                default:
					echo json_encode(array("status"=>"success",'key'=>$key,'pass'=>$arr[1]));break;
            }
			
			
			
			$content = "Поздравляем, ты успешно зарегистрирован(а) в сервисе QuickDesk!<br/><br/>Для окончания регистрации перейди по ссылке ниже<br/><br/>http://diplom.massique.com/usr/activate/".$key."<br/><br/>Твой логин - ".$regInfo['mail'].",<br/><br/>пароль - ".$arr[1];
			
			
		//	В случае неподтверждения регистрации, в 00:00 часа Ваша учетная запись будет удалена.";
			
			mail($regInfo['mail'],"Регистрация в сервисе QuickDesk", $content,mail_headers("QuickDesk"));
		}
	}
	
	public function getUsr(){
		$Request = new Request;
		$args = $Request->getArgs();
		
		$this->load->model('usr');
		
		return json_decode($this->usr->getUsr($args[0]));
	}
	
	public function chPass(){
		
		$args = $_POST['email'];
		
		$this->load->model('usr');
		$this->usr->chPass($args);
	}
	
	public function activate(){
		$Request = new Request;
		$args = $Request->getArgs();
		
		$this->load->model('usr');
		if(isset($args[1])){
			$this->usr->actUsr($args[0], $args[1]);
		}else{
			$this->usr->actUsr($args[0]);
		}
		header("Location:/note/list");
	}

}

?>