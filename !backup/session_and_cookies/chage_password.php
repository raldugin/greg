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
	// подставляем в форму VALUE текущего Username и EMAIL
	$username_current = $_SESSION['username'];
	$email_current = $_SESSION['user_id'];

	if (isset($_POST['submit'])) {
		// получаем VALUE из инпутов формы, EMAIL и PASSWORD
		$email = clear_data($_POST['email']);
		$password = clear_data($_POST['password']);
		// валидируем значения input в форме
		$error = validate_user_data($email, $email_current, $email_validator, $password, $open_data_file);

		if (empty($error)) {
			$error = '<h4 style="color: Red;">Изменения не внесены</h4>';
			header('refresh:2; url=home.php');
		}
	}


	/**
	 * @param $email			- вводимый новый email из формы
	 * @param &$email_current	- текущий email залогиненного пользователя,который пишется в сессию после login. С этой переменной работаем по ссылке (&)
	 * @param $email_validator	- регулярное выражение REGEX
	 * @param $password			- вводимый текущий пароль из формы, для подтвержения изменений
	 * @param $open_data_file	- ассоциативный массив из файла JSON с данными пользователя,
	 * 							  где ключ - 'email' => ['password'=>'...','username'=>'...','time'=>'...'] - его значения
	 * @return string
	 */
	function validate_user_data($email, &$email_current, $email_validator, $password, $open_data_file)
	{
		// если пароль не менялся, выходим
		// (текущий EMAIL в поле формы идентичен тому, который записан в массив $_SESSION['user_id'] при входе в систему)
		if ($email == $_SESSION['user_id']) {
			$error = '';
			return $error;
		}
		// если поле формы EMAIL пустое, или введен новый EMAIL который не прошел REGEX, выводим ошибку
		elseif (empty($email) || !preg_match($email_validator, $email)) {
			$error = '<h4 style="color: Red;">Введите валидный Email</h4>';
			return $error;
		}
		// если в форме введен email который уже есть в массиве данных (т.е. уже зарегистрирован другим пользаком), выводим ошибку
		elseif (array_key_exists($email, $open_data_file)) {
			$error = '<h4 style="color: Red;">Такой Email/Пользователь уже зарегистрирован</h4>';
			return $error;
		}
		// если введенный в форпму EMAIL, оличен от EMAIL_CURRENT (записан при логине в перменную сессии ['user_id'])
		// и введенный пароль в форме не совпадает с тем что пользак вводил при регистрации (сохранен в массиве), то выводим ошибку
		// тут $_SESSION['user_id'], это EMAIL залогиненного пользователя, т.е. ключ ассоциативного массива со значениями (данными) пользователя

		elseif ($email !== $email_current && md5($password) !== $open_data_file[$_SESSION['user_id']]['password']) {
//			$email_current = $email;
//			var_dump($email);
//			echo 'Current';
//			var_dump($email_current);
			$error = '<h4 style="color: Red;">Введите Новый Email и подтвердите его текущим паролем</h4>';
			return $error;
		}



		// если валидация EMAIL и PASSWORD успешна, то меняем значение текущего Email на введенный
		//меняем в сесиии

		// меняем в массиве и пишем





		$error = '<h3 style="color: Red;">Успешно внесены изменения</h3>';
		return $error;
	}
	// чистим введенные данные от мусора
	function clear_data($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

//	var_dump($_SESSION['user_id']);
//	echo '<br>';
//	var_dump(md5($password));
//	echo '<br>';
//	var_dump($open_data_file[$_SESSION['user_id']]['password']);

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
	<br>
	<h3>Изменить личные данные:</h3>
	<?= $error; ?>
	<form method="post">
		<p><label>Ваше имя</label></p>
		<input type="text" name="username" value="<?= $username_current ?>">
		<p><label>Email</label></p>
		<input type="text" name="email" value="<?= $email_current ?>">
		<p><label>Текущий пароль</label></p>
		<input type="password" name="password">
		<p><input type="submit" name="submit"></p>
	</form>
	<br>
	<h3>Изменить пароль:</h3>
	<form action="" method="post">
		<p><label>Текущий пароль</label></p>
		<input type="password" name="password">
		<p><label>Новый пароль</label></p>
		<input type="password" name="new_password">
		<p><label>Подтвердите новый пароль</label></p>
		<input type="password" name="confirmed_new_password">
		<p><input type="submit" name="change_password"></p>
	</form>
	<?= $error; ?>
	<a href="home.php">Перейти на главную страницу</a>
	<br>
	<a href="logout.php">Покинуть сайт</a>
</body>
</html>