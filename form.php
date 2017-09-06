<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>
<body>

<div id="content">
	<h1>Добро пожаловать!</h1>
	<p>Приветствую вас здесь. Слышал, вы учитесь на PHP-программиста!</p>
	<p>Почему бы вам не набрать свое имя для меня:</p>
	<form method="GET">
		<p>
			<i>Введите свое имя:</i>
			<input type="text" name="name" size="20" />
			<i>Ваш возраст:</i>
			<input type="text" name="age" size="2" />
		</p>
		<p><input type="submit" value="Поприветствуйте меня" /></p>
	</form>
</div>

<?php


	$name = strip_tags($_REQUEST['name']);
	$age = strip_tags($_REQUEST['age']);

	if (empty($_REQUEST['age']) && empty($_REQUEST['age'])) {
		echo "<p style='font-weight: 700'>Введите данные</p>";
	}
	else {
	echo "Hello, " . $name . " Ваш возраст" .$age;
	}
	echo "<pre>";
	var_dump($_REQUEST);
	echo "</pre>";

?>

</body>
</html>
