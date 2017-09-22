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
	$user_key_in_array = find_user_key ($user_current, $open_data_file);

	function find_user_key($user_current, $open_data_file)
	{
		foreach ($open_data_file as $key => $value) {
			if ($key == $user_current) {
				return $key;
			}
		}
	}

	var_dump($user_key_in_array);







	// подставляем в форму VALUE текущего Username и EMAIL



	$username_current 	= $open_data_file[ $user_current ][ 'username' ];
	$email_current 		= $user_current;
	$password_current 	= $open_data_file[ $user_current ][ 'password' ];
	$phone_current 		= $open_data_file[ $user_current ][ 'phone' ];
	$address_current 	= $open_data_file[ $user_current ][ 'address' ];
	$time 				= $open_data_file[ $user_current ][ 'time' ];



	if (isset($_POST['submit'])) {
		// получаем VALUE из инпутов формы, EMAIL и PASSWORD
		$username = clear_data($_POST['username']);
		$email = clear_data($_POST['email']);
		$phone = clear_data($_POST['phone']);
		$address = clear_data($_POST['address']);
		$password = clear_data($_POST['password']);
		// валидируем значения input в форме
		$error = validate_user_data($username, $username_current,
			$email, $email_current,
			$phone, $phone_current,
			$address, $phone_current,
			$email_validator,
			$password, $open_data_file);

		if (empty($error)) {

			echo "<pre>";
			print_r($open_data_file);
			echo "</pre>";

			$changed_user_info [$email_current] = ['username' => "$username_current", 'password' => "$password_current", 'phone' => "$phone_current", 'address' => "$address_current", 'time' => "$time"];
			echo "<pre>";
			print_r($changed_user_info);
			echo "</pre>";

		}
		/*
				$change_info =

						foreach ($open_data_file as $key => $value) {
						echo 'работаем'.'<br>';
						if ($key == $_SESSION['user_id']) {
							echo '<br>Текущий email:<br>';
							var_dump($email_current);
							echo '<br>Имя ключа массива:<br>';
							var_dump($key);
							echo '<br>Имя нового ключа:<br>';
							$key = $email_current;
							echo '<br>Имя сесии:<br>';
							var_dump($_SESSION['user_id']);
							echo '<br>';
							print_r($value);
						}


		*/


//		foreach ($open_data_file as $key => $value) {
//			echo '<br>';
//			$key = $key.'_new';
//			print_r($key);
//
//
//
//		}

//			$arr[$newkey] = $arr[$oldkey];
//			unset($arr[$oldkey]);

		//file_put_contents(USER_DATA_DIR. 'data.json', json_encode($open_data_file), JSON_UNESCAPED_UNICODE);
		//$open_data_file[$_SESSION['user_id']]['username'] = $username_current;
		//$open_data_file[$_SESSION['user_id']] = $email_current;
		//$open_data_file[$_SESSION['user_id']]['phone'] = $phone_current;
		//$open_data_file[$_SESSION['user_id']]['address'] = $address_current;
		//file_put_contents(USER_DATA_DIR. 'data.json', json_encode($open_data_file), JSON_UNESCAPED_UNICODE);

		//$_SESSION['user_id'] = $email_current;
		//$_SESSION['username'] = $username_current;


		//$error = 'Изменения внесены';
		//header('refresh:2; url=profile.php');
	}


	/**
	 * @param $username - вводимый новый username из формы
	 * @param $username_current - текущий username
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
		$username, &$username_current,
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
			$error = 'Ничего не поменялось';
			return $error;
		}

		if (empty($username)) {
			$username_current = $username;
			$error = 'Введите имя';
			return $error;
		}
		// если поле формы EMAIL пустое, или введен новый EMAIL который не прошел REGEX, выводим ошибку
		if (empty($email) || !preg_match($email_validator, $email)) {
			$email_current = '';
			$error = 'Введите валидный Email';
			return $error;
		}
		else {
			$email_current = $email;
		}
		var_dump($email);


		// если в форме введен email который уже есть в массиве данных (т.е. уже зарегистрирован другим пользаком), выводим ошибку
		if (array_key_exists($email, $open_data_file)) {
			$error = 'Такой Email/Пользователь уже зарегистрирован';
			return $error;
		}

		if (!empty($phone)) {
			$phone_current = $phone;
			$error = '';
			return $error;
		}

		// если введенный в форпму EMAIL, оличен от EMAIL_CURRENT (записан при логине в перменную сессии ['user_id'])
		// и введенный пароль в форме не совпадает с тем что пользак вводил при регистрации (сохранен в массиве), то выводим ошибку
		// тут $_SESSION['user_id'], это EMAIL залогиненного пользователя, т.е. ключ ассоциативного массива со значениями (данными) пользователя

		elseif ($email !== $email_current && md5($password) !== $open_data_file[$_SESSION['user_id']]['password']) {
			$email_current = $email;
//			var_dump($email);
//			echo 'Current';
//			var_dump($email_current);
			$error = 'Введите пароль для изменений';
			return $error;
		}
		// если валидация EMAIL и PASSWORD успешна, то меняем значение текущего Email на введенный
		//меняем в сесиии

		// меняем в массиве и пишем


		$error = 'Успешно внесены изменения';
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
<h4 style="color: Red;"><?= $error; ?></h4>
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
	<p><input type="submit" value="потвердить изменения" name="submit"></p>
</form>
<br>
<a href="profile.php">Перейти в личный кабинет</a>
<br>
<a href="home.php">Перейти на главную страницу</a>
<br>
<a href="logout.php">Покинуть сайт</a>
</body>
</html>