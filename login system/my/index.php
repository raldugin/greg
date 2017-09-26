<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Login</title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="css/materialize.css" media="screen,projection"/>
	<link type="text/css" rel="stylesheet" href="css/normalize.css"/>
	<style>
		* { margin: 0; padding: 0; }
		html { height: 100%; overflow-y: scroll; -ms-overflow-style: scrollbar; text-rendering: optimizeLegibility !important; -webkit-font-smoothing: antialiased !important; }
		body { height: 100%; -webkit-backface-visibility: hidden; background: #ececec; }

		.wrapper {
			position: relative;
			width: 405px;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			-moz-transform: translate(-50%, -50%);
			-webkit-transform: translate(-50%, -50%);
			-o-transform: translate(-50%, -50%);
			-ms-transform: translate(-50%, -50%);
			-webkit-transition: transform 0.2s ease-out;
			-moz-transition: transform 0.2s ease-out;
			-o-transition: transform 0.2s ease-out;
			transition: transform 0.2s ease-out;
		}
	</style>
</head>
<body>
<!-- Dropdown Structure -->
<ul id="dropdown-but" class="dropdown-but dropdown-content">
	<li><a href="#!">one</a></li>
	<li><a href="#!">two</a></li>
	<li class="divider"></li>
	<li><a href="#!">three</a></li>
</ul>
<nav>
	<div class="nav-wrapper">
		<a href="#!" class="brand-logo">Logo</a>
		<ul class="right hide-on-med-and-down">
			<li><a href="sass.html">Sass</a></li>
			<li><a href="badges.html">Components</a></li>
			<!-- Dropdown Trigger -->
			<li><a class="dropdown-button" href="#!" data-activates="dropdown1">Dropdown<i class="material-icons right">arrow_drop_down</i></a></li>
		</ul>
	</div>
</nav>

<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$error = [];
	$email_validator = '/.+@.+\..+/i';

	$label_name_arr = ['Имя', 'Введите Ваше имя'];
	$label_email_arr = ['Email', 'Введите email', 'Введите валидный email'];
	$label_password_arr = ['Пароль', 'Введите пароль', 'Пароль должен быть не менее 6 символов'];
	$label_confirmed_password_arr = ['Повторите пароль','Введите повторно пароль','Пароли не совпадают'];

	$label_name = $label_name_arr[0];
	$label_email = $label_email_arr[0];
	$label_password = $label_password_arr[0];
	$label_confirmed_password = $label_confirmed_password_arr[0];

	$name = $email = $password = $password_confirmed = NULL;

	//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['submit'])) {
		$name = clear_data($_POST['name']);
		$email = clear_data($_POST['email']);
		$password = clear_data($_POST['password']);
		$confirmed_password = clear_data($_POST['confirmed_password']);

		//var_dump( (bool)isset($name)); // если установлена переменная, то TRUE
		//var_dump( (bool)empty($name)); // если переменная 0, "0",'', false или NULL, то TRUE

		// преверка name
		if (empty($name) ) {
			$label_name = $label_name_arr[1];
			$error [] = 'name_problem';
		}

		// преверка email
		if (empty($email)) {
			$label_email = $label_email_arr[1];
			$error [] = 'email_problem';
		}
		elseif (!preg_match($email_validator, $email)) {
			$label_email = $label_email_arr[2];
			$error [] = 'email_validation_problem';
			$class_email = 'invalid';
		}

		// преверка пароля
		if (empty($password)) {
			$label_password = $label_password_arr[1];
			$error [] = 'password_problem';
		}
		elseif (strlen($password) < 1) {
			$label_password = $label_password_arr[2];
			$error [] = 'password_length_problem';
			$class_password = 'invalid';
		}

		// преверка дубликата пароля
		if (empty($confirmed_password) ) {
			$label_confirmed_password = $label_confirmed_password_arr[1];
			$error [] = 'confirmed_password_problem';
			$class = 'invalid';
		}
		elseif ($confirmed_password !== $password) {
			$label_confirmed_password = $label_confirmed_password_arr[2];
			$error [] = 'confirmed_password_problem';
			$class_confirmed_password = 'invalid';
		}


//		if (isset($_POST['mission'])) {
//			//var_dump($_POST['mission']);
//		}
//		if (isset($_POST['comment'])) {
//			//var_dump($_POST['comment']);
//		}
//		if (isset($_POST['radio_button'])) {
//			//var_dump($_POST['radio_button']);
//		}
//		if (isset($_POST['remember_me'])) {
//			//var_dump($_POST['remember_me']);
//		}

		// если кол-во элементов массива $error - FALSE (не найдены ошибки), то делаем редирект на новую страницу и передаем имя
		if (!count($error)) {

			// перекодировка ИМЕНИ пользователя из utf-8 в windows-1251 для создания директории (для WINDOWS машин)
			$user_dir = 'users/' . iconv('utf-8', 'windows-1251', $name);

			if (is_dir($user_dir)) {
				rmdir_recursive ($user_dir);
				//rmdir($user_dir);
			}

			// recursive для вложенной структуры
			mkdir($user_dir, 0755, true);

			// пишет данные в файл и добавляет новые записи при новом обращении
			//file_put_contents($user_dir.'/user_data.txt', $name.'|'.$email.'|'.$password.'|'.$confirmed_password.PHP_EOL, FILE_APPEND);

			// пишет данные в файл и перезаписывает его при новом обращении
			file_put_contents($user_dir.'/name.txt', $name.'|'.$email.'|'.$password.'|'.$confirmed_password.PHP_EOL);
//			//header( 'Location: entered.php?name='.$name);
		}

	} // end of if ($_POST['submit'])

