<?php
class Controller_Auth extends Controller{
	function __construct() {
		$this->view = new View();
	}

	function action_index(){
		if(isset($_POST['login'])){
			if(trim($_POST['login']) == 'admin' && trim($_POST['pwd']) == '123'){
				$_SESSION['is_admin'] = true;
				$data = [];
			}else{
				$data['auth_error'] = true;
			}
		}else{
			$data = [];
		}

		$this->view->generate('login_view.php', 'common_view.php', $data);

	}

	function action_logout(){
		if(isset($_SESSION['is_admin'])){
			unset($_SESSION['is_admin']);
		}
		header('Location:/');
		exit;
	}
}
?>