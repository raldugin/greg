<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>
<pre>
<body>
<?php
	/**
	 * ФУНКЦИИ ЛЕЖАТ В ФАЙЛЕ functions.php
	 */

	/**
	 * __DIR__ считается как ROOT директорий для текущего файла.
	 *  поэтому надо ставить слэш "/functions.php"
	 */
	include_once __DIR__ . "/functions.php";
	var_dump(__DIR__);


	$name = 'Alex';
	$surname = "Evgenijovich";
	$family = "Raldugin";

	// возвращаем результат  getFullName () в переменную $fullname
	$fullname = getFullName($name, $surname);

	// или сразу выводим результат работы функции
	echo getFullName($name, $surname);
	echo getFullName($name, $surname, $family);


	/**
	 * ------------------------------- работа по линку ---------------------------------
	 * добавляем к строке $fullname HASH с помощью функции (addHash). В ответ она ничего не возращает,
	 * а с помощью обявленного в ней линка (&), мы сразу с помощью функции изменяем переменную $fullName в глобальной области видимости (или namespace)
	 *
	 */
	addHash($fullname, "строка для создания хеша");
	echo $fullname."<br>";

	/** @var FUNCTION $callback
	 *
	 * ------------------------------ анонимные функции --------------------------------
	 * callback функции.. присваиваем функцию к переменной и потом вызываем ее через переменную
	 * и передаем функции массив где его перемешиваем и удаляем последний элемент массива.
	 * возвращаем массив в новую переменную $new_arr
	 * @return mixed
	 */
	$callback = function ($arr) {
		shuffle($arr);
		array_pop($arr);
		return $arr;
	};

	$arr=[1,2,3,4,5,['nissan'=>'leaf'],'last'];
	$new_arr = $callback($arr);
	print_r($arr);
	print_r($new_arr);





?>
</pre>
</body>
</html>



