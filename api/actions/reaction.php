<?php 
	require_once('../../geral.php');

	header('Content-Type: application/json');

	if (extract($_POST) && isset($user)) {
		$order = (isset($_POST['order'])) ? $_POST['order'] : '';

		if ($order == 'article') {
			$article_id = (isset($_POST['article_id'])) ? $_POST['article_id'] : '';

			if (is_numeric($article_id)) {
				$consult_if_exists_article = $db->prepare("SELECT * FROM cms_news WHERE id = ?");
				$consult_if_exists_article->bindValue(1, $article_id);
				$consult_if_exists_article->execute();

				if ($consult_if_exists_article->rowCount() > 0) {
					$consult_article_liked = $db->prepare("SELECT * FROM cms_post_reaction WHERE user_id = ? AND post_id = ? AND type = ?");
					$consult_article_liked->bindValue(1, $user['id']);
					$consult_article_liked->bindValue(2, $article_id);
					$consult_article_liked->bindValue(3, 'article');
					$consult_article_liked->execute();

					if ($consult_article_liked->rowCount() > 0) {
						$result_article_liked = $consult_article_liked->fetch(PDO::FETCH_ASSOC);

						if ($result_article_liked['state'] == 'like') {
							$update_article_reaction = $db->prepare("UPDATE cms_post_reaction SET state = ? WHERE post_id = ? AND user_id = ? AND type = ?");
							$update_article_reaction->bindValue(1, 'undefined');
							$update_article_reaction->bindValue(2, $article_id);
							$update_article_reaction->bindValue(3, $user['id']);
							$update_article_reaction->bindValue(4, 'article');
							$update_article_reaction->execute();

							$state = 'remove';
						} else {
							$update_article_reaction = $db->prepare("UPDATE cms_post_reaction SET state = ? WHERE post_id = ? AND user_id = ? AND type = ?");
							$update_article_reaction->bindValue(1, 'like');
							$update_article_reaction->bindValue(2, $article_id);
							$update_article_reaction->bindValue(3, $user['id']);
							$update_article_reaction->bindValue(4, 'article');
							$update_article_reaction->execute();

							$state = 'like';
						}

						$consult_article_reactions = $db->prepare("SELECT * FROM cms_post_reaction WHERE post_id = ? AND state != ? AND type = ?");
						$consult_article_reactions->bindValue(1, $article_id);
						$consult_article_reactions->bindValue(2, 'undefined');
						$consult_article_reactions->bindValue(3, 'article');
						$consult_article_reactions->execute();

						if ($consult_article_reactions->rowCount() == 0 || $consult_article_reactions->rowCount() > 1) {
							echo json_encode([
								"response" => 'update',
								"state" => $state,
								"likes" => $consult_article_reactions->rowCount() . ' likes'
							]);
						} else {
							echo json_encode([
								"response" => 'update',
								"state" => $state,
								"likes" => $consult_article_reactions->rowCount() . ' like'
							]);
						}
					} else {
						$insert_article_reaction = $db->prepare("INSERT INTO cms_post_reaction (type, post_id, user_id, state) VALUES (?,?,?,?)");
						$insert_article_reaction->bindValue(1, 'article');
						$insert_article_reaction->bindValue(2, $article_id);
						$insert_article_reaction->bindValue(3, $user['id']);
						$insert_article_reaction->bindValue(4, 'like');
						$insert_article_reaction->execute();

						$consult_article_reactions = $db->prepare("SELECT * FROM cms_post_reaction WHERE post_id = ? AND state != ? AND type = ?");
						$consult_article_reactions->bindValue(1, $article_id);
						$consult_article_reactions->bindValue(2, 'undefined');
						$consult_article_reactions->bindValue(3, 'article');
						$consult_article_reactions->execute();

						if ($consult_article_reactions->rowCount() == 0 || $consult_article_reactions->rowCount() > 1) {
							echo json_encode([
								"response" => 'success',
								"likes" => $consult_article_reactions->rowCount() . ' likes'
							]);
						} else {
							echo json_encode([
								"response" => 'success',
								"likes" => $consult_article_reactions->rowCount() . ' like'
							]);
						}
					}
				} else {
					echo json_encode([
						"response" => 'not-found'
					]);
				}
			} else {
				echo json_encode([
					"response" => 'error'
				]);
			}
		}
	} else {
		echo 'Cannot get ' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '.';
	}
?>