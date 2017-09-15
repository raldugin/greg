<?php
	session_name( 'overhot_session');
	session_start();

	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}
	else {
		session_unset();
		session_destroy();
		header('Location: index.php');
	}

