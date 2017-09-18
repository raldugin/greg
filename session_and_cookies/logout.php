<?php
	session_name( 'overhot_session');
	session_start();

	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}
	else {
		session_unset();
		setcookie(session_name(), '', time() - 1);
		session_destroy();
		header('Location: index.php');
	}

