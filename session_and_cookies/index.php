<?php

	error_reporting(E_ALL);

	$error = '';
    $email_validator = '/.+@.+\..+/i';
    $username = $email = $password = '';
	$userdata = [];


	if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmed_password = $_POST['confirmed_password'];

		if (!empty($_POST['username'])
			&& !empty($_POST['email'])
			&& !empty($_POST['password'])
			&& !empty($_POST['confirmed_password'])) {
			$error = validate_user_data ($email, $email_validator, $password, $confirmed_password);
		}
		else {
            $error = '<h4 style="color: Red;">Заполните все поля</h4>';
		}
        if ($error == '') {
            $userdata["$email"] = ['password'=>"$password",'username'=>"$username"];
            echo '<pre>';
            print_r($userdata);
            echo '</pre>';
        }
	}

    /**
     *
     */
    function validate_user_data ($email, $email_validator, $password, $confirmed_password) {
		if (!preg_match($email_validator, $email)) {
			$error = '<h4 style="color: Red;">Введите валидный Email</h4>';
			return $error;
		}
		elseif (strlen($password) <1) {
            $error = '<h4 style="color: Red;">В пароле должно быть не менее 6 символов</h4>';
            return $error;
		}
		elseif ($password !== $confirmed_password) {
            $error = '<h4 style="color: Red;">Пароли не совпадают</h4>';
            return $error;
		}
	}
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Register</title>
</head>
<body>
<form method="post">
	<h3>Please Register or <a href="login.php">Sign in</a></h3>
    <?= $error; ?>
	<p><label>Your name</label></p>
	<input type="text" name="username" value="<?= $username ?>">
	<p><label>Email</label></p>
	<input type="text" name="email" value="<?= $email ?>">
	<p><label>Password</label></p>
	<input type="password" name="password" value="<?= $password ?>">
	<p><label>Confirm password</label></p>
	<input type="password" name="confirmed_password">
	<p><input type="submit" name="submit"></p>
</form>
</body>
</html>
