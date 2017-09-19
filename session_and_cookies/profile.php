<?php

	error_reporting(E_ALL);
	define('USER_DATA_DIR', 'users_data/');

	$error = '';
	$email_validator = '/.+@.+\..+/i';

	session_name( 'overhot_session');
	session_start();

	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}

	// открываем массив данных пользователей из файл JSON
	$open_data_file = json_decode(file_get_contents(USER_DATA_DIR . 'data.json'), true);
	// подставляем в форму VALUE текущего Имени и EMAIL
	$username = $_SESSION['username'];
	$email_current = $_SESSION['user_id'];

	if (isset($_POST['submit'])) {

		// получаем VALUE из инпутов формы EMAIL и PASSWORD
		$email = clear_data($_POST['email']);
		$password = clear_data($_POST['password']);

		// валидируем состояние значений в форме
		$error = validate_user_data($email, $email_current, $email_validator, $password, $open_data_file);
	}

	function validate_user_data($email, $email_current, $email_validator, $password, $open_data_file)
	{
		//var_dump($email);
		//var_dump($email_current);
		// если текущий EMAIL в поле формы идентичен тому, который записан в массив $_SESSION['user_id'] при входе в систему, выходим
		if ($email == $_SESSION['user_id']) {
			$error = '';
			return $error;
		}
		// если поле формы EMAIL пустое, выводим ошибку
		elseif (empty($email)) {
			$error = '<h4 style="color: Red;">Поле Email не может быть пустым</h4>';
			return $error;
		}
		// если введен новый email который не прошел REGEX, выходим и выводим ошибку
		elseif (!preg_match($email_validator, $email)) {
			$error = '<h4 style="color: Red;">Введите валидный Email</h4>';
			return $error;
		}
		// если введен email который уже есть в массиве данных (т.е. уже зарегистрирован другим пользаком), выходим и выводим ошибку
		elseif (array_key_exists($email, $open_data_file)) {
			$error = '<h4 style="color: Red;">Такой Email/Пользователь уже зарегистрирован</h4>';
			return $error;
		}
		// если EMAIL был изменен и не указан текущий пароль, выводим отшибку
		// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! тут ошибка и скрипт не идет дальше
		elseif ($email !== $email_current) {
			$_SESSION['user_id'] = $email;
			//var_dump($_SESSION['user_id'] = $email);
			$error = '<h4 style="color: Red;">Введите Текущий пароль для внесения изменений</h4>';
			return $error;
		}
		// если пароль пустой, выводим отшибку
		elseif (md5($password) !== $open_data_file[$_SESSION['user_id']]['password']) {
			$error = '<h3 style="color: Red;">Неправильный пароль</h3>';
			return $error;
		}
		// если введенный пароль не соответствует паролю из массива данных, выводим ошибку
//		elseif (md5($password) !== $open_data_file[$_SESSION['user_id']]['password']) {
//			$error = '<h3 style="color: Red;">Неправильный пароль</h3>';
//			return $error;
//		}

	}

	function validate_password($password, $open_data_file)
	{
		// если поле пароль в форме пустое, выходим
		if (empty($password)) {
			$error = '';
			return $error;
		}
		// если введенный пароль в форпме не совпадает с тем что пользак вводил при регистрации (сохранен в массиве), то выводим ошибку
		// тут $_SESSION['user_id'], это EMAIL пользователя, т.е. ключ ассоциативного массива со значениями (данными) пользователя
		elseif (md5($password) !== $open_data_file[$_SESSION['user_id']]['password']) {
			$error = '<h3 style="color: Red;">Неправильный пароль</h3>';
			return $error;
		}
		 // !!!!! тут делаем переназначение новых данных пользователя (измененный EMAIL или USERNAME)
	}

	// чистим введенные данные от мусора
	function clear_data($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	/*
	echo 'Веденный пароль в форму';
	var_dump(!empty($password));
	echo '<br>Пароль';
	var_dump($password);
	echo '<br>хеш пароля';
	var_dump(md5($password));
	echo '<br><br>Текущий пользователь';
	var_dump([$_SESSION['user_id']]);
	echo '<br>Его пароль';
	var_dump($open_data_file[$_SESSION['user_id']]['password']);
	*/
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Личный кабинет</title>
</head>
<body>
	<h2>Личный кабинет</h2>
	<?= $error; ?>
	<form method="post">
		<p><label>Ваше имя</label></p>
		<input type="text" name="username" value="<?= $username ?>">
		<p><label>Email</label></p>
		<input type="text" name="email" value="<?= $email_current ?>">
		<p><label>Текущий пароль</label></p>
		<input type="password" name="password">
		<p><label>Новый пароль</label></p>
		<input type="password" name="new_password">
		<p><label>Подтвердите новый пароль</label></p>
		<input type="password" name="confirmed_new_password">
		<p><input type="submit" name="submit"></p>
	</form>

	<a href="home.php">Перейти на главную страницу</a>
	<br>
	<a href="logout.php">Покинуть сайт</a>
</body>
</html>