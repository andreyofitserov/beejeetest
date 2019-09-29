<?php
class Model_Tasks extends Model{

	public function get_task($id){
		if(!isset($id) || $id <= 0){
			return [];
		}

		$query = $this->db->prepare("SELECT * FROM task WHERE id = ?");
		$query->bindValue(1, $id, PDO::PARAM_INT);
		$query->execute();

		return $query->fetch(PDO::FETCH_ASSOC);
	}

	public function get_tasks($offset, $limit, $sort, $order) {
		if(empty($sort)){
			$sort = 'id';
			$order = 'asc';
		}else{
			$sort = get_magic_quotes_gpc() ? $sort : addslashes($sort);
			$order = get_magic_quotes_gpc() ? $order : addslashes($order);
		}

		$sql = "SELECT * FROM task ORDER BY $sort $order LIMIT ?, ?";
		$query = $this->db->prepare($sql);
		$query->bindValue(1, $offset, PDO::PARAM_INT);
		$query->bindValue(2, $limit, PDO::PARAM_INT);
		$query->execute();

		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	public function get_tasks_with_pager($from_page, $per_page, $sort, $order) {
		$start_pos = $per_page * ($from_page - 1);
		$tasks = $this->get_tasks($start_pos, $per_page, $sort, $order);
		$total_pages_query = $this->db->query("SELECT COUNT(id) as total_pages FROM task");
		$total_pages = $total_pages_query->fetchColumn();

		return [
			'tasks' => $tasks,
			'total_pages' => ceil($total_pages / $per_page)
		];
	}

	public function insert_task() {
		$fields = ['user_name', 'email', 'description'];
		$errors = [];
		$values = [];
		$set = "";

		foreach($fields as $field) {

			if(empty($_POST[$field])) {
				 $errors[$field] = 'empty';
				 continue;
			}else {
				 if($field == 'email' && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
					  $errors[$field] = 'no valid';
					  continue;
				 }
				 $set .= "`$field` = :$field, ";
				 $values[$field] = htmlspecialchars($_POST[$field]);
			}
		}

		if(!empty($errors)) {
			return ['errors' => $errors];
		}else {
			$set = substr($set, 0, -2);
			$sql = "INSERT INTO task SET $set";
			$query = $this->db->prepare($sql);
			$query->execute($values);
			return ['success' => $query->rowCount()];
		}

	}

	public function update_task() {
		$errors = [];


		$task_id = intval($_POST['id']);
		$task = $this->get_task($task_id);
		if(empty($task)){
			$errors['task_not_found'] = true;
		}

		if(empty($_POST['description'])){
			$errors['empty_description'] = true;
		}else{
			$description = htmlspecialchars($_POST['description']);
		}

		$status = !empty($_POST['status']) ? 1 : 0;

		if(!empty($errors))
			return ['errors' => $errors];

		$edited = $task['description'] == $description ? 0 : 1;
		$sql = "UPDATE task SET description = ?, status = ?, edited = ? WHERE id = ?";
		$query = $this->db->prepare($sql);
		$query->bindValue(1, $description);
		$query->bindValue(2, $status, PDO::PARAM_INT);
		$query->bindValue(3, $edited, PDO::PARAM_INT);
		$query->bindValue(4, $task_id, PDO::PARAM_INT);
		$query->execute();

		return ['success' => $query->rowCount()];
	}
}
?>
