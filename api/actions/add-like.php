<?php
	session_start();
	sleep(2);
	require_once "../../geral.php";


	$feed_id = (int)$_POST['id'];
	$iduser = (int)$user['id'];

	if(!verifClicked($feed_id, $iduser)) {
		if(AddClick($feed_id, $iduser)) {
			echo "sucesso";
		} else {
			echo 'erro';
		}
	} else {
		echo 'erro';
	}

?>