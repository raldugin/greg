<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Cookie</title>
</head>
<body>
<p>Set cookies - 'userId', 'sdasd989asd898as8d', time () + 1000 * 60 * 60</p>
<p>Set cookies - 'stuff', 'fdsfsdfsdfsdfsd2312', time () + 1000 * 60 * 30</p>
<pre>

	<?php

		// устанавливаем куки -имя- -значение- - время жизни .. 1000мс = 1 сек
		setcookie('userId', 'sdasd989asd898as8d', time()+60);
		setcookie('stuff', 'fdsfsdfsdfsdfsd2312', time()+60);
		setcookie('stuffId', 'fdsfsdfsdfsdfsd2312', time()+30);

		if (!empty($_COOKIE)) {
			print_r($_COOKIE);
			echo $_COOKIE['userId'] . "<br>";
			echo $_COOKIE['stuff'] . "<br>";
		} else {

		}

		// удаляем куки, т.е. время жизни - текущее время минус 1 секунда
		setcookie('stuffId', 'fdsfsdfsdfsdfsd2312', time() + 10);

		// удаляет переменную из скрипта, но не удаляет саму куку с компа
		unset($_COOKIE['stuffIf']);
	?>
</pre>
</body>
</html>

