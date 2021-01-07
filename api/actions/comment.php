<?php 
	require_once('../../geral.php');

	header('Content-Type: application/json');

	if (extract($_POST) && isset($user)) {
		$order = (isset($_POST['order'])) ? $_POST['order'] : '';

		if ($order == 'article') {
			$article_id = (isset($_POST['article_id'])) ? $_POST['article_id'] : '';
			$value = (isset($_POST['value'])) ? $_POST['value'] : '';

			if (is_numeric($article_id)) {
				$consult_if_exists_article = $db->prepare("SELECT id FROM cms_news WHERE id = ?");
				$consult_if_exists_article->bindValue(1, $article_id);
				$consult_if_exists_article->execute();

				if ($consult_if_exists_article->rowCount() > 0) {
					$result_if_exists_article = $consult_if_exists_article->fetch(PDO::FETCH_ASSOC);

					$consult_last_comment_by_me = $db->prepare("SELECT id,timestamp FROM cms_post_comments WHERE type = ? AND post_id = ? AND author_id = ? ORDER BY timestamp DESC LIMIT 1");
					$consult_last_comment_by_me->bindValue(1, 'article');
					$consult_last_comment_by_me->bindValue(2, $result_if_exists_article['id']);
					$consult_last_comment_by_me->bindValue(3, $user['id']);
					$consult_last_comment_by_me->execute();

					$result_last_comment_by_me = $consult_last_comment_by_me->fetch(PDO::FETCH_ASSOC);

					if ($result_last_comment_by_me['timestamp'] >= time() - 600) {
						echo json_encode([
							"response" => 'error',
							"append" => '<div class="general-warn-time-2"><label>Você precisa esperar <b>10 minutos</b> para poder comentar novamente ' . $user['username'] . '.</label></div>'
						]);
					} else {
						$trim_value = strip_tags($value);

						if (strlen($trim_value) == 0) {
							echo json_encode([
								"response" => 'error',
								"append" => '<div class="general-warn-2"><label>Você precisa digitar algo para poder comentar.</label></div>'
							]);
						} else if (strlen($trim_value) > 100) {
							echo json_encode([
								"response" => 'error',
								"append" => '<div class="general-warn-2"><label>Vish ' . $user['username'] . ', seu comentário é muito grande.</label></div>'
							]);
						} else if ($Function::AntiPub($value) !== false) {
							echo json_encode([
								"response" => 'error',
								"append" => '<div class="general-warn-2"><label>Hmm, parece que encontramos uma palavra da lista negra no seu comentário.</label></div>'
							]);
						} else {
							$insert_comment_article = $db->prepare("INSERT INTO cms_post_comments (type, post_id, value, author_id, timestamp) VALUES (?,?,?,?,?)");
							$insert_comment_article->bindValue(1, 'article');
							$insert_comment_article->bindValue(2, $result_if_exists_article['id']);
							$insert_comment_article->bindValue(3, $Function::Filter('xss', $value));
							$insert_comment_article->bindValue(4, $user['id']);
							$insert_comment_article->bindValue(5, TIME);
							$insert_comment_article->execute();

							$consult_last_comment_by_me = $db->prepare("SELECT id,value,timestamp FROM cms_post_comments WHERE type = ? AND post_id = ? AND author_id = ? ORDER BY timestamp DESC LIMIT 1");
							$consult_last_comment_by_me->bindValue(1, 'article');
							$consult_last_comment_by_me->bindValue(2, $result_if_exists_article['id']);
							$consult_last_comment_by_me->bindValue(3, $user['id']);
							$consult_last_comment_by_me->execute();

							$result_last_comment_by_me = $consult_last_comment_by_me->fetch(PDO::FETCH_ASSOC);

							echo json_encode([
								"response" => 'success',
								"label" => [
									"comment-id" => $result_last_comment_by_me['id'],
									"figure" => AVATARIMAGE . 'figure=' . $user['figure'] . '&action=std&direction=2&head_direction=3&gesture=std&size=s&img_format=png&frame=0&headonly=0',
									"alt" => $user['username'] . ' - ' . HOTELNAME,
									"comment" => $Function::Filter('emoji', $result_last_comment_by_me['value']),
									"username" => $user['username'],
									"profile" => [
										"link" => URL . '/profile/' . $user['username'],
										"place" => 'Perfil: ' . $user['username'] . ' - ' . HOTELNAME
									],
									"time" => [
										"date" => utf8_encode(strftime('%d de %B %Y', $result_last_comment_by_me['timestamp'])),
										"hour" => utf8_encode(strftime('%H:%M', $result_last_comment_by_me['timestamp']))
									]
								]
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
					"response" => 'error',
					"append" => '<div class="general-warn-2"><label>Não foi possivel comentar nesta noticia, tente novamente mais tarde!</label></div>'
				]);
			}
		}
	} else {
		echo 'Cannot get ' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '.';
	}
?>