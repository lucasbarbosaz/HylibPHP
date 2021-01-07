<?php 
	require_once('../geral.php');

	if (isset($user['username'])) {
		session_destroy();
		Redirect(URL);
	} else {
		Redirect(URL);
	}
?>