<?php 
	require_once('../../geral.php');

	header('Content-Type: application/json');

	echo json_encode([
		"count" => Functions::Onlines()
	]);
?>