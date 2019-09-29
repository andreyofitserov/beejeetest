<?php
class Controller_Tasks extends Controller {
	function __construct() {
		$this->model = new Model_Tasks();
		$this->view = new View();
	}

	function action_index($result = []) {
		$from_page = !empty($_GET['page']) ? intval($_GET['page']) : 1;
		$per_page = 3;
		$sort = !empty($_GET['sortby']) ? $_GET['sortby'] : '';
		$order = !empty($_GET['order']) ? $_GET['order'] : '';
		$data = $this->model->get_tasks_with_pager($from_page, $per_page, $sort, $order);
		$data['current_page'] = $from_page;

		if(!empty($result['errors'])) {
			$data['errors'] = $result['errors'];
		}
		$this->view->generate('tasks_view.php', 'common_view.php', $data);
	}

	function action_insert() {
		if(empty($_POST)) {
			$this->action_index();
		}else {
			$result = $this->model->insert_task();
			if(!empty($result['success'])){
				$_SESSION['success'] = true;
				header('Location: /');
				exit;
			}
			$this->action_index($result);
		}
	}

	function action_edit() {
		if(empty($_SESSION['is_admin'])){
			header('Location: /auth');
			exit;
		}

		if(!empty($_GET['id'])) {
			$data['task'] = $this->model->get_task(intval($_GET['id']));
			$this->view->generate('task_edit_view.php', 'common_view.php', $data);
		}elseif(!empty($_POST['id'])) {
			$result = $this->model->update_task();

			if(isset($result['success'])){
				$_SESSION['edit_success'] = true;
				header('Location: /');
				exit;
			}elseif(!empty($result['errors'])){
				$data['task'] = $this->model->get_task(intval($_POST['id']));
				$data['errors'] = $result['errors'];
				$this->view->generate('task_edit_view.php', 'common_view.php', $data);
			}
		}else {
			$this->action_index();
		}
	}

}
?>
