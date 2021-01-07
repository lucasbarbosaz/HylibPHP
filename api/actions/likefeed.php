<?php
	require_once "../../geral.php";
	$feed_id = (int)$_POST['id'];
	$numbersOfLikes = returnLike($feed_id);
	echo $numbersOfLikes;
?>