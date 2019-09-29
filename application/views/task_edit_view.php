<div class="col-12">
	<?php
	if(empty($_SESSION['is_admin'])){
		echo "<div class='alert alert-danger' role='alert'>Редактировать задачи имеет право только администратор!</div>";
	}

	if(!empty($data['errors']))
		echo "<div class='alert alert-danger' role='alert'>Ошибка при сохранении задачи.</div>";

	if(!empty($data['task'])){
		$task = $data['task'];
	?>
		<h1>Редактирование задачи.</h1>

		<form action="/tasks/edit" method="POST">
			<input type="hidden" name="id" value="<?php echo $task['id']; ?>">
			<div class="form-group">
				<label>имя пользователя:
					<input type="text" name="user_name" value="<?php echo $task['user_name']; ?>" disabled class="form-control">
				</label>
			</div>
			<div class="form-group">
				<label>email:
					<input type="text" name="email" value="<?php echo $task['email']; ?>" disabled class="form-control">
				</label>
			</div>
			<div class="form-group">
				<label>описание:
					<textarea name="description" class="form-control
					<?php
						if(!empty($data['errors']['empty_description']))
							echo "is-invalid";
					?>"><?php echo $task['description']; ?></textarea>
				</label>
				<?php
					if(!empty($data['errors']['empty_description'])){
				?>
					<div class='invalid-feedback'>описание не может быть пустым</div>
				<?php
				}
				?>
			</div>

			<div class="form-group">
				<label>статус:
					<input type="checkbox" name="status" <?php if($task['status']) echo "checked";?> class="form-control">
				</label>
			</div>
			<input type="submit" value="сохранить" class="btn btn-primary">
		</form>

	<?php
	}else{
	?>
		<div class='alert alert-danger' role='alert'>Задача с указанным id не найдена.</div>
	<?php
	}
	?>
</div>