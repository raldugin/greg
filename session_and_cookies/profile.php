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
	// подставляем в форму VALUE текущего Username и EMAIL
	$username = $email = $phone = $address = $time = '';

	$username = $_SESSION['username'];
	$email = $_SESSION['user_id'];

	$phone = $open_data_file[$email]['phone'];
	$address = $open_data_file[$email]['address'];
	$time = $open_data_file[$email]['time'];
	var_dump($address);

	//$open_data_file[$_SESSION['user_id']]['password']

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Личный кабинет</title>
	<style>
		table, th, td {
			border-collapse: collapse;
			border: 1px solid Black;
			padding: 5px;
		}
		table {
			margin: 20px 0;
		}
	</style>
</head>
<body>
	<h2>Личный кабинет</h2>

	<table width="400">
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
	<a href="chage_password.php">Изменить пароль</a>
	<br>
	<br>
	<a href="home.php">Перейти на главную страницу</a>
	<br>
	<a href="logout.php">Покинуть сайт</a>
</body>
</html>