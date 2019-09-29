<?php
if(empty($_SESSION['is_admin'])){
	if(!empty($data['auth_error'])){
		echo "<div class='alert alert-danger' role='alert'>Ошибка авторизации</div>";
	}
?>
	<form action="/auth" method="POST">
		<div class="form-group">
			<label>логин<input type="text" name="login" class="form-control"></label>
		</div>
		<div class="form-group">
			<label>пароль<input type="password" name="pwd" class="form-control"></label>
		</div>
		<div class="form-group">
			<input type="submit" value="войти" class="btn btn-primary">
		</div>
	</form>
<?php
}else{
?>
	<h2>Добро пожаловать, Админ!</h2>
<?php
}
?>