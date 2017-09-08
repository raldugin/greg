<?php

	/**
	 * @param string $string
	 * @param int $arg
	 * @param bool $arg1
	 * @param array $arg3
	 * @internal param array $arr
	 */
	function wl($string, $arg, $arg1, array $arg3) {
		echo "<pre>";
		var_dump($string, $arg, $arg1, $arg3);
		echo "</pre>";
	}

	$options = ['Hello function', 55, true, ['nissan'=>'leaf']];

	/** @var TYPE_NAME $options
	 *
	 * передаем в функцию массив аргументов,
	 * первый с ключем 0 - 'Hello function'
	 * второй с ключем 1 - 55
	 * третий с ключем 2 - true
	 * четвертый с ключем 3 - массив ['nissan'=>'leaf']
	 */
	wl(...$options);
	echo "----------------------------------<br>";

	/**
	 * передаем в функцию аргументы напрямую без переменных,
	 * первый с ключем 0 - 'Hello function'
	 * второй с ключем 1 - 55
	 * третий с ключем 2 - true
	 * четвертый с ключем 2 - массив ['nissan'=>'leaf']
	 */
	wl('Hello function', 55,true, ['nissan'=>'leaf']);

	echo "<br>";

	$a = 'hello';
	// $$a означет что, взять значение переменной $a (hello), создать новую переменную с именем $hello и присвоить ей значение 'world'
	$$a = 'world';
	echo $a . $hello."<br><br>";

	echo PHP_MAJOR_VERSION;


