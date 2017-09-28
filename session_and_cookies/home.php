<?php

    error_reporting(E_ALL);
	session_name( 'overhot_session');
	session_start();

	echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";

	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}

    ?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Главная страница</title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/materialize.css" media="screen,projection">
	<link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<div class="container">
	<div class="shopping_cart">
		<a href="">КОРЗИНА</a>
	</div>
	<h5>Здравствуйте, <?= $_SESSION['username'] ?></h5>
	<h5>Вы залогинились как, <?= $_SESSION['user_id'] ?> </h5>
	<a href="profile.php">Перейти в личный кабинет</a>
	<br>
	<a href="logout.php">Покинуть сайт</a>
</div>
</body>
<script src="//code.jquery.com/jquery-latest.js"></script>
<script src="assets/js/materialize.js"></script>
</html>
