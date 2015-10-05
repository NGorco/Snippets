<?php
	class indexController extends baseController{
		
		public function __construct(){
			parent::__construct();
		}
		public function index(){
			if(isset($_SESSION['loggedin'])&&$_SESSION['loggedin']!=''){
				header("Location:/note/list");exit();
			}
			$this->load->view('index');	
		}

	}
