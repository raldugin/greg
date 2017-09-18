<?php

	error_reporting(E_ALL);

	$username_db = 'alex';
	$password_db = '1';
	$error = '';

	if (isset($_POST['submit'])) {

		if (!empty($_POST['username']) || !empty($_POST['password'])) {
			$error = auth_user ($username_db, $password_db);
		} else {
			$error = '<h3 style="color: Red;">Заполните все поля</h3>';
		}

		if ($error == '') {

			session_name( 'overhot_session');
			session_start();
			$_SESSION['user_id'] = $_POST['username'];
			header('Location: home.php');
		}


	} // end if (isset($_POST['submit']))

	function auth_user ($username_db, $password_db) {

		if ( $_POST['username'] !== $username_db ) {
			$error = '<h3 style="color: Red;">Неправильный логин</h3>';
			return $error;
		}
		elseif ($_POST['password'] !== $password_db) {
			$error = '<h3 style="color: Red;">Неправильный пароль</h3>';
			return $error;
		}
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
<form method="post">
	<h3>Please Sign in or <a href="index.php">Register</a></h3>
	<?= $error; ?>
	<p><label>Login</label></p>
	<input type="text" name="username">
	<p><label>Password</label></p>
	<input type="password" name="password">
	<p><input type="submit" name="submit"></p>
</form>
</body>
</html>
