<?php
	lockedAccess();
	class noteController extends baseController{
		
		public function __construct(){
			parent::__construct();
		}
		public function index(){
			header("Location:/note/lists");
		}
		
		public function removeboard(){
			if(isset($_POST['id'])){
				$this->load->model('note');
				$this->note->removeBoard($_POST['id']);
			}
		}
		
		public function save(){
			if(isset($_POST['data'])){
				$this->load->model('note');
				if($_POST['id']==''){
					if($newId = $this->note->save()){
						$result = array('status'=>"newItem",'id'=>$newId);
					}else{
						$result = array('status'=>"fail");
					}
				}else{
					if($this->note->update()){
						$result = array('status'=>"updateSuccess");
					}else{
						$result = array('status'=>"fail");
					}
				}
				echo json_encode($result);
			}
		}
		
		public function getnote(){
			$Request	= new Request;
			$args = $Request->getArgs();
			if(!empty($args)){
				
				if($args[0]==30)
					
				if(empty($args[1])||$args[1]!="naturamlijeko") die();
				
				$this->load->model('note');
				$Raw = $this->note->getDesk($args[0]);
				echo $Raw['desk_content'];
			}
		}
		
		public function get_list(){
			lockedAccess();
			$this->load->model('note');
			$result = array();
			
			$Raw = $this->note->getList($_SESSION['id']);
			$res['res'] = $Raw;
			$this->load->view('noteListRaw',$res);
		}
		
		public function lists(){			
			$Request = new Request;
			$args = $Request->getArgs();
			$show_list = '';
			if(!empty($args)&&$args[0]=='show'){
				$show_list = true;
			}
			$res['show'] =$show_list; 
			$this->load->view('noteList',$res);
		}
		
		public function view(){
			$Request = new Request;
			$args = $Request->getArgs();
			if(!empty($args)){
				$this->load->model('note');
				$result = array();
				
				$Raw = $this->note->getDesk($args[0]);
				if($Raw['id']==''){
			
					header("Location:/note/lists/show");
					exit();
				}
				$result['id'] = $Raw['id'];
				$result['title'] = $Raw['title'];
				$result['desk_content'] = json_encode(json_decode($Raw['desk_content']));
				$this->load->view('note',$result);
			}else{
				$this->load->view('note');
			}
		}

	}