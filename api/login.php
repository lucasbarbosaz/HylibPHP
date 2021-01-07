<?php 
	require_once('../geral.php');

	header('Content-Type: application/json');

	if (extract($_POST)) {
		$type = (isset($_POST['type'])) ? $_POST['type'] : '';
		$identification = (isset($_POST['identification'])) ? $_POST['identification'] : '';
		$password = (isset($_POST['password'])) ? $_POST['password'] : '';

		if ($type == 'staff') {
			$Auth::Login($identification, $password, 'staff');
		} else if ($type == 'permission') {
			$Auth::Login($identification, $password, 'permission');
		} else {
			 {
				$Auth::Login($identification, $password);
			}
		}
	} else {
		echo 'Cannot get ' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '.';
	}
?>