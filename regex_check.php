<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Regex check</title>
</head>
<body>
<?php
	/**
	 * /.+@.+\..+/i
	 */

	$email = $_POST['email'] ?? "";
	$email_validator = '/.+@.+\..+/i';

	$email_status = ['Введите email','Email валидный','Email НЕ валидный'];
	$placeholder = $email_status[0];

	if (!empty($email) && preg_match($email_validator, $email)) {
		$placeholder = $email_status[1];
	}
	elseif (empty($email)) { $placeholder = $email_status[0];
	}
	else {
		$placeholder = $email_status[2];
	}

?>

<form action="regex_check.php" method="post">
	<p>Email check</p>
	<input type="text" name="email" placeholder="<?= $placeholder ?>">
	<input type="submit" name="">
</form>

<?php
	echo "<pre>";
	var_dump($_POST);
	echo "</pre>";
?>
</body>
</html>




