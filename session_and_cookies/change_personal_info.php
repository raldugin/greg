<?php

	error_reporting(E_ALL);
	define('USER_DATA_DIR', 'users_data/');

	$error = '';
	$email_validator = '/.+@.+\..+/i';

	session_name('overhot_session');
	session_start();

	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}

	// открываем массив данных пользователей из файл JSON
	$open_data_file = json_decode(file_get_contents(USER_DATA_DIR . 'data.json'), true);
	$user_current = $_SESSION['user_id'];
	/*
	$user_key_in_array = find_user_key ($user_current, $open_data_file);
	function find_user_key($user_current, $open_data_file)
	{
		foreach ($open_data_file as $key => $value) {
			if ($key == $user_current) {
				return $key;
			}
		}
	}
	*/

	// подставляем в форму VALUE текущего Username и EMAIL
	$username_current	= $open_data_file[ $user_current ][ 'username' ];
	$email_current		= $user_current;
	$password_current	= $open_data_file[ $user_current ][ 'password' ];
	$phone_current		= $open_data_file[ $user_current ][ 'phone' ];
	$address_current	= $open_data_file[ $user_current ][ 'address' ];
	$time				= $open_data_file[ $user_current ][ 'time' ];



	if (isset($_POST['submit'])) {
		// получаем VALUE из инпутов формы, EMAIL и PASSWORD
		$username = clear_data($_POST['username']);
		$email = clear_data($_POST['email']);
		$phone = clear_data($_POST['phone']);
		$address = clear_data($_POST['address']);
		$password = clear_data($_POST['password']);
		// валидируем значения input в форме
		$error = validate_user_data(
			$username, $username_current, $user_current,
			$email, $email_current,
			$phone, $phone_current,
			$address, $address_current,
			$email_validator,
			$password, $open_data_file
		);

	if (empty($error)) {
		$changed_user_data [$email_current] = [
				'username' => "$username_current",
				'password' => "$password_current",
				'phone' => "$phone_current",
				'address' => "$address_current",
				'time' => "$time"];

			$_SESSION['user_id'] = $email_current;
			unset($open_data_file["$user_current"]);

		$save_data_file = array_merge($open_data_file, $changed_user_data);
		file_put_contents(USER_DATA_DIR . 'data.json', json_encode($save_data_file, JSON_UNESCAPED_UNICODE));

		//header('refresh:1; url=profile.php');
		header('Location: profile.php');

	}
	}


	/**
	 * @param $username - вводимый новый username из формы
	 * @param $username_current - текущий username
	 * @param $user_current - текущий login/email из переменной сессии
	 * @param $email - вводимый новый email из формы
	 * @param &$email_current - текущий email залогиненного пользователя,который пишется в сессию после login. С этой переменной работаем по ссылке (&)
	 * @param $phone
	 * @param $phone_current
	 * @param $address
	 * @param $address_current
	 * @param $email_validator - регулярное выражение REGEX
	 * @param $password - вводимый текущий пароль из формы, для подтвержения изменений
	 * @param $open_data_file - ассоциативный массив из файла JSON с данными пользователя,
	 *                              где ключ - 'email' => ['password'=>'...','username'=>'...','time'=>'...'] - его значения
	 * @return string
	 */


	function validate_user_data(
		$username, &$username_current, $user_current,
		$email, &$email_current,
		$phone, &$phone_current,
		$address, &$address_current,
		$email_validator,
		$password, $open_data_file)
	{

		if ($username == $username_current
			&& $email == $email_current
			&& $phone == $phone_current
			&& $address == $address_current) {
			$error = '';
			return $error;
		}

		if (empty($username)) {
			$username_current = $username;
			$error = 'Введите имя';
			return $error;
		}
		$username_current = $username;
		$_SESSION['username'] = $username_current;
		// если поле формы EMAIL пустое, или введен новый EMAIL который не прошел REGEX, выводим ошибку
		if (empty($email) || !preg_match($email_validator, $email)) {
			$email_current = '';
			$error = 'Введите валидный Email';
			return $error;
		}
		else {
			$email_current = $email;
		}

		$phone_current = $phone;
		$address_current = $address;


		// если введенный в форпму EMAIL, оличен от user_current (записан при логине в перменную сессии ['user_id'])
		// и введенный пароль в форме не совпадает с тем что пользак вводил при регистрации (сохранен в массиве), то выводим ошибку
		// тут $_SESSION['user_id'], это EMAIL залогиненного пользователя, т.е. ключ ассоциативного массива со значениями (данными) пользователя
		// если в форме введен email который уже есть в массиве данных (т.е. уже зарегистрирован другим пользаком), выводим ошибку


		if ($email !== $user_current && array_key_exists($email, $open_data_file)) {
			$error = 'Такой Email/Пользователь уже зарегистрирован';
			return $error;
		}

		if (md5($password) !== $open_data_file[$_SESSION['user_id']]['password']) {
			//$email_current = $email;
//			var_dump($email);
//			echo 'Current';
//			var_dump($email_current);
			$error = 'Введите пароль для изменений';
			return $error;
		}
		//$error = 'Успешно внесены изменения';
		//return $error;
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
	<link rel="stylesheet" href="assets/css/materialize.css">
	<link rel="stylesheet" href="assets/css/styles.css">
	<title>Личный кабинет</title>
</head>
<body>
<div class="container">
	<div class="shopping_cart">
		<a href="">КОРЗИНА</a>
	</div>

	<h5>Личный кабинет</h5>
	<br>
	<h6>Изменить личные данные:</h6>
	<h6 style="color: Red;"><?= $error; ?> </h6>
	<form method="post">
		<p><label>Ваше имя</label></p>
		<input type="text" name="username" value="<?= $username_current ?>">
		<p><label>Email</label></p>
		<input type="text" name="email" value="<?= $email_current ?>">
		<p><label>Телефон</label></p>
		<input type="text" name="phone" value="<?= $phone_current ?>">
		<p><label>Адрес</label></p>
		<input type="text" name="address" value="<?= $address_current ?>">
		<p><label>Текущий пароль</label></p>
		<input type="password" name="password">
		<p><input type="submit" name="submit" value="ok" ></p>
	</form>
	<br>
	<a href="profile.php">Перейти в личный кабинет</a>
	<br>
	<a href="home.php">Перейти на главную страницу</a>
	<br>
	<a href="logout.php">Покинуть сайт</a>
</div>
</body>
<script src="//code.jquery.com/jquery-latest.js"></script>
<script src="assets/js/materialize.js"></script>
</html>