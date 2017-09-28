<?php

	error_reporting(E_ALL);
	define('USER_DATA_DIR', 'users_data/');

	session_name( 'overhot_session');
	session_start();

	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}

	// открываем массив данных пользователей из файл JSON
	$open_data_file = json_decode(file_get_contents(USER_DATA_DIR . 'data.json'), true);


	$username = $_SESSION['username'];
	$email = $_SESSION['user_id'];

	$phone = $open_data_file[$email]['phone'];
	$address = $open_data_file[$email]['address'];
	$time = $open_data_file[$email]['time'];


?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/materialize.css" media="screen,projection">
	<link rel="stylesheet" href="assets/css/styles.css">
	<title>Личный кабинет</title>
</head>
<body>
<div class="container">
	<div class="shopping_cart">
		<a href="">КОРЗИНА</a>
	</div>

	<h5>Личный кабинет</h5>
	<table class="striped">
		<tr>
			<td>Имя:</td>
			<td><?= $username ?></td>
		</tr>
		<tr>
			<td>Email:</td>
			<td><?= $email ?></td>
		</tr>
		<tr>
			<td>Телефон:</td>
			<td><?= $phone ?></td>
		</tr>
		<tr>
			<td>Адрес:</td>
			<td><?= $address ?></td>
		</tr>
		<tr>
			<td>Когда зарегистрирован:</td>
			<td><?= $time ?></td>
		</tr>
	</table>
	<a href="change_personal_info.php">Изменить или добавить личные данные</a>
	<br>
	<a href="change_password.php">Изменить пароль</a>
	<br>
	<br>
	<a href="home.php">Перейти на главную страницу</a>
	<br>
	<a href="logout.php">Покинуть сайт</a>
</div>
</body>
<script src="//code.jquery.com/jquery-latest.js"></script>
<script src="assets/js/materialize.js"></script>
</html>