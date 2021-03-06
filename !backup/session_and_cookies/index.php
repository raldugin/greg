<?php

	error_reporting(E_ALL);
	define('USER_DATA_DIR', 'users_data/');
	// именуем сессию и стартуем ее
	session_name('overhot_session');
	session_start();

	$email = $password = $error = '';
	$email_validator = '/.+@.+\..+/i';

	if (isset($_POST['submit'])) {
		$email = clear_data($_POST['email']);
		// чистим шифруем пароль
		$password = md5(clear_data($_POST['password']));
		// открываем массив данных пользователей из файл JSON
		$open_data_file = json_decode(file_get_contents(USER_DATA_DIR . 'data.json'), true);

		// если VALUE фомы EMAIL или PASSWORD не пустые, валидируем данные, иначе выводим ошибку
		if (!empty($email) || !empty($password)) {
			$error = auth_user($email, $password, $open_data_file);
		} else {
			$error = '<h3 style="color: Red;">Заполните все поля</h3>';
		}

		// валидация пользователя прошла успешно
		// записываем в сессию EMAIL пользователя (user_id) и его Имя (username), Переадресовываемся на домашнюю страницу
		if ($error == '') {
			$_SESSION['user_id'] = $email;
			$_SESSION['username'] = $open_data_file[$email]['username'];
			header('Location: home.php');
		}


	} // end if (isset($_POST['submit']))

	function auth_user($email, $password, $open_data_file)
	{
		// если массив с данными взятым из JSON не пустой, то начинаем валидацию
		if (!empty($open_data_file)) {
			// если в форме введен email которого нет в массиве (т.е. не зарегистрирован другим пользаком), выходим и выводим ошибку
			if (!array_key_exists($email, $open_data_file)) {
				$error = '<h4 style="color: Red;">Неправильный логин или пароль</h4>';
				return $error;
			}
			// если введенный пароль в форме не совпадает с паролем в массиве, выходим и выводим ошибку
			elseif ($password !== $open_data_file[$email]['password']) {
				$error = '<h3 style="color: Red;">Неправильный логин или пароль</h3>';
				return $error;
			}
		}
	}

	// чистим введенные данные от мусора
	function clear_data($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}


?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Вход в систему</title>
</head>
<body>
<form method="post">
	<h3>Войдите в систему или <a href="register.php">Зарегистрируйтесь</a></h3>
	<?= $error; ?>
	<p><label>Email</label></p>
	<input type="text" name="email" value="<?= $email ?>">
	<p><label>Пароль</label></p>
	<input type="password" name="password">
	<p><input type="submit" name="submit"></p>
</form>
</body>
</html>
