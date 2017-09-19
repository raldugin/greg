<?php

    error_reporting(E_ALL);
	session_name( 'overhot_session');
	session_start();

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
</head>
<body>
	<h2>Здравствуйте, <?= $_SESSION['username'] ?></h2>
	<h2>Вы залогинились как, <?= $_SESSION['user_id'] ?> </h2>
	<a href="profile.php">Перейти в личный кабинет</a>
	<br>
	<a href="logout.php">Покинуть сайт</a>
</body>
</html>
