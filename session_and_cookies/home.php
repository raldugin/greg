<?php
    /**
     * Created by PhpStorm.
     * User: IO
     * Date: 15.09.2017
     * Time: 07:34
     */
    //error_reporting(E_ALL);
	session_name( 'overhot_session');
	session_start();
	var_dump($_SESSION);

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
	<title>Document</title>
</head>
<body>
	<h2>Здравствуйте,</h2>
	<h3>Вы успешно вошли в систему</h3>
	<a href="home1.php">Перейти на другую страницу</a>
	<br>
	<a href="logout.php">Покинуть сайт</a>
</body>
</html>
