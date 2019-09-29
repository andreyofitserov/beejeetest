<h1>Задачи</h1>
<div class="row">
	<div class="col-9 col-sm-12 col-lg-9">
		<?php
		if(!empty($_SESSION['edit_success'])){
			echo "<div class='alert alert-success' role='alert'>Задача сохранена!</div>";
			unset($_SESSION['edit_success']);
		}

		$is_admin = !empty($_SESSION['is_admin']);
		if(!empty($data['tasks'])) {
			$order = !empty($_GET['order']) && $_GET['order'] == 'asc' ? 'desc' : 'asc';
			$sortby_user_href = http_build_query(array_merge($_GET, ["sortby"=>"user_name", "order"=>$order]));
			$sortby_email_href = http_build_query(array_merge($_GET, ["sortby"=>"email", "order"=>$order]));
			$sortby_status_href = http_build_query(array_merge($_GET, ["sortby"=>"status", "order"=>$order]));

			$content = "<table class='table table-striped'><thead><tr>
			<td><a href='/?$sortby_user_href'>Пользователь</a></td>
			<td><a href='/?$sortby_email_href'>email</a></td><td>Описание</td>
			<td><a href='/?$sortby_status_href'>Статус</a></td>
			<td>редакция</td>
			".($is_admin ? "<td>действия</td>" : "")."</tr></thead><tbody>";

			foreach($data['tasks'] as $task) {
			  $content .= "<tr><td>$task[user_name]</td><td>$task[email]</td><td>$task[description]</td><td>".($task['status'] == 0 ? "открыта" : "завершена")."</td><td>".($task['edited'] == 0 ? '' : 'отредактировано администратором')."</td>".($is_admin ? "<td><a href=/tasks/edit/?id=$task[id]>редактировать</a></td>" : "");
			}
			$content .= "</tbody></table>";
			$page_link_class = "class='page-link'";
			if($data['total_pages'] > 1) {
			  $pager = "<nav aria-label='Page navigation'><ul class='pagination'>";
			  for($page = 1; $page <= $data['total_pages']; $page++) {
					$pager .= "<li class='page-item'>";
					if($page == 1) {
						if(isset($_GET['page'])){
							unset($_GET['page']);
						}
						if(!empty($_GET)){
							$pager .= "<a href='/?".http_build_query($_GET)."' $page_link_class>$page</a>";
						}else{
							$pager .= "<a href='/' $page_link_class>$page</a>";
						}
					}else if($page == $data['current_page']) {
						$pager .= "<a $page_link_class>$page</a>";
					}else {
						$pager .= "<a href='/?".http_build_query(array_merge($_GET, ['page'=>$page]))."' $page_link_class>$page</a>";
					}
					$pager .= "</li>";
			  }
			  $pager .= "</ul></nav>";
			  $content .= "$pager";
			}
			echo $content;
		}else {
			echo "<div class='alert alert-info' role='alert'>список задач пуст</div>";
		}
		?>
	</div>
	<div class="col-3 col-sm-12 col-lg-3">
		<h2>Добавить задачу</h2>
		<?php
		if(!empty($data['errors'])){
			echo "<div class='alert alert-danger' role='alert'>Ошибка при добавлении задачи</div>";
		}

		if(!empty($_SESSION['success'])){
			echo "<div class='alert alert-success' role='alert'>Задача добавлена!</div>";
			unset($_SESSION['success']);
		}
		?>
		<form action="/tasks/insert" method="POST">
			<input type="hidden" name="status" value="0">
			<div class="form-group">
				<label>имя пользователя:
					<input type="text" name="user_name" class="form-control <?php
					if(!empty($data['errors']['user_name']))
						echo "is-invalid";
					?>" value="<?php if(!empty($_POST['user_name'])) echo $_POST['user_name'];?>">
				</label>
				<?php
				if(!empty($data['errors']['user_name']))
					echo"<div class='invalid-feedback'>заполните это поле</div>";
				?>
			</div>
			<div class="form-group">
				<label>email:
					<input type="text" name="email" class="form-control <?php
					if(!empty($data['errors']['email']))
						echo "is-invalid";
					?>" value="<?php if(!empty($_POST['email'])) echo $_POST['email'];?>">
				</label>
				<?php
				if(!empty($data['errors']['email'])){
					if($data['errors']['email'] == 'empty')
						echo"<div class='invalid-feedback'>заполните это поле</div>";
					else
						echo "<div class='invalid-feedback'>не корректный email</div>";
				 }
				 ?>
			</div>
			<div class="form-group">
				<label>описание:
					<textarea cols="40" rows="10" name="description" class="form-control
					<?php
					if(!empty($data['errors']['description']))
						echo "is-invalid";
					?>"><?php if(!empty($_POST['description'])) echo trim($_POST['description']);?></textarea>
					<?php
						if(!empty($data['errors']['description']))
							echo"<div class='invalid-feedback'>заполните это поле</div>";
					?>
			</label>
			</div>
			<div class="form-group">
				<input type="submit" value="добавить" class="btn btn-primary">
			</div>
		</form>
	</div>
</div>
