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

<?php
	$label_name_arr = ['Имя', 'Введите Ваше имя'];
	$label_email_arr = ['Email', 'Введите валидный email'];
	$label_password_arr = ['Пароль', 'Введите пароль'];
	$label_confirmed_password_arr = ['Продублируйте пароль','Пароль не совпадает'];

	$label_name = $label_name_arr[0];
	$label_email = $label_email_arr[0];
	$label_password = $label_password_arr[0];
	$label_confirmed_password = $label_confirmed_password_arr[0];

	$value_name = $value_email = $value_password = $value_password_confirmed = NULL;

	if (isset($_POST['submit'])) {
		$name = user_data($_POST['name']);
		$email = user_data($_POST['email']);
		$password = user_data($_POST['password']);
		$confirmed_password = user_data($_POST['confirmed_password']);

		var_dump( (bool)isset($name)); // если установлена переменная, то TRUE
		var_dump( (bool)empty($name)); // если переменная 0, "0",'', false или NULL, то TRUE

		if (empty($name) ) {
			$label_name = $label_name_arr[1];
		}
		else {
			$value_name = $name;
		}
		if (empty($email)) {
			$label_email = $label_email_arr[1];
		}
		else {
			$value_email = $email;
		}

		if (empty($password)) {
			$label_password = $label_password_arr[1];
		}
		else {
			$value_password = $password;
		}

		if (empty($confirmed_password)) {
			$label_confirmed_password = $label_confirmed_password_arr[1];
		}
		else {
			$value_password_confirmed = $confirmed_password;
		}



		if (isset($_POST['mission'])) {
			//var_dump($_POST['mission']);
		}
		if (isset($_POST['comment'])) {
			//var_dump($_POST['comment']);
		}
		if (isset($_POST['radio_button'])) {
			//var_dump($_POST['radio_button']);
		}
		if (isset($_POST['remember_me'])) {
			//var_dump($_POST['remember_me']);
		}

	} // end of if ($_POST['submit'])

	function user_data($data) {
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
						<input  name="name" value="<?= $value_name ?>" id="name" type="text" class="validate active">
						<label for="name"><?= $label_name ?></label>
					</div>
					<div class="input-field">
						<input name="email" value="<?= $value_email ?>" id="email" type="email" class="validate">
						<label for="email"><?= $label_email ?></label>
					</div>
					<div class="input-field">
						<input name="password" value="<?= $value_password ?>" id="password" type="password" class="validate">
						<label for="password"><?= $label_password ?></label>
					</div>
					<div class="input-field">
						<input name="confirmed_password" value="<?= $value_password_confirmed ?>" id="confirmed_password" type="password" class="validate">
						<label for="confirmed_password"><?= $label_confirmed_password ?></label>
					</div>
					<div class="input-field">
						<select name="mission"> <!--  multiple="multiple" -->
							<option value="" disabled selected>Выберите вариант</option>
							<option value="Дизайн">Дизайн</option>
							<option value="Программирование">Программирование</option>
							<option value="Ничего не прет">Ничего не прет</option>
						</select>
						<label>Призвание</label>
					</div>

					<!-- блок UPLOAD файлов -->
					<div class="file-field input-field">
						<div class="btn btn-circle">
							<i class="material-icons">attach_file</i></a>
							<input id="avatar" type="file">
						</div>
						<div class="file-path-wrapper">
							<input placeholder="загрузите аватар" id="file_text" class="file-path validate" type="text">
						</div>
					</div>

					<!-- блок textarea -->
					<div class="input-field">
						<textarea name="comment" id="textarea" class="materialize-textarea"></textarea>
						<label for="textarea">Ваш комментарий</label>
					</div>

					<!-- блок радиобаттанов -->
					<div class="row">
						<p>
							<input name="radio_button" value="LARAVEL" type="radio" id="test1" />
							<label for="test1">LARAVEL</label>
							<input name="radio_button" value="SIMFONY" type="radio" id="test2" />
							<label for="test2">SIMFONY</label>
						</p>
					</div>

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
<script type="text/javascript" src="js/materialize.min.js"></script>
<script>
    $(document).ready(function () {
        $('select').material_select();
    });
</script>
</html>