//		echo "<pre>";
//		print_r($error);
//		echo "</pre>";

	// функция удаляет рекурсивно директорию с вложениями и файлами
	function rmdir_recursive($dir) {
		$it = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
		$it = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
		foreach($it as $file) {
			if ($file->isDir()) rmdir($file->getPathname());
			else unlink($file->getPathname());
		}
		rmdir($dir);
	}

	function clear_data($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}


?>

<main class="wrapper">
	<div class="row card-panel">
		<form method="post">
			<div class="col s12">
				<div class="row">
					<h5 class="row center-align">Регистрация</h5>
					<div class="input-field">
						<input  name="name" value="<?= $name ?>" id="name" type="text" class="validate active <?= $class_name ?>">
						<label for="name"><?= $label_name ?></label>
					</div>
					<div class="input-field">
						<input name="email" value="<?= $email ?>" id="email" type="email" class="validate <?= $class_email ?>">
						<label for="email"><?= $label_email ?></label>
					</div>
					<div class="input-field">
						<input name="password" value="<?= $password ?>" id="password" type="password" class="validate <?= $class_password ?>">
						<label for="password"><?= $label_password ?></label>
					</div>
					<div class="input-field">
						<input name="confirmed_password" id="confirmed_password" type="password" class="validate <?= $class_confirmed_password ?>">
						<label for="confirmed_password"><?= $label_confirmed_password ?></label>
					</div>

					<!-- блок select
					<div class="input-field">
						<select name="mission">
							<option value="" disabled selected>Выберите вариант</option>
							<option value="Дизайн">Дизайн</option>
							<option value="Программирование">Программирование</option>
							<option value="Ничего не прет">Ничего не прет</option>
						</select>
						<label>Призвание</label>
					</div>
					-->

					<!-- блок UPLOAD файлов
					<div class="file-field input-field">
						<div class="btn btn-circle">
							<i class="material-icons">attach_file</i></a>
							<input id="avatar" type="file">
						</div>
						<div class="file-path-wrapper">
							<input placeholder="загрузите аватар" id="file_text" class="file-path validate" type="text">
						</div>
					</div>
					 -->

					<!-- блок textarea
					<div class="input-field">
						<textarea name="comment" id="textarea" class="materialize-textarea"></textarea>
						<label for="textarea">Ваш комментарий</label>
					</div>
					 -->

					<!-- блок радиобаттанов
					<div class="row">
						<p>
							<input name="radio_button" value="LARAVEL" type="radio" id="test1" />
							<label for="test1">LARAVEL</label>
							<input name="radio_button" value="SIMFONY" type="radio" id="test2" />
							<label for="test2">SIMFONY</label>
						</p>
					</div>
					 -->

					<!-- блок чекбоксов -->
					<p>
						<input name="remember_me" value="checked" type="checkbox" class="filled-in" id="filled-in-box" checked>
						<label for="filled-in-box">Запомнить меня</label>
					</p>

					<!-- блок кнопок SUBMIT -->
					<button class="btn waves-effect waves-light" type="submit" name="submit" value="submited">Зарегистрироваться</button>
					<button class="btn waves-effect waves-light" type="reset" value="Reset">Очистить</button>
				</div>
			</div>
		</form>
	</div>
</main>


</body>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="js/materialize.js"></script>
<script>
    $(document).ready(function () {
        $('select').material_select();
        $("#dropdown-but").dropdown();
    });
</script>
</html>