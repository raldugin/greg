<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>
<body>
	Логин успешен!
	<?= 'Здравствуйте, '. $_GET['name'] ?>
</body>
</html>
<?php
	/**
	 * Created by PhpStorm.
	 * User: Al
	 * Date: 12.09.2017
	 * Time: 12:12
	 */
	include_once ('includes/constants.php');


	//$user_data_arr = explode('|', file_get_contents(USER_DATA_DIR.'user_data.txt'));
	$user_data_arr = explode(PHP_EOL, file_get_contents(USER_DATA_DIR.'user_data.txt'));

	echo "<pre>";
	print_r($user_data_arr);
	echo "</pre>";


?>