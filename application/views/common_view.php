<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<title>Задачи</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<div  class="container">
		<ul class="nav">
			<li class="nav-item">
				<a href="/" class="nav-link active">Список задач</a>
			</li>
			<li class="nav-item">
				<?php
				if(!empty($_SESSION['is_admin'])){
				?>
					<a href='/auth/logout' class='nav-link active'>Выйти</a>
				<?php
				}else{
				?>
					<a href='/auth' class='nav-link active'>Вход</a>
				<?php
				}
				?>
			</li>
		</ul>
		<?php include 'application/views/'.$content_view; ?>
	</div>
</body>
</html>
