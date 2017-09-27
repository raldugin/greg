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
	$password = $new_password = $confirmed_new_password = '';
	$user_current = $_SESSION['user_id'];

	if (isset($_POST['submit'])) {
		// получаем VALUE из инпутов формы, EMAIL и PASSWORD
		$password = md5(clear_data($_POST['password']));
		$new_password = clear_data($_POST['new_password']);
		$confirmed_new_password = clear_data($_POST['confirmed_new_password']);
		// валидируем значения input в форме

		$error = validate_user_passwords($password, $new_password, $confirmed_new_password, $user_current, $open_data_file);

		if (empty($error)) {
			$new_password_hashed = md5($new_password);
			$open_data_file [$user_current]['password'] = $new_password_hashed;
			$save_data_file = $open_data_file;
			file_put_contents(USER_DATA_DIR . 'data.json', json_encode($save_data_file, JSON_UNESCAPED_UNICODE));
			header('Location: profile.php');
		}
	}



	function validate_user_passwords($password, $new_password, $confirmed_new_password, $user_current, $open_data_file)
	{
		if (empty($new_password) && empty($confirmed_new_password)) {
			$error = '';
			return $error;
		}
		if ( $password !== $open_data_file[$user_current]['password']) {
			$error = 'Неправильный текущий пароль';
			return $error;
		}
		if (strlen($new_password) < 6) {
			$error = 'В новом пароле должно быть не менее 6 символов';
			return $error;
		}

		if ($new_password !== $confirmed_new_password) {
			$error = 'Пароли не совпадают';
			return $error;
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
	<h6>Изменить пароль:</h6>
	<h6 style="color: Red;"><?= $error; ?> </h6>
	<div class="row">
		<div class="col s6" style="padding: 0">
				<form class="col s12" action="" method="post">
					<div class="input-field">
						<input type="password" id="password" name="password">
						<label for="password">Текущий пароль:</label>
					</div>
					<div class="input-field input-field-no-top-margin">
						<input type="password" id="new_password" name="new_password">
						<label for="new_password">Новый пароль:</label>
					</div>
					<div class="input-field input-field-no-top-margin">
						<input type="password" id="confirmed_new_password" name="confirmed_new_password">
						<label for="confirmed_new_password">Подтвердите новый пароль:</label>
						<input type="submit" name="submit" value="ok">
					</div>
				</form>
		</div>
		<div class="col s6" style="padding: 0">
			Текст описания
		</div>
	</div>
	<p><a href="home.php">Перейти на главную страницу</a></p>
	<p><a href="logout.php">Покинуть сайт</a></p>
</div>


</body>
<script src="//code.jquery.com/jquery-latest.js"></script>
<script src="assets/js/materialize.js"></script>
<script>
    $(document).ready(function() {
        Materialize.updateTextFields();
    })
</script>
</html>