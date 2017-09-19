<?php

	error_reporting(E_ALL);
	define('USER_DATA_DIR', 'users_data/');

	$email_validator = '/.+@.+\..+/i';
	$username = $email = $password = $error = '';
	$userdata = [];

	if (isset($_POST['submit'])) {
		$username = clear_data($_POST['username']);
		$email = clear_data($_POST['email']);
		$password = clear_data($_POST['password']);
		$confirmed_password = clear_data($_POST['confirmed_password']);

		if (!empty($username)
			&& !empty($email)
			&& !empty($password)
			&& !empty($confirmed_password)) {
			$error = validate_user_data($email, $email_validator, $password, $confirmed_password);
		} else {
			$error = '<h4 style="color: Red;">Заполните все поля</h4>';
		}

		// прошли успешно валидацию формы
		if ($error == '') {

			$time = date('d.m.Y H:i', time());
			$password = md5($password);

			$userdata["$email"] = ['password' => "$password", 'username' => "$username", "time" => "$time"];
			if (is_dir(USER_DATA_DIR)) {
				$open_data_file = json_decode(file_get_contents(USER_DATA_DIR . 'data.json'), true);
				$save_data_file = array_merge($open_data_file, $userdata);
				file_put_contents(USER_DATA_DIR . 'data.json', json_encode($save_data_file));
			} else {
				// создаем дир и пишем первую запись с данными юзера
				mkdir(USER_DATA_DIR, 0777, true);
				file_put_contents(USER_DATA_DIR . 'data.json', json_encode($userdata));
			}
			header('Location: index.php');

		}
	}

	/**
	 * string $email, $email_validator, $password, $confirmed_password
	 */
	function validate_user_data($email, $email_validator, $password, $confirmed_password)
	{
		$open_data_file = json_decode(file_get_contents(USER_DATA_DIR . 'data.json'), true);
		if (!preg_match($email_validator, $email)) {
			$error = '<h4 style="color: Red;">Введите валидный Email</h4>';
			return $error;
		}
		// если файл не пустой, открываем json и в массиве проверяем совпадение email из файла и формы
		// если такой email есть, возвращаем ошибку
		elseif (!empty($open_data_file)) {
			if (array_key_exists($email, $open_data_file)) {
				$error = '<h4 style="color: Red;">Такой пользователь уже есть в системе</h4>';
				return $error;
			}
			unset($open_data_file);
		} elseif (strlen($password) < 6) {
			$error = '<h4 style="color: Red;">В пароле должно быть не менее 6 символов</h4>';
			return $error;
		} elseif ($password !== $confirmed_password) {
			$error = '<h4 style="color: Red;">Пароли не совпадают</h4>';
			return $error;
		}
	}

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
	<title>Регистрация</title>
</head>
<body>
<form method="post">
	<h3>Зарегистрируйтесь <a href="index.php">или войдите в систему</a></h3>
	<?= $error; ?>
	<p><label>Ваше имя</label></p>
	<input type="text" name="username" value="<?= $username ?>">
	<p><label>Email</label></p>
	<input type="text" name="email" value="<?= $email ?>">
	<p><label>Пароль</label></p>
	<input type="password" name="password" value="<?= $password ?>">
	<p><label>Подтвердите пароль</label></p>
	<input type="password" name="confirmed_password">
	<p><input type="submit" name="submit"></p>
</form>
</body>
</html>
