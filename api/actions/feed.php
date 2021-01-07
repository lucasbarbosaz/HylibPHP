<?php 
	require_once('../../geral.php');

	header('Content-Type: application/json');

	$consultLastFeed = $db->prepare("SELECT * FROM cms_feed ORDER BY timestamp DESC LIMIT 1");
	$consultLastFeed->execute();
	$resultLastFeed1 = $consultLastFeed->fetch(PDO::FETCH_ASSOC);


	if(extract($_POST) && isset($user)) {
		$feedId = $resultLastFeed1['id'];

		$consultReactions = $db->prepare("SELECT * FROM cms_feed_like WHERE feed_id = ? AND player_id = ?");
		$consultReactions->bindValue(1, $feedId);
		$consultReactions->bindValue(2, $user['id']);
		$consultReactions->execute();

		$consultReactionsLikes = $db->prepare("SELECT * FROM cms_feed_like WHERE feed_id = ? AND player_id = ?");
		$consultReactionsLikes->bindValue(1, $feedId);
		$consultReactionsLikes->bindValue(2, $user['id']);
		$consultReactionsLikes->execute();
		$resultReactionsLikes = $consultReactionsLikes->fetch(PDO::FETCH_ASSOC);

		if(isset($_POST['curtir'])) {
			$consultReactionsLikes = $db->prepare("SELECT * FROM cms_feed_like WHERE feed_id = ? AND player_id = ?");
			$consultReactionsLikes->bindValue(1, $feedId);
			$consultReactionsLikes->bindValue(2, $user['id']);
			$consultReactionsLikes->execute();
			$resultReactionsLikes = $consultReactionsLikes->fetch(PDO::FETCH_ASSOC);

			$insertLikes = $db->prepare("INSERT INTO cms_feed_like (feed_id, player_id) VALUES (?, ?)");
			$insertLikes->bindValue(1, $resultLastFeed1['id']);
			$insertLikes->bindValue(2, $user['id']);
			$insertLikes->execute();
		}


	}