<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>
<body>
<?php
	/**
	 * /.+@.+\..+/i
	 */

	$email_validator = '/.+@.+\..+/i';
	//$email_validator = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
	$email_status = ['Введите email','Email валидный'];
	$placeholder = $email_status[0];
	$email = '';
	$password = '';

	//$email = $_POST['email'] ?? "";
	if ( isset($_POST['email']) && !empty($_POST['email'])) {
		$email = $_POST['email'];
	}
	if (preg_match($email_validator, $email)) {
		$placeholder = $email_status[1];
		$email = $_POST['email'];
		header("Location:http://www.google.com");
	}
	else {
		$placeholder = $email_status[0];
	}

?>

<form method="POST">
	<p>Email check</p>
	<input type="text" name="email" placeholder="<?= $placeholder, $email ?>"><br>
	<input type="password" name="password" placeholder="Введите пароль"><br>
	<input type="submit" name="">
</form>

<?php
	echo "<pre>";
	var_dump($_POST);
	echo "</pre>";
	echo $email;
?>

</body>
</html>